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
    "rate-limiter" => \DI\object('App\Service\RateLimiter')
        ->constructor(\DI\get("redis")),
    "router" => function () {
        return \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/', ['App\Controller\IndexController', 'index'], [
                "name" => "index"
            ]);
            $r->addRoute('GET', '/reset', ['App\Controller\MessageController', 'resetToken'], [
                "name" => "reset"
            ]);
            $r->addRoute('GET', '/message', ['App\Controller\MessageController', 'getList'], [
                "name" => "message.list"
            ]);
            $r->addRoute('POST', '/message', ['App\Controller\MessageController', 'create'], [
                "name" => "message.create"
            ]);
        });
    },
];
