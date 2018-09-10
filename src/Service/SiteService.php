<?php

namespace App\Service;

use App\Builder\Site\BuilderAbstract;
use App\Builder\Site\CrawlBuilder;
use App\Builder\Site\ImageStatsBuilder;
use App\Builder\Site\Director;
use App\Composite\Page\Page;

class SiteService
{
    private $redis;

    public function __construct(RedisService $redisSerivice)
    {
        $this->redis = $redisSerivice->c();
    }

    public function buildFromUrl(string $url, int $depth) : Page
    {
        $builder = new CrawlBuilder($this->redis);
        $director = new Director($builder);
        $director->constructCrawlSite($url, $depth);
        return $builder->getResult();
    }

    public function getImageStats(string $host) : array
    {
        $builder = new ImageStatsBuilder($this->redis);
        $director = new Director($builder);
        $director->constructImageStats($host);
        return $builder->getResult();
    }

    public function getHosts() : array
    {
        $pattern = implode(':', [BuilderAbstract::KEY_ROOT, '*', BuilderAbstract::KEY_IMAGES]);
        $keys = $this->redis->keys($pattern);
        $out = [];
        foreach ($keys as $k) {
            $p = implode('', [
                '#',
                BuilderAbstract::KEY_ROOT,
                '\:(.+)\:',
                BuilderAbstract::KEY_IMAGES,
                '#',
            ]);
            preg_match($p, $k, $matches);
            if($matches) {
                $out[] = $matches[1];
            }
        }
        return $out;
    }
}
