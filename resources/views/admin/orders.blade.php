 public function adminIndex()
    {
        $orders = Orders::with(['orderItems.product', 'customer'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    // Jika Anda masih ingin menggunakan resource route untuk admin, 
    // tambahkan method ini untuk mapping ke admin methods:
    public function index()
    {
        // Cek apakah user adalah admin atau customer
        if (auth()->user()->role === 'admin') {
            return $this->adminIndex();
        } else {
            return $this->customerOrders();
        }
    }

    // ===== ADMIN METHODS =====

    // Admin Orders Index
   
    // Admin Show Order
    public function adminShow($id)
    {
        $order = Orders::with(['orderItems.product', 'customer'])
            ->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    // Admin Edit Order
    public function adminEdit($id)
    {
        $order = Orders::with(['orderItems.product', 'customer'])
            ->findOrFail($id);

        return view('admin.orders.edit', compact('order'));
    }

    // Admin Update Order
    public function adminUpdate(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order = Orders::findOrFail($id);
        $oldStatus = $order->status;
        
        // Jika status berubah dari cancelled ke status lain, cek stock
        if ($oldStatus === 'cancelled' && $request->status !== 'cancelled') {
            foreach ($order->orderItems as $item) {
                $product = Products::find($item->product_id);
                if ($product->stock < $item->quantity) {
                    return back()->with('error', "Stock untuk {$product->name} tidak mencukupi");
                }
            }
            
            // Kurangi stock lagi
            foreach ($order->orderItems as $item) {
                Products::where('id', $item->product_id)
                    ->decrement('stock', $item->quantity);
            }
        }
        
        // Jika status berubah menjadi cancelled, kembalikan stock
        if ($oldStatus !== 'cancelled' && $request->status === 'cancelled') {
            foreach ($order->orderItems as $item) {
                Products::where('id', $item->product_id)
                    ->increment('stock', $item->quantity);
            }
        }

        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Status pesanan berhasil diperbarui!');
    }

    // Admin Delete Order
    public function adminDestroy($id)
    {
        $order = Orders::findOrFail($id);

        DB::beginTransaction();

        try {
            // Restore stock jika order belum cancelled
            if ($order->status !== 'cancelled') {
                foreach ($order->orderItems as $item) {
                    Products::where('id', $item->product_id)
                        ->increment('stock', $item->quantity);
                }
            }

            // Delete order items first
            $order->orderItems()->delete();
            
            // Delete order
            $order->delete();

            DB::commit();

            return redirect()->route('admin.orders.index')
                ->with('success', 'Pesanan berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus pesanan');
        }
    }
}
