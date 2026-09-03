<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = trim($request->input('q'));

        if (empty($query) || strlen($query) < 2) {
            return response()->json([
                'products' => [],
                'categories' => [],
            ]);
        }

        $products = Product::with('category')
            ->where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('sku', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->take(6)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category' => $product->category->name ?? 'General',
                    'dosage_form' => $product->dosage_form,
                    'url' => route('products.show', $product->slug),
                ];
            });

        $categories = Category::where('name', 'LIKE', "%{$query}%")
            ->take(4)
            ->get()
            ->map(function ($cat) {
                return [
                    'id' => $cat->id,
                    'name' => $cat->name,
                    'url' => route('category.show', $cat->slug),
                ];
            });

        return response()->json([
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
