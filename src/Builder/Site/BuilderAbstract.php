<?php

namespace App\Builder\Site;

use Predis\Client as Redis;

abstract class BuilderAbstract
{
    const KEY_ROOT = 'img_crawler';
    const KEY_IMAGES = 'images';
    const KEY_URIS = 'uris';
    const KEY_CHILDREN = 'children';

    private $redis;
    private $scheme;
    private $host;
    private $depth = 0;

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    protected function redis() : Redis
    {
        return $this->redis;
    }

    public function setUrl(string $url)
    {
        $urlData = parse_url($url);
        if(!$urlData) {
            throw new InvalidArgumentException("Are You sure You've passed me an URL?");
        }
        $this->scheme = $urlData['scheme'];
        $this->host = $urlData['host'];
    }

    public function setDepth(int $depth)
    {
        $this->depth = $depth;
    }

    public function depth() : int
    {
        return $this->depth;
    }

    protected function scheme() : string
    {
        return $this->scheme;
    }

    protected function host() : string
    {
        return $this->host;
    }

    protected function url() : string
    {
        return implode('://', [$this->scheme, $this->host]);
    }
}
