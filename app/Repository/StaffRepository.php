<?php

namespace App\Repository;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StaffRepository
{
    public function search($request, $perPage)
    {
        $search = Staff::query();

        $filters = [
            'name' => fn($search) => $search->where('name', 'LIKE', '%' . $request->input('name') . '%'),
            'phone' => fn($search) => $search->where('phone', 'LIKE', '%' . $request->input('phone') . '%'),
            'address' => fn($search) => $search->where('address', 'LIKE', '%' . $request->input('address') . '%'),
            'message' => fn($search) => $search->whereHas('boards', function (Builder $query) use ($request) {
                $query->where('content', 'LIKE', "%{$request->input('message')}%");
            }),
        ];

        foreach ($filters as $key => $filter) {
            if (!empty($request->input($key))) {
                $search = $filter($search);
            }
        }

        //dd($search->toSql())
        return $search->orderBy('id', 'DESC')->paginate($perPage, ['*'], 'pages');
    }

    public function add($data)
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

    public function get($id)
    {
        return Staff::with('boards')->find($id);
    }


}
