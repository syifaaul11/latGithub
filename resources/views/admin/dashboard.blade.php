@extends('layout.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
        <p class="text-gray-600 mt-2">Selamat datang, {{ auth()->user()->name }}!</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-blue-500 text-white p-6 rounded-lg">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-blue-100">Total Produk</p>
                    <p class="text-2xl font-bold">{{ $stats['total_products'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-green-500 text-white p-6 rounded-lg">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-green-100">Total Kategori</p>
                    <p class="text-2xl font-bold">{{ $stats['total_categories'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-yellow-500 text-white p-6 rounded-lg">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-yellow-100">Total Customer</p>
                    <p class="text-2xl font-bold">{{ $stats['total_customers'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-purple-500 text-white p-6 rounded-lg">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-purple-100">Total Order</p>
                    <p class="text-2xl font-bold">{{ $stats['total_orders'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Order</h3>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span>Pending</span>
                    <span class="font-semibold text-yellow-600">{{ $stats['pending_orders'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Completed</span>
                    <span class="font-semibold text-green-600">{{ $stats['completed_orders'] }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Revenue</h3>
            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Stock Alert</h3>
            <p class="text-2xl font-bold text-red-600">{{ $stats['low_stock_products'] }}</p>
            <p class="text-sm text-gray-600">Produk stok rendah</p>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Order Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-2 text-left">Order ID</th>
                        <th class="px-4 py-2 text-left">Customer</th>
                        <th class="px-4 py-2 text-left">Total</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recent_orders as $order)
                    <tr class="border-b">
                        <td class="px-4 py-2">#{{ $order->id }}</td>
                        <td class="px-4 py-2">{{ $order->customer->name }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 text-xs rounded-full
                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($order->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection