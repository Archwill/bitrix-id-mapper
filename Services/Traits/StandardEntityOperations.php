<?php


namespace Services\Traits;


trait StandardEntityOperations
{
    public function getEntityById($iblockId, $id, $select = [])
    {
        $result = $this->setIblock($iblockId)
            ->setFilter(["ID" => $id])
            ->setSelect($select)
            ->getListFromDb();
        return array_shift($result);
    }

    public function getEntityByCode($iblockId, $code, $select = [])
    {
        $result = $this->setIblock($iblockId)
            ->setFilter(["CODE" => $code])
            ->setSelect($select)
            ->getListFromDb();
        return array_shift($result);
    }

    public function getEntitiesByFilter($iblockId, $filter, $select = [])
    {
        return $this->setIblock($iblockId)
            ->setFilter($filter)
            ->setSelect($select)
            ->getListFromDb();
    }
}