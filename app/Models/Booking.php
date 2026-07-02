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

    public function getPaymentStatusLabel(): string
    {
        return match ((int) $this->payment_status) {
            1 => 'Complete',
            2 => 'Deposit Paid',
            default => 'Pending',
        };
    }

    public function getPaymentStatusColor(): string
    {
        return match ((int) $this->payment_status) {
            1 => 'success',
            2 => 'warning',
            default => 'danger',
        };
    }

    public function isDepositPaid(): bool
    {
        return (int) $this->payment_status === 2;
    }

    public function isDepositPending(): bool
    {
        return (int) $this->payment_status === 0;
    }

    public function getDepositPercentage(): int
    {
        return (int) ($this->deposit_percentage ?? config('booking.cod_deposit_percentage', 30));
    }

    public function getDepositAmount(): float
    {
        if (isset($this->deposit_amount)) {
            return (float) $this->deposit_amount;
        }

        return (float) round($this->total_price * ($this->getDepositPercentage() / 100), 2);
    }

    public function getRemainingAmount(): float
    {
        if (isset($this->remaining_amount)) {
            return (float) $this->remaining_amount;
        }

        return (float) round(max(0, $this->total_price - $this->getDepositAmount()), 2);
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
