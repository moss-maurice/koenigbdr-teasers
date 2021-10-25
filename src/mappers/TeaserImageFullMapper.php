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
class TeaserImageFullMapper extends MapperInterface
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

        return $teaser;
    }
}
