<?php
namespace App\Service;

class RateLimiter
{
    private $redis;

    public function __construct(\Predis\Client $client)
    {
        $this->redis = $client;
    }

    public function getNumberOfRequests($user)
    {
        return $this->redis->get("list-{$user}");
    }

    public function resetCounter($user)
    {
        $this->redis->del("list-{$user}");
        $this->redis->del($user);
    }

    public function increaseNumberOfRequests($user)
    {
        return $this->redis->incr("list-{$user}");
    }

    public function getLastTime($user)
    {
        if ($this->redis->get($user) != null) {
            $date = new \DateTime();
            return $date->setTimestamp($this->redis->get($user));
        }
        $last = new \DateTime();
        $this->redis->set($user, $last->getTimestamp());
        return $last;
    }
}
