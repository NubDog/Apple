<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5'
        ]);
        
        // Kiểm tra xem người dùng đã đánh giá sản phẩm này chưa
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();
            
        if ($existingReview) {
            // Cập nhật đánh giá hiện có
            $existingReview->update([
                'rating' => $request->rating,
                'comment' => $request->comment
            ]);
            
            return redirect()->back()->with('success', 'Đánh giá của bạn đã được cập nhật thành công.');
        }
        
        // Tạo đánh giá mới
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);
        
        return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm.');
    }
}
