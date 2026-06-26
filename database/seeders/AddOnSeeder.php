<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AddOn;

class AddOnSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo 5 add-ons ngẫu nhiên
        AddOn::factory()->count(5)->create();

        // Hoặc thêm vài mẫu cố định
        AddOn::create([
            'name' => 'Breakfast',
            'price' => 10.00,
            'description' => 'Buffet breakfast included',
        ]);

        AddOn::create([
            'name' => 'Airport Pickup',
            'price' => 25.00,
            'description' => 'Private car from airport',
        ]);
    }
}