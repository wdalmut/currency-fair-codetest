<?php

 header("Access-Control-Allow-Origin: *");
use GianArb\Penny\Exception\MethodNotAllowed;
use GianArb\Penny\Exception\NotFound;
use GianArb\Penny\Event\HttpErrorFlow;

chdir(dirname(__DIR__));
require "vendor/autoload.php";

$app = new \GianArb\Penny\App();

$app->getContainer()->get("http.flow")->attach("*", function ($e) {
    $response = $e->getResponse()->withHeader('Content-Type', 'application/json');
    $e->setResponse($response);
});

$app->getContainer()->get("http.flow")->attach("*", function ($e) {
    if ($e instanceof HttpErrorFlow && $e->getException() != null) {
        $response = $e->getResponse()->withStatus(500);
        $response->getBody()->write(json_encode(["error" => [
            "message" => $e->getException()->getMessage()
        ]]));
        $e->setResponse($response);
    }
}, -999);

$app->getContainer()->get("http.flow")->attach("ERROR_DISPATCH", function ($e) {

    if ($e->getException() instanceof RouteNotFound) {
        $response = $e->getResponse()->withStatus(404);
    }
    if ($e->getException() instanceof MethodNotAllowed) {
        $response = $e->getResponse()->withStatus(405);
    }
    $e->setResponse($response);
}, -1000);

$emitter = new \Zend\Diactoros\Response\SapiEmitter();
$emitter->emit($app->run());
