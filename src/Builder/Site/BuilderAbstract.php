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
