<?php

namespace Services;

interface DbServiceInterface
{
    public function getList();

    public function getResult($name);
}