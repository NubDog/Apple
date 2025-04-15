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
        // Get favorites from the Favorites table
        $favoriteRecords = Favorite::with('product')
            ->where('user_id', Auth::id())
            ->get();
            
        // Get favorite product IDs from the user's JSON column
        $user = Auth::user();
        $favoriteIds = $user->favorites ?? [];
        
        // Get products from favorite IDs that are not in the Favorites table
        $additionalProducts = [];
        if (!empty($favoriteIds)) {
            $existingProductIds = $favoriteRecords->pluck('product_id')->toArray();
            $missingProductIds = array_diff($favoriteIds, $existingProductIds);
            
            if (!empty($missingProductIds)) {
                $additionalProducts = Product::whereIn('id', $missingProductIds)->get();
                
                // Convert products to favorite records format
                foreach ($additionalProducts as $product) {
                    $favorite = new Favorite();
                    $favorite->product_id = $product->id;
                    $favorite->user_id = Auth::id();
                    $favorite->created_at = now();
                    $favorite->product = $product;
                    $favoriteRecords->push($favorite);
                }
            }
        }
        
        // Paginate the results manually
        $perPage = 12;
        $currentPage = request()->get('page', 1);
        $currentPageItems = $favoriteRecords->forPage($currentPage, $perPage);
        $favorites = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems,
            $favoriteRecords->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        return view('favorites.index', compact('favorites'));
    }

    /**
     * Add a product to favorites.
     */
    public function add(Product $product)
    {
        $user = Auth::user();
        
        // Check if already in favorites table
        $exists = Favorite::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->exists();
            
        if (!$exists) {
            // Add to Favorites table
            Favorite::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id
            ]);
            
            // Add to user's favorites JSON column
            $favorites = $user->favorites ?? [];
            if (!in_array($product->id, $favorites)) {
                $favorites[] = $product->id;
                $user->favorites = $favorites;
                $user->save();
            }
            
            return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào danh sách yêu thích!');
        }
        
        return redirect()->back()->with('info', 'Sản phẩm đã có trong danh sách yêu thích của bạn.');
    }

    /**
     * Remove a product from favorites.
     */
    public function remove(Product $product)
    {
        $user = Auth::user();
        
        // Remove from Favorites table
        Favorite::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->delete();
            
        // Remove from user's favorites JSON column
        $favorites = $user->favorites ?? [];
        if (in_array($product->id, $favorites)) {
            $favorites = array_values(array_diff($favorites, [$product->id]));
            $user->favorites = $favorites;
            $user->save();
        }
            
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
        $user = Auth::user();
        
        // Check if already in favorites table
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('product_id', $product_id)
            ->first();
            
        // Check if in user's favorites JSON column
        $favorites = $user->favorites ?? [];
        $inJsonFavorites = in_array($product_id, $favorites);
        
        $status = '';
        $message = '';
            
        if ($favorite || $inJsonFavorites) {
            // Remove from both storage methods
            if ($favorite) {
                $favorite->delete();
            }
            
            if ($inJsonFavorites) {
                $favorites = array_values(array_diff($favorites, [$product_id]));
                $user->favorites = $favorites;
                $user->save();
            }
            
            $status = 'removed';
            $message = 'Đã xóa khỏi danh sách yêu thích';
        } else {
            // Add to both storage methods
            Favorite::create([
                'user_id' => Auth::id(),
                'product_id' => $product_id
            ]);
            
            $favorites[] = $product_id;
            $user->favorites = $favorites;
            $user->save();
            
            $status = 'added';
            $message = 'Đã thêm vào danh sách yêu thích';
        }
        
        // Count total favorites (combine both sources)
        $dbCount = Favorite::where('user_id', Auth::id())->count();
        $jsonCount = count($user->favorites ?? []);
        $totalCount = max($dbCount, $jsonCount); // Use the larger count to avoid duplicates
        
        return response()->json([
            'status' => $status,
            'message' => $message,
            'product_id' => $product_id,
            'count' => $totalCount
        ]);
    }
    
    /**
     * Check if a product is in user's favorites
     */
    public function check(Request $request)
    {
        $productIds = $request->input('product_id');
        
        if (!Auth::check()) {
            return response()->json([
                'favorites' => []
            ]);
        }
        
        // Handle both array and single value inputs
        if (!is_array($productIds)) {
            if (is_string($productIds) && strpos($productIds, ',') !== false) {
                $productIds = explode(',', $productIds);
            } else {
                $productIds = [$productIds];
            }
        }
        
        $user = Auth::user();
        
        // Get favorites from database
        $dbFavorites = Favorite::where('user_id', Auth::id())
            ->whereIn('product_id', $productIds)
            ->pluck('product_id')
            ->toArray();
            
        // Get favorites from user's JSON column
        $jsonFavorites = array_intersect($user->favorites ?? [], $productIds);
        
        // Merge both sources (avoiding duplicates)
        $favorites = array_unique(array_merge($dbFavorites, $jsonFavorites));
            
        return response()->json([
            'favorites' => $favorites
        ]);
    }
}
