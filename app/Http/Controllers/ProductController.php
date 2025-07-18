<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Categories;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Public methods for customers
    public function index()
    {
        $products = Products::with('category')
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->paginate(12);

        $categories = Categories::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = Products::with('category')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $related_products = Products::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'related_products'));
    }

    // Admin methods
    public function adminIndex()
    {
        $products = Products::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function adminShow($id)
    {
        $product = Products::with('category')->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function adminCreate()
    {
        $categories = Categories::all();
        return view('admin.products.create', compact('categories'));
    }

    public function adminStore(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('products', 'public');
        }

        $validatedData['slug'] = Str::slug($validatedData['name']);

        Products::create($validatedData);

        return redirect()->route('admin.products.index')->with('success', 'Product berhasil ditambahkan!');
    }

    public function adminEdit($id)
    {
        $product = Products::findOrFail($id);
        $categories = Categories::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function adminUpdate(Request $request, $id)
    {
        $product = Products::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validatedData['image'] = $request->file('image')->store('products', 'public');
        }

        $validatedData['slug'] = Str::slug($validatedData['name']);

        $product->update($validatedData);

        return redirect()->route('admin.products.index')->with('success', 'Product berhasil diupdate!');
    }

    public function adminDestroy($id)
    {
        $product = Products::findOrFail($id);
        
        // Delete image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product berhasil dihapus!');
    }
}