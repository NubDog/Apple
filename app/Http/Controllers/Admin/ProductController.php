<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::orderBy('name')->get();
        $totalProducts = Product::count();
        $activeProducts = Product::where('quantity', '>', 0)->count();
        $lowStockProducts = Product::where('quantity', '>', 0)->where('quantity', '<=', 10)->count();
        $outOfStockProducts = Product::where('quantity', 0)->count();
        
        return view('admin.products.index', compact(
            'products', 
            'categories', 
            'totalProducts', 
            'activeProducts', 
            'lowStockProducts', 
            'outOfStockProducts'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'details' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'quantity' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'featured' => 'boolean',
            'is_new' => 'boolean',
            'on_sale' => 'boolean',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'details' => $request->details,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'quantity' => $request->quantity,
            'featured' => $request->has('featured'),
            'is_new' => $request->has('is_new'),
            'on_sale' => $request->has('on_sale')
        ];

        // Handle main image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        // Handle additional images upload
        $additionalImages = [];
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $path = $image->store('products', 'public');
                $additionalImages[] = $path;
            }
            $data['images'] = json_encode($additionalImages);
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $id,
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'details' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'featured' => 'boolean',
            'is_new' => 'boolean',
            'on_sale' => 'boolean',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'details' => $request->details,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'quantity' => $request->quantity,
            'featured' => $request->has('featured'),
            'is_new' => $request->has('is_new'),
            'on_sale' => $request->has('on_sale')
        ];

        // Handle main image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        // Handle additional images upload
        if ($request->hasFile('additional_images')) {
            // Delete old additional images
            if (!empty($product->images)) {
                $oldImages = json_decode($product->images, true);
                foreach ($oldImages as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $additionalImages = [];
            foreach ($request->file('additional_images') as $image) {
                $path = $image->store('products', 'public');
                $additionalImages[] = $path;
            }
            $data['images'] = json_encode($additionalImages);
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        // Check if product has order items
        if ($product->orderItems()->count() > 0) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Cannot delete product with associated orders');
        }

        // Delete main image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Delete additional images
        if (!empty($product->images)) {
            $additionalImages = json_decode($product->images, true);
            foreach ($additionalImages as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully');
    }

    /**
     * Upload temporary product image for the dropzone
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products/temp', 'public');
            return response()->json(['success' => true, 'path' => $path]);
        }
        
        return response()->json(['success' => false], 400);
    }
}
