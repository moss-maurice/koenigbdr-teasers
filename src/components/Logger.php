<?php

/**
 * Copyright © 2021 Moss Maurice. All rights reserved.
 * Contacts: <kreexus@yandex.ru>
 * Profile: <https://github.com/moss-maurice>
 */

namespace mmaurice\bdr\teasers\components;

use \mmaurice\bdr\teasers\helpers\CmdHelper;

/**
 * Класс логгера
 */
class Logger
{
    const NO_MESSAGES = 0;
    const ALL_MESSAGES = 1;
    const IMPORTANT_MESSAGES = 2;
    const ERROR_MESSAGES = 3;

    const LEVEL_NORMAL = 0;
    const LEVEL_IMPORTANT = 1;
    const LEVEL_ERROR = 2;

    protected $level;

    /**
     * Метод-конструктор
     *
     * @param integer $level
     */
    public function __construct($level = self::ALL_MESSAGES)
    {
        $this->level = intval($level);
    }

    /**
     * Метод сверки уровня сообщения
     *
     * @param integer $level
     * @return boolean
     */
    protected function checkMessageLevel($level)
    {
        switch ($this->level) {
            case self::ALL_MESSAGES:
                return in_array($level, [self::LEVEL_ERROR, self::LEVEL_IMPORTANT, self::LEVEL_NORMAL]);

                break;
            case self::IMPORTANT_MESSAGES:
                return in_array($level, [self::LEVEL_ERROR, self::LEVEL_IMPORTANT]);

                break;
            case self::ERROR_MESSAGES:
                return in_array($level, [self::LEVEL_ERROR]);

                break;
            case self::NO_MESSAGES:
            default:

                break;
        }

        return false;
    }

    /**
     * Метод ввода данных в логгер
     *
     * @param string $line
     * @param array $options
     * @param integer $level
     * @return void
     */
    public function set($line, $options = [], $level = self::LEVEL_NORMAL)
    {
        if ($this->checkMessageLevel($level)) {
            $coloredLine = CmdHelper::textColor(($level !== self::LEVEL_ERROR ? ($level !== self::LEVEL_IMPORTANT ? 'light_cyan' : 'light_yellow') : 'light_red'), $line);

            $rawLine = CmdHelper::textColor('yellow', date('Y-m-d H:i:s')) . CmdHelper::textColor('white', ' > ') . $coloredLine;

            if (is_array($options) and !empty($options)) {
                foreach ($options as $key => $option) {
                    $options[$key] = CmdHelper::textColor('white', $key) . ': ' . CmdHelper::textColor('magenta', $option);
                }

                $rawLine .= CmdHelper::textColor('white', ' (' . implode('; ', array_values($options)) . ')');
            }

            fwrite(STDOUT, $rawLine . PHP_EOL);
        }
    }
}
