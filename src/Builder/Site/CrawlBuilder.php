<?php

namespace App\Builder\Site;

use App\Composite\CompositeAbstract;
use App\Composite\CompositeVisitorInterface;
use App\Composite\Page\Page;
use InvalidArgumentException;
use Symfony\Component\DomCrawler\Crawler;
use Exception;

class CrawlBuilder extends BuilderAbstract implements BuilderInterface, CompositeVisitorInterface
{
    use PagePersisterTrait;

    private $uniqueUris = [];
    private $lastId = 0;

    public function getResult() : Page
    {
        $this->clearStorage();
        $page = new Page();
        $page->setUri('/');
        $page->accept($this);
        return $page;
    }

    public function visit(CompositeAbstract $page)
    {
        $this->uniqueUris[] = $page->getUri();
        $link = $this->url() . $page->getUri();
        try {
            $html = file_get_contents($link);
        } catch (Exception $e) {
            var_dump("Warning: failed fetching " . $page->getUri());
            $parent = $page->getParent();
            if($parent) {
                $parent->deleteChild($page->getUri());
            }
            return;
        }
        $crawler = new Crawler($html);  // Yeah, not recursion-friendly action. I'm sorry.

        $imageNumber = count($this->getImageUris($crawler));
        $page->setImages($imageNumber);

        $page->setId(++$this->lastId);
        $this->persist($page);

        $str = str_pad($page->getUri(), strlen($page->getUri()) + $page->getLevel() - 1, "_",
            STR_PAD_LEFT);
        var_dump('Info: processed ' . $str);

        if($page->getLevel() < $this->depth()) {
            $childPageUris = $this->getChildPageUris($crawler);
            $this->processChildren($page, $childPageUris);
        }
    }

    private function processChildren(CompositeAbstract $page, array $childUris)
    {
        foreach($childUris as $childUri) {
            if(in_array($childUri, $this->uniqueUris)) {
                continue;
            }
            $child = new Page();
            $page->addChild($child);
            $child->setUri($childUri);
            $child->setParent($page);
            $child->accept($this);
        }
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
