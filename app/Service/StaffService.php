<?php

namespace App\Service;

use App\Repository\StaffRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    public function addStaff($data)
    {
        return $this->staffRepository->add($data);
    }

    public function getStaff($id)
    {
        return $this->staffRepository->get($id);
    }

    public function editStaffView($id)
    {
        return $this->staffRepository->editView($id);
    }
}
