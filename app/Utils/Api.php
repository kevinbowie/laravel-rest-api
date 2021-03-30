<?php
namespace App\Utils;

class Api {
    public static function response($data, $meta=null)
    {
        $res = [
            'data' => $data
        ];
        if ($meta) {
            $res['meta'] = $meta;
        }
        return $res;
    }
}