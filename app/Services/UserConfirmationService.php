<?php

namespace App\Services;

use App\Auth\AuthManager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

/**
 * Class UserConfirmationService
 * @package App\Services
 */
class UserConfirmationService
{
    public function countUsers(Request $request)
    {
        $count  = User::where('id', '>', 0);
        if ($request->get('status') != "") {
            $count->where('status', 'like', 'review');
        }
        return $count->count();
    }

    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $data =  DB::table('users as u2')
                ->select(
                    'u2.*',
                    DB::raw("(select name from users where id = u2.uderconfirmid)  as user_confirm"),
                    DB::raw("(select image from users where id = u2.uderconfirmid)  as image_confirm"),
                )
                ->where('u2.id', '>', '0');

            if ($request->get('status') != '') {
                $data->where('u2.status', 'like', $request->get('status'));
            }

            $reference_code = $request->get('reference_code');
            $userid = $request->get('userid');
            $id = $request->get('id');

            if ($userid != '' && $reference_code != '') {
                $data->where('u2.id', $userid);
            }

            if ($userid == '' && $reference_code != '') {
                $data->where('u2.referrercode', $reference_code);
            }

            if ($id != '') {
                $data->where('u2.id', $id);
            }

            $data
                ->orderBy('u2.status', 'desc')
                ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = 0;
                    return $id;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return response()->json([]);
    }

    public function confrimStatus(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['message' => $validatedData->messages(), 'status' => false], 422);
        }

        if (AuthManager::isAdmin() == false) {
            return response()->json(['message' => 'Please contact to admin ...', 'status' => false], 422);
        }

        $id = $request->get('id');

        User::where('id', $id)
            ->update([
                'uderconfirmid' => AuthManager::getAuthId(),
                'status' => $request->get('status'),
                'confirmtime' => AuthManager::get_time(),
                'confirmdate' => AuthManager::get_date(),
            ]);

        return response()->json([
            'message' => 'updated successfully'
        ], 201);
    }
}
