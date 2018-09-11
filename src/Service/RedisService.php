<?php

namespace App\Service;

use Predis\Client as Redis;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class RedisService
{
    private $redis;

    public function __construct(Container $container)
    {
        $connString = $container->getParameter('redis')['connection_string'];
        $this->redis = new Redis($connString);
    }

    public function c() : Redis
    {
        return $this->redis;
    }
}
