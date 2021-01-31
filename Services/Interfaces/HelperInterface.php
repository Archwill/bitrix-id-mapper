<?php


namespace Services\Interfaces;


interface HelperInterface
{
    
    public function getEntityById($iblockId, $id, Array $select);

    public function getEntityByCode($iblockId, $code, Array $select);

    public function getEntitiesByFilter($iblockId, Array $filter, Array $select, Array $pagination);

}
