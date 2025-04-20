<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm yêu thích.
     */
    public function index()
    {
        // Lấy tất cả sản phẩm yêu thích của người dùng hiện tại
        $favorites = Favorite::with('product')
            ->where('user_id', Auth::id())
            ->paginate(12);
            
        return view('favorites.index', compact('favorites'));
    }

    /**
     * Thêm sản phẩm vào danh sách yêu thích.
     */
    public function add(Product $product)
    {
        // Kiểm tra xem sản phẩm đã có trong danh sách yêu thích chưa
        $exists = Favorite::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->exists();
            
        if (!$exists) {
            // Thêm sản phẩm vào danh sách yêu thích
            Favorite::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id
            ]);
            
            return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào danh sách yêu thích!');
        }
        
        return redirect()->back()->with('info', 'Sản phẩm đã có trong danh sách yêu thích của bạn.');
    }

    /**
     * Xóa sản phẩm khỏi danh sách yêu thích.
     */
    public function remove(Product $product)
    {
        // Xóa sản phẩm khỏi danh sách yêu thích
        Favorite::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->delete();
            
        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi danh sách yêu thích!');
    }

    /**
     * Thêm/xóa sản phẩm vào/khỏi danh sách yêu thích (toggle).
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $product_id = $request->product_id;
        
        // Kiểm tra xem sản phẩm đã có trong danh sách yêu thích chưa
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('product_id', $product_id)
            ->first();
            
        $status = '';
        $message = '';
            
        if ($favorite) {
            // Xóa sản phẩm khỏi danh sách yêu thích
            $favorite->delete();
            $status = 'removed';
            $message = 'Đã xóa khỏi danh sách yêu thích';
        } else {
            // Thêm sản phẩm vào danh sách yêu thích
            Favorite::create([
                'user_id' => Auth::id(),
                'product_id' => $product_id
            ]);
            $status = 'added';
            $message = 'Đã thêm vào danh sách yêu thích';
        }
        
        // Đếm tổng số sản phẩm yêu thích hiện tại
        $count = Favorite::where('user_id', Auth::id())->count();
        
        return response()->json([
            'status' => $status,
            'message' => $message,
            'product_id' => $product_id,
            'count' => $count
        ]);
    }
    
    /**
     * Kiểm tra sản phẩm có trong danh sách yêu thích không.
     */
    public function check(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'favorites' => []
            ]);
        }
        
        $productIds = $request->input('product_id');
        
        // Xử lý cả giá trị đơn lẻ và mảng
        if (!is_array($productIds)) {
            if (is_string($productIds) && strpos($productIds, ',') !== false) {
                $productIds = explode(',', $productIds);
            } else {
                $productIds = [$productIds];
            }
        }
        
        // Lấy danh sách sản phẩm yêu thích
        $favorites = Favorite::where('user_id', Auth::id())
            ->whereIn('product_id', $productIds)
            ->pluck('product_id')
            ->toArray();
            
        return response()->json([
            'favorites' => $favorites
        ]);
    }
}
