<?php

namespace App\Helpers;

class FormatHelper {


    public static function numberToMoney($number, $currency = false){
        $ret = 0;
        if(is_numeric($number)){
            if($currency == false){
                $currency = env("APP_CURRENCY", "R$");
            }
        }
    }

}