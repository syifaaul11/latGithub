<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Products;
use App\Models\Categories;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $categories = Categories::all();

        $products = [
            [
                'name' => 'Smartphone Samsung Galaxy A54',
                'description' => 'Smartphone Android terbaru dengan kamera 64MP dan baterai 5000mAh',
                'price' => 4999000,
                'stock' => 50,
                'category_id' => $categories->where('slug', 'elektronik')->first()->id,
                'is_active' => true,
            ],
            [
                'name' => 'Laptop ASUS VivoBook',
                'description' => 'Laptop dengan processor Intel Core i5, RAM 8GB, SSD 512GB',
                'price' => 8999000,
                'stock' => 25,
                'category_id' => $categories->where('slug', 'elektronik')->first()->id,
                'is_active' => true,
            ],
            [
                'name' => 'Kaos Polo Premium',
                'description' => 'Kaos polo cotton combed 30s dengan berbagai warna',
                'price' => 150000,
                'stock' => 100,
                'category_id' => $categories->where('slug', 'fashion')->first()->id,
                'is_active' => true,
            ],
            [
                'name' => 'Sepatu Running Nike',
                'description' => 'Sepatu running dengan teknologi Air Max untuk kenyamanan maksimal',
                'price' => 1299000,
                'stock' => 30,
                'category_id' => $categories->where('slug', 'olahraga')->first()->id,
                'is_active' => true,
            ],
            [
                'name' => 'Serum Vitamin C',
                'description' => 'Serum wajah dengan kandungan vitamin C untuk kulit cerah',
                'price' => 89000,
                'stock' => 75,
                'category_id' => $categories->where('slug', 'kesehatan-kecantikan')->first()->id,
                'is_active' => true,
            ],
            [
                'name' => 'Blender Philips',
                'description' => 'Blender 2 liter dengan 5 kecepatan dan fungsi pulse',
                'price' => 450000,
                'stock' => 20,
                'category_id' => $categories->where('slug', 'rumah-taman')->first()->id,
                'is_active' => true,
            ],
            [
                'name' => 'Kopi Arabika Premium',
                'description' => 'Kopi arabika single origin dengan cita rasa premium',
                'price' => 125000,
                'stock' => 60,
                'category_id' => $categories->where('slug', 'makanan-minuman')->first()->id,
                'is_active' => true,
            ],
            [
                'name' => 'Headphone Wireless Sony',
                'description' => 'Headphone wireless dengan noise cancelling dan battery 30 jam',
                'price' => 2499000,
                'stock' => 15,
                'category_id' => $categories->where('slug', 'elektronik')->first()->id,
                'is_active' => true,
            ],
            [
                'name' => 'Tas Ransel Traveling',
                'description' => 'Tas ransel kapasitas 40L dengan material anti air',
                'price' => 350000,
                'stock' => 40,
                'category_id' => $categories->where('slug', 'fashion')->first()->id,
                'is_active' => true,
            ],
            [
                'name' => 'Protein Whey Isolate',
                'description' => 'Suplemen protein whey isolate untuk pembentukan otot',
                'price' => 899000,
                'stock' => 25,
                'category_id' => $categories->where('slug', 'olahraga')->first()->id,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Products::create($product);
        }

        // Create additional products using factory
        Products::factory(50)->create();
    }
}