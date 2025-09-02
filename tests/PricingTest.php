<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../vendor/autoload.php';

class PricingTest extends TestCase
{
    private $pricing;

    protected function setUp(): void
    {
        $this->pricing = new Pricing();
    }

    public function testCalculatePriceWithoutDiscounts()
    {
        // 2 players, weekend (Saturday)
        $price = $this->pricing->calculatePrice(2, "2023-12-23 15:00"); // Saturday
        $this->assertEquals(40.00, $price);
    }

    public function testCalculatePriceWithWeekdayDiscount()
    {
        // 2 players, weekday (Monday)
        $price = $this->pricing->calculatePrice(2, "2023-12-25 15:00"); // Monday
        $this->assertEquals(36.00, $price); // 20*2 * 0.9
    }

    public function testCalculatePriceWithGroupDiscount()
    {
        // 4 players, weekend
        $price = $this->pricing->calculatePrice(4, "2023-12-23 15:00"); // Saturday
        $this->assertEquals(68.00, $price); // 20*4 * 0.85
    }

    public function testCalculatePriceWithBothDiscounts()
    {
        // 4 players, weekday
        $price = $this->pricing->calculatePrice(4, "2023-12-25 15:00"); // Monday
        $this->assertEquals(61.20, $price); // 20*4 * 0.9 * 0.85
    }
}
