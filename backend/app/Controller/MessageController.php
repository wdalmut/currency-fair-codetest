<?php

namespace App\Controller;

use App\Validator\MessageValidator;

class MessageController
{
    /**
     * @Inject("di")
     */
    private $container;

    public function resetToken($request, $response)
    {
        $rateLimiter = $this->container->get("rate-limiter");
        parse_str($request->getUri()->getQuery(), $query);
        if (!array_key_exists("userId", $query)) {
            throw new \Exception("Query param userId is missing");
        }
        $rateLimiter->resetCounter($query['userId']);
        return $response;
    }

    public function create($request, $response)
    {
        $redis = $this->container->get("redis");
        $rateLimiter = $this->container->get("rate-limiter");
        $now = new \DateTime();
        $body = json_decode((string)$request->getBody(), true);
        $filter = $this->container->get('App\Validator\MessageValidator');
        $filter->setData($body);

        if ($filter->isValid()) {
            $rateLimiter->increaseNumberOfRequests($body['userId']);
            $lastTime = $rateLimiter->getLastTime($body['userId']);
            $numberOfCalls = $rateLimiter->getNumberOfRequests($body['userId']);
            $response = $response->withHeader("X-Count", $numberOfCalls);

            if ($now->diff($lastTime)->format("%s") <= 300 && $numberOfCalls <= 10) {
                $body['id'] = $redis->incr("list");
                $redis->lpush("transactions", json_encode($body));
                $redis->publish("app", json_encode($body));
                $response->getBody()->write(json_encode($body));
                return $response;
            }

            $response = $response->withStatus(429);
            return $response;
        }
        $response = $response->withStatus(406);
        return $response;
    }

    public function getList($request, $response)
    {
        $rows = $this->container->get("redis")->lrange("transactions", 1, -1);
        $list = [];
        foreach ($rows as $row) {
            $list[] = json_decode($row, true);
        }
        $response->getBody()->write(json_encode($list));
        return $response;
    }
}
