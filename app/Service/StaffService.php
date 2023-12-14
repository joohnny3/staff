<?php

namespace App\Service;

use App\Repository\StaffRepository;
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

    public function addStaff(array $data)
    {
        return $this->staffRepository->add($data);
    }

    public function getStaff(string $id)
    {
        return $this->staffRepository->get($id);
    }

    public function editStaffView(string $id)
    {
        return $this->staffRepository->editView($id);
    }

    public function deleteStaff(string $id)
    {
        return $this->staffRepository->delete($id);
    }
}
