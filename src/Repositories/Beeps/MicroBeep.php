<?php

namespace BeeperApi\Repositories\Beeps;

use MicroDB\Database;

class MicroBeep implements BeepRepository
{
    private $beepsTable;

    public function __construct()
    {
        $this->beepsTable = new Database('data/beeps');
    }

    public function create($data, $createdBy)
    {
        $beep = [
            'id' => uniqid(),
            'user_id' => $createdBy['id'],
            'text' => (string) $data['text'],
            'likes' => 0,
            'created_at' => time(),
        ];

        $this->beepsTable->create($beep);
    }

    public function find($where = null)
    {
        return $this->beepsTable->find($where);
    }

    public function first($where)
    {
        return $this->beepsTable->first($where);
    }
}