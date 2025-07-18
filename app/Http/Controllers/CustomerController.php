<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Statistics
        $totalOrders = Order::where('user_id', $user->id)->count();
        $pendingOrders = Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
        $completedOrders = Order::where('user_id', $user->id)
            ->where('status', 'delivered')
            ->count();
        $cartItems = Cart::where('user_id', $user->id)->count();

        // Recent orders
        $recentOrders = Order::with(['orderItems.product'])
            ->where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        // Recommended products (most popular)
        $recommendedProducts = Product::withCount('orderItems')
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->orderByDesc('order_items_count')
            ->limit(8)
            ->get();

        return view('customers.dashboard', compact(
            'user',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'cartItems',
            'recentOrders',
            'recommendedProducts'
        ));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('customers.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'address']);

        // Update password if provided
        if ($request->filled('password')) {
            if (!$request->filled('current_password')) {
                return redirect()->back()->with('error', 'Password lama harus diisi!');
            }

            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->with('error', 'Password lama tidak sesuai!');
            }

            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Profile berhasil diupdate!');
    }
}