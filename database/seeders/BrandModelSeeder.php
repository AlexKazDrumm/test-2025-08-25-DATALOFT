<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Brand, CarModel};

class BrandModelSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => Hash::make('password')]
        );

        $data = [
            'Toyota' => ['Camry','Corolla','RAV4'],
            'BMW'    => ['3 Series','5 Series','X5'],
            'Audi'   => ['A4','A6','Q5'],
        ];

        foreach ($data as $brandName => $models) {
            $brand = Brand::firstOrCreate(['name' => $brandName]);
            foreach ($models as $m) {
                CarModel::firstOrCreate(['brand_id' => $brand->id, 'name' => $m]);
            }
        }
    }
}
