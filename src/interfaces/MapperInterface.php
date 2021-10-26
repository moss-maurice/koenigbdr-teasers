<?php

/**
 * Copyright © 2021 Moss Maurice. All rights reserved.
 * Contacts: <kreexus@yandex.ru>
 * Profile: <https://github.com/moss-maurice>
 */

namespace mmaurice\bdr\teasers\interfaces;

use \mmaurice\bdr\teasers\components\Registry;
use \mmaurice\qurl\Client;
use \mmaurice\qurl\Response;

/**
 * Интерфейс маппера
 */
abstract class MapperInterface
{
    protected $registry;
    protected $request;

    /**
     * Метод-конструктор
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        $this->registry = $registry;

        // Подготавливаем объект запроса
        $this->request = (new Client)->request();
    }

    /**
     * Метод обновления данных
     *
     * @param string $json
     * @param Response $response
     * @return string
     */
    public function parse($json, &$response = null)
    {
        $api = $this->registry->get('config')->api;
        $dDate = $this->registry->get('config')->ddate;
        $rDate = $this->registry->get('config')->rdate;

        // Данные тизера
        $teaserData = json_decode($json);

        // Если тизер имеет валидный url
        if ($this->valideTeaserUrl($teaserData->url)) {
            $getParams = [];

            parse_str(parse_url($teaserData->url, PHP_URL_QUERY), $getParams);

            // Если в ссылке тизера есть aid
            if (array_key_exists('aid', $getParams)) {
                // Собираем запрос
                $response = $this->request->get([
                    "{$api}/api/offer",
                    [
                        'v' => '9a8b0eb5dbf9',
                        'adult' => 2,
                        'child' => 0,
                        'ibe' => 'package',
                        'su' => 130101,
                        'taid' => 'buchdeinereise',
                        'resPerPagOff' => 1,
                        'aid' => $getParams['aid'],
                        'ddate' => date('Y-m-d', strtotime(date('Y-m-d') . $dDate)),
                        'rdate' => date('Y-m-d', strtotime(date('Y-m-d') . $rDate)),
                    ],
                ]);

                // Если запрос удался
                if (in_array($response->getResponseCode(), [200])) {
                    // Обновляем данные тизера
                    $teaserData = $this->remap($teaserData, json_decode($response->getRawResponseBody()));
                }
            }
        }

        // Возвращаем JSON-код с данными тизера
        return json_encode($teaserData, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }

    /**
     * Метод ремаппинга данных тизера
     *
     * Метод необходим для обогощения $teaser из $data.
     * Необходимо вернуть обогощенный $teaser.
     *
     * @param object $teaser - объект, построенный из JSON-объекта тизера из БД
     * @param object $data - объект, построенный из JSON-объекта ответа на запрос
     * 
     * @return object $teaser
     */
    public function remap(object $teaser, object $data)
    {
        $api = $this->registry->get('config')->api;

        // Цена
        $teaser->button_text = $data->data->items[0]->price->original->amount;
        // Ссылка
        $teaser->url = "{$api}/offer?taid=buchdeinereise&su=130101&prcl=082e39&accol=0cb6b1&bgcol=t&adult=2&aid={$data->data->items[0]->hotel->id}&ddate={$data->data->items[0]->start->date}&rdate={$data->data->items[0]->end->date}";

        // Возвращаем тизер
        return $teaser;
    }

    /**
     * Метод валидации URL тизера
     *
     * @param string $url
     * @return boolean
     */
    protected function valideTeaserUrl($url)
    {
        if (!is_null($url) and !empty($url)) {
            $api = $this->registry->get('config')->api;

            return preg_match('/(' . str_replace([':', '/', '.', '-'], ["\\:", "\\/", "\\.", "\\-"], $api) . ')/im', $url, $matches);
        }

        return false;
    }
}
