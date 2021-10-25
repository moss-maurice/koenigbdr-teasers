<?php

/**
 * Copyright © 2021 Moss Maurice. All rights reserved.
 * Contacts: <kreexus@yandex.ru>
 * Profile: <https://github.com/moss-maurice>
 */

namespace mmaurice\bdr\teasers\components;

/**
 * Класс таймера
 */
class Timer
{
    const DEFAULT_TIMER = 'main';

    protected static $timers = [];

    /**
     * Метод инициализации таймера
     *
     * @param string $name
     * @return void
     */
    public function start($name = self::DEFAULT_TIMER)
    {
        self::$timers[$name] = microtime(true);
    }

    /**
     * Метод остановки таймера
     *
     * @param string $name
     * @param integer $round
     * @return void
     */
    public function finish($name = self::DEFAULT_TIMER, $round = 2)
    {
        if (array_key_exists($name, self::$timers)) {
            return round(microtime(true) - self::$timers[$name], $round) . ' sec.';
        }

        return false;
    }

    /**
     * Метод уничтожения таймера
     *
     * @param string $name
     * @return void
     */
    public function destroy($name = self::DEFAULT_TIMER)
    {
        if (array_key_exists($name, self::$timers)) {
            unset(self::$timers[$name]);

            return true;
        }

        return false;
    }

    /**
     * Метод ожидания
     *
     * @param integer $msec
     * @return void
     */
    public function delay($msec = 0)
    {
        if (intval($msec) > 0) {
            usleep(intval($msec));

            return true;
        }

        return false;
    }
}
