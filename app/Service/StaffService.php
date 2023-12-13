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
        $data = $this->staffRepository->get($id);

        if (empty($data)) {
            Log::error('not found data');
            abort(404);
        }

        $data->boards->reduce(
            function ($carry, $board) use ($data) {

                if ($board->board_id) {
                    $carry[$board->board_id][] = $board->content;
                }

                $data->boards->each(
                    function ($board) use ($carry) {
                        if (array_key_exists($board->id, $carry)) {
                            $board->reply_contents = $carry[$board->id];
                        }
                    }
                );
                return $carry;
            },
            []
        );

        return $data;
    }
}
