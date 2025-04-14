<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'reply',
        'replied_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'boolean',
        'replied_at' => 'datetime',
    ];

    /**
     * Scope a query to only include contacts with status not replied
     */
    public function scopeNotReplied($query)
    {
        return $query->where('status', false);
    }

    /**
     * Scope a query to only include contacts with status replied
     */
    public function scopeReplied($query)
    {
        return $query->where('status', true);
    }
}
