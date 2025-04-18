<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        $sliders = Slider::active()->ordered()->take(5)->get();
        $featuredProducts = Product::featured()->take(8)->get();
        $newProducts = Product::new()->orderBy('created_at', 'desc')->take(8)->get();
        $saleProducts = Product::onSale()->take(8)->get();
        $popularProducts = Product::withCount('orderItems')->orderBy('order_items_count', 'desc')->take(8)->get();
        $categories = Category::all();

        return view('home', compact(
            'sliders',
            'featuredProducts',
            'newProducts',
            'saleProducts',
            'popularProducts',
            'categories'
        ));
    }

    /**
     * Search for products
     */
    public function search(Request $request)
    {
        try {
            $query = $request->input('query');
            $category = $request->input('category');
            $minPrice = $request->input('min_price');
            $maxPrice = $request->input('max_price');
            
            $productsQuery = Product::query()
                ->with('category')
                ->where(function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%")
                      ->orWhere('details', 'like', "%{$query}%");
                });
                
            // Apply category filter if provided
            if ($category) {
                $productsQuery->whereHas('category', function($q) use ($category) {
                    $q->where('slug', $category);
                });
            }
            
            // Apply price range filters if provided
            if ($minPrice) {
                $productsQuery->where(function($q) use ($minPrice) {
                    $q->where('price', '>=', $minPrice)
                      ->orWhere('sale_price', '>=', $minPrice);
                });
            }
            
            if ($maxPrice) {
                $productsQuery->where(function($q) use ($maxPrice) {
                    $q->where('price', '<=', $maxPrice)
                      ->orWhere(function($sq) use ($maxPrice) {
                          $sq->where('sale_price', '<=', $maxPrice)
                             ->where('sale_price', '>', 0);
                      });
                });
            }
            
            $products = $productsQuery->get();
            
            // Get all categories for filter options
            $categories = Category::select('id', 'name', 'slug')->get();
            
            $formattedProducts = $products->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'image' => $product->image,
                    'details' => $product->details,
                    'price' => (float) $product->price,
                    'sale_price' => (float) ($product->sale_price ?? 0),
                    'is_new' => (bool) $product->is_new,
                    'on_sale' => (bool) $product->on_sale,
                    'featured' => (bool) $product->featured,
                    'category_name' => $product->category ? $product->category->name : 'Uncategorized'
                ];
            });
            
            return response()->json([
                'success' => true,
                'count' => $formattedProducts->count(),
                'products' => $formattedProducts,
                'categories' => $categories,
                'filters' => [
                    'query' => $query,
                    'category' => $category,
                    'min_price' => $minPrice,
                    'max_price' => $maxPrice
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi tìm kiếm: ' . $e->getMessage(),
                'products' => []
            ], 500);
        }
    }
}
