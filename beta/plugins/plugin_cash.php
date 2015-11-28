<?
require_once 'payment_type.php';

class plugin_cash extends payment_type{
  function __construct(){
    parent::init("Cash", "cash", "All done! When you're ready, go and pay for your pizza.", "");
  }

  function prepayment($price, $name, $order, $config){
      $guid = database::setGuid($name, $order, $price, $this->name);
      return $price;
  }

  function postpayment($config, $token){
    $guid = database::getGuid($_POST['guid']);
    $name = $guid['name'];
    $order = $guid['order'];
    $price = $guid['price'];
    
    if ($guid['method'] != $this->name) {
      return false;
    }
    
    database::setOrder($name, $order, $price, 1);
    if ($config['live'] == 1) {
      database::setLog($name, $order, $price, 1);
    }
    
    return true;
  }
}
?>
