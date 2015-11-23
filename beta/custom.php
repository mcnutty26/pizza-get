<?
require_once 'database.php'; 

//Redirect the user if the navigated here accidentally
if ($config['active'] != 1 or !isset($_POST['pizza']) or !isset($_POST['crust']) or !isset($_POST['size']) or !isset($_POST['name'])) {
  header( 'Location: index.php' ) ;
}

//Load and correctly display the base price of the pizza
$size = $_POST['size'];
$pizza = database::getPizza($_POST['pizza']);
if ($_POST['pizza'] == "B") {
  $pizza['pizza'] = "Build Your Own";
}

if ($size == "1") {
  $price = $pizza['large'];
  $topping_price = 130;
} else if ($size == "2") {
  $price = $pizza['medium'];
  $topping_price = 120;
} else if ($size == "3") {
  $price = $pizza['small'];
  $topping_price = 100;
} else if ($size == "4") {
  $price = $pizza['personal'];
  $topping_price = 80;
} else {
  //Redirect on impossible pizza size
  header( 'Location: index.php' );
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
  <? if ($config['live'] == 0 and $config['active'] == 1) { ?>
  <footer>
    <div class="container">
      <p>TEST MODE</p>
    </div>
  </footer>
  <? } ?>
    <div class="container">
      <form method="post" action="order.php">
        <input type="hidden" name="name" value="<?=$_POST['name']?>">
        <input type="hidden" name="size" value="<?=$_POST['size']?>">
        <input type="hidden" name="crust" value="<?=$_POST['crust']?>">
        <input type="hidden" name="comments" value="<?=$_POST['comments']?>">
        <input type="hidden" name="pizza" value="<?=$_POST['pizza']?>">
        <?$result = database::getSides();
        foreach ($result as $row) {
          if (isset($_POST['side' . $row['id']])) {
            echo "<input type=\"hidden\" name=\"side" . $row['id'] . "\" value=\"on\">";
          }
        } ?>
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
        
        <div class="login-form">
          <h4><?=$pizza['pizza']?></h4>
          <div id="byo">
            Pizza Base:
            <div class="form-group row">
              <div class="col-xs-3">
                <label class="checkbox" for="sauce">
                  <input type="checkbox" id="sauce" name="sauce" onchange="processSauce(0)" checked="checked" data-toggle="checkbox"/>
                  Tomato Sauce
                </label>
              </div>
              <div class="col-xs-3">
                <label class="checkbox" for="bsauce">
                  <input type="checkbox" id="bsauce" name="bsauce" onchange="processSauce(1)" data-toggle="checkbox"/>
                  BBQ Sauce
                </label>
              </div>
              <div class="col-xs-3">
                <label class="checkbox" for="cheese">
                  <input type="checkbox" id="cheese" name="cheese" checked="checked" data-toggle="checkbox"/>
                Mozzarella Cheese
                </label>
              </div>
              <div class="col-xs-3">
                <label class="checkbox" for="pcheese">
                  <input type="checkbox" id="pcheese" name="pcheese" onchange="processCheese()" data-toggle="checkbox"/>
                Extra Cheese (£<?=number_format((float)$topping_price/$config['discount'], 2, '.', '')?>)
                </label>
              </div>
            </div>
            Choose your toppings:
            <div class="form-group">
              <?
              $count = 0;
              $total = 0;
              foreach (database::getToppings() as $row) {
                
                $checked = "";
                foreach (database::getIngredients($pizza['id']) as $ingredients) {
                  if ($ingredients['topping'] == $row['id']) {
                    $checked = "checked=\"checked\"";
                  }
                }
                
                if ($count == 0) {
                  echo "<div class=\"row\">";
                }
                echo "<div class=\"form-group col-xs-3\">";
                echo "<label class=\"checkbox\" for=\"topping" . $row['id'] . "\">";
                echo "<input type=\"checkbox\" id=\"topping" . $row['id'] . "\" name=\"topping" . $row['id'] . "\" data-toggle=\"checkbox\"" . $checked . ">" . $row['name'] . " (£" . number_format((float)$topping_price/$config['discount'], 2, '.', '') . ")</label>";
                echo "</div>";
                if ($count == 3) {
                  echo "</div>";
                  $count = -1;
                }
                $count++;
                $total++;
              } 
              if ($total % 4 != 0) {
                echo "</div>";
              }
              ?>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-xs-12">
              <button class="btn btn-primary btn-lg btn-block">Go to Payment</button>
            </div>
          </div>
        </div>
        </div>
      </form>
    </div> <!-- /container -->
    
    <? if ($config['live'] == 0 and $config['active'] == 1) { ?>
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
  $.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
       return null;
    }
    else{
       return results[1] || 0;
    }
  }
  
  function init() {
    if ($.urlParam('mode') == 'H') {
      //$('#byo').hide();
    } else {
      //$('#hnh').hide();  
    }
  }
  
  function processSauce(arg) {
    if ($("#sauce").prop("checked") && $("#bsauce").prop("checked")) {
      if (arg == 0) {
        $("#bsauce").prop("checked", false);
      } else {
        $("#sauce").prop("checked", false);
      }
    }
  }
  
  function processCheese() {
      $("#cheese").prop("checked", true);
  }
  </script>
    
    <script>
      videojs.options.flash.swf = "dist/js/vendors/video-js.swf"
    </script>
  </body>
</html>
