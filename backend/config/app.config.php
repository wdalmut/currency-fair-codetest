<?php
return [
    "parameters" => [
        "database" => [
            "host" => "127.0.0.1",
            "user" => "root",
            "password" => "root",
            "dbName" => "app",
        ]
    ],
    "redis" => \DI\object("Predis\Client"),
    "router" => function () {
        return \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/', ['App\Controller\IndexController', 'index'], [
                "name" => "index"
            ]);
            $r->addRoute('POST', '/message', ['App\Controller\MessageController', 'create'], [
                "name" => "message.create"
            ]);
        });
    },
];
