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
        $query = $request->input('query');
        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->paginate(12);
        
        return view('products.search', compact('products', 'query'));
    }
}
