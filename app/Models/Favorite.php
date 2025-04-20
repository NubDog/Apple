<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use HasFactory;

    /**
     * Các thuộc tính có thể gán giá trị hàng loạt.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'product_id'
    ];

    /**
     * Lấy thông tin người dùng sở hữu mục yêu thích
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Lấy thông tin sản phẩm được yêu thích
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
