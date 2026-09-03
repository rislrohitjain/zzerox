<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class CatalogController extends Controller
{
    protected function getCachedCategories()
    {
        return Cache::rememberForever('nav_categories_tree', function () {
            return Category::whereNull('parent_id')
                ->with(['children' => function ($query) {
                    $query->orderBy('order', 'asc');
                }])
                ->orderBy('order', 'asc')
                ->get();
        });
    }

    public function category(Request $request, $slug)
    {
        $categories = $this->getCachedCategories();

        $currentCategory = Category::where('slug', $slug)
            ->with(['children', 'parent'])
            ->firstOrFail();

        // Get category IDs (including self and subcategory IDs)
        $categoryIds = array_merge([$currentCategory->id], $currentCategory->children->pluck('id')->toArray());

        $query = Product::with('category')->whereIn('category_id', $categoryIds)->where('is_active', true);

        // Sorting
        $sort = $request->get('sort', 'name_asc');
        switch ($sort) {
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'name_asc':
            default:
                $query->orderBy('name', 'asc');
                break;
        }

        $products = $query->paginate(9)->withQueryString();

        return view('products.category', compact('categories', 'currentCategory', 'products', 'sort'));
    }

    public function product($slug)
    {
        $categories = $this->getCachedCategories();

        $product = Product::with(['category.parent', 'verifications'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('products.show', compact('categories', 'product', 'relatedProducts'));
    }
}
