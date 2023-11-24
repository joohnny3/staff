<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class StaffSheet implements FromView, ShouldAutoSize, WithTitle
{
    protected $staff;

    public function __construct($staff)
    {
        $this->staff = $staff;
    }


    public function view(): View
    {
        return view('exports.staff', [
            'data' => $this->staff
        ]);
    }

    public function title(): string
    {
        return $this->staff->first()->name;
    }
}
