<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class BoardController extends Controller
{
    public function addMessage(Request $request, Staff $staff)
    {
        if (isset($request->board_id)) {
            try {
                DB::beginTransaction();

                $validateDate = $request->validate([
                    'content' => 'required|max:255',
                ]);

                $data = [
                    'content' => $validateDate['content'],
                    'staff_id' => $staff->id,
                    'board_id' => $request->board_id
                ];

                Board::create($data);

                DB::commit();
            } catch (Throwable $t) {

                DB::rollBack();

                abort(404);
            }
        } else {
            try {
                DB::beginTransaction();

                $validateDate = $request->validate([
                    'content' => 'required|max:255',
                ]);

                $data = [
                    'content' => $validateDate['content'],
                    'staff_id' => $staff->id
                ];

                Board::create($data);

                DB::commit();
            } catch (Throwable $t) {
                DB::rollBack();

                abort(404);
            }
        }


        return redirect()->route('staff.show', ['staff' => $staff]);
    }
}
