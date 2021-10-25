<?php

/**
 * Copyright © 2021 Moss Maurice. All rights reserved.
 * Contacts: <kreexus@yandex.ru>
 * Profile: <https://github.com/moss-maurice>
 */

use \mmaurice\bdr\teasers\components\Logger;
use \mmaurice\bdr\teasers\mappers\TeaserMapper;
use \mmaurice\bdr\teasers\mappers\TeaserBoxMapper;
use \mmaurice\bdr\teasers\mappers\TeaserContentDoubleMapper;
use \mmaurice\bdr\teasers\mappers\TeaserImageMapper;
use \mmaurice\bdr\teasers\mappers\TeaserImageFullMapper;
use \mmaurice\bdr\teasers\mappers\TeaserToplistMapper;

if (!defined('TEST_ENV')) {
    define('TEST_ENV', false);
}

// Объявление констант для инициализации Modx API
define('MODX_API_MODE', true);
define('MODX_CLI', true);

// Если объявлен режим отладки
if (TEST_ENV) {
    // Директивы PHP для режима отладки
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    ini_set('memory_limit', '4096M');

    // Объявление констант для корректного вывода ошибок Modx
    $_SESSION['mgrValidated'] = 1;
    define('IN_MANAGER_MODE', true);
}

// Возвращаемая конфигурация
return [
    // Задержка между циклами в мсек. 1 000 000 мсек. = 1 сек.
    'delayTime' => 1000000,
    // Соответствие классов-мапперов объявленным конфигам
    'teasers' => array_filter([
        'teaser' => TeaserMapper::class,
        'teaser_box' => TeaserBoxMapper::class,
        'teaser_content_double' => TeaserContentDoubleMapper::class,
        'teaser_image' => TeaserImageMapper::class,
        'teaser_image_full' => TeaserImageFullMapper::class,
        'teaser_toplist' => TeaserToplistMapper::class,
    ]),
];
