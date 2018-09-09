<?php

namespace App\Builder\Site;

use App\Composite\Page\Page;

class CrawlBuilder extends BuilderAbstract implements BuilderInterface
{
    private $url;

    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    public function getResult() : Page
    {
        return new Page();
    }
}
