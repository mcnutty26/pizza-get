<?
abstract class payment {

    private $name;
    private $token_type;
    private $payment_accept;
    private $payment_reject;

    final function __construct($name, $token_type, $payment_accept, $payment_reject) {
        $this->name = $name;
        $this->token_type = $token_type;
        $this->payment_accept = $payment_accept;
        $this->payment_reject = $payment_reject;
    }

    final function get_name(){
        return $this->name;
    }

    final function get_token_type(){
        return $this->token_type;
    }

    final function get_payment_accept(){
        return $this->payment_accept;
    }

    final funtion get_payment_reject(){
        return $this->payment_reject;
    }

    abstract function prepayment($price-pizza, $price-sides, $description, $config);
    abstract function postpayment($price-pizza, $price-sides, $description, $config, $token);
}
?>
