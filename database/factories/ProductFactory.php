<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition()
    {
        $name = $this->faker->words(3, true);
        
        return [
            'name' => $name,
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(10000, 10000000),
            'stock' => $this->faker->numberBetween(0, 100),
            'slug' => Str::slug($name),
            'category_id' => Category::factory(),
            'is_active' => $this->faker->boolean(90), // 90% chance