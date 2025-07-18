<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Orders;

class customers extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'birth_date',
        'gender',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];
    public function orders()
    {
        return $this->hasMany(orders::class, 'customer_id'); 
    }

    // Mendapatkan total pembelian customer
    public function getTotalPurchaseAttribute()
    {
        return $this->orders->sum('total_amount');
    }

    // Mendapatkan order terakhir
    public function getLastOrderAttribute()
    {
        return $this->orders()->latest()->first();
    }
}
