<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categories;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'description' => 'Produk elektronik seperti smartphone, laptop, tablet, dan aksesoris',
                'slug' => 'elektronik',
            ],
            [
                'name' => 'Fashion',
                'description' => 'Pakaian, sepatu, tas, dan aksesoris fashion',
                'slug' => 'fashion',
            ],
            [
                'name' => 'Kesehatan & Kecantikan',
                'description' => 'Produk kesehatan, kecantikan, dan perawatan tubuh',
                'slug' => 'kesehatan-kecantikan',
            ],
            [
                'name' => 'Rumah & Taman',
                'description' => 'Peralatan rumah tangga, furniture, dan perlengkapan taman',
                'slug' => 'rumah-taman',
            ],
            [
                'name' => 'Olahraga',
                'description' => 'Peralatan olahraga, pakaian olahraga, dan suplemen',
                'slug' => 'olahraga',
            ],
            [
                'name' => 'Makanan & Minuman',
                'description' => 'Makanan ringan, minuman, dan produk makanan lainnya',
                'slug' => 'makanan-minuman',
            ],
        ];

        foreach ($categories as $category) {
            Categories::create($category);
        }
    }
}