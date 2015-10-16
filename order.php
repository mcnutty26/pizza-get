<?
require_once 'database.php';
require_once 'dist/php/stripe-php-3.4.0/init.php';
$config = include('config.php');

if (!(isset($_POST['name']) or isset($_POST['token']))) {
  header( 'Location: index.php' ) ;
}

if (isset($_POST['name'])) {
  $name = substr(database::escape($_POST['name']), 0, 50);
  $pizza = database::escape($_POST['pizza']);
  $pizza_name = database::getPizza($pizza);
  $size = database::escape($_POST['size']);
  $menu = database::getMenu();
  $size_name = "Nothing";
  $price = 0;

  if ($size == "1") {
    $size_name = "Large";
    while ($row = mysqli_fetch_array($menu)) {
      if ($row['id'] == $pizza) {
        $price = $row['large'];
      }
    }
  } else if ($size == "2") {
    $size_name = "Medium";
    while ($row = mysqli_fetch_array($menu)) {
      if ($row['id'] == $pizza) {
        $price = $row['medium'];
      }
    }
  } else if ($size == "3") {
    $size_name = "Small";
    while ($row = mysqli_fetch_array($menu)) {
      if ($row['id'] == $pizza) {
      $price = $row['small'];
      }
    }
  }
  
  $crust = database::escape($_POST['crust']);
  if ($crust == "d" or $crust == "e" or $crust == "f") {
    $price += 250;
  }
  
  $crust_name = "Nothing";
  if ($crust == "a") {
    $crust_name = "Normal Crust";
  } else if ($crust == "b") {
    $crust_name = "Italian Crust";
  } else if ($crust == "c") {
    $crust_name = "Thin and Crispy Crust";
  } else if ($crust == "d") {
    $crust_name = "Stuffed Crust";
  } else if ($crust == "e") {
    $crust_name = "Hotdog Stuffed Crust";
  } else if ($crust == "f") {
    $crust_name = "BBQ Stuffed Crust";
  }
  
  $discount = database::getDiscount();
  $price = $price/$discount;
  $price_stripe = number_format((float)($price * 1.019) + 20, 0, '.', '');
  $comments = database::escape($_POST['comments']);
  if ($comments != "") {
    $comments = "(" . $comments . ")";
  }
  
  $guid = uniqid();
  database::setGuid($guid, $price, $price_stripe);
    
} else {
  $token = database::escape($_POST['token']);
  $name = database::escape($_POST['user']);
  $order = substr(database::escape($_POST['order']), 0, 200);
  $guid = database::escape($_POST['guid']);
    
  if ($token != "cash") {
    $email = database::escape($_POST['email']);
    $price = database::getGuid($guid, 1);
    if ($price == false) {
      $token = "duplicate";
    }
    
    if ($token != "duplicate") {
      $declined = false;
      
      \Stripe\Stripe::setApiKey($config['api_private']);
      try {
      $charge = \Stripe\Charge::create(array(
        "amount" => $price,
        "currency" => "gbp",
        "source" => $token,
        "description" => "$order")
      );
      database::setOrder($name, $order, $price, 1);
      mail($email, "Pizza Order", "Your order for $order was successful! You have been charged £" . $price/100 . ".");
      } catch(\Stripe\Error\Card $e) {
        $declined = true;
      } catch(\Stripe\Error\InvalidRequest $e) {
        $declined = true;
      }
    }
  } else {
    $price = database::getGuid($guid, 0);
    if ($price == false) {
      $token = "duplicate";
    } else {
      database::setOrder($name, $order, $price, 0);
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>pizza-get</title>
    
    <meta name="description" content="So you can order pizza at gaming!"/>

    <meta name="viewport" content="width=1000, initial-scale=1.0, maximum-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="dist/css/vendor/bootstrap.min.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="dist/css/flat-ui.css" rel="stylesheet">
    <link href="docs/assets/css/demo.css" rel="stylesheet">

    <link rel="shortcut icon" href="img/favicon.ico">
    
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="dist/js/vendor/html5shiv.js"></script>
      <script src="dist/js/vendor/respond.min.js"></script>
    <![endif]-->
  </head>
  <body onload="init()">
    <div class="container">
      <div class="row demo-row">
        <div class="col-xs-12">
          <nav class="navbar navbar-inverse navbar-embossed" role="navigation">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
                <span class="sr-only">Toggle navigation</span>
              </button>
              <a class="navbar-brand" href="index.php">pizza-get</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse-01">
              <ul class="nav navbar-nav navbar-left">
                <li><a href="index.php">Order</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="https://www.dominos.co.uk/store" target="_blank">Dominoes Menu</a></li>
               </ul>
            </div><!-- /.navbar-collapse -->
          </nav><!-- /navbar -->
        </div>
      </div> <!-- /row -->
      <div class="demo-type-example">
	    <h3>Review your order</h3>
      </div>
      
      <div class="login-form">
      
      <? if (isset($_POST['name'])) { ?>
        
        <div class="row">
          <div class="form-group col-xs-6">
            <p>Name: <?=$name?></p>
          </div>
          <div class="form-group col-xs-6">
            <p>Pizza: <?=$pizza_name?></p>
          </div><!-- /btn-group -->
        </div>
        
        <div class="row">
          <div class="form-group col-xs-6">
            <p>Size: <?=$size_name?></p>
          </div>
          <div class="form-group col-xs-6">
            <p>Crust: <?=$crust_name?></p>
          </div>
        
        </div> <!-- /row -->
        
        <div class="form-group">
          <p>Comments: <?=$comments?></p>
        </div>

        <div class="row">
          <div class="form-group col-xs-4">
            <button class="btn btn-primary btn-lg btn-block" id="customButton">Pay by card £<?=number_format((float)$price_stripe/100, 2, '.', '')?></button>
          </div>
          
          <div class="form-group col-xs-4">
            <form method="post" action="order.php">
              <input type="hidden" name="token" value="cash">
              <input type="hidden" name="user" value="<?=$name?>">
              <input type="hidden" name="order" value="<?="A $size_name $pizza_name with a $crust_name $comments"?>">
              <input type="hidden" name="guid" value="<?=$guid?>">
              <input class="btn btn-primary btn-lg btn-block" type="submit" value="Pay by cash £<?=number_format((float)$price/100, 2, '.', '')?>">
            </form>
          </div>
          
          <div class="form-group col-xs-4">
            <a class="btn btn-danger btn-lg btn-block" href="index.php">Cancel</a>
          </div>
      </div>
      <p>Please check your order before continuing. Card payments are slightly higher to cover the fee we have to pay.</p>
      <p>Transactions are handled over https by <a href="https://stripe.com/gb" target="_blank">Stripe</a>, meaning that none of your card details ever touch our servers.</p>
      
      <? } else { ?>
        
        <div class="form-group">
          <p>Name: <?=$name?></p>
        </div>
        
        <div class="form-group">
          <p>Order: <?=$order?></p>
        </div><!-- /btn-group -->
      
        <div class="form-group">
          <p>Price: £<?=number_format((float)$price/100, 2, '.', '')?></p>
        </div>

        <div class="form-group">
          <? if (!$declined and ($token != "cash") and ($token != "duplicate")) { ?>
          <p>Payment completed successfully! A confirmation email has been sent to <?=$email?></p>
          <? } else if (($token != "cash") and ($token != "duplicate")) { ?>
          <p>Your payment was declined. Please <a href="index.php">try again</a> or use cash.</p>
          <? } else if ($token != "duplicate"){ ?>
          <p>All done! When you're ready, go and pay for your pizza.</p>
          <? } else {?>
          <p>Looks like you've submitted a duplicate order. Please <a href="index.php">try again</a>.</p>
          <? } ?>
      </div>
      
      <? } ?>
      </div>
    </div> <!-- /container -->

    <script src="dist/js/vendor/jquery.min.js"></script>
    <script src="dist/js/vendor/video.js"></script>
    <script src="dist/js/flat-ui.min.js"></script>
    <script src="docs/assets/js/application.js"></script>
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>
    <script>
    function init() {
      var handler = StripeCheckout.configure({
        key: '<?=$config['api_public']?>',
        image: 'img/logo.png',
        locale: 'auto',
        token: function(token) {
          
          var form = $('<form></form>');
          form.attr("method", "post");
          form.attr("action", "order.php");

          var fTok = $('<input></input>');
          fTok.attr("type", "hidden");
          fTok.attr("name", "token");
          fTok.attr("value", token.id);
          form.append(fTok);
          
          var fEmail = $('<input></input>');
          fEmail.attr("type", "hidden");
          fEmail.attr("name", "email");
          fEmail.attr("value", token.email);
          form.append(fEmail);
          
          var fName = $('<input></input>');
          fName.attr("type", "hidden");
          fName.attr("name", "user");
          fName.attr("value", "<?=$name?>");
          form.append(fName);
          
          var fOrder = $('<input></input>');
          fOrder.attr("type", "hidden");
          fOrder.attr("name", "order");
          fOrder.attr("value", "<?="A $size_name $pizza_name with a $crust_name $comments"?>");
          form.append(fOrder);
          
          var fPrice = $('<input></input>');
          fPrice.attr("type", "hidden");
          fPrice.attr("name", "guid");
          fPrice.attr("value", "<?=$guid?>");
          form.append(fPrice);

          $(document.body).append(form);
          form.submit();
        }
      });

      $('#customButton').on('click', function(e) {
        // Open Checkout with further options
        handler.open({
          name: 'UWCS Pizza',
          description: '<?="A $size_name $pizza_name"?>',
          zipCode: true,
          currency: "gbp",
          amount: <?=$price_stripe?>,
        });
        e.preventDefault();
      });

      // Close Checkout on page navigation
      $(window).on('popstate', function() {
        handler.close();
      });
    }
    </script>
    <script>
      videojs.options.flash.swf = "dist/js/vendors/video-js.swf"
    </script>
    
  </body>
</html>
