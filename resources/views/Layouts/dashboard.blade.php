<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="flex h-screen bg-gray-100">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white flex flex-col">
        <div class="p-6 text-2xl font-bold border-b border-gray-700">Toko Online</div>
        <nav class="flex-1 p-4">
            <a href="#" class="block py-2 px-3 rounded hover:bg-gray-700"><i class="fas fa-home mr-2"></i> Dashboard</a>
            <a href="/customers/orders" class="block py-2 px-3 rounded hover:bg-gray-700"><i class="fas fa-shopping-cart mr-2"></i> Orders</a>
            <a href="/customers/profil" class="block py-2 px-3 rounded hover:bg-gray-700"><i class="fas fa-user mr-2"></i> Profile</a>
        </nav>
    </aside>

    <!-- Main -->
    <main class="flex-1 overflow-y-auto">
        <!-- Header -->
        <header class="flex justify-between items-center bg-white px-6 py-4 border-b">
            <h1 class="text-xl font-semibold">@yield('page-title')</h1>
            <div class="flex items-center gap-2">
                <span>{{ auth()->user()->name }}</span>
                <img src="https://via.placeholder.com/32" alt="avatar" class="rounded-full">
            </div>
        </header>

        <!-- Content -->
        <div class="p-6">
            @yield('content')
        </div>
    </main>

</body>
</html>
