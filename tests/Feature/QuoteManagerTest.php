<?php

namespace Tests\Feature;

use App\Services\KanyeDriver;
use App\Services\QuoteManager;
use InvalidArgumentException;
use Tests\TestCase;

class QuoteManagerTest extends TestCase
{
    public function test_it_returns_default_driver_as_kanye()
    {
        $manager = new QuoteManager(app());
        $this->assertEquals('kanye', $manager->getDefaultDriver());
    }

    public function test_it_creates_kanye_driver_instance()
    {
        $manager = new QuoteManager(app());
        $this->assertInstanceOf(KanyeDriver::class, $manager->createKanyeDriver());
    }

    public function test_it_throws_exception_for_invalid_driver()
    {
        $this->expectException(InvalidArgumentException::class);
        $manager = new QuoteManager(app());
        $manager->driver('invalid');
    }
}
