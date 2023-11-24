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
        $this->phoneEncrypt();
    }

    protected function phoneEncrypt()
    {
        $this->staff = $this->staff->map(function ($staff) {
            $replace = ['(', ')', '+', '-'];
            $staff->phone = str_replace($replace, '', $staff->phone);
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

    public function title(): string
    {
        return $this->staff->first()->name;
    }
}
