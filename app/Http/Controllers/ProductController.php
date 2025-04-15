<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $query = Product::query();
        
        // Apply filters
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        $products = $query->paginate(12);
        $categories = Category::all();
        
        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display the specified product.
     */
    public function show($slug)
    {
        $product = Product::with(['category', 'reviews.user'])->where('slug', $slug)->firstOrFail();
        
        // Load related products from the same category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();
            
        // Calculate average rating
        $avgRating = $product->reviews->avg('rating');
        $reviewsCount = $product->reviews->count();
            
        return view('products.show', compact('product', 'relatedProducts', 'avgRating', 'reviewsCount'));
    }

    /**
     * Display products by category.
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $query = Product::where('category_id', $category->id);
        
        // Apply price filters if provided
        if (request()->has('min_price')) {
            $query->where(function($q) {
                $minPrice = request('min_price');
                $q->where('price', '>=', $minPrice)
                  ->orWhere('sale_price', '>=', $minPrice);
            });
        }
        
        if (request()->has('max_price')) {
            $query->where(function($q) {
                $maxPrice = request('max_price');
                $q->where('price', '<=', $maxPrice)
                  ->orWhere(function($sq) use ($maxPrice) {
                      $sq->where('sale_price', '<=', $maxPrice)
                         ->where('sale_price', '>', 0);
                  });
            });
        }
        
        // Apply sorting
        if (request()->has('sort')) {
            switch (request('sort')) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        $products = $query->paginate(10); // Show 10 products per page (1 row each)
        $categories = Category::all();
        
        return view('products.category', compact('category', 'products', 'categories'));
    }
}
