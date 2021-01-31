<?php


namespace Services\Traits;

use Bitrix\Main\Data\Cache;

trait BitrixEntity
{
    private $iblockId;

    private $select = [
        "ID",
        "CODE",
        "IBLOCK_ID"
    ];

    private $cacheTime = 0;
    private $cachePath;
    private $cacheId;

    private $filter = [

    ];

    private $offset;
    private $limit;

    public function __call($name, $arguments)
    {
        switch ($name) {
            case "setIblock":
                $this->iblockId = array_shift($arguments);
                break;
            case "setPagination":
                $this->offset = array_shift($arguments);
                $this->limit = array_shift($arguments);
                break;
            case "setSelect":
                $this->select = array_merge($this->select, array_shift($arguments));
                break;
            case "setFilter":
                $this->filter = array_merge($this->filter, array_shift($arguments));
                break;
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

    private function buildQuery($query)
    {
        $query->setSelect($this->select);

        if (isset($this->limit) && isset($this->offset)) {
            $query->setLimit($this->limit);
            $query->setOffset($this->offset);
        }

        if (!empty($this->filter)) {
            $query->setFilter($this->filter);
        }

        return $query;
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