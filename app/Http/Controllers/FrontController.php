<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class FrontController extends Controller
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

    public function home()
    {
        $categories = $this->getCachedCategories();

        $featuredProducts = Cache::rememberForever('home_featured_products', function () {
            return Product::with('category')
                ->where('is_active', true)
                ->latest()
                ->take(8)
                ->get();
        });

        return view('home', compact('categories', 'featuredProducts'));
    }

    public function about()
    {
        $categories = $this->getCachedCategories();
        return view('about', compact('categories'));
    }

    public function contact()
    {
        $categories = $this->getCachedCategories();
        return view('contact', compact('categories'));
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        return redirect()->back()->with('success', 'Thank you for reaching out to Zerox Pharmaceuticals. Our team will get back to you shortly.');
    }

    public function analysis()
    {
        $categories = $this->getCachedCategories();

        $labReports = [
            ['title' => 'Anavar 10mg HPLC Purity Assay Report', 'date' => '2026-05-10', 'purity' => '99.6%', 'batch' => 'ZX-2026-B1', 'pdf' => 'reports/anavar-10mg.pdf'],
            ['title' => 'Testorox Prop 100mg Sterility & Heavy Metal Test', 'date' => '2026-06-14', 'purity' => '99.8%', 'batch' => 'ZX-2026-B2', 'pdf' => 'reports/testorox-prop.pdf'],
            ['title' => 'Somatropin 10IU Endotoxin & Amino Acid Analysis', 'date' => '2026-07-02', 'purity' => '99.9%', 'batch' => 'ZX-2026-B3', 'pdf' => 'reports/somatropin-10iu.pdf'],
            ['title' => 'BPC-157 5mg Mass Spectrometry (MS) Certificate', 'date' => '2026-08-01', 'purity' => '99.5%', 'batch' => 'ZX-2026-B4', 'pdf' => 'reports/bpc-157.pdf'],
        ];

        return view('analysis', compact('categories', 'labReports'));
    }
}
