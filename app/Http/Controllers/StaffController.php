<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $request->validate([
                'perPage' => 'integer',
            ]);
        } catch (ValidationException $t) {
            abort(404);
        }

        $search = Staff::query();

        $name = $request->input('name');

        $phone = $request->input('phone');

        $address = $request->input('address');

        $message = $request->input('message');

        if ($name) {
            $search = $search->where('name', 'LIKE', "%{$name}%");
        }

        if ($phone) {
            $search = $search->where('phone', 'LIKE', "%{$phone}%");
        }

        if ($address) {
            $search = $search->where('address', 'LIKE', "%{$address}%");
        }

        if ($message) {
            $search = $search->whereHas('boards', function (Builder $query) use ($message) {
                $query->where('content', 'LIKE', "%{$message}%");
            });
        }

        $perPage = $request->get('perPage', 30);

        $data = $search->orderBy('id', 'DESC')->paginate($perPage, ['*'], 'pages');


        return view('index', ['data' => $data, 'perPage' => $perPage, 'name' => $name, 'phone' => $phone, 'address' => $address, 'message' => $message]);
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

        $reply = $data->boards->reduce(
            function ($carry, $board) {

                if ($board->board_id) {
                    $carry[$board->board_id][] = $board->content;
                }
                return $carry;
            },
            []
        );

        $data->boards->each(function ($board) use ($reply) {
            if (array_key_exists($board->id, $reply)) {
                $board->reply_contents = $reply[$board->id];
            }
        });

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
}
