<?php

namespace Services;

use DbServiceInterface;

abstract class AbstractService implements DbServiceInterface
{
    protected static $list;

    abstract protected function getListFromDb();

    public function getList(){
        if(empty(static::$list)){
            static::$list = $this->getListFromDb();
        }
    }

    abstract public function getResult($name);

}