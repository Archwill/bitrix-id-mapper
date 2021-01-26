<?php

namespace Interfaces;

interface DbServiceInterface
{
    public function getList();

    public function getResult($name);
}