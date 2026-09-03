<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVerification;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_verifications' => ProductVerification::count(),
            'verified_codes' => ProductVerification::where('is_verified', true)->count(),
            'total_subscribers' => Subscriber::count(),
            'total_users' => User::count(),
        ];

        // Graphical Presentation 1: Products distribution by parent Category
        $categoriesChart = Category::whereNull('parent_id')
            ->withCount('products')
            ->get();

        $catLabels = $categoriesChart->pluck('name')->toArray();
        $catData = $categoriesChart->pluck('products_count')->toArray();

        // Graphical Presentation 2: Verification scans count by batch
        $batchChart = ProductVerification::select('batch_number', DB::raw('count(*) as total'))
            ->groupBy('batch_number')
            ->get();

        $batchLabels = $batchChart->pluck('batch_number')->toArray();
        $batchData = $batchChart->pluck('total')->toArray();

        $recentVerifications = ProductVerification::with('product')
            ->where('is_verified', true)
            ->latest('verified_at')
            ->take(6)
            ->get();

        $latestProducts = Product::with('category')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'catLabels', 'catData', 'batchLabels', 'batchData', 'recentVerifications', 'latestProducts'));
    }
}
