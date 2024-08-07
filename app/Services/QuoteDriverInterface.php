<?php

namespace App\Services;

interface QuoteDriverInterface
{
    public function refresh(): self;
    public function get(): array;
}
