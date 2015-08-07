<?php

namespace App\Controller;

class IndexController
{
    public function index($request, $response)
    {
        $response->getBody()->write(json_encode(["ping" => "ok"]));
        return $response;
    }
}
