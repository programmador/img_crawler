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
        /*$this->builder->setTokenId($this->getAccessToken());
        $this->builder->setUid($uid);
        $this->builder->setKey($this->getMacKey());
        $this->builder->setScope($scope);
        $this->builder->setTtl($ttl);*/
        return $this;
    }
}
