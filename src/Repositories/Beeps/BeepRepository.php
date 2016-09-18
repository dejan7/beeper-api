<?php

namespace BeeperApi\Repositories\Beeps;

interface BeepRepository
{
    public function create($data, $createdBy);

    public function find($where = null);

    public function first($where);
}