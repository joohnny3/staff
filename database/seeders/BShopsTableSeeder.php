<?php

namespace Database\Seeders;

use App\Models\BShop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BShopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = collect(range(1, 10000))->map(function ($index) {
            return [
                'money' => fake()->randomNumber(4, true),
            ];
        })->all();
        
        BShop::insert($data);
    }
}
