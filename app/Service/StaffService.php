<?php

namespace App\Service;

use App\Repository\StaffRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class StaffService
{
    protected $staffRepository;

    public function __construct(StaffRepository $staffRepository)
    {
        $this->staffRepository = $staffRepository;
    }

    public function searchStaff(Request $request)
    {
        $perPage = $request->get('perPage', 30);

        if ($request->input('searchFlag')) {
            session()->forget('staff_checkbox_ids');
        }

        return $this->staffRepository->search($request, $perPage);
    }
}
