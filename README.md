
# Обновление тизеров для *www.koenigbdr.devs.ideo-software.com*

![main](https://raw.githubusercontent.com/moss-maurice/koenigbdr-teasers/main/assets/images/main.png)

![PHP version](https://img.shields.io/badge/PHP->=v5.6-red.svg?php=7.3) ![qURL Library](https://img.shields.io/badge/qURL->=v0.1.1-green.svg?qURL=0.1.1)

## Для чего это надо?
Данный модуль реализован для обновления тизеров на сайте [www.koenigbdr.devs.ideo-software.com](https://www.koenigbdr.devs.ideo-software.com/)

## Установка

1) Необходимо склонировать проект на веб-сервер с помощью SSH. Клонировать необходимо в корневой каталог веб-сервера:
```sh
root@localhost:~#: git clone https://github.com/moss-maurice/koenigbdr-teasers.git
```

2) В SSH-консоли необходимо перейти в склонированный каталог проекта `koenigbdr-teasers` и выполнить обновление компонентов `composer`:
```sh
root@localhost:~#: cd koenigbdr-teasers
root@localhost:~/koenigbdr-teasers#: composer update
```

3) Для запуска, достаточно перейти в корневой каталог проекта `koenigbdr-teasers` и выполнить cli-команду:
```sh
root@localhost:~/koenigbdr-teasers#: php cli.php
```
Эту же команду достаточно добавить в планировщик CRON.

4) Для включения режима отладки, необходимо в файле `koenigbdr-teasers/configs/config.php` добавить в начале следующий код:
```php
define('TEST_ENV', true);
```
Или достаточно раскоментировать аналогичную строку в файле `koenigbdr-teasers/cli.php`.
