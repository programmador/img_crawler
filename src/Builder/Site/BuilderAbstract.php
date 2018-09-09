<?php

namespace App\Builder\Site;

use SymfonyBundles\RedisBundle\Redis\ClientInterface as Redis;

abstract class BuilderAbstract
{
    private $redis;

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    protected function redis() : Redis
    {
        return $this->redis;
    }
}
