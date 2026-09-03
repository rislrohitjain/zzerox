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

    public function allCategories()
    {
        $categories = $this->getCachedCategories();

        $allParents = Cache::rememberForever('all_categories_master', function () {
            return Category::whereNull('parent_id')
                ->with(['children.products', 'products'])
                ->orderBy('order', 'asc')
                ->get();
        });

        return view('products.index', compact('categories', 'allParents'));
    }

    public function category(Request $request, $slug)
    {
        $categories = $this->getCachedCategories();

        $currentCategory = Cache::remember('cat_by_slug_' . $slug, 3600, function () use ($slug) {
            return Category::where('slug', $slug)
                ->with(['children', 'parent'])
                ->firstOrFail();
        });

        $page = $request->get('page', 1);
        $sort = $request->get('sort', 'name_asc');
        $cacheKey = "cat_prods_{$slug}_sort_{$sort}_page_{$page}";

        $products = Cache::remember($cacheKey, 1800, function () use ($currentCategory, $sort) {
            $categoryIds = array_merge([$currentCategory->id], $currentCategory->children->pluck('id')->toArray());
            $query = Product::with(['category', 'images'])->whereIn('category_id', $categoryIds)->where('is_active', true);

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

            return $query->paginate(12)->withQueryString();
        });

        return view('products.category', compact('categories', 'currentCategory', 'products', 'sort'));
    }

    public function product($slug)
    {
        $categories = $this->getCachedCategories();

        $product = Cache::remember('product_detail_' . $slug, 1800, function () use ($slug) {
            return Product::with(['category.parent', 'verifications', 'images'])
                ->where('slug', $slug)
                ->where('is_active', true)
                ->firstOrFail();
        });

        $relatedProducts = Cache::remember('product_related_' . $slug, 1800, function () use ($product) {
            return Product::with(['category', 'images'])
                ->where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->where('is_active', true)
                ->take(4)
                ->get();
        });

        return view('products.show', compact('categories', 'product', 'relatedProducts'));
    }

    public static function clearFileCache()
    {
        Cache::forget('nav_categories_tree');
        Cache::forget('all_categories_master');
        Cache::forget('home_banners');
        Cache::forget('home_featured_products');
    }
}
