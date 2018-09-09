<?php

namespace App\Composite\Page;

use App\Composite\CompositeAbstract;

class Page extends CompositeAbstract
{
    const FETCH_ERROR = 'FETCH_ERROR';

    private $uri = '/';
    private $duration = 0;
    private $images = 0;

    public function setUri(string $value)
    {
        $this->uri = $value;
    }

    public function getUri() : string
    {
        return $this->uri;
    }

    public function setDuration(int $value)
    {
        $this->duration = $value;
    }

    public function getDuration() : int
    {
        return $this->duration;
    }

    public function setImages(int $value)
    {
        $this->images = $value;
    }

    public function getImages() : int
    {
        return $this->images;
    }

}
