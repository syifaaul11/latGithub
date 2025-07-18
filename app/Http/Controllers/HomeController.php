<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // Featured products
        $featuredProducts = Product::where('is_active', true)
            ->where('stock', '>', 0)
            ->withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->limit(8)
            ->get();

        // New products
        $newProducts = Product::where('is_active', true)
            ->where('stock', '>', 0)
            ->latest()
            ->limit(8)
            ->get();

        // Categories
        $categories = Category::withCount('products')
            ->having('products_count', '>', 0)
            ->limit(6)
            ->get();

        return view('welcome', compact('featuredProducts', 'newProducts', 'categories'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function contactStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Here you can save to database or send email
        // For now, just return success message
        
        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim!');
    }
}