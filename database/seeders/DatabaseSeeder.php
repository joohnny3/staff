<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Board;
use App\Models\Staff;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Staff::factory('2000')->create();
        Staff::get()->each(function ($staff) {
            Board::factory('1')->create([
                'staff_id' => $staff->id,
            ]);
        });
    }
}
