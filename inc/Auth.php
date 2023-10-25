<?php

namespace Inc;

use App\Enums\StateEnum;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;

class Auth
{

    public static $user = null;
    public static $id_session = 0;

    public static $token = null;

    public static function init($closure = null, $token = '')
    {

        # Buscar token en $_REQUEST[$name] (GET Query Params)
        if (empty($token)) {
            $token = _REQ('token');
        }

        # Buscar token en Headers
        if (empty($token)) {
            $token = self::getBearerToken();
        }

        if(!$token) return null;
        $personalAccessToken = PersonalAccessToken::findToken($token);
        if(!$personalAccessToken) return null;
        $idUser = $personalAccessToken->tokenable_id;
        $user = DB::table('users')
            ->where('state', StateEnum::ENABLED->value)
            ->where('id', $idUser)
            ->first();

        if($user && $user->id){
            self::$user = $user;
            self::$token = $token;
            //self::$id_session = $user->se_id;
            return true;
        }
        //return $user;
    }

    public static function user()
    {
        self::init();
        return self::$user;
    }


    /**
     * get access token from header
     * */
    static function getBearerToken()
    {
        $headers = self::getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (empty($headers)) return '';
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
    }

    /**
     * Get hearder Authorization
     * */
    static function getAuthorizationHeader()
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    public static function logged()
    {
        return self::user() && self::id() > 0;
    }

    public static function id()
    {
        return self::$user->id;
    }

    public static function root()
    {
        return self::logged() && self::user()->root();
    }


}
