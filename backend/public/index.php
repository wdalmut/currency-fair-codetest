<?php

use GianArb\Penny\Exception\MethodNotAllowed;
use GianArb\Penny\Exception\RouteNotFound;

chdir(dirname(__DIR__));
require "vendor/autoload.php";

$app = new \GianArb\Penny\App();

$app->getContainer()->get("http.flow")->attach("*", function ($e) {
    $response = $e->getResponse()->withHeader('Content-Type', 'application/json');
    $e->setResponse($response);
});

$app->getContainer()->get("http.flow")->attach("ERROR_DISPATCH", function ($e) {

    if ($e->getException() instanceof RouteNotFound) {
        $response = $e->getResponse()->withStatus(404);
        $e->setResponse($response);
        throw $e;
    }

    if ($e->getException() instanceof MethodNotAllowed) {
        $response = $e->getResponse()->withStatus(405);
        $e->setResponse($response);
        throw $e;
    }

    if ($e->getException() instanceof \Exception) {
        $response = $e->getResponse()->withStatus(500);
        $e->setResponse($response);
        throw $e;
    }
}, -1000);

$emitter = new \Zend\Diactoros\Response\SapiEmitter();
$emitter->emit($app->run());
