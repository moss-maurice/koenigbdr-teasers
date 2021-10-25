<?php

/**
 * Copyright © 2021 Moss Maurice. All rights reserved.
 * Contacts: <kreexus@yandex.ru>
 * Profile: <https://github.com/moss-maurice>
 */

namespace mmaurice\bdr\teasers\components;

use \Closure;

/**
 * Класс реестра данных
 */
class Registry
{
    protected $storage;

    /**
     * Метод-конструктор
     */
    public function __construct()
    {
        $this->flush();
    }

    /**
     * Метод вывода данных из реестра
     *
     * @param string $key
     * @param mixed $defaultValue
     * @return mixed
     */
    public function get($key, $defaultValue = null)
    {
        if ($this->has($key)) {
            if ($this->storage[$key] instanceof Closure) {
                return $this->storage[$key]->__invoke();
            }

            return $this->storage[$key];
        }

        return $defaultValue;
    }

    /**
     * Метод ввода данных в реестр
     *
     * @param string $key
     * @param mixed $value
     * @return object
     */
    public function set($key, $value)
    {
        $this->storage[$key] = $value;

        return $this;
    }

    /**
     * Метод определения наличия ключа в реестре
     *
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
        if (array_key_exists($key, $this->storage)) {
            return true;
        }

        return false;
    }

    /**
     * Метод обнуления реестра
     *
     * @return object
     */
    public function flush()
    {
        $this->storage = [];

        return $this;
    }
}
