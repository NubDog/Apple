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
        'expires_at',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_uses' => 'integer',
        'used_times' => 'integer',
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];
    
    /**
     * Check if coupon is expired
     */
    public function isExpired()
    {
        if (!$this->expires_at) {
            return false;
        }
        
        return now() > $this->expires_at;
    }
    
    /**
     * Check if coupon is valid for use
     */
    public function isValid()
    {
        // Check if active
        if (!$this->is_active) {
            return false;
        }
        
        // Check if expired
        if ($this->isExpired()) {
            return false;
        }
        
        // Check if max uses reached
        if ($this->max_uses && $this->used_times >= $this->max_uses) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Calculate discount amount based on coupon type and value
     *
     * @param float $amount The cart amount to apply discount to
     * @return float
     */
    public function calculateDiscount($amount)
    {
        // If coupon is fixed amount
        if ($this->type === 'fixed') {
            return min($this->value, $amount);
        }
        
        // If coupon is percentage
        if ($this->type === 'percent') {
            return ($amount * $this->value) / 100;
        }
        
        return 0;
    }
} 