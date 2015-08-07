<?php

namespace App\Controller;

use App\Validator\MessageValidator;

class MessageController
{
    /**
     * @Inject("di")
     */
    private $container;

    public function create($request, $response)
    {
        $body = json_decode((string)$request->getBody(), true);
        $filter = $this->container->get('App\Validator\MessageValidator');
        $filter->setData($body);

        if ($filter->isValid()) {
            $body['id'] = $this->container->get("redis")->incr("app");
            $this->container->get("redis")->set($body['id'], json_encode($body));
            $this->container->get("redis")->publish("app", json_encode($body));
            $response->getBody()->write(json_encode($body));
            var_dump($response->getBody()->__toString());
            return $response;
        }
        $response = $response->withStatus(406);
        return $response;
    }
}
