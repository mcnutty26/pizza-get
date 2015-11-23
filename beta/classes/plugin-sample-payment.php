<?
require payment_type.php

//Sample payment plugin

class plugin-smaple-payment extends payment_type{

    /* This function gets called after the user has chosen their order but before they pay.
    *  If the payment type needs to emit any javascript, it should do that here.
    */ It should also calculate the price and return that.
    function prepayment($price-pizza, $price-sides, $description, $config){
        return ($price + 10);
    }

    /* This function gets called if the user has picked this payment type on the form post back.
    *  The actual charge should be made here, with the token if required.
    /* If the payment fails for any reason, this function should return false, otherwise true.
    function postpayment($price-pizza, $price-sides, description, $config, $token){
        return FALSE;
    }
}
?>
