<?php

namespace Tests\Unit\States;

use App\Models\Booking;
use App\Services\BookingStateManager;
use App\States\CompleteBookingState;
use App\States\PendingBookingState;
use Tests\TestCase;

class BookingStateTest extends TestCase
{
    /** @test */
    public function it_creates_booking_with_pending_state_by_default(): void
    {
        $booking = Booking::factory()->create(['status' => 0]);

        $this->assertTrue($booking->isPending());
        $this->assertFalse($booking->isComplete());
        $this->assertEquals('Pending', $booking->getStatusLabel());
        $this->assertEquals('warning', $booking->getStatusColor());
    }

    /** @test */
    public function it_creates_booking_with_complete_state(): void
    {
        $booking = Booking::factory()->create(['status' => 1]);

        $this->assertFalse($booking->isPending());
        $this->assertTrue($booking->isComplete());
        $this->assertEquals('Complete', $booking->getStatusLabel());
        $this->assertEquals('success', $booking->getStatusColor());
    }

    /** @test */
    public function it_can_approve_pending_booking(): void
    {
        $booking = Booking::factory()->create(['status' => 0]);

        $this->assertTrue($booking->canBeApproved());
        $booking->approve();

        $this->assertTrue($booking->isComplete());
        $this->assertFalse($booking->isPending());
    }

    /** @test */
    public function it_cannot_approve_complete_booking(): void
    {
        $booking = Booking::factory()->create(['status' => 1]);

        $this->assertFalse($booking->canBeApproved());
        $this->expectException(\Exception::class);
        $booking->approve();
    }

    /** @test */
    public function it_cannot_cancel_complete_booking(): void
    {
        $booking = Booking::factory()->create(['status' => 1]);

        $this->assertFalse($booking->canBeCancelled());
        $this->expectException(\Exception::class);
        $booking->cancel();
    }

    /** @test */
    public function it_can_cancel_pending_booking(): void
    {
        $booking = Booking::factory()->create(['status' => 0]);

        $this->assertTrue($booking->canBeCancelled());
        $booking->cancel();

        $this->assertTrue($booking->isPending());
    }

    /** @test */
    public function it_returns_correct_state_instances(): void
    {
        $pendingState = BookingStateManager::getStateFromValue(0);
        $completeState = BookingStateManager::getStateFromValue(1);

        $this->assertInstanceOf(PendingBookingState::class, $pendingState);
        $this->assertInstanceOf(CompleteBookingState::class, $completeState);
    }

    /** @test */
    public function it_returns_all_available_states(): void
    {
        $states = BookingStateManager::getAvailableStates();

        $this->assertCount(2, $states);
        $this->assertInstanceOf(PendingBookingState::class, $states[0]);
        $this->assertInstanceOf(CompleteBookingState::class, $states[1]);
    }

    /** @test */
    public function it_returns_pending_state_for_default_value(): void
    {
        $defaultState = BookingStateManager::getStateFromValue(999);

        $this->assertInstanceOf(PendingBookingState::class, $defaultState);
    }
}
