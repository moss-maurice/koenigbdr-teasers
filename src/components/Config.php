<?php

/**
 * Copyright © 2021 Moss Maurice. All rights reserved.
 * Contacts: <kreexus@yandex.ru>
 * Profile: <https://github.com/moss-maurice>
 */

namespace mmaurice\bdr\teasers\components;

/**
 * Класс конфигурации
 */
class Config
{
    protected $baseConfigPath = '/../configs/config.php';

    protected $config = [];

    /**
     * Метод-конструктор
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $baseConfigPath = realpath(dirname(__FILE__) . $this->baseConfigPath);

        if ($baseConfigPath) {
            $baseConfig = include $baseConfigPath;

            $this->config = array_merge($this->config, $baseConfig);
        }

        $this->config = array_merge($this->config, $config);
    }

    /**
     * Магический метод вывода
     *
     * @param string $key
     * @return void
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->config)) {
            return $this->config[$key];
        }

        return null;
    }

    /**
     * Магический метод ввода
     *
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        $this->config[$key] = $value;

        $this->config = array_filter($this->config);
    }
}
