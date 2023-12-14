<?php

namespace App\Service;

use App\Repository\StaffRepository;
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

    public function exportStaff(Request $request)
    {
        try {
            $sessionIds = session('staff_checkbox_ids', []);

            $inputIds = $request->input('staff_id', []);

            $staffIds = array_unique(array_merge($inputIds, $sessionIds));

            session()->forget('staff_checkbox_ids');

            return $staffIds;
        } catch (\Throwable $throwable) {
            Log::error($throwable->getMessage());

            return abort(404);
        }
    }

    public function checkBoxSession(Request $request)
    {
        try {
            $nowIds = session('staff_checkbox_ids', []);

            $newIds = $request->selectedIds;

            $allIds = array_unique(array_merge($nowIds, $newIds));

            session(['staff_checkbox_ids' => $allIds]);
        } catch (\Throwable $throwable) {
            Log::error($throwable->getMessage());

            return abort(404);
        }
    }
}
