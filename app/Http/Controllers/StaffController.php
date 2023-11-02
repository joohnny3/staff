<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $test = $request->query();
        if (isset($test['page'])) {
            $test['pages'] = $test['page'];
            $request->query->replace($test);
        }
        // dd($test);

        $perPage = $request->replace($test)->get('perPage', 30);

        try {

            $validatedData = $request->validate([
                'perPage' => 'integer|min:1|max:100',
            ]);

            $perPage = $validatedData['perPage'] ?? $perPage;
        } catch (ValidationException $t) {
            abort(404);
        }

        $data = Staff::orderBy('id', 'DESC')->paginate($perPage);

        return view('index', ['data' => $data, 'perPage' => $perPage]);
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
        dd($data);
        $boards = Board::whereNotNull('board_id')->where('staff_id', $data->id)->get();

        if (!$data) {
            abort(404);
        }

        return view('board', [
            'staff' => $data,
            'message' => $boards
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
}
