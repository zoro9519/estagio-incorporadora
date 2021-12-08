<?php 
    function numberToMoney($number, $currency = false){
        $ret = "";
        if(is_numeric($number)){
            if($currency == false){
                $currency = env("APP_CURRENCY", "R$") . " ";
            }
            $ret = $currency . number_format($number, 2, ',', '.');
        }
        return $ret;
    }

?>