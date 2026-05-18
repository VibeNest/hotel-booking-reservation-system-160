<?php

namespace Pdo;

if (\PHP_VERSION_ID < 80400 && ! class_exists(Mysql::class) && \defined('PDO::MYSQL_ATTR_SSL_CA')) {
    class Mysql
    {
        public const ATTR_SSL_CA = \PDO::MYSQL_ATTR_SSL_CA;
    }
}
