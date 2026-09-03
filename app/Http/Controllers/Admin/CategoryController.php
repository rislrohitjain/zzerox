<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CatalogController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::with('parent');

        if ($request->has('trashed') && $request->input('trashed') == '1') {
            $query->onlyTrashed();
        }

        $categories = $query->orderBy('order', 'asc')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
        ]);

        $validated['slug'] = !empty($request->input('slug')) ? Str::slug($request->input('slug')) : Str::slug($validated['name']);
        $validated['order'] = $validated['order'] ?? 0;

        if ($request->hasFile('category_image')) {
            $file = $request->file('category_image');
            $fileName = 'cat_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/categories'), $fileName);
            $validated['image_path'] = 'img/categories/' . $fileName;
        }

        Category::create($validated);

        CatalogController::clearFileCache();

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully with custom slug and CKEditor description.');
    }

    public function edit(Category $category)
    {
        $parentCategories = Category::whereNull('parent_id')->where('id', '!=', $category->id)->get();
        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
        ]);

        $validated['slug'] = !empty($request->input('slug')) ? Str::slug($request->input('slug')) : Str::slug($validated['name']);
        $validated['order'] = $validated['order'] ?? 0;

        if ($request->hasFile('category_image')) {
            $file = $request->file('category_image');
            $fileName = 'cat_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/categories'), $fileName);
            $validated['image_path'] = 'img/categories/' . $fileName;
        }

        $category->update($validated);

        CatalogController::clearFileCache();

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete(); // Soft delete
        CatalogController::clearFileCache();

        return redirect()->route('admin.categories.index')->with('success', 'Category soft-deleted successfully.');
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();
        CatalogController::clearFileCache();

        return redirect()->back()->with('success', 'Category restored successfully.');
    }

    public function forceDelete($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->forceDelete();
        CatalogController::clearFileCache();

        return redirect()->back()->with('success', 'Category permanently deleted.');
    }
}
