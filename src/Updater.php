<?php

/**
 * Copyright © 2021 Moss Maurice. All rights reserved.
 * Contacts: <kreexus@yandex.ru>
 * Profile: <https://github.com/moss-maurice>
 */

namespace mmaurice\bdr\teasers;

use \Exception;
use \mmaurice\bdr\teasers\components\Logger;
use \mmaurice\bdr\teasers\components\Registry;
use \mmaurice\bdr\teasers\components\Timer;

/**
 * Класс обновления тизеров
 */
class Updater
{
    protected $registry;

    /**
     * Метод-конструктор
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * Метод с основной логикой
     *
     * @return void
     */
    public function run()
    {
        // Извлекаем из реестра нужные узлы
        $teasers = $this->registry->get('config')->teasers;
        $modx = $this->registry->get('modx');

        // Если в конфиге нет тизеров с назначенными мапперами
        if (!is_array($teasers) or empty($teasers)) {
            throw new Exception("Teasers is not defined");
        }

        // Иначе
        $this->registry->get('logger')->set("Teasers list defined", [
            'teasers' => implode(', ', array_keys($teasers)),
        ]);

        // Выбираем из БД объявленные тизеры
        $resource = $modx->db->select('*', $modx->getFullTableName('pagebuilder'), "`config` IN ('" . implode("','", array_keys($teasers)) . "')");

        // Тизеры найдены
        if ($rowsCount = $modx->db->getRecordCount($resource)) {
            $this->registry->get('logger')->set("Teasers founded", [
                'count' => $rowsCount,
            ]);

            // Обходим все тизеры
            while ($row = $modx->db->getRow($resource)) {
                $response = null;

                // Создаём класс маппера
                $mapper = new $teasers[$row['config']]($this->registry);

                // Получаем новые данные по тизеру
                $newValues = $mapper->parse($row['values'], $response);

                // Если тизер был получен по API
                if (!is_null($response)) {
                    // Обновляем тизер
                    $result = $modx->db->update([
                        'values' => $this->normalizeJson($newValues),
                    ], $modx->getFullTableName('pagebuilder'), "`id`='{$row['id']}'");

                    $this->registry->get('logger')->set("Teaser parsed", [
                        'id' => intval($row['id']),
                        'config' => $row['config'],
                        'update' => ($result ? 'OK' : 'FAIL'),
                    ]);

                    // Если задано время задержки
                    if (Timer::delay($this->registry->get('config')->delayTime)) {
                        $this->registry->get('logger')->set("Delayed", [
                            'delayTime' => ($this->registry->get('config')->delayTime / 1000000) . ' sec.',
                        ]);
                    }
                } else {
                    // Иначе
                    $this->registry->get('logger')->set("Teaser ignored", [
                        'id' => intval($row['id']),
                        'config' => $row['config'],
                    ]);
                }
            }
        }
    }

    /**
     * Метод нормализации json-кода
     *
     * @param string $json
     * @return string
     */
    protected function normalizeJson($json)
    {
        // Экранируем одинарные кавычки
        $json = str_replace("'", "\'", $json);

        return $json;
    }
}
