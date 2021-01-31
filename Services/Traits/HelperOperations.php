<?php


namespace Services\Traits;


trait HelperOperations
{
    private $select = [
        "ID",
        "CODE",
        "IBLOCK_ID"
    ];
    private $iblockId;
    private $filter = [];
    private $offset;
    private $limit;

    public function getEntityById($iblockId, $id, Array $select = [])
    {
        $result = $this->setIblock($iblockId)
            ->setFilter(["ID" => $id])
            ->setSelect($select)
            ->getListFromDb();
        return array_shift($result);
    }

    public function getEntityByCode($iblockId, $code, Array $select = [])
    {
        $result = $this->setIblock($iblockId)
            ->setFilter(["CODE" => $code])
            ->setSelect($select)
            ->getListFromDb();
        return array_shift($result);
    }

    public function getEntitiesByFilter($iblockId, Array $filter, Array $select = [], Array $pagination = [])
    {
        $result = $this->setIblock($iblockId)
            ->setFilter($filter)
            ->setSelect($select);
        if(!is_null($pagination["limit"]) && !is_null($pagination["offset"])){
            $result->setPagination($pagination["offset"], $pagination["limit"]);
        }
        return $result->getListFromDb();
    }

    public function setIblock($iblockId)
    {
        $this->iblockId = $iblockId;
        return $this;
    }

    public function setFilter($filter)
    {
        $this->filter = array_merge($this->filter, $filter);
        return $this;
    }

    public function setSelect($select)
    {
        $this->filter = array_merge($this->filter, $select);
        return $this;
    }

    public function setPagination($offset, $limit)
    {
        $this->offset = $offset;
        $this->limit = $limit;
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
}