<?php
require_once 'database.php';

$total_price = database::getTotalPrice();
$total_orders = database::getTotalOrders();
$active = database::getActive();
$isLive = database::getLive()
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
  <body>
	<? if ($isLive == 0 and $active == 1) { ?>
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
	    <h3>About pizza-get</h3>

		<p>Doing pizza orders is such a faff. So far we have automated <?=$total_orders?> orders, worth a total of &pound;<?=number_format($total_price/100, 0, '.', ',')?>.</p>
        <p>Made by William Seymour (mcnutty). Uses Flat UI/bootstrap for the interface and PHP for the back end. Payments are handled by <a href="https://stripe.com/gb" target="_blank">Stripe</a> which means that the app doesn't have to deal with any sensitive information (which is just better for everyone).</p>
		<p>The source for pizza-get is available on <a href="https://github.com/mcnutty26/pizza-get">github</a>. Feel free to submit a pull request if you spot a bug or want to implement a feature :)</p>
      </div>
      
    </div> <!-- /container -->

	<? if ($isLive == 0 and $active == 1) { ?>
 	<footer>
 		<div class="container">
			<p>TEST MODE</p>
		</div>
	</footer>
	<? } ?>
	
	<script src="dist/js/vendor/jquery.min.js"></script>
    <script src="dist/js/flat-ui.min.js"></script>
    <script src="docs/assets/js/application.js"></script>

  </body>
</html>
