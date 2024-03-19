<?php


namespace App\Auth;


use Illuminate\Support\Facades\DB;

/**
 * Class AuthManager
 * @package App\Auth
 */
class AuthManager
{
    /**
     * @return int|string|null
     */
    public static function getAuthId(){
        return auth()->id();
    }

    /**
     * @return bool
     */
    public static function isAdmin(){
        $permissions = DB::table('tblpermission')
            ->where('fkuserid', self::getAuthId())
            ->first();
        if($permissions != '' && $permissions->admin == 1){
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public static function isUser()
    {
        $permissions = DB::table('tblpermission')
            ->where('fkuserid', self::getAuthId())
            ->first();
        if($permissions !== '' && $permissions->normal == 1){
            return true;
        }
        return false;
    }

    /**
     * @return false|string
     */
    public static function get_date_time(){
        return date('Y-m-d H:i:s');
    }


    /**
     * @return false|string
     */
    public static function get_date(){
        return date('Y-m-d');
    }


    /**
     * @return false|string
     */
    public static function get_time(){
        return date('H:i:s');
    }

}
