<?php

namespace App\Builder\Site;

use App\Composite\CompositeAbstract;
use App\Composite\CompositeVisitorInterface;
use App\Composite\Page\Page;
use InvalidArgumentException;
use Symfony\Component\DomCrawler\Crawler;

class CrawlBuilder extends BuilderAbstract implements BuilderInterface, CompositeVisitorInterface
{
    public function getResult() : Page
    {
        $page = new Page();
        $page->setUri('/');
        $page->accept($this);
        return $page;
    }

    public function visit(CompositeAbstract $page)
    {
        $link = $this->url() . $page->getUri();
        $html = file_get_contents($link);
        $crawler = new Crawler($html);

        $imageNumber = count($this->getImageUris($crawler));
        $page->setImages($imageNumber);

        $childPages = $this->getChildPageUris($crawler);

        // @TODO call accept() for children until max depth reached
    }

    private function getImageUris(Crawler $crawler) : array
    {
        $uris = [];
        foreach ($crawler->filter('img') as $domElement) {
            $src = $domElement->getAttributeNode("src")->value;
            $uri = $this->getImageUri($src);
            if($uri) {
                $uris[] = $uri;
            }
        }
        return $uris;
    }

    private function getImageUri(string $src) : ?string
    {
        $expr = "/^\/\S+\.(jpg|png|gif)$/";
        preg_match($expr, $src, $matches);
        if($matches) {
            return $matches[0];
        }
        return null;
    }

    private function getChildPageUris(Crawler $crawler) : array
    {
        $uris = [];
        foreach ($crawler->filter('a') as $domElement) {
            $src = $domElement->getAttributeNode("href")->value;
            $uri = $this->getChildPageUri($src);
            if($uri) {
                $uris[] = $uri;
            }
        }
        return $uris;
    }

    private function getChildPageUri(string $url) : ?string
    {
        $urlData = parse_url($url);
        if(!$urlData) {
            return null;
        }
        if(!isset($urlData['host']) || !isset($urlData['path'])) {
            return null;
        }
        if($urlData['host'] != $this->host()) {
            return null;
        }
        if(isset($urlData['query'])) {
            return implode('?', [$urlData['path'], $urlData['query']]);
        }
        return $urlData['path'];
    }

    private function startsWith(string $str, string $starts) : bool
    {
        return (strpos($str, $starts) === 0);
    }

    private function convertUrlToUriIfLocal(string $url) : string
    {
        if($this->startsWith($url, $this->url())) {
            return str_replace($this->url(), '', $url);
        }
        return $url;
    }
}
