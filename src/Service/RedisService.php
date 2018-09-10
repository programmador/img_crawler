<?php

namespace App\Service;

use Predis\Client as Redis;

class RedisService
{
    private $redis;

    public function __construct()
    {
        /*
            I HATE SYMFONY BUNDLES
            I HATE SYMFONY BUNDLES
            I HATE SYMFONY BUNDLES
            I HATE SYMFONY BUNDLES
            I HATE SYMFONY BUNDLES
            I HATE SYMFONY BUNDLES
            I HATE SYMFONY BUNDLES
            I HATE SYMFONY BUNDLES

            I'm sorry. I know it's not the best place for blaming
            but it's not a production project.

            One bundle needs an older (yes, an older one!) PHP

            Another bundle provides nice config in .env and dependency injection but
            is only able to build a cluster connection and I get:
            "Cannot use 'KEYS' over clusters of connections."
            Why can't I just setup ['cluster' => false] as in Laravel?
            Nobody uses KEYS command in Redis+Symfony?

            And Yesss! Of course, Ill leave the server config hardcoded here!
         */
        $this->redis = new Redis('redis://127.0.0.1:6379/');
    }

    public function c() : Redis
    {
        return $this->redis;
    }
}
