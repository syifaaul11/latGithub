<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Products;
use App\Models\Categories;
use App\Models\Orders;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Statistics
        $totalUsers = User::where('role', 'customer')->count();
        $totalProducts = Products::count();
        $totalCategories = Categories::count();
        $totalOrders = Orders::count();
        $totalRevenue = Orders::where('status', 'delivered')->sum('total_amount');
        
        // Monthly revenue
        $monthlyRevenue = Orders::where('status', 'delivered')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total_amount');

        // Recent orders
        $recentOrders = Orders::with(['user', 'orderItems'])
            ->latest()
            ->limit(5)
            ->get();

        // Top products
        $topProducts = Products::withCount('orderItems')
            ->having('order_items_count', '>', 0)
            ->orderByDesc('order_items_count')
            ->limit(5)
            ->get();

        // Low stock products
        $lowStockProducts = Products::where('stock', '<', 10)
            ->where('is_active', true)
            ->orderBy('stock')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalProducts',
            'totalCategories',
            'totalOrders',
            'totalRevenue',
            'monthlyRevenue',
            'recentOrders',
            'topProducts',
            'lowStockProducts'
        ));
    }

    public function users()
    {
        $users = User::where('role', 'customer')
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function userShow($id)
    {
        $user = User::with(['orders.orderItems.product'])
            ->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    public function userEdit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function userUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());

        return redirect()->route('admin.users.show', $id)
            ->with('success', 'Data user berhasil diupdate!');
    }

    public function userDestroy($id)
    {
        $user = User::findOrFail($id);
        
        // Check if user has orders
        if ($user->orders()->exists()) {
            return redirect()->back()->with('error', 'User tidak dapat dihapus karena memiliki pesanan!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }
}