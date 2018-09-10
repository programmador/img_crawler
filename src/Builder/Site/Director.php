<?php

namespace App\Builder\Site;

class Director
{
    private $builder;

    public function __construct(BuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    public function constructCrawlSite(string $url, int $depth) : self
    {
        $this->builder->setUrl($url);
        $this->builder->setDepth($depth);
        return $this;
    }

    public function constructImageStats(string $host) : self
    {
        $this->builder->setUrl('http://' . $host);
        return $this;
    }
}
