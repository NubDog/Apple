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
        $favorites = Favorite::with('product')->where('user_id', Auth::id())->paginate(12);
        
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
            
            return redirect()->back()->with('success', 'Product added to favorites!');
        }
        
        return redirect()->back()->with('info', 'Product is already in your favorites.');
    }

    /**
     * Remove a product from favorites.
     */
    public function remove(Product $product)
    {
        Favorite::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->delete();
            
        return redirect()->back()->with('success', 'Product removed from favorites!');
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
            
        if ($favorite) {
            // Remove from favorites
            $favorite->delete();
            return redirect()->back()->with('success', 'Product removed from favorites!');
        } else {
            // Add to favorites
            Favorite::create([
                'user_id' => Auth::id(),
                'product_id' => $product_id
            ]);
            return redirect()->back()->with('success', 'Product added to favorites!');
        }
    }
}
