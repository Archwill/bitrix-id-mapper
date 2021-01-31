<?php

namespace Services;

use Bitrix\Iblock\Iblock;
use Services\Traits\BitrixEntity;
use Services\Traits\StandardEntityOperations;

class IblockElementService extends AbstractService
{
    use BitrixEntity, StandardEntityOperations;

    protected static $list;

    private function buildCacheId()
    {
        return "iblock_element_" . implode("_", [
                $this->iblockId,
                $this->offset,
                $this->limit,
                implode("_", $this->filter),
                implode("_", $this->select)
            ]);
    }

    private function getElements()
    {
        $result = [];

        if ($this->iblockId > 0) {
            $iblock = Iblock::wakeUp($this->iblockId);
            $query = $iblock->getEntityDataClass()::query();

            $result = $this->buildQuery($query)->fetchAll();
        }

        return $result;
    }

    protected function getListFromDb()
    {
        if ($this->cacheTime > 0) {
            $this->setCachePath("/iblock_element_" . $this->iblockId);
            $this->setCacheId($this->buildCacheId());
            return $this->cacheResult([self::class, "getElements"]);
        } else {
            return $this->getElements();
        }
    }
}