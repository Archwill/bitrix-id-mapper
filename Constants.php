<?php

use Interfaces\DbServiceInterface;

class Constants
{
    private $service;

    public function __construct(DbServiceInterface $service)
    {
        $this->service = $service;
        $this->service->getList();
    }

    public function __get($name)
    {
        return $this->service->getResult($name);
    }
}