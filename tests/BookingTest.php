<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../vendor/autoload.php';

class BookingTest extends TestCase
{
    private $booking;

    protected function setUp(): void
    {
        $this->booking = new Booking();
    }

    public function testCheckAvailabilityReturnsTrueForAvailableSlot()
    {
        $this->assertTrue($this->booking->checkAvailability("2023-12-25 15:00", "Room 1"));
    }

    public function testCheckAvailabilityReturnsFalseForOutsideOpeningHours()
    {
        $this->assertFalse($this->booking->checkAvailability("2023-12-25 08:00", "Room 1"));
        $this->assertFalse($this->booking->checkAvailability("2023-12-25 23:00", "Room 1"));
    }

    public function testCheckAvailabilityReturnsFalseForBookedSlot()
    {
        $this->booking->book("2023-12-25 15:00", "Room 1", ["Alice", "Bob"]);
        $this->assertFalse($this->booking->checkAvailability("2023-12-25 15:00", "Room 1"));
    }

    public function testBookReturnsTrueForSuccessfulBooking()
    {
        $result = $this->booking->book("2023-12-25 15:00", "Room 1", ["Alice", "Bob"]);
        $this->assertTrue($result);
        $this->assertCount(1, $this->booking->getReservations());
    }

    public function testBookReturnsFalseForUnavailableSlot()
    {
        $this->booking->book("2023-12-25 15:00", "Room 1", ["Alice", "Bob"]);
        $result = $this->booking->book("2023-12-25 15:00", "Room 1", ["Charlie", "Dave"]);
        $this->assertFalse($result);
    }

    public function testValidateAgeReturnsTrueForValidAges()
    {
        $this->assertTrue($this->booking->validateAge([14, 15, 12]));
    }

    public function testValidateAgeReturnsFalseForInvalidAges()
    {
        $this->assertFalse($this->booking->validateAge([10, 15, 12]));
    }
}
