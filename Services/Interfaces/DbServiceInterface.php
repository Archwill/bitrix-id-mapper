<?php


namespace Services\Interfaces;


interface DbServiceInterface
{
    public function getList();

    public function getResult($name);

}