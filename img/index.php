<?
require_once 'database.php'; 

$active = database::getActive();
$discount = database::getDiscount() * 100;
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
  <body>
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
	    <h3>At gaming? Want pizza? We've got you covered.</h3>
      </div>
      <? if ($active == 1) { ?>
      <div class="login-form">
        <form action="order.php" method="post" id="orderForm" onsubmit="return validateCrust()">
          <div class="row">
            <div class="col-xs-6">
              <div class="form-group" id="nameField">
                <input type="text" class="form-control " placeholder="Enter your name" id="login-name" name="name" onfocus="resetName()"/>
                <label class="login-field-icon fui-user" for="login-name"></label>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="form-group">
                <select class="form-control select select-primary" data-toggle="select" name="pizza">

                  <? $result = database::getMenu();
                  while ($row = mysqli_fetch_array($result)) {
                    echo '<option value="' . $row['id'] . '" >' . $row['pizza'] . ' (£' . number_format((float)$row['large']/$discount, 2, '.', '') . ')</option>';
                  } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
          
            <div class="form-group col-xs-6">
              <select class="form-control select select-primary" data-toggle="select" name="size" id="sizeSelect" onchange="processCrust(this);">
                <option value="1">Large</option>
                <option value="2">Medium (-£<?=number_format((float)200/$discount, 2, '.', '')?>)</option>
                <option value="3">Small (-£<?=number_format((float)400/$discount, 2, '.', '')?>)</option>
              </select>
            </div>
            
            <div class="form-group col-xs-6">
              <select class="form-control select select-primary" data-toggle="select" name="crust" id="crustSelect">
                <option value="a">Normal Crust</option>
                <option value="b">Italian Crust</option>
                <option value="c">Thin and Crispy Crust</option>
                <option value="d">Stuffed Crust (+£<?=number_format((float)250/$discount, 2, '.', '')?>)</option>
                <option value="e">Hotdog Stuffed Crust (+£<?=number_format((float)250/$discount, 2, '.', '')?>)</option>
                <option value="f">BBQ Stuffed Crust (+£<?=number_format((float)250/$discount, 2, '.', '')?>)</option>
              </select>
            </div>
          
          </div> <!-- /row -->
          
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Enter comments (like your two free topping changes)" id="comments" name="comments"" />
            <label class="login-field-icon fui-chat" for="comments"></label>
          </div>

          <a class="btn btn-primary btn-lg btn-block" href="#" onclick="validateCrust()">Go to payment</a>
        </form>
      </div>
      <? } else { ?>
      <p>Sorry, but there are no pizza orders at the moment</p>
      <? } ?>
    </div> <!-- /container -->

    <script src="dist/js/vendor/jquery.min.js"></script>
    <script src="dist/js/vendor/video.js"></script>
    <script src="dist/js/flat-ui.min.js"></script>
    <script src="docs/assets/js/application.js"></script>
    <script src="js/jquery-1.11.3.min.js"></script>

    <script>
    function processCrust(arg) {
      switch(arg.value) {
        case '1':
            $("option[value='c']").removeAttr('disabled');
            $("option[value='d']").removeAttr('disabled');
            $("option[value='e']").removeAttr('disabled');
            $("option[value='f']").removeAttr('disabled');
            break;
        case '2':
            $("option[value='c']").removeAttr('disabled');
            $("option[value='d']").removeAttr('disabled');
            $("option[value='e']").removeAttr('disabled');
            $("option[value='f']").removeAttr('disabled');
            break;
        default:
            $("option[value='c']").attr("disabled", "disabled");
            $("option[value='d']").attr("disabled", "disabled");
            $("option[value='e']").attr("disabled", "disabled");
            $("option[value='f']").attr("disabled", "disabled");
      }
    }
	
    function validateCrust() {
      if (document.getElementById("login-name").value == "") {
        $("#nameField").addClass("has-error");
        return false;
      }
      var c = document.getElementById("crustSelect");
      var s = document.getElementById("sizeSelect");
      switch(c.options[c.selectedIndex].value) {
        case 'c':
        case 'd':
        case 'e':
        case 'f':
          if (s.options[s.selectedIndex].value == '3') {
            alert("You can't have this crust with a small pizza :(");
            return false;
            break;
          }
        default:
          document.getElementById("orderForm").submit();
      }
    }
    
    function resetName() {
      $("#nameField").removeClass("has-error");
    }
    </script>
    
    <script>
      videojs.options.flash.swf = "dist/js/vendors/video-js.swf"
    </script>
  </body>
</html>