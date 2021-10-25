<?php

/**
 * Copyright © 2021 Moss Maurice. All rights reserved.
 * Contacts: <kreexus@yandex.ru>
 * Profile: <https://github.com/moss-maurice>
 */

use \Exception;
use \mmaurice\bdr\teasers\components\Config;
use \mmaurice\bdr\teasers\components\Logger;
use \mmaurice\bdr\teasers\components\Registry;
use \mmaurice\bdr\teasers\components\Timer;
use \mmaurice\bdr\teasers\Updater;

try {
    global $modx;

    // Объявляем режим тестирования и отладки
    //define('TEST_ENV', true);

    // Подключаем вендоры композера
    require_once realpath(dirname(__FILE__) . '/vendor/autoload.php');

    // Загрузка пользовательского конфига
    $config = [];

    $configPath = realpath(dirname(__FILE__) . '/configs/config.php');

    if ($configPath) {
        $config = include $configPath;
    }

    // Объявляем реестр
    $registry = new Registry;

    // Инициируем таймер
    $registry->set('timer', function () {
        return new Timer;
    });

    // Инициируем конфиг
    $registry->set('config', function () use ($config) {
        return new Config($config);
    });

    // Инициируем Modx API
    include_once realpath(dirname(__FILE__) . '/../index.php');

    $registry->set('modx', $modx);

    // Инициируем логгер
    $registry->set('logger', function () use ($registry) {
        return new Logger($registry->get('config')->logger);
    });

    // Ограничиваем использование скрипта только режимом CLI
    if ((php_sapi_name() !== 'cli')) {
        throw new Exception("Access denied! Only CLI-mode available");
    } else {
        // Запускаем скрипт
        $registry->get('timer')->start();

        $updater = new Updater($registry);

        $updater->run();

        $time = $registry->get('timer')->finish();

        $registry->get('timer')->destroy();

        $registry->get('logger')->set("Done in {$time}", [], Logger::LEVEL_IMPORTANT);

        // Нормальный выход
        exit;
    }
} catch (Exception $exception) {
    $registry->get('logger')->set("Canceled with error", [], Logger::LEVEL_IMPORTANT);
    $registry->get('logger')->set($exception->getMessage(), [], Logger::LEVEL_ERROR);

    // Выход с ошибкой
    exit(1);
}
