<?php


namespace App\Services;


use App\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\Upload;

class PrivacyService
{
    public function getPrivacy(Request $request)
    {
        if ($request->ajax()) {
            if ($request->get('type') == 'list') {
                $language = $request->get('language');

                if ($language == '') {
                    $language = 'en';
                }

                $privacy = DB::table('tbl_privacy_file')
                    ->where('language_name', '=', $language)
                    ->first();

                if ($privacy != null) {
                    $privacy_details = DB::table('tbl_privacy_details')
                        ->where('privacy_id', '=', $privacy->privacy_id)
                        ->get();
                }
                return response()->json([
                    'privacy' => $privacy,
                    'privacy_details' => $privacy_details
                ]);
            }

            $privacy = $privacy = DB::table('tbl_privacy_file')->get();

            foreach ($privacy as $key) {
                $key->items = DB::table('tbl_privacy_details')
                    ->where('privacy_id', '=', $key->privacy_id)
                    ->get();
            }

            return response()->json([
                $privacy,
            ]);
        }


        $user = DB::table('users')->where('id' , AuthManager::getAuthId())->first();

        $language = 'en';

        if ($user != null && $user->language != null) {
           $language = $user->language;
        }

        if ($request->get('page') == 'view') {
            return view('privacy.show', compact('language'));
        }
        if (AuthManager::isAdmin() == false) {
            return view('privacy.show', compact('language'));
        }
        return view('privacy.index', compact('language'));
    }

    use Upload;

    public function createPrivacy(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'language_name' => 'required',
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

        $privacy_id = $request->get('privacy_id');

        if ($privacy_id == 0) {
            DB::table('tbl_privacy_file')
                ->insert([
                    'language_name' => $request->get('language_name'),
                    'is_show' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
        }

        if ($privacy_id > 0) {
            DB::table('tbl_privacy_file')
                ->where('privacy_id', '=',  $privacy_id)
                ->update([
                    'language_name' => $request->get('language_name'),
                    'is_show' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
        }

        return response()->json([
            'message' => 'created successfully'
        ]);
    }

    public function updatePrivacy(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'id' => 'required',
            'image_path' => 'required',
            'privacy_id' => 'required',
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

        $id = $request->get('id');
        $image_path = $this->UploadFilePDF($request, 'privacy');
        $is_show = $request->get('is_show');
        $privacy_id = $request->get('privacy_id');

        if ($id == 0) {
            DB::table('tbl_privacy_details')
                ->insert([
                    'id' => 0,
                    'image_path' => $image_path,
                    'is_show' => $is_show,
                    'privacy_id' => $privacy_id,
                ]);
        }

        if ($id > 0) {
            DB::table('tbl_privacy_details')
                ->where('id', '=',  $id)
                ->update([
                    'image_path' => $image_path,
                    'is_show' => $is_show,
                    'privacy_id' => $privacy_id,
                ]);
        }

        return response()->json([
            'message' => 'created successfully'
        ]);
    }
}
