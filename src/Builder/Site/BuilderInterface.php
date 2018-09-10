<?php

namespace App\Builder\Site;

use App\Composite\Page\Page;

interface BuilderInterface
{
    function setUrl(string $url);

    function setDepth(int $depth);

    /* Simple image stats builder currently does not implement Page composite as a return value */ 
    //function getResult() : Page;
    function getResult();
}
