<?php

/**
 * Copyright © 2021 Moss Maurice. All rights reserved.
 * Contacts: <kreexus@yandex.ru>
 * Profile: <https://github.com/moss-maurice>
 */

namespace mmaurice\bdr\teasers\mappers;

use \mmaurice\bdr\teasers\interfaces\MapperInterface;

/**
 * Класс-маппер
 */
class TeaserBoxMapper extends MapperInterface
{
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
        $teaser = parent::remap($teaser, $data);

        $teaser->image = "https:{$data->data->hotel->images->large}";
        $teaser->subtitle = $data->data->hotel->name;
        $teaser->stars = $data->data->hotel->category;
        $teaser->text = "{$this->registry->get('config')->amadeusLngJson['board'][$data->data->items[0]->board->code]} | " . $this->normalizeString($data->data->items[0]->room->name) . " | 2 Personen | {$data->data->items[0]->duration} {$this->registry->get('config')->amadeusLngJson['duration']['nights']}";

        return $teaser;
    }

    /**
     * Метод нормализации строки
     *
     * @param string $string
     * @return string
     */
    protected function normalizeString($string)
    {
        $string = str_replace([',', '  '], [', ', ' '], $string);

        return $string;
    }
}
