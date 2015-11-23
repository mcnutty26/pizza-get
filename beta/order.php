<?
require_once 'database.php';
spl_autoload_register(function ($class) {
    include 'plugins/' . $class . '.php';
});

$config = include('config.php');
$payment_methods = array(new plugin_stripe());

//Redirect the user if they navigated here accidentally or orders are closed
if (!(isset($_POST['name']) or isset($_POST['token'])) or $active == false) {
  header( 'Location: index.php' ) ;
}

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
    foreach ($payment_type as $payment){
      $payment->calculated_price = $payment->prepayment($price, $name, $description, $config);
    }
    ?>
    
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
          <?
          foreach ($payment_type as $payment){
            $payment_name = $payment['name'];
            $payment_price = number_format((float)$payment->calculated_price/100, 2, '.', '');
            echo "<div class=\"form-group col-xs-4\">";
            echo "<button class=\"btn btn-primary btn-lg btn-block\" id=\"$payment_name\">Pay by $payment_name £$payment_price</button>";
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
    <script>
      videojs.options.flash.swf = "dist/js/vendors/video-js.swf"
    </script>
    
  </body>
</html>
