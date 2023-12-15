<?php
require_once "./vendor/autoload.php";


use Firebase\JWT\JWT;

class Auth
{


    private static $secret_key = 'Sdw1s9x8@';
    private static $encrypt = ['HS256'];

    // Crea el elemento en base a la data que obtine
    public static function SignIn($data)
    {
        $time = time();

        $token = array(
            // 'exp' => $time + (60*360),
            'exp' => $time + (60),
            'aud' => self::Aud(),
            'data' => $data
        );

        return JWT::encode($token, self::$secret_key);
    }

        //Validacion del token
    public static function Check()
    {
        $headers = apache_request_headers();
        $token = str_replace("Bearer ", '', $headers['Authorization']);

        if(empty($token))
        {
            throw new Exception("Invalid token supplied.");
        }

        $decode = JWT::decode(
            $token,
            self::$secret_key,
            self::$encrypt
        );

        if($decode->aud !== self::Aud())
        {
            throw new Exception("Invalid user logged in.");
        }
    }

    public static function GetData($token)
    {
        //Obtine lo que viene en el token y lo decodifica pasandolo a la propiedad data
        return JWT::decode(
            $token,
            self::$secret_key,
            self::$encrypt
        )->data;
    }

    private static function Aud()
    {
        $aud = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }

        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();

        return sha1($aud);
    }
}

?>