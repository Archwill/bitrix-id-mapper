<?php


namespace Services;


use Bitrix\Iblock\Iblock;
use Bitrix\Main\Data\Cache;
use Services\Traits\BitrixEntityTrait;
use Services\AbstractService;

class IblockElementService extends AbstractService
{
    use BitrixEntityTrait;

    protected static $list;

    private function getCacheId()
    {
        return "iblock_element_" . implode("_", [
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
            if ($cache->initCache($this->cacheTime, $this->getCacheId(), "/iblock_element_" . $this->iblockId)) {
                $result = $cache->getVars();
            } elseif ($cache->startDataCache()) {
                $result = array();

                $iblock = Iblock::wakeUp($this->iblockId);
                $query = $iblock->getEntityDataClass()::query();

                $result = $this->buildQuery($query)->fetchAll();

                $cache->endDataCache($result);
            }


            return $result;
        }

        return [];
    }
}