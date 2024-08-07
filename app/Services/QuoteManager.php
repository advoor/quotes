<?php

namespace App\Services;

use Illuminate\Support\Manager;

class QuoteManager extends Manager
{
    public function getDefaultDriver()
    {
        return 'kanye';
    }

    public function createKanyeDriver(): KanyeDriver
    {
        return new KanyeDriver();
    }
}
