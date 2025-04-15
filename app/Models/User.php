<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'profile_image',
        'favorites'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'favorites' => 'array',
        ];
    }

    /**
     * Check if user is admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get the orders for the user
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the favorites for the user
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Get the reviews for the user
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get favorite product IDs from favorites JSON column
     * 
     * @return array
     */
    public function getFavoriteIds(): array
    {
        return $this->favorites ?? [];
    }

    /**
     * Add a product ID to favorites JSON column
     * 
     * @param int $productId
     * @return void
     */
    public function addFavorite(int $productId): void
    {
        $favorites = $this->getFavoriteIds();
        if (!in_array($productId, $favorites)) {
            $favorites[] = $productId;
            $this->favorites = $favorites;
            $this->save();
        }
    }

    /**
     * Remove a product ID from favorites JSON column
     * 
     * @param int $productId
     * @return void
     */
    public function removeFavorite(int $productId): void
    {
        $favorites = $this->getFavoriteIds();
        $this->favorites = array_values(array_filter($favorites, function($id) use ($productId) {
            return $id != $productId;
        }));
        $this->save();
    }

    /**
     * Check if a product ID is in favorites JSON column
     * 
     * @param int $productId
     * @return bool
     */
    public function hasFavorite(int $productId): bool
    {
        return in_array($productId, $this->getFavoriteIds());
    }
}
