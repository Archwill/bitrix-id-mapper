<?php


namespace Services\Traits;


trait BitrixEntityTrait
{
    private $iblockId;

    private $select = [
        "ID",
        "CODE",
        "IBLOCK_ID"
    ];

    private $cacheTime = 36000000;

    private $filter = [

    ];

    private $offset;
    private $limit;

    public function setIblock($id)
    {
        $this->iblockId = $id;
        return $this;
    }

    public function setPagination($offset, $limit)
    {
        $this->offset = $offset;
        $this->limit = $limit;
        return $this;
    }

    public function setSelect(Array $select)
    {
        $this->select = array_merge($this->select, $select);
        return $this;
    }

    public function setFilter(Array $filter)
    {
        $this->filter = array_merge($this->filter, $filter);
        return $this;
    }

    public function setCacheTime($cacheTime)
    {
        $this->cacheTime = $cacheTime;
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

    public function getResult($name)
    {
        $result = [];
        foreach (static::$list as $item) {
            $result[$item["CODE"] ?? $item["ID"]] = $item;
        }
        return $result;
    }

}