<?php

namespace App\Messenger;

class BuyProduct
{
    public function __construct(public int $accountId, public int $productId)
    {
    }
}
