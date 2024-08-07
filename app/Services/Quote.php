<?php

namespace App\Services;

use Illuminate\Support\Facades\Facade;

class Quote extends Facade
{
    protected static function getFacadeAccessor()
    {
        return QuoteManager::class;
    }
}
