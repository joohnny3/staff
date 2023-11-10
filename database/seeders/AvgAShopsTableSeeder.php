<?php

namespace Database\Seeders;

use App\Models\AShop;
use App\Models\BShop;
use App\Models\CShop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AvgAShopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bShopsData = BShop::pluck('money', 'id');
        $cShopsData = CShop::pluck('money', 'id');


        $bShopsData->each(function ($money, $id) use ($cShopsData) {
            if (isset($cShopsData[$id])) {
                $avgMoney = ($money + $cShopsData[$id]) / 2;

                AShop::where('id', $id)->update(['avg' => $avgMoney]);
            }
        });

    }
}
