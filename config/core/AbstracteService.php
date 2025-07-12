<?php
namespace App\Core;
abstract class AbstracteService
{
    protected AbstracteRipository $repository;

    public function __construct(AbstracteRipository $repository)
    {
        $this->repository = $repository;
    }

    public static function getInstance(AbstracteRipository $repository): self
    {
        return new static($repository);
    }
}

