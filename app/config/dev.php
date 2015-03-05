<?php
// Doctrine (db)
$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'charset'  => 'utf8',
    'host'     => '127.0.0.1',  // Mandatory for PHPUnit testing
    'port'     => '3306',
    'dbname'   => 'microcms',
    'user'     => 'microcms_user',
    'password' => 'microcms_pass',
);

// Enable the debug mode
$app['debug'] = true;

// Define log level
$app['monolog.level'] = 'INFO';
