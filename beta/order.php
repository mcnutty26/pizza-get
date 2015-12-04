<?
require_once 'database.php';

spl_autoload_register(function ($class) {
    include 'plugins/' . $class . '.php';
});

$payment_methods = array(new plugin_stripe(), new plugin_cash());

//Redirect the user if they navigated here accidentally or orders are closed
if (!(isset($_POST['name']) or isset($_POST['token'])) or $config['active'] == false) {
  header('Location: index.php');
}

$name = htmlspecialchars($_POST['name']);
$comments = htmlspecialchars($_POST['comments']);
$pizza = $_POST['pizza'];
$crust = $_POST['crust'];
$size = $_POST['size'];

$size_name = pizza_helper::get_size_name($size);
$pizza_name = database::getPizzaName($pizza); 
$pizza_price = pizza_helper::get_pizza_price($pizza, $size_name);
$crust_name = pizza_helper::get_crust_name($crust, $size);
$crust_price = pizza_helper::get_crust_price($crust, $size);
$sides_name = pizza_helper::get_sides_name($_POST);
$sides_price = pizza_helper::get_sides_price($_POST);
$toppings_name = pizza_helper::get_toppings_name($_POST, $pizza);
$toppings_price = pizza_helper::get_toppings_price($_POST, $pizza, $size);
$sauce_name = pizza_helper::get_sauce_name($_POST);

$price = ($pizza_price + $toppings_price)/$config['discount'];
$price += $price_sides / ($config['discount_sides'] == 1 ? $config['discount'] : 1);
$order = "A $size_name $pizza_name ($sauce_name) $toppings_name $sides_name";

if (isset($_POST['name'])) {
} else {
  $payment_method = new $_POST['method'];
  $payment_method->postpayment($config, $_POST['token']);
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
    
    <? 
    foreach ($payment_methods as $payment){
      $payment->calculated_price = $payment->prepayment($price, $name, $order, $config);
    }
    ?>
    
  </head>
  <body>
  <? if ($config['live'] == 0) { ?>
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
                <li><a href="about.html">About</a></li>
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
      
      <? if (isset($_POST['name'])){ ?>
        
        <div class="row">
          <div class="form-group col-xs-6">
            <p>Name: <?=$name?></p>
          </div>
          <div class="form-group col-xs-6">
            <p>Order: <?="$order"?></p>
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
          <?
          foreach ($payment_methods as $payment){
            echo "<div class=\"form-group col-xs-4\">";
            echo $payment->button();
            echo "</div>";
          }
          ?>

          <div class="form-group col-xs-4">
            <a class="btn btn-danger btn-lg btn-block" href="index.php">Cancel</a>
          </div>
      </div>
      <p>Please check your order before continuing. Card payments are slightly higher to cover the fee we have to pay.</p>
      
      <? } else { ?>

        <div class="form-group">
          <p>Name: <?=htmlspecialchars($_POST['name'])?></p>
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
    <? if ($config['live'] == 0) { ?>
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
    <script>
      videojs.options.flash.swf = "dist/js/vendors/video-js.swf"
    </script>
    
  </body>
</html>
