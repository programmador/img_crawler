<?php

namespace App\Builder\Site;

use App\Composite\Page\Page;

trait PagePersisterTrait
{
    private function persist(Page $page)
    {
        $this->saveImages($page);
        $this->saveUris($page);
        $this->saveAsChild($page);
        //$this->saveDuration($page);   //unimplemented
    }

    private function clearStorage()
    {
        $pattern = $this->getKey('*');
        $keys = $this->redis()->keys($pattern);
        foreach ($keys as $key) {
            $this->redis()->del($key);
        }
    }

    private function saveImages(Page $page)
    {
        $key = $this->getKey(BuilderAbstract::KEY_IMAGES);
        $this->redis()->zadd($key, $page->getImages(), $page->getId());
    }

    private function saveUris(Page $page)
    {
        $key = $this->getKey(BuilderAbstract::KEY_URIS);
        $this->redis()->hset($key, $page->getId(), $page->getUri());
    }

    private function saveAsChild(Page $page)
    {
        if(!$parent = $page->getParent()) {
            return;
        }
        $keyEnd = implode(':', [BuilderAbstract::KEY_CHILDREN, $parent->getId()]);
        $key = $this->getKey($keyEnd);
        $this->redis()->sadd($key, $page->getId());
    }

    private function getKey(string $keyEnd) : string
    {
        return implode(':', [BuilderAbstract::KEY_ROOT, $this->host(), $keyEnd]);
    }
}
