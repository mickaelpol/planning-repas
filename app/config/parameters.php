<?php
$params = [
    'DATABASE_URL',
    'APP',
    'SYMFONY_ENV',
    'SECRET',
];

foreach ($params as $param) {
    if (isset($_ENV[$param])) {
        $container->setParameter(strtolower($param), $_ENV[$param]);
    }
}