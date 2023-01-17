<?php

use Alco\Gallery\Class\DiContainer\DiContainer;
use Alco\Gallery\Class\Repository\DrinksRepository;
use Alco\Gallery\Class\Repository\TokensRepository;
use Alco\Gallery\Class\Repository\UsersRepository;

require_once './vendor/autoload.php';

$container = new DiContainer();
$pdo = new PDO('sqlite:./db.db');
$container->bind(
    DrinksRepository::class,
    new DrinksRepository($pdo)
);

$container->bind(
    TokensRepository::class,
    new TokensRepository($pdo)
);

$container->bind(
    UsersRepository::class,
    new UsersRepository($pdo)
);

return $container;