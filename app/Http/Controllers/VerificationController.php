<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductVerification;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class VerificationController extends Controller
{
    protected function getCachedCategories()
    {
        try {
            return Cache::rememberForever('nav_categories_tree', function () {
                return Category::whereNull('parent_id')
                    ->with(['children' => function ($query) {
                        $query->orderBy('order', 'asc');
                    }])
                    ->orderBy('order', 'asc')
                    ->get();
            });
        } catch (\Throwable $e) {
            return collect([]);
        }
    }

    public function index()
    {
        $categories = $this->getCachedCategories();
        return view('authenticity', compact('categories'));
    }

    public function verify(Request $request)
    {
        $request->validate([
            'security_code' => 'required|string|max:100',
        ]);

        $code = trim($request->input('security_code'));

        try {
            $verification = ProductVerification::with('product.category')
                ->where('security_code', $code)
                ->first();
        } catch (\Throwable $e) {
            $verification = null;
        }

        if (!$verification) {
            return response()->json([
                'status' => 'invalid',
                'message' => 'WARNING: The security code entered could not be verified in our master database. This product may be COUNTERFEIT.',
                'code' => $code,
            ], 404);
        }

        if ($verification->is_verified) {
            return response()->json([
                'status' => 'previously_verified',
                'message' => 'ATTENTION: This security code was previously verified on ' . ($verification->verified_at ? $verification->verified_at->format('F j, Y, g:i a') : 'an earlier date') . ' from IP: ' . ($verification->ip_address ?? 'Unknown') . '.',
                'code' => $verification->security_code,
                'batch_number' => $verification->batch_number,
                'product' => $verification->product ? [
                    'name' => $verification->product->name,
                    'category' => $verification->product->category->name ?? 'General',
                    'dosage_form' => $verification->product->dosage_form,
                    'pack_size' => $verification->product->pack_size,
                    'url' => route('products.show', $verification->product->slug),
                ] : null,
            ]);
        }

        try {
            $verification->update([
                'is_verified' => true,
                'verified_at' => now(),
                'ip_address' => $request->ip(),
            ]);
        } catch (\Throwable $e) {}

        return response()->json([
            'status' => 'authentic',
            'message' => 'AUTHENTIC PRODUCT CONFIRMED! Thank you for purchasing genuine Zerox Pharmaceuticals product.',
            'code' => $verification->security_code,
            'batch_number' => $verification->batch_number,
            'verified_at' => now()->format('F j, Y, g:i a'),
            'product' => $verification->product ? [
                'name' => $verification->product->name,
                'category' => $verification->product->category->name ?? 'General',
                'dosage_form' => $verification->product->dosage_form,
                'pack_size' => $verification->product->pack_size,
                'url' => route('products.show', $verification->product->slug),
            ] : null,
        ]);
    }
}
