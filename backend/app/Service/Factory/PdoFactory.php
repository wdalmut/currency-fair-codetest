<?php
namespace App\Service\Factory;

use DI\Container;

class PdoFactory
{
    public function create(Container $c)
    {
        $host = $c->get("parameters")['database']['host'];
        $dbName = $c->get("parameters")['database']['dbName'];
        $user = $c->get("parameters")['database']['user'];
        $password = $c->get("parameters")['database']['password'];

        $pdo = new \PDO("mysql:host={$host};dbname={$dbName}", $user, $password);
        return $pdo;
    }
}
