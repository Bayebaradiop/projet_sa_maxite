<?php
namespace App\Core;
abstract class AbstracteService
{
    protected AbstracteRipository $repository;

    public function __construct(AbstracteRipository $repository)
    {
        $this->repository = $repository;
    }
}

