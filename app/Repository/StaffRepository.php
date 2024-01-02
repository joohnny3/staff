<?php

namespace App\Repository;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Matrix\Exception;

class StaffRepository
{
    public function search(Request $request, int $perPage)
    {
        $search = Staff::query();

        $filters = [
            'name_k' => $request->input('name'),
            'phone_k' => $request->input('phone'),
            'address_k' => $request->input('address'),
        ];

        $search = $search->whereHas('boards', function (Builder $query) use ($request) {
            $array = ['content_k' => $request->input('message')];
            $query->filter($array);
        });


        /*
        $filters = [
            'name' => fn($search) => $search->where('name', 'LIKE', '%' . $request->input('name') . '%'),
            'phone' => fn($search) => $search->where('phone', 'LIKE', '%' . $request->input('phone') . '%'),
            'address' => fn($search) => $search->where('address', 'LIKE', '%' . $request->input('address') . '%'),
            'message' => fn($search) => $search->whereHas('boards', function (Builder $query) use ($request) {
                $query->where('content', 'LIKE', " %{
                    $request->input('message')}%");
            }),
        ];

        foreach ($filters as $key => $filter) {
            if (!empty($request->input($key))) {
                $search = $filter($search);
            }
        }
        */

        return $search->filter($filters)->orderBy('id', 'DESC')->paginate($perPage, ['*'], 'pages');
    }

    public function add(array $data)
    {
        try {
            DB::beginTransaction();

            Staff::create($data);

            DB::commit();
        } catch (\Throwable $throwable) {
            DB::rollBack();
            Log::error($throwable->getMessage());
            throw $throwable;
        }
    }

    public function get(string $id)
    {
        $filters = [
            'id_eq' => $id
        ];

        $data = Staff::with('boards')->filter($filters)->first();

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

    public function editView(string $id)
    {
        $filters = [
            'id_eq' => $id
        ];

        $data = Staff::filter($filters)->first();

        if (!$data) {
            abort(404);
        }
        return $data;
    }

    public function edit(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            if (!$id) {
                throw new Exception('Not Found Edit ID');
            }

            $filters = [
                'id_eq' => $id
            ];

            $item = Staff::filter($filters)->firstOrFail();

            if (!$item) {
                throw new Exception('Not Found Edit Staff');
            }

            $item->name = $request['name'];
            $item->phone = $request['phone'];
            $item->address = $request['address'];
            $item->save();

            DB::commit();
        } catch (\Throwable $throwable) {
            DB::rollBack();
            Log::error($throwable->getMessage());
        }
    }

    public function delete(string $id)
    {
        try {
            DB::beginTransaction();

            $filters = [
                'id_eq' => $id
            ];

            $data = Staff::filter($filters)->firstOrFail();
            $data->delete();

            DB::commit();
        } catch (\Throwable $t) {
            DB::rollBack();

            abort(404);
        }
    }
}
