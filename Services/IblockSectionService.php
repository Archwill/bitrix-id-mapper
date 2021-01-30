<?php

namespace Services;

use Bitrix\Iblock\SectionTable;

use Bitrix\Main\Data\Cache;
use Services\Traits\BitrixEntityTrait;
use Services\AbstractService;
use Bitrix\Iblock\Model\Section;

class IblockSectionService extends AbstractService
{
    use BitrixEntityTrait;

    protected static $list;

    private function getCacheId()
    {
        return "iblock_section_" . implode("_", [
                $this->iblockId,
                $this->offset,
                $this->limit,
                implode("_", $this->filter),
                implode("_", $this->select)
            ]);
    }

    protected function getListFromDb()
    {
        if ($this->iblockId > 0) {

            $cache = Cache::createInstance();
            if ($cache->initCache($this->cacheTime, $this->getCacheId(), "/iblock_section_" . $this->iblockId)) {
                $result = $cache->getVars();
            } elseif ($cache->startDataCache()) {
                $result = array();

                $sectionEntity = Section::compileEntityByIblock($this->iblockId);

                $query = $sectionEntity::query();

                $result = $this->buildQuery($query)->fetchAll();

                $cache->endDataCache($result);
            }


            return $result;
        }

        return [];
    }
}