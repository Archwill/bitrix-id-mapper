<?php

namespace Services;

use Bitrix\Iblock\Model\Section;
use Services\Interfaces\HelperInterface;
use Services\Traits\CacheOperations;
use Services\Traits\HelperOperations;

class IblockSectionService extends AbstractService implements HelperInterface
{
    use CacheOperations, HelperOperations;

    protected static $list;

    private function buildCacheId()
    {
        return "iblock_section_" . implode("_", [
                $this->iblockId,
                $this->offset,
                $this->limit,
                implode("_", $this->filter),
                implode("_", $this->select)
            ]);
    }

    private function getSections()
    {
        $result = [];

        if ($this->iblockId > 0) {
            $sectionEntity = Section::compileEntityByIblock($this->iblockId);
            $query = $sectionEntity::query();
            $result = $this->buildQuery($query)->fetchAll();
        }

        return $result;
    }

    protected function getListFromDb()
    {
        if ($this->cacheTime > 0) {
            $this->setCachePath("/iblock_section_" . $this->iblockId);
            $this->setCacheId($this->buildCacheId());
            return $this->cacheResult([self::class, "getSections"]);
        } else {
            return $this->getSections();
        }
    }
}