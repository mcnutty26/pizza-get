<?
require_once 'database.php'; 

$active = database::getActive();
$discount = database::getDiscount() * 100;
$discount_sides = database::getDiscountSides();
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
  <body onload="init()">
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
                <li><a href="about.html">About</a></li>
                <li><a href="https://www.dominos.co.uk/store" target="_blank">Dominos Menu</a></li>
               </ul>
            </div><!-- /.navbar-collapse -->
          </nav><!-- /navbar -->
        </div>
      </div> <!-- /row -->
      
      <div class="demo-type-example">
        <h3><?=$config['front_string']?></h3>
      </div>
      <? if ($active == 1) { ?>
      <div class="login-form">
        <form action="order.php" method="post" id="orderForm" onsubmit="return validateCrust()">
          <div class="row">
            <div class="alert alert-danger" id="size-error">
              Whoops! You can't have those options with that size pizza :(
            </div>
            <div class="col-xs-6">
              <div class="form-group" id="nameField">
                <input type="text" class="form-control " placeholder="Enter your name" id="login-name" name="name" onfocus="resetName()"/>
                <label class="login-field-icon fui-user" for="login-name"></label>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="form-group">
                <select class="form-control select select-primary" data-toggle="select" name="pizza" id="pizzaSelect" onchange="processPizza(this)">

                  <? $result = database::getMenu();
                  foreach ($result as $row) {
                    echo '<option value="' . $row['id'] . '" >' . $row['pizza'] . ' (£' . number_format((float)$row['large']/$discount, 2, '.', '') . ')</option>';
                  } ?>
                  <option value="H">Half and Half (varies)</option>
                  <option value="B">Build your Own (varies)</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
          
            <div class="form-group col-xs-4">
              <select class="form-control select select-primary" data-toggle="select" name="size" id="sizeSelect" onchange="processCrust(this);">
                <option value="1">Large</option>
                <option value="2">Medium (-£<?=number_format((float)200/$discount, 2, '.', '')?>)</option>
                <option value="3">Small (-£<?=number_format((float)400/$discount, 2, '.', '')?>)</option>
                <option value="4">Personal (varies)</option>
              </select>
            </div>
            
            <div class="form-group col-xs-4">
              <select class="form-control select select-primary" data-toggle="select" name="crust" id="crustSelect">
                <option value="a">Normal Crust</option>
                <option value="b">Italian Crust</option>
                <option value="c">Thin and Crispy Crust</option>
                <option value="d">Stuffed Crust (+£<?=number_format((float)250/$discount, 2, '.', '')?>)</option>
                <option value="e">Hotdog Stuffed Crust (+£<?=number_format((float)250/$discount, 2, '.', '')?>)</option>
                <option value="g">Hotdog Stuffed Crust with Mustard (+£<?=number_format((float)250/$discount, 2, '.', '')?>)</option>
                <option value="f">BBQ Stuffed Crust (+£<?=number_format((float)250/$discount, 2, '.', '')?>)</option>
              </select>
            </div>
            
            <div class="form-group col-xs-4">
              <a class="btn btn-primary btn-lg btn-block" href="#" onclick="processSides()" id="showSides">Show Sides</a>
            </div>
          
          </div> <!-- /row -->
          
          <div class="form-group" id="sides">
            <? $result = database::getSides();
            $count = 0;
            $total = 0;
            foreach ($result as $row) {
              if ($count == 0) {
                echo "<div class=\"row\">";
              }
              echo "<div class=\"form-group col-xs-3\">";
              echo "<label class=\"checkbox\" for=\"side" . $row['id'] . "\">";
              echo "<input type=\"checkbox\" id=\"side" . $row['id'] . "\" name=\"side" . $row['id'] . "\" data-toggle=\"checkbox\">" . $row['name'] . " (£" . number_format((float)$row['price']/( $discount_sides == 1 ? $discount : 100), 2, '.', '') . ")</label>";
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
          
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Enter comments (like your two free topping changes)" id="comments" name="comments" />
            <label class="login-field-icon fui-chat" for="comments"></label>
          </div>

          <a class="btn btn-primary btn-lg btn-block" id="submitForm" href="#" onclick="validateCrust()">Go to Payment</a>
        </form>
      </div>
      <? } else { ?>
      <p>Sorry, but there are no pizza orders at the moment</p>
      <? } ?>
    </div> <!-- /container -->
    
    <? if ($isLive == 0 and $active == 1) { ?>
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
    function processCrust(arg) {
      switch(arg.value) {
        case '1':
        case '2':
            $("option[value='c']").removeAttr('disabled');
            $("option[value='d']").removeAttr('disabled');
            $("option[value='e']").removeAttr('disabled');
            $("option[value='f']").removeAttr('disabled');
            $("option[value='g']").removeAttr('disabled');
            $("option[value='b']").removeAttr('disabled');
            break;        
        case '3':
            $("option[value='c']").attr("disabled", "disabled");
            $("option[value='d']").attr("disabled", "disabled");
            $("option[value='e']").attr("disabled", "disabled");
            $("option[value='f']").attr("disabled", "disabled");
            $("option[value='g']").attr("disabled", "disabled");
            break;
        case '4':
            $("option[value='b']").attr("disabled", "disabled");
            $("option[value='c']").attr("disabled", "disabled");
            $("option[value='d']").attr("disabled", "disabled");
            $("option[value='e']").attr("disabled", "disabled");
            $("option[value='f']").attr("disabled", "disabled");
            $("option[value='g']").attr("disabled", "disabled");
      }
    }
	
    function validateCrust() {
      if (document.getElementById("login-name").value == "") {
        $("#nameField").addClass("has-error");
        return false;
      }
      var c = document.getElementById("crustSelect");
      var s = document.getElementById("sizeSelect");
      var p = document.getElementById("pizzaSelect");
      if (p.options[p.selectedIndex].value == "H" && s.options[s.selectedIndex].value == "4") {
        $('#size-error').show();
        return false;
      } else {        
        switch(c.options[c.selectedIndex].value) {
          case 'b':
            if (s.options[s.selectedIndex].value == '4') {
              $('#size-error').show();
              return false;
            } else {
              $('#crustSelect').removeAttr("disabled");
              $('#sizeSelect').removeAttr("disabled");
              document.getElementById("orderForm").submit();
            }
            break;
          case 'c':
          case 'd':
          case 'e':
          case 'f':
          case 'g':
            if (s.options[s.selectedIndex].value == '3' || s.options[s.selectedIndex].value == '4') {
              $('#size-error').show();
              return false;
            }
          default:
            $('#crustSelect').removeAttr("disabled");
            $('#sizeSelect').removeAttr("disabled");
            document.getElementById("orderForm").submit();
        }
      }
    }
    
    function resetName() {
      $("#nameField").removeClass("has-error");
    }
    
    function init() {
      $('#sides').hide();
      $('#size-error').hide();
    }
    
    function processSides() {
      if ($('#sides').is(":visible")) {
        document.getElementById('showSides').innerHTML = "Show sides";
        $('#sides').hide('fast');
      } else {
        document.getElementById('showSides').innerHTML = "Hide sides";
        $('#sides').show('fast');
      }
    }
    
    function processPizza(arg) {
      if (arg.value == "H") {
        $('#crustSelect').removeAttr("disabled");
        $('#sizeSelect').removeAttr("disabled");
        $('#orderForm').attr('action', 'custom.php?mode=H');
        $('#submitForm').html('Customise Your Pizza');
        $("option[value='4']").attr('disabled', 'disabled');
      } else if (arg.value == "B") {
        $('#crustSelect').removeAttr("disabled");
        $('#sizeSelect').removeAttr("disabled");
        $('#orderForm').attr('action', 'custom.php?mode=B');
        $('#submitForm').html('Customise Your Pizza');
        $("option[value='4']").removeAttr('disabled');
      } else if (arg.value == "<?=$config['empty_pizza']?>") {
        $('#crustSelect').attr("disabled", "disabled");
        $('#sizeSelect').attr("disabled", "disabled");
      } else {
        $('#crustSelect').removeAttr("disabled");
        $('#sizeSelect').removeAttr("disabled");
        $('#orderForm').attr('action', 'order.php');
        $('#submitForm').html('Go to Payment');
      }
    }
    </script>
    
    <script>
      videojs.options.flash.swf = "dist/js/vendors/video-js.swf"
    </script>
  </body>
</html>
