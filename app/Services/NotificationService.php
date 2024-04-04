<?php


namespace App\Services;


use App\Auth\AuthManager;
use App\Models\Deposit;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class NotificationService
 * @package App\Services
 */
class NotificationService
{
    // get list
    public function getNotifications(Request $request)
    {
        if (AuthManager::isAdmin() == false) {
            return response()->json([
                array()
            ]);
        }

        $limit = 200;

        $users = User::where('status', 'like', 'review')
            ->select(
                'id',
                'name',
                'image',
                'status',
                'timeupdate as time',
                'dateupdate as date',
                DB::raw('(select "Register") as type')
            )
            ->take($limit)
            ->orderByDesc('id')
            ->get();

        $withdraw = Withdrawal::where('tblwidtraw.status', 'like', 'pending')
            ->join('users', 'tblwidtraw.fkuserid', '=', 'users.id')
            ->select(
                'tblwidtraw.withdrawid  as id',
                'users.name',
                'users.image',
                'tblwidtraw.status',
                'tblwidtraw.createtime as time',
                'tblwidtraw.createdate  as date',
                DB::raw('(select "Withdraw") as type')
            )
            ->take($limit)
            ->orderByDesc('id')
            ->get();

        $deposit = Deposit::where('tbldeposit.status', 'like', 'pending')
            ->join('users', 'tbldeposit.fkuserid', '=', 'users.id')
            ->select(
                'tbldeposit.depositid  as id',
                'users.name',
                'users.image',
                'tbldeposit.status',
                'tbldeposit.timeupdate as time',
                'tbldeposit.dateupdate  as date',
                DB::raw('(select "Deposit") as type')
            )
            ->take($limit)
            ->orderByDesc('id')
            ->get();

        $data = array(...$users, ...$withdraw, ...$deposit);

        return response()->json([
            $data,
        ]);
    }
}
