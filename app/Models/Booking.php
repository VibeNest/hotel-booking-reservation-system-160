<?php

namespace App\Models;

use App\Services\BookingStateManager;
use App\States\BookingState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function assign_rooms()
    {
        return $this->hasMany(BookingRoomList::class, 'booking_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'rooms_id', 'id');
    }

    /**
     * Get the current state of the booking
     */
    public function getState(): BookingState
    {
        return BookingStateManager::getState($this);
    }

    /**
     * Get the state label for display
     */
    public function getStatusLabel(): string
    {
        return $this->getState()->label();
    }

    /**
     * Get the state color for UI badge
     */
    public function getStatusColor(): string
    {
        return $this->getState()->color();
    }

    /**
     * Approve the booking (transition to Complete)
     */
    public function approve(): void
    {
        BookingStateManager::approve($this);
    }

    /**
     * Cancel the booking
     */
    public function cancel(): void
    {
        BookingStateManager::cancel($this);
    }

    /**
     * Check if booking can be approved
     */
    public function canBeApproved(): bool
    {
        return $this->getState()->canApprove();
    }

    /**
     * Check if booking can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return $this->getState()->canCancel();
    }

    /**
     * Check if booking is pending
     */
    public function isPending(): bool
    {
        return $this->status === 0;
    }

    /**
     * Check if booking is complete
     */
    public function isComplete(): bool
    {
        return $this->status === 1;
    }

    public function getAddonFee(): float
    {
        return (float) max(0, round($this->total_price - $this->subtotal + $this->discount, 2));
    }
}
