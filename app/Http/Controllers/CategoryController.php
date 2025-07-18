<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Categories::withCount('products')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        Categories::create($validatedData);

        return redirect()->route('admin.categories.index')->with('success', 'Category berhasil ditambahkan!');
    }

    public function show($id)
    {
        $category = Categories::with('products')->findOrFail($id);
        return view('admin.categories.show', compact('category'));
    }

    public function edit($id)
    {
        $category = Categories::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Categories::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $category->update($validatedData);

        return redirect()->route('admin.categories.index')->with('success', 'Category berhasil diupdate!');
    }

    public function destroy($id)
    {
        $category = Categories::findOrFail($id);

        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')->with('error', 'Category tidak dapat dihapus karena masih memiliki produk!');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category berhasil dihapus!');
    }
}