<?php


namespace Domain\WarModule\Contracts;


use Domain\WarModule\Entities\Army;
use Illuminate\Support\Collection;

interface RecordInterface
{
    public function generateRecord(Army $opponent, string $result): Army;
    public function getRecord(): Collection;
}
