<?php


namespace App\Helpers;


use Illuminate\Support\Str;

class Helper
{
    public static function  changeRequestSnakeCase($input){
        $grouped = collect($input)->flatMap(function ($item, $key) {
            return [Str::snake($key) => $item];
        });
       return $snaked_request = $grouped->toArray();
    }


}
