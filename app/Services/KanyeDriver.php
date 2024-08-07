<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class KanyeDriver implements QuoteDriverInterface
{
    public const CACHE_KEY = 'kanye-quotes';

    public function refresh(): self
    {
        Cache::forget(self::CACHE_KEY);

        return $this;
    }

    public function get(): array
    {
        return Cache::remember(self::CACHE_KEY, config('quote.cache_time_in_seconds'), function () {
            $quotes = [];
            for ($i = 0; $i < config('quote.number_of_quotes'); $i++) {
                $quotes[] = Http::get('https://api.kanye.rest/')->json();
            }

            return $quotes;
        });
    }
}
