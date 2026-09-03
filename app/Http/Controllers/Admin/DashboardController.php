<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVerification;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_verifications' => ProductVerification::count(),
            'verified_codes' => ProductVerification::where('is_verified', true)->count(),
            'total_users' => User::count(),
        ];

        $recentVerifications = ProductVerification::with('product')
            ->where('is_verified', true)
            ->latest('verified_at')
            ->take(6)
            ->get();

        $latestProducts = Product::with('category')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentVerifications', 'latestProducts'));
    }
}
