<?php

namespace app;

class Security
{
    const POST_TYPE = 'post_type';
    const GET_TYPE = 'get_type';

    public static function secure($data) {
        
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    public static function isNumber($char) : bool {
        $char = self::secure($char);
        
        $regex = '/^[0-9]+$/';
        if(preg_match($regex, $char)){
            return true;
        }
        return false;
    }

    public static function isVerified(array $data, string $data_method) {
        $isVerified = true;
        if($data_method === self::GET_TYPE) {
            $isVerified = self::verifyGET($data);
        }
        if($data_method === self::POST_TYPE) {
            $isVerified = self::verifyPOST($data);
        }
        return $isVerified;
    }

    private static function verifyPOST(array $data) {
        $verified = true;
        foreach($data as $key) {
            if(!isset($_POST[$key])) {
                $verified = false;
            }
        }
        return $verified;
    }

    private static function verifyGET(array $data) {
        $verified = true;
        foreach($data as $key) {
            if(!isset($_GET[$key])) {
                $verified = false;
            }
        }
        return $verified;
    }
}