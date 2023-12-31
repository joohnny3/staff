<?php

namespace App\Http\Controllers;

use App\Exports\StaffExport;
use App\Models\Staff;
use App\Service\StaffService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class StaffController extends Controller
{
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

    public function addStaffView()
    {
        return view('create');
    }

    public function addStaff(Request $request)
    {
        try {
            //DB::beginTransaction();
            $data = $request->validate([
                'name' => 'required|string|max:24',
                'phone' => 'required|string|max:30',
                'address' => 'required|string|max:100',
            ]);

            //Staff::create($data);

            //DB::commit();
            $this->staffService->addStaff($data);

            return redirect()->route('staff.index');
        } catch (ValidationException $t) {
            //DB::rollBack();

            Log::error($t->getMessage());

            return abort(404);
        }
    }

    public function getStaff(string $id)
    {
        //$data = Staff::with('boards')->find($id);
        /*if (empty($data)) {
            Log::error('not found data');
            abort(404);
        }*/
        /*$data->boards->reduce(
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
        );*/
        $data = $this->staffService->getStaff($id);

         return view('board', [
             'staff' => $data,
         ]);

         //return response()->hello();
    }

    public function editStaffView(string $id)
    {
        $data = $this->staffService->editStaffView($id);

        /*$data = Staff::find($id);
        if (!$data) {
            abort(404);
        }*/

        return view('edit')->with('data', $data);
    }

    public function editStaff(Request $request, string $id)
    {
        $this->staffService->editStaff($request, $id);

        /*try {
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
        }*/
        return redirect()->route('staff.index');
    }

    public function deleteStaff(string $id)
    {
        $this->staffService->deleteStaff($id);

        /*try {
            DB::beginTransaction();

            $data = Staff::findOrFail($id);
            $data->delete();

            DB::commit();
        } catch (Throwable $t) {
            DB::rollBack();

            abort(404);
        }*/

        return redirect()->route('staff.index');
    }

    public function export(Request $request)
    {
        $staffIds = $this->staffService->exportStaff($request);

        /*try {
            $sessionIds = session('staff_checkbox_ids', []);

            $inputIds = $request->input('staff_id', []);

            $staffIds = array_unique(array_merge($inputIds, $sessionIds));

            session()->forget('staff_checkbox_ids');

        } catch (\Throwable $th) {
            abort(404);
        }*/
        return Excel::download(new StaffExport($staffIds), 'staff.xlsx');
    }

    public function checkBoxSession(Request $request)
    {
        $this->staffService->checkBoxSession($request);

        /* try {
             $nowIds = session('staff_checkbox_ids', []);

             $newIds = $request->selectedIds;

             $allIds = array_unique(array_merge($nowIds, $newIds));

             session(['staff_checkbox_ids' => $allIds]);

         } catch (\Throwable $th) {
             return response()->json(['error' => $th->getMessage()], 500);
         }*/

        return response(null, 200);
    }
}
