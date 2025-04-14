<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'max_uses',
        'used_times',
        'is_active',
        'expires_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /**
     * Scope a query to only include active coupons
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    /**
     * Check if the coupon is still valid
     */
    public function isValid(): bool
    {
        // Check if the coupon is active
        if (!$this->is_active) {
            return false;
        }

        // Check if the coupon has expired
        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        // Check if the coupon has reached its maximum uses
        if ($this->max_uses && $this->used_times >= $this->max_uses) {
            return false;
        }

        return true;
    }

    /**
     * Calculate the discount amount for a given total
     */
    public function calculateDiscount($total)
    {
        if (!$this->isValid()) {
            return 0;
        }

        // Check min order amount
        if ($this->min_order_amount && $total < $this->min_order_amount) {
            return 0;
        }

        if ($this->type === 'fixed') {
            return $this->value;
        } else {
            // Percentage discount
            return ($total * $this->value) / 100;
        }
    }
}
