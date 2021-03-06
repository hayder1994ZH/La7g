<?php
namespace App\Core\Helpers;

use Illuminate\Support\Facades\Hash;

class Utilities {

    public static function wrap($data)
    {
        return response()->json($data, 200);
    }

    public static function wrapStatus($data, int $httpCode)
    {
        return response()->json($data, $httpCode);
    }

    public static function upload($file, $filePath)
    {
        return (string)$file->store($filePath);
    }

    public static function hash($string)
    {
        return Hash::make($string);
    }

}
