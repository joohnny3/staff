<?php

namespace Database\Seeders;

use App\Models\CShop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CShopsTableSeeder extends Seeder
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

        CShop::insert($data);
    }
}
