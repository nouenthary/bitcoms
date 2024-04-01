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
        // fee
        $fee = Fee::where('feeid', '>', '0')->get();
        // company
        $company = DB::table('tblcompany')->get();
        // contact us
        $contactUs = DB::table('tblcontactus')->get();
        // privacy
        $privacy = DB::table('tblprivcy')->get();
        return response()->json([
            'fee' => $fee,
            'company' => $company,
            'contact_us' => $contactUs,
            'privacy' => $privacy
        ]);
    }
    use Upload;
    // create fee
    public function createFee(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            // fee
            'tradeffeepercent' => 'required',
            'widtrwfeepercent' => 'required',
            // company
            'nameweb' => 'required',
            // contact us
            // 'phone' => 'required',
            // 'address' => 'required',
            // 'city' => 'required',
            // 'coutry' => 'required',
            // 'Description' => 'required',
            // 'email' => 'required',
            // privacy 
            // 'desceng' => 'required',
            // 'descesp' => 'required',
            // 'descfre' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json(
                [
                    'message' => $validatedData->messages(),
                    'status' => false
                ],
                422
            );
        }

        if (AuthManager::isAdmin() == false) {
            return response()->json([
                'message' => 'Please contact your administrator'
            ]);
        }

        // Create or update Fee
        $fee = Fee::where('feeid', '>', '0')->first();
        $model = [
            'tradeffeepercent' => $request->get('tradeffeepercent') ?? 0,
            'widtrwfeepercent' => $request->get('widtrwfeepercent') ?? 0,
            'timeupdate' => AuthManager::get_time(),
            'dateupdate' => AuthManager::get_date(),
            'deposit_fee_percent' => $request->get('deposit_fee_percent') ?? 0,
            'profit_fee_percentage' => $request->get('profit_fee_percentage') ?? 0,
        ];
        if ($fee == null) {
            $model['feeid'] = 0;
            Fee::create($model);
        } else if ($fee != null) {
            Fee::where(
                'feeid',
                $fee->feeid
            )->update($model);
        }
        // Create or update Fee

        // create or update company
        $logo = $this->UploadFileLogo($request, 'logo');
        $company = DB::table('tblcompany')->first();
        $model = [
            'nameweb' => $request->get('nameweb'),
        ];
        if ($company == null) {
            DB::table('tblcompany')
                ->insert($model);
        } else if ($company != null) {
            if ($logo != null) {
                $model['logo'] = $logo;
            }
            DB::table('tblcompany')
                ->where('companyid', '=', $company->companyid)
                ->update($model);
        }
        // create or update company

        // create or update contact us
        $contactUs = [
            'contactusid' => 1,
            'phone' => $request->get('phone'),
            'address' => $request->get('address'),
            'city' => $request->get('city'),
            'coutry' => $request->get('coutry'),
            'Description' => $request->get('Description'),
            'email' => $request->get('email'),
        ];
        $contactUsFirst = DB::table('tblcontactus')
            ->where('contactusid', '>', 0)
            ->first();
        if ($contactUsFirst == null) {
            DB::table('tblcontactus')
                ->insert($contactUs);
        } else if ($contactUsFirst != null) {
            DB::table('tblcontactus')
                ->where('contactusid', '=', $contactUsFirst->contactusid)
                ->update($contactUs);
        }
        // create or update contact us

        // create or update privacy 
        // $en = $this->UploadFilePDF($request, 'privacy');
        // $privacy = [
        //     'privcyid' => 1,
        //     'desceng' => $en,
        //     'descesp' => 'sp',
        //     'descfre' => 'fre',
        // ];
        // $privacyFirst = DB::table('tblprivcy')
        //     ->where('privcyid', '>', 0)
        //     ->first();
        // if ($privacyFirst == null) {
        //     DB::table('tblprivcy')
        //         ->insert($privacy);
        // } else if ($privacyFirst != null) {
        //     DB::table('tblprivcy')
        //         ->where('privcyid', '=', $privacyFirst->privcyid)
        //         ->update($privacy);
        // }
        // create or update privacy
        return response()->json(['message' => 'updated successfully.']);
    }
}
