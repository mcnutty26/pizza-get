<?
require_once 'payment_type.php';
require 'dist/php/stripe-php-3.4.0/init.php';

class plugin_stripe extends payment_type{

    function __construct(){
      parent::init("Card", "", "", "Your payment was declined (you have not been charged). You may have submitted the form twice - check to see if you have a confirmation email. Alternatively try again or use cash.");
    }
    
    function deployment_name($config){
      if ($config['live'] == 1) {
        return "_live";
      } else {
        return "_test";
      }
    }

    function prepayment($price, $name, $order, $config){
        $key = $config['api_public' . $this->deployment_name($config)];
        $guid = database::setGuid($name, $order, $price, $this->name);
        $payment_name = $this->name;
        
        echo "<script>
        function init() {
          var handler = StripeCheckout.configure({
            key: '$key',
            image: 'img/logo.png',
            locale: 'auto',
            token: function(token) {
              
              var form = $('<form></form>');
              form.attr('method', 'post');
              form.attr('action', 'order.php');
              
              var fEmail = $('<input></input>');
              fEmail.attr('type', 'hidden');
              fEmail.attr('name', 'email');
              fEmail.attr('value', token.email);
              form.append(fEmail);

              var fTok = $('<input></input>');
              fTok.attr('type', 'hidden');
              fTok.attr('name', 'token');
              fTok.attr('value', token.id);
              form.append(fTok);
              
              var fMet = $('<input></input>');
              fMet.attr('type', 'hidden');
              fMet.attr('name', 'method');
              fMet.attr('value', '$payment_name');
              form.append(fMet);
              
              var fPrice = $('<input></input>');
              fPrice.attr('type', 'hidden');
              fPrice.attr('name', 'guid');
              fPrice.attr('value', '$guid');
              form.append(fPrice);

              $(document.body).append(form);
              form.submit();
            }
          });

          $('#customButton').on('click', function(e) {
            // Open Checkout with further options
            handler.open({
              name: 'UWCS Pizza',
              description: '$description',
              zipCode: true,
              currency: 'gbp',
              amount: $price,
            });
            e.preventDefault();
          });

          // Close Checkout on page navigation
          $(window).on('popstate', function() {
            handler.close();
          });
        }
        </script>";
        echo "<script src=\"https://checkout.stripe.com/checkout.js\"></script>";
        
        return number_format((float)($price * 1.019) + 20, 0, '.', '');
    }

    function postpayment($config, $token){
      $guid = database::getGuid($_POST['guid']);
      $name = $guid['name'];
      $order = $guid['order'];
      $price = $guid['price'];
      
      if ($guid['method'] != $this->name) {
        return false;
      }
      
      \Stripe\Stripe::setApiKey($config['api_private' . $this->deployment_name($config)]);
      try {
        \Stripe\Charge::create(array(
          "amount" => $price,
          "currency" => "gbp",
          "source" => $token,
          "description" => "$order")
        );
        database::setOrder($name, $order, $price, 1);
        if ($config['live'] == 1) {
          database::setLog($name, $order, $price, 1);
        }
        mail($email, "Pizza Order", "Your order for $order was successful! You have been charged £" . $price/100 . ".");
      } catch(\Stripe\Error\Card $e) {
        return false;
      } catch(\Stripe\Error\InvalidRequest $e) {
        return false;
      }
      return true;
    }
}
?>
