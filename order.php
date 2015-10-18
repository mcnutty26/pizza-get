<?
require_once 'database.php';
require_once 'dist/php/stripe-php-3.4.0/init.php';
$config = include('config.php');
$isLive = database::getLive();
if ($isLive == 1) {
  $deployment_name = "_live";
} else {
  $deployment_name = "_test";
}

if (!(isset($_POST['name']) or isset($_POST['token']))) {
  header( 'Location: index.php' ) ;
}

if (isset($_POST['name'])) {
  $name = substr($_POST['name'], 0, 50);
  $pizza = $_POST['pizza'];
  $pizza_name = database::getPizza($pizza);
  $size = $_POST['size'];
  $menu = database::getMenu();
  $error = false;
  
  if ($pizza_name == false) {
    $error = true;
  }

  if ($size == "1") {
    $size_name = "Large";
    foreach ($menu as $row) {
      if ($row['id'] == $pizza) {
        $price = $row['large'];
      }
    }
  } else if ($size == "2") {
    $size_name = "Medium";
    foreach ($menu as $row) {
      if ($row['id'] == $pizza) {
        $price = $row['medium'];
      }
    }
  } else if ($size == "3") {
    $size_name = "Small";
    foreach ($menu as $row) {
      if ($row['id'] == $pizza) {
      $price = $row['small'];
      }
    }
  } else {
    $error = true;
  }
  
  $crust = $_POST['crust'];
  if ($crust == "d" or $crust == "e" or $crust == "f") {
    $price += 250;
  }

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
  } else {
    $error = true;
  }
  
  $discount = database::getDiscount();
  $price = $price/$discount;
  $price_stripe = number_format((float)($price * 1.019) + 20, 0, '.', '');
  $comments = $_POST['comments'];
  if ($comments != "") {
    $comments = "(" . $comments . ")";
  }
  
  $order = "A $size_name $pizza_name with a $crust_name $comments";
  $guid = uniqid();
  
  if ($error == false) {
    database::setGuid($guid, $name, $order, $price, $price_stripe);
  }
    
} else {
  $token = $_POST['token'];
  $guid = database::getGuid($_POST['guid']);
  database::deleteGuid($_POST['guid']);
  $name = $guid['name'];
  $order = $guid['order'];
  if (empty($guid)) {
    $token = "duplicate";
  }
    
  if ($token != "cash" and $token != "duplicate") {
    $price = $guid['price_stripe'];
    $email = $_POST['email'];
    $declined = false;
    
    \Stripe\Stripe::setApiKey($config["api_private$deployment_name"]);
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
  } else if ($token == "cash") {
    $price = $guid['price'];
    database::setOrder($name, $order, $price, 0);
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
      
      <script src="https://checkout.stripe.com/checkout.js"></script>
      <script>
      function init() {
        var handler = StripeCheckout.configure({
          key: '<?=$config["api_public$deployment_name"]?>',
          image: 'img/logo.png',
          locale: 'auto',
          token: function(token) {
            
            var form = $('<form></form>');
            form.attr("method", "post");
            form.attr("action", "order.php");
            
            var fEmail = $('<input></input>');
            fEmail.attr("type", "hidden");
            fEmail.attr("name", "email");
            fEmail.attr("value", token.email);
            form.append(fEmail);

            var fTok = $('<input></input>');
            fTok.attr("type", "hidden");
            fTok.attr("name", "token");
            fTok.attr("value", token.id);
            form.append(fTok);
            
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
          <p>Your payment was declined. You may have submitted the form twice - check to see if you have a confirmation email. Alternatively <a href="index.php">try again</a> or use cash.</p>
          <? } else if ($token != "duplicate"){ ?>
          <p>All done! When you're ready, go and pay for your pizza.</p>
          <? } else {?>
          <p>Looks like there was a problem with your order! You may have submitted the form twice. If not, please <a href="index.php">try again</a>.</p>
          <? } ?>
      </div>
      <script>
        function init() {}
      </script>
      <? } ?>
      </div>
    </div> <!-- /container -->

    <script src="dist/js/vendor/jquery.min.js"></script>
    <script src="dist/js/vendor/video.js"></script>
    <script src="dist/js/flat-ui.min.js"></script>
    <script src="docs/assets/js/application.js"></script>
    <script src="js/jquery-1.11.3.min.js"></script>
    <script>
      videojs.options.flash.swf = "dist/js/vendors/video-js.swf"
    </script>
    
  </body>
</html>
