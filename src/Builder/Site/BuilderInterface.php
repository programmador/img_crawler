<?php

namespace App\Builder\Site;

use App\Composite\Page\Page;

interface BuilderInterface
{
    function setUrl(string $url);

    function setDepth(int $depth);

    function getResult() : Page;
}
