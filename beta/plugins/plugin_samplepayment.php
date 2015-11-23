<?
require payment_type.php

class plugin_sample_payment extends payment_type{

    function prepayment($price, $name, $description, $config){
        return ($price + 10);
    }

    function postpayment($config, $token);{
        return true;
    }
}
?>
