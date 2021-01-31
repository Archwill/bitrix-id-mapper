<?php


namespace Services\Traits;

use Bitrix\Main\Data\Cache;

trait CacheOperations
{

    private $cacheTime = 0;
    private $cachePath;
    private $cacheId;

    public function __call($name, $arguments)
    {
        switch ($name) {
            case "setCacheTime":
                $this->cacheTime = array_shift($arguments);
                break;
            case "setCacheId":
                $this->cacheId = array_shift($arguments);
                break;
            case "setCachePath":
                $this->cachePath = array_shift($arguments);
                break;
        }
        return $this;
    }

    private function cacheResult(Callable $getResultMethod)
    {
        $cache = Cache::createInstance();
        if ($cache->initCache($this->cacheTime, $this->cacheId, $this->cachePath)) {
            $result = $cache->getVars();
        } elseif ($cache->startDataCache()) {
            $result = $getResultMethod();

            $cache->endDataCache($result);
        }

        return $result;
    }

    public function getResult($name = null)
    {
        $result = [];
        foreach (static::$list as $item) {
            $result[$item["CODE"] ?? $item["ID"]] = $item;
        }
        return $result;
    }

}