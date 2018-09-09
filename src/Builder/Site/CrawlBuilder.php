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
        var_dump($page->getImages());

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
}
