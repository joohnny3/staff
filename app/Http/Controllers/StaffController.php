<?php

namespace App\Http\Controllers;

use App\Exports\StaffExport;
use App\Models\Staff;
use App\Service\StaffService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $staffService;

    public function __construct(StaffService $staffService)
    {
        $this->staffService = $staffService;
    }

    public function index(Request $request)
    {
        try {
            $request->validate([
                'perPage' => 'integer',
            ]);

            $data = $this->staffService->searchStaff($request);

            return view('index', [
                'data' => $data,
                'perPage' => $data->perPage(),
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'message' => $request->input('message')
            ]);
        } catch (ValidationException $t) {
            return abort(404);
        }

        //$search = Staff::query(); //Repository

        /*
         $name = $request->input('name');

         $phone = $request->input('phone');

         $address = $request->input('address');

         $message = $request->input('message');
        */

        /**
         * 改用filter方式
         * if ($request->input('searchFlag')) {
         * session()->forget('staff_checkbox_ids');
         * }
         *
         * if ($name !== null && $name !== '') {
         * $search = $search->where('name', 'LIKE', "%{$name}%");
         * }
         *
         * if ($phone !== null && $phone !== '') {
         * $search = $search->where('phone', 'LIKE', "%{$phone}%");
         * }
         *
         * if ($address !== null && $address !== '') {
         * $search = $search->where('address', 'LIKE', "%{$address}%");
         * }
         *
         * if ($message !== null && $message !== '') {
         * $search = $search->whereHas('boards', function (Builder $query) use ($message) {
         * $query->where('content', 'LIKE', "%{$message}%");
         * });
         * }
         */

        /* 分層架構 Service
        $filters = [
            'name' => fn($search, $value) => $search->where('name', 'LIKE', "%{$value}%"),
            'phone' => fn($search, $value) => $search->where('phone', 'LIKE', "%{$value}%"),
            'address' => fn($search, $value) => $search->where('address', 'LIKE', "%{$value}%"),
            'message' => fn($search, $value) => $search->whereHas('boards', function (Builder $query) use ($message) {
                $query->where('content', 'LIKE', "%{$message}%");
            }),
        ];

        foreach ($filters as $key => $v) {
            $value = $request->input($key);
            if (!empty($value)) {
                $v($search, $value);
            }
        }

        if ($request->input('searchFlag')) {
            session()->forget('staff_checkbox_ids');
        }

        $perPage = $request->get('perPage', 30);



        return view('index', [
            'data' => $data,
            'perPage' => $perPage,
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'message' => $request->input('message')
        ]);
        */
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validate([
                'name' => 'required|string|max:24',
                'phone' => 'required|string|max:30',
                'address' => 'required|string|max:100',
            ]);

            Staff::create($data);

            DB::commit();
        } catch (ValidationException $t) {

            DB::rollBack();

            abort(404);
        }

        return redirect()->route('staff.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Staff::with('boards')->find($id);

        if (!$data) {
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

        return view('board', [
            'staff' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Staff::find($id);
        if (!$data) {
            abort(404);
        }

        return view('edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            if (!$id) {
                throw new Exception('Not Find ID');
            }

            $item = Staff::find($id);
            if (!$item) {
                throw new Exception('Staff not found.');
            }

            $item->name = $request['name'];
            $item->phone = $request['phone'];
            $item->address = $request['address'];
            $item->save();

            DB::commit();
        } catch (Throwable $t) {

            DB::rollBack();

            abort(404);
        }


        return redirect()->route('staff.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $data = Staff::findOrFail($id);
            $data->delete();

            DB::commit();
        } catch (Throwable $t) {
            DB::rollBack();

            abort(404);
        }
        return redirect()->route('staff.index');
    }


    public function export(Request $request)
    {
        try {
            $sessionIds = session('staff_checkbox_ids', []);

            $inputIds = $request->input('staff_id', []);

            $staffIds = array_unique(array_merge($inputIds, $sessionIds));

            session()->forget('staff_checkbox_ids');

            return Excel::download(new StaffExport($staffIds), 'staff.xlsx');
        } catch (\Throwable $th) {
            abort(404);
        }
    }

    public function checkBox(Request $request)
    {
        try {
            $nowIds = session('staff_checkbox_ids', []);

            $newIds = $request->selectedIds;

            $allIds = array_unique(array_merge($nowIds, $newIds));

            session(['staff_checkbox_ids' => $allIds]);

            return response(null, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
