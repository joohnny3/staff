<?php

namespace App\Exports;

use App\Models\Staff;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StaffExport implements FromView, ShouldAutoSize
{
    protected $staff;

    public function __construct($staffIds)
    {
        $this->staff = Staff::whereIn('id', $staffIds)
            ->get()
            ->map(function ($staff) {

                $replace = ['(', ')', '+', '-'];

                $staff->phone = str_replace($replace, '', $staff->phone);

                // $staff->phone = preg_replace('/[\+\(\)\-]/', '', $staff->phone);

                $staff->phone = substr($staff->phone, 0, 3) . '###' . substr($staff->phone, -4);

                return $staff;
            });
    }

    public function view(): View
    {
        return view('exports.staff', [
            'data' => $this->staff
        ]);
    }
}
