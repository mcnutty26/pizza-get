<?
abstract class payment_type {

    public $name;
    public $token_type;
    public $payment_accept;
    public $payment_reject;
    public $calculated_price;

    abstract function __construct();

    final function init($name, $token_type, $payment_accept, $payment_reject){
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

    final function get_payment_reject(){
        return $this->payment_reject;
    }

    abstract function prepayment($price, $name, $order, $config);
    abstract function postpayment($config, $token);
    abstract function button();
}
?>
