<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the user's favorite products.
     */
    public function index()
    {
        $favorites = Favorite::with('product')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12);
        
        return view('favorites.index', compact('favorites'));
    }

    /**
     * Add a product to favorites.
     */
    public function add(Product $product)
    {
        // Check if already in favorites
        $exists = Favorite::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->exists();
            
        if (!$exists) {
            Favorite::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id
            ]);
            
            return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào danh sách yêu thích!');
        }
        
        return redirect()->back()->with('info', 'Sản phẩm đã có trong danh sách yêu thích của bạn.');
    }

    /**
     * Remove a product from favorites.
     */
    public function remove(Product $product)
    {
        Favorite::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->delete();
            
        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi danh sách yêu thích!');
    }

    /**
     * Toggle a product in favorites (add if not exists, remove if exists).
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $product_id = $request->product_id;
        
        // Check if already in favorites
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('product_id', $product_id)
            ->first();
        
        $status = '';
        $message = '';
            
        if ($favorite) {
            // Remove from favorites
            $favorite->delete();
            $status = 'removed';
            $message = 'Đã xóa khỏi danh sách yêu thích';
        } else {
            // Add to favorites
            Favorite::create([
                'user_id' => Auth::id(),
                'product_id' => $product_id
            ]);
            $status = 'added';
            $message = 'Đã thêm vào danh sách yêu thích';
        }
        
        if ($request->ajax()) {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'product_id' => $product_id,
                'count' => Favorite::where('user_id', Auth::id())->count()
            ]);
        }
        
        return redirect()->back()->with('success', $message);
    }
    
    /**
     * Check if a product is in user's favorites
     */
    public function check(Request $request)
    {
        $request->validate([
            'product_id' => 'required'
        ]);
        
        $productIds = $request->product_id;
        
        // If single product_id is passed
        if (!is_array($productIds)) {
            $isFavorite = Favorite::where('user_id', Auth::id())
                ->where('product_id', $productIds)
                ->exists();
                
            return response()->json([
                'is_favorite' => $isFavorite,
                'product_id' => $productIds
            ]);
        }
        
        // If multiple product_ids are passed
        $favorites = Favorite::where('user_id', Auth::id())
            ->whereIn('product_id', $productIds)
            ->pluck('product_id')
            ->toArray();
            
        return response()->json([
            'favorites' => $favorites
        ]);
    }
}
