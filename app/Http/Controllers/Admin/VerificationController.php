<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductVerification;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VerificationController extends Controller
{
    public function index()
    {
        $verifications = ProductVerification::with('product')->latest()->paginate(20);
        return view('admin.verifications.index', compact('verifications'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.verifications.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'batch_number' => 'required|string|max:100',
            'count' => 'required|integer|min:1|max:100',
        ]);

        $productId = $validated['product_id'];
        $batch = $validated['batch_number'];
        $count = $validated['count'];

        for ($i = 0; $i < $count; $i++) {
            $code = 'ZX-' . rand(1000, 9999) . '-' . strtoupper(Str::random(4));
            ProductVerification::create([
                'product_id' => $productId,
                'batch_number' => $batch,
                'security_code' => $code,
                'is_verified' => false,
            ]);
        }

        return redirect()->route('admin.verifications.index')->with('success', "{$count} verification codes generated successfully.");
    }

    public function destroy(ProductVerification $verification)
    {
        $verification->delete();
        return redirect()->route('admin.verifications.index')->with('success', 'Verification record deleted.');
    }
}
