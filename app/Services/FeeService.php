<?php


namespace App\Services;


use App\Auth\AuthManager;
use App\Models\Fee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\Upload;


/**
 * Class FeeService
 * @package App\Services
 */
class FeeService
{
    // page fee
    public function viewPage()
    {
        if (AuthManager::isAdmin() == false) {
            return view('error.error');
        }
        return view('fee.index');
    }
    // get list fee
    public function getFee()
    {
        if (AuthManager::isAdmin() == false) {
            return response()->json([
                'message' => 'Please contact your administrator'
            ]);
        }
        $fee = Fee::where('feeid', '>', '0')->get();
        $company = DB::table('tblcompany')->where('companyid', '>', '0')->get();
        return response()->json([
            'fee' => $fee,
            'company' => $company
        ]);
    }
    use Upload;
    // create fee
    public function createFee(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'tradeffeepercent' => 'required',
            'widtrwfeepercent' => 'required',
            'nameweb' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['message' => $validatedData->messages(), 'status' => false], 422);
        }

        if (AuthManager::isAdmin() == false) {
            return response()->json([
                'message' => 'Please contact your administrator'
            ]);
        }

        $fee = Fee::where('feeid', '>', '0')->first();

        $model = [
            'tradeffeepercent' => $request->get('tradeffeepercent'),
            'widtrwfeepercent' => $request->get('widtrwfeepercent'),
            'timeupdate' => AuthManager::get_time(),
            'dateupdate' => AuthManager::get_date()
        ];

        if ($fee == null) {
            $model['feeid'] = 0;
            Fee::create($model);
            return response()->json(['message' => 'created successfully.']);
        }
        Fee::where(
            'feeid',
            $fee->feeid
        )->update($model);

        //
        $logo = $this->UploadFileLogo($request, 'logo');
        $company = DB::table('tblcompany')->first();

        $model = [
            'nameweb' => $request->get('nameweb'),
        ];

        if ($company == null) {
            DB::table('tblcompany')
                ->insert($model);
        }
        if ($company != null) {
            if ($logo != null) {
                $model['logo'] = $logo;
            }

            DB::table('tblcompany')
                ->where('companyid', '=', $company->companyid)
                ->update($model);
        }

        return response()->json(['message' => 'updated successfully.']);
    }
}
