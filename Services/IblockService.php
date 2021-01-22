<?php

namespace Services;

use Bitrix\Iblock\IblockTable;

class IblockService extends AbstractService
{

    protected static $list;

    protected function getListFromDb()
    {
        $rsIblocks = IblockTable::getList([
            'select' => ["ID", "CODE", "IBLOCK_TYPE_ID"]
        ]);
        return $rsIblocks->fetchAll();
    }

    public function getResult($name)
    {
        $result = [];
        foreach (static::$list as $item) {
            if ($item["IBLOCK_TYPE_ID"] == $name) {
                $result[$item["CODE"]] = $item;
            }
        }
        return $result;
    }
}