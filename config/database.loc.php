<?php

define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', $config["ncompany"]);
define('DB_LOGIN', 'root');
define('DB_PASSWORD', '');

define('DSN_MYSQL', 'mysql:host=' . DB_HOST . ';port=' . DB_HOST . ';dbname=' . DB_NAME);
