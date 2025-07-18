<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function customerDashboard()
    {
        $user = Auth::user();
        
        // Pastikan user adalah customer
        if ($user->role !== 'customer') {
            return redirect()->route('login');
        }
        
        return view('customers.dashboard', compact('user'));
    }

    public function adminDashboard()
    {
        $user = Auth::user();
        
        // Pastikan user adalah admin
        if ($user->role !== 'admin') {
            return redirect()->route('login');
        }
        
        return view('admin.dashboard', compact('user'));
    }
}