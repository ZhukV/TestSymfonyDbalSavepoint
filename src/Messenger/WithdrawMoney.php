<?php

namespace App\Messenger;

class WithdrawMoney
{
    public function __construct(public int $id, public float $money)
    {
    }
}