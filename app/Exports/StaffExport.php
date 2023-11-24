<?php

namespace App\Exports;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StaffExport implements WithMultipleSheets
{
    protected $staff;

    public function __construct($staff)
    {
        $this->staff = $staff;
    }

    public function sheets(): array
    {
        $sheets = [];

        $staffCollection = Staff::whereIn('id', $this->staff)->get()->map(function ($staff) {
            $replace = ['(', ')', '+', '-'];
            $staff->phone = str_replace($replace, '', $staff->phone);
            $staff->phone = substr($staff->phone, 0, 3) . '###' . substr($staff->phone, -4);
            return $staff;
        });

        $sheets = $staffCollection->chunk(10)->map(function ($chunk) {
            return new StaffSheet($chunk);
        })->all();

        return $sheets;
    }
}
