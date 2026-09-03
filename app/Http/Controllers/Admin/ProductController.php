<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'images'])->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku',
            'dosage_form' => 'nullable|string|max:100',
            'pack_size' => 'nullable|string|max:100',
            'description' => 'required|string',
            'chemical_characteristics' => 'nullable|string',
            'side_effects' => 'nullable|string',
            'administration_uses' => 'nullable|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $fileName = time() . '_main_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/products'), $fileName);
            $validated['image_path'] = 'img/products/' . $fileName;
        }

        $product = Product::create($validated);

        // Store gallery images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $index => $gFile) {
                $gName = time() . '_gallery_' . $index . '_' . uniqid() . '.' . $gFile->getClientOriginalExtension();
                $gFile->move(public_path('img/products'), $gName);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'img/products/' . $gName,
                    'order' => $index + 1,
                ]);
            }
        }

        Cache::forget('home_featured_products');

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully with image and gallery.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('images');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku,' . $product->id,
            'dosage_form' => 'nullable|string|max:100',
            'pack_size' => 'nullable|string|max:100',
            'description' => 'required|string',
            'chemical_characteristics' => 'nullable|string',
            'side_effects' => 'nullable|string',
            'administration_uses' => 'nullable|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $fileName = time() . '_main_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/products'), $fileName);
            $validated['image_path'] = 'img/products/' . $fileName;
        }

        $product->update($validated);

        // Upload additional gallery images if provided
        if ($request->hasFile('gallery_images')) {
            $currentMaxOrder = $product->images()->max('order') ?? 0;
            foreach ($request->file('gallery_images') as $index => $gFile) {
                $gName = time() . '_gallery_' . ($currentMaxOrder + $index + 1) . '_' . uniqid() . '.' . $gFile->getClientOriginalExtension();
                $gFile->move(public_path('img/products'), $gName);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'img/products/' . $gName,
                    'order' => $currentMaxOrder + $index + 1,
                ]);
            }
        }

        Cache::forget('home_featured_products');

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroyImage($imageId)
    {
        $image = ProductImage::findOrFail($imageId);
        $image->delete();
        return redirect()->back()->with('success', 'Gallery image removed.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        Cache::forget('home_featured_products');

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
