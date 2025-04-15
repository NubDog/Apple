<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        try {
            $query = $request->input('query');
            $category = $request->input('category');
            $minPrice = $request->input('min_price');
            $maxPrice = $request->input('max_price');
            
            Log::info('Search query received: ' . $query);
            
            // Kiểm tra xem bảng products có tồn tại không
            if (!DB::getSchemaBuilder()->hasTable('products')) {
                Log::error('Products table does not exist');
                return response()->json([
                    'success' => false,
                    'message' => 'Bảng dữ liệu chưa được khởi tạo',
                    'products' => []
                ]);
            }
            
            // Sử dụng DB query builder thay vì model
            $productsQuery = DB::table('products')
                ->select('products.id', 'products.name', 'products.slug', 'products.image', 
                         'products.details', 'products.price', 'products.sale_price', 
                         'products.featured', 'products.is_new', 'products.on_sale',
                         'categories.name as category_name')
                ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                ->where(function($q) use ($query) {
                    $q->where('products.name', 'like', "%{$query}%")
                      ->orWhere('products.description', 'like', "%{$query}%")
                      ->orWhere('products.details', 'like', "%{$query}%");
                });
                
            // Apply category filter if provided
            if ($category) {
                $productsQuery->where('categories.slug', $category);
            }
            
            // Apply price range filters if provided
            if ($minPrice) {
                $productsQuery->where(function($q) use ($minPrice) {
                    $q->where('products.price', '>=', $minPrice)
                      ->orWhere('products.sale_price', '>=', $minPrice);
                });
            }
            
            if ($maxPrice) {
                $productsQuery->where(function($q) use ($maxPrice) {
                    $q->where('products.price', '<=', $maxPrice)
                      ->orWhere(function($sq) use ($maxPrice) {
                          $sq->where('products.sale_price', '<=', $maxPrice)
                             ->where('products.sale_price', '>', 0);
                      });
                });
            }
            
            $products = $productsQuery->get();
                
            Log::info('Search found ' . $products->count() . ' products');
            
            // Get all categories for filter options
            $categories = DB::table('categories')->select('id', 'name', 'slug')->get();
            
            // Xử lý dữ liệu trả về để đảm bảo có đủ các trường
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
                    'category_name' => $product->category_name
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
            Log::error('Search error: ' . $e->getMessage());
            Log::error('Error trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi tìm kiếm: ' . $e->getMessage(),
                'products' => []
            ], 500);
        }
    }
}
