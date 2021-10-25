<?php

/**
 * Copyright © 2021 Moss Maurice. All rights reserved.
 * Contacts: <kreexus@yandex.ru>
 * Profile: <https://github.com/moss-maurice>
 */

use \mmaurice\bdr\teasers\components\Logger;

if (!defined('TEST_ENV')) {
    define('TEST_ENV', false);
}

return [
    // delay 1000000 msec. = 1 sec.
    'delayTime' => 1000000,
    'logger' => (TEST_ENV ? Logger::ALL_MESSAGES : Logger::IMPORTANT_MESSAGES),
    'api' => 'https://basic-light-ibe.traveltainment.de',
    'teasers' => [],
    'amadeusLngJson' => json_decode('{"board":{"ONLYSTAY":"nur Übernachtung","SELFCATERING":"nur Übernachtung","BREAKFAST":"Frühstück","BREAKFASTECONOMY":"Frühstück Economy","BREAKFASTSUPERIOR":"Frühstück Superior","HALFBOARD":"Halbpension","HALFBOARDECONOMY":"Halbpension Economy","HALFBOARDSUPERIOR":"Halbpension Superior","FULLBOARD":"Vollpension","FULLBOARDECONOMY":"Vollpension Economy","FULLBOARDSUPERIOR":"Vollpension Superior","ALLINCLUSIVE":"All Inclusive","ALLINCLUSIVEECONOMY":"All Inclusive Economy","ALLINCLUSIVESUPERIOR":"All Inclusive Superior","HALFBOARDPLUS":"Halbpension Plus","FULLBOARDPLUS":"Vollpension Plus","ALLINCLUSIVEPLUS":"All Inclusive Plus","SPECIALBOARD":"Spezial","ACCORDINGDESCRIPTION":"Laut Programm"},"duration": {"night":"Nacht","nights":"Nächte"}}', true),
    'ddate' => ' + 3 days',
    'rdate' => ' + 180 days',
];
