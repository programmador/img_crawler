<?php

namespace App\Service;

use App\Builder\Site\CrawlBuilder;
use App\Builder\Site\Director;
use App\Composite\Page\Page;
use SymfonyBundles\RedisBundle\Redis\ClientInterface as Redis;

class SiteService
{
    private $redis;

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    public function buildFromUrl(string $url, int $depth) : Page
    {
        $builder = new CrawlBuilder($this->redis);
        $director = new Director($builder);
        $director->constructCrawlSite($url, $depth);
        return $builder->getResult();
    }
}
