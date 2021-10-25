<?php

/**
 * Copyright © 2021 Moss Maurice. All rights reserved.
 * Contacts: <kreexus@yandex.ru>
 * Profile: <https://github.com/moss-maurice>
 */

namespace mmaurice\bdr\teasers\helpers;

use \PHP_Parallel_Lint\PhpConsoleColor\ConsoleColor;

/**
 * Консольный помощник
 */
class CmdHelper
{
    /**
     * Колоризированный текст
     *
     * @param string $color
     * @param string $text
     * @return void
     */
    public static function textColor($color, $text)
    {
        return (new ConsoleColor)->apply($color, $text);
    }

    /**
     * Вывод строки данных с переводом каретки в консоль в формате лога
     *
     * @param string $string
     * @return void
     */
    public static function logLine($string = '')
    {
        return self::drawLine(self::textColor('white', date('Y-m-d H:i:s') . ' > ') . $string);
    }

    /**
     * Вывод строки данных с переводом каретки в консоль
     *
     * @param string $string
     * @return void
     */
    public static function drawLine($string = '')
    {
        return self::drawString($string . PHP_EOL);
    }

    /**
     * Вывод строки данных в консоль
     *
     * @param string $string
     * @return void
     */
    public static function drawString($string = '')
    {
        echo $string;

        return true;
    }
}
