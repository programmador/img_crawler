<?php

namespace App\Builder\Site;

use App\Composite\Page\Page;

class ImageStatsBuilder extends BuilderAbstract implements BuilderInterface
{
    public function getResult() : array
    {
        $out = [];
        $scores = $this->getImageScore();
        foreach($scores as $id => $score) {
            $out[$this->getImageUri($id)] = $score;
        }
        return $out;
    }

    private function getImageScore() : array
    {
        $host = $this->host();
        $key = implode(':', [BuilderAbstract::KEY_ROOT, $host, BuilderAbstract::KEY_IMAGES]);
        $scores = $this->redis()->zrange($key, 0, -1, 'WITHSCORES');
        return $scores;
    }

    private function getImageUri(int $id) : string
    {
        $host = $this->host();
        $key = implode(':', [BuilderAbstract::KEY_ROOT, $host, BuilderAbstract::KEY_URIS]);
        return $this->redis()->hget($key, $id);
    }
}
