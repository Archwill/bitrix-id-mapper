<?php

namespace Services;

use Bitrix\Iblock\SectionTable;

class IblockSectionService extends AbstractService
{
    protected static $list;

    protected function getListFromDb()
    {
        $rsIblocks = SectionTable::getList([
            'select' => [
                "ID",
                "CODE",
                "IBLOCK_TYPE" => "IBLOCK.IBLOCK_TYPE_ID",
                "IBLOCK_CODE" => "IBLOCK.CODE"
            ]
        ]);
        return $rsIblocks->fetchAll();
    }

    public function getResult($name)
    {
        $result = [];
        foreach (static::$list as $item) {
            if ($item["IBLOCK_TYPE"] == $name) {
                $result[$item["IBLOCK_CODE"]][$item["CODE"]] = $item;
            }
        }
        return $result;
    }
}