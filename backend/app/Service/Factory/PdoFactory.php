<?php
namespace App\Service\Factory;

use DI\Container;

class PdoFactory
{
    public function create(Container $c)
    {
        $parametes = $c->get('parameters');

        $host = $parametes['database']['host'];
        $dbName = $parametes['database']['dbName'];
        $user = $parametes['database']['user'];
        $password = $parametes['database']['password'];

        $pdo = new \PDO("mysql:host={$host};dbname={$dbName}", $user, $password);
        return $pdo;
    }
}
