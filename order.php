<?
require_once 'database.php';
require_once 'dist/php/stripe-php-3.4.0/init.php';
$config = include('config.php');
$isLive = database::getLive();
$active = database::getActive();

//echo $isLive;

//Determine which API key to use (live/test)
if ($isLive == 1) {
  $deployment_name = "_live";
} else {
  $deployment_name = "_test";
}

//Redirect the user if they navigated here accidentally or orders are closed
if (!(isset($_POST['name']) or isset($_POST['token'])) or $active == false) {
  header( 'Location: index.php' ) ;
}

if (isset($_POST['name'])) {
  
  $menu = database::getMenu();
  $toppings = database::getToppings();
  $discount = database::getDiscount();
  $discount_sides = database::getDiscountSides();
  $error = false;
  
  //Process half and half
  if ($_POST['pizza'] == "H") {
    $pizzaA = database::getPizza($_POST['pizzaA']);
    $pizzaB = database::getPizza($_POST['pizzaB']);
    
    //Price is simply the full price of the most expensive of the two halves
    if ($pizzaA['large'] > $pizzaB['large']) {
      $pizza = $_POST['pizzaA'];
    } else {
      $pizza = $_POST['pizzaB'];
    }
    
    //Set the pizza name to something appropriate
    $pizza_name = database::getPizzaName($_POST['pizzaA']) . '/' . database::getPizzaName($_POST['pizzaB']);
    
    if ($size > 3) {
      $error == true;
    }
  } else if ($_POST['pizza']!= "B") {
    
    //For normal pizzas we can just look up the name
    $pizza = $_POST['pizza'];
    $pizza_name = database::getPizzaName($pizza);
  } else {
    $pizza_name = "Build Your Own";
  }
  
  //Truncate the name ready for database storage
  $name = substr($_POST['name'], 0, 50);
  $size = $_POST['size'];
  
  //If the user specified an invalid pizza, don't open a session for them
  if ($pizza_name == false) {
    $error = true;
  }

  //Set the price based on the pizza size
  if ($size == "1") {
    $size_name = "Large";
    $topping_price = 130;
    foreach ($menu as $row) {
      if ($row['id'] == $pizza) {
        $price = $row['large'];
      } else if ($row['id'] == $config['basic_pizza'] and $_POST['pizza'] == "B") {
        $price = $row['large'];
      } 
    }
  } else if ($size == "2") {
    $size_name = "Medium";
    $topping_price = 120;
    foreach ($menu as $row) {
      if ($row['id'] == $pizza) {
        $price = $row['medium'];
      } else if ($row['id'] == $config['basic_pizza'] and $_POST['pizza'] == "B") {
        $price = $row['medium'];
      } 
    }
  } else if ($size == "3") {
    $size_name = "Small";
    $topping_price = 100;
    foreach ($menu as $row) {
      if ($row['id'] == $pizza) {
      $price = $row['small'];
      } else if ($row['id'] == $config['basic_pizza'] and $_POST['pizza'] == "B") {
        $price = $row['small'];
      }
    }
  } else if ($size == "4") {
    $size_name = "Personal";
    $topping_price = 80;
    foreach ($menu as $row) {
      if ($row['id'] == $pizza) {
      $price = $row['personal'];
      } else if ($row['id'] == $config['basic_pizza'] and $_POST['pizza'] == "B") {
        $price = $row['personal'];
      } 
    }
  } else {
    $error = true;
  }
  
  //Process build your own
  if ($_POST['pizza'] == "B") {
    
    //Toppings are charged after the first two (normally sauce and cheese)
    $topping_count = 0;
    
    //We need to check for different sauce/cheese configurations so we can alert the person doing the order
    if ($_POST['sauce'] == "on") {
      if ($topping_count == 0) {
        $pizza_name = $pizza_name . " - " . "Tomato Sauce";
      } else {
        $pizza_name = $pizza_name . ', ' . "Tomato Sauce";
      }
      if ($topping_count > 1) {
          $price += $topping_price;
        }
        $topping_count++;
    } else if ($_POST['bsauce'] == "on") {
      if ($topping_count == 0) {
        $pizza_name = $pizza_name . " - " . "BBQ Sauce";
      } else {
        $pizza_name = $pizza_name . ', ' . "BBQ Sauce";
      }
      if ($topping_count > 1) {
          $price += $topping_price;
        }
        $topping_count++;
    } else {
      if ($topping_count == 0) {
        $pizza_name = $pizza_name . " - " . "No Sauce";
      } else {
        $pizza_name = $pizza_name . ', ' . "No Sauce";
      }
    }
    if ($_POST['cheese'] != "on") {
        $pizza_name = $pizza_name . ', ' . "No Cheese";
    } else {
      $pizza_name = $pizza_name . ', ' . "Mozarella Cheese";
      if ($topping_count > 1) {
        $price += $topping_price;
      }
      $topping_count++;
    }
      
    //Process toppings
    foreach ($toppings as $row) {
      if (isset($_POST['topping' . $row['id']])) {
        $pizza_name = $pizza_name . ', ' . $row['name'];
        if ($topping_count > 1) {
          $price += $topping_price;
        }
        $topping_count++;
      }
    }
  }
  
  //Charge for the crust if appropriate
  $crust = $_POST['crust'];
  if (($crust == "d" or $crust == "e" or $crust == "f" or $crust == "g") and $_POST['pizza'] != $config['empty_pizza'] and $size < 3) {
    $price += 250;
  }

  //Determine the name of the chosen crust
  if ($crust == "a") {
    $crust_name = "Normal Crust";
  } else if ($crust == "b" and $size < 4) {
    $crust_name = "Italian Crust";
  } else if ($crust == "c" and $size < 3) {
    $crust_name = "Thin and Crispy Crust";
  } else if ($crust == "d" and $size < 3) {
    $crust_name = "Stuffed Crust";
  } else if ($crust == "e" and $size < 3) {
    $crust_name = "Hotdog Stuffed Crust";
  } else if ($crust == "f" and $size < 3) {
    $crust_name = "BBQ Stuffed Crust";
  } else if ($crust == "g" and $size < 3) {
    $crust_name = "Hotdog Stuffed Crust with Mustard";
  } else {
    $error = true;
  }
  
  //Charge for sides and add the names to a string
  $result = database::getSides();
  foreach ($result as $row) {
    if (isset($_POST['side' . $row['id']])) {
      if ($sides == "") {
        $sides = " with " . $row['name'];
      } else {
        $sides = $sides . ', ' . $row['name'];
      }
      $price_sides += $row['price']/($discount_sides == 1 ? $discount : 1);
    }
  }
  
  //Final price calculations and discount application
  //Note that discount is applied seperately to side orders
  $price = ($price/$discount) + $price_sides;
  $price_stripe = number_format((float)($price * 1.019) + 20, 0, '.', '');
  $comments = $_POST['comments'];
  if ($comments != "") {
    $comments = " (" . $comments . ")";
  }
  
  //Compile the order into a string and generate a guid to represent the session
  if ($_POST['pizza'] == $config['empty_pizza']) {
    $order = "$pizza_name$sides$comments";
    $crust_name = "N/A";
    $size_name = "N/A";
  } else {
    $order = "A $size_name $crust_name $pizza_name$sides$comments";
  }
  $guid = uniqid();
  
  //Open a session if the supplied data was valid
  //This preserves the details in a way that doesn't expose them to the user
  if ($error == false) {
    database::setGuid($guid, $name, $order, $price, $price_stripe);
  }
    
} else {
  //Determine which payment method the user chose and retreive the order from the database
  $token = $_POST['token'];
  $guid = database::getGuid($_POST['guid']);
  
  //Make sure we consume the session to prevent duplicate orders
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
    
    //Charge the card
    \Stripe\Stripe::setApiKey($config["api_private$deployment_name"]);
    try {
    $charge = \Stripe\Charge::create(array(
      "amount" => $price,
      "currency" => "gbp",
      "source" => $token,
      "description" => "$order")
    );
    
    //Store the order in the database as paid
    database::setOrder($name, $order, $price, 1);
    if ($isLive == 1) {
      database::setLog($name, $order, $price, 1);
    }
    mail($email, "Pizza Order", "Your order for $order was successful! You have been charged £" . $price/100 . ".");
    } catch(\Stripe\Error\Card $e) {
      $declined = true;
    } catch(\Stripe\Error\InvalidRequest $e) {
      $declined = true;
    }
  } else if ($token == "cash") {
    //Store the order in the database as not paid
    $price = $guid['price'];
    database::setOrder($name, $order, $price, 0);
    if ($isLive == 1) {
      database::setLog($name, $order, $price, 0);
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
    <link href="dist/css/pizza-get.css" rel="stylesheet">

    <link rel="shortcut icon" href="img/favicon.ico">
    
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="dist/js/vendor/html5shiv.js"></script>
      <script src="dist/js/vendor/respond.min.js"></script>
    <![endif]-->
  </head>
  <body onload="init()">
  <? if ($isLive == 0) { ?>
  <footer>
    <div class="container">
      <p>TEST MODE</p>
    </div>
  </footer>
  <? } ?>
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
                <li><a href="about.php">About</a></li>
                <li><a href="https://www.dominos.co.uk/store" target="_blank">Dominos Menu</a></li>
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
            <p>Name: <?=htmlspecialchars($name)?></p>
          </div>
          <div class="form-group col-xs-6">
            <p>Order: <?="$pizza_name$sides"?></p>
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
          <p>Comments: <?=htmlspecialchars($comments)?></p>
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
          <p>Name: <?=htmlspecialchars($name)?></p>
        </div>
        
        <div class="form-group">
          <p>Order: <?=htmlspecialchars($order)?></p>
        </div><!-- /btn-group -->
      
        <div class="form-group">
          <p>Price: £<?=number_format((float)$price/100, 2, '.', '')?></p>
        </div>

        <div class="form-group">
          <? if (!$declined and ($token != "cash") and ($token != "duplicate")) { ?>
          <div class="alert alert-success" id="size-error">
            Payment completed successfully! A confirmation email has been sent to <?=$email?></p>
          </div>
          <? } else if (($token != "cash") and ($token != "duplicate")) { ?>
          <div class="alert alert-danger" id="size-error">
            Your payment was declined (you have not been charged). You may have submitted the form twice - check to see if you have a confirmation email. Alternatively <a href="index.php">try again</a> or use cash.
          </div>
          <? } else if ($token != "duplicate"){ ?>
          <div class="alert alert-success" id="size-error">
            All done! When you're ready, go and pay for your pizza.
          </div>
          <? } else {?>
          <div class="alert alert-danger" id="size-error">
            Looks like there was a problem with your order! You may have submitted the form twice. If not, please <a href="index.php">try again</a>.
          </div>
          <? } ?>
      </div>
      <script>
        function init() {}
      </script>
      <? } ?>
      </div>
    </div> <!-- /container -->
    <? if ($isLive == 0) { ?>
    <footer>
      <div class="container">
        <p>TEST MODE</p>
      </div>
    </footer>
    <? } ?>
    
    <script src="dist/js/vendor/jquery.min.js"></script>
    <script src="dist/js/vendor/video.js"></script>
    <script src="dist/js/flat-ui.min.js"></script>
    <script src="docs/assets/js/application.js"></script>
    
  </body>
</html>
