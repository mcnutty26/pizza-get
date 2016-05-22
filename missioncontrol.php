<?
$config = include('config.php');

#Save sessions in a secure location to prevent session hijacking 
session_save_path($config['session_path']);
session_start();
require_once 'database.php'; 

if ($_POST['login'] == 2) {
  session_destroy();
  header( 'Location: missioncontrol.php' ) ;
}

if ($_POST['pw'] == $config['cp_pass']) {
    $_SESSION['login'] = $config['cp_guid'];
  }

if ($_SESSION['login'] == $config['cp_guid']) {
  
  //These are set by the form controls
  if (isset($_POST['discount'])) {
    $sides_bit = (substr($_POST['discount'], 0, 1) == 'S' ? 1 : 0);
    $discount = substr($_POST['discount'], 1);
    database::setDiscount($discount);
    database::setDiscountSides($sides_bit);
  }
  if (isset($_POST['active'])) {
    if ($_POST['active'] == '1') {
      database::setActive(1);
    } else {
      database::setActive(0);
      database::clearGuid();
    }
  }
  if (isset($_POST['deployment'])) {
    if ($_POST['deployment'] == '1') {
      database::setLive(1);
    } else {
      database::setLive(0);
    }
  }
  
  if (isset($_POST['mark'])) {
    database::setPaid($_POST['mark']);
  }
  
  if (isset($_POST['entered'])) {
    database::setEntered($_POST['entered']);
  }
  
  if (isset($_POST['del'])) {
    database::deleteOrder($_POST['del']);
  }
  
  if ($_POST['clear'] == 1) {
    database::clearOrders();
  }
  
  $discount = database::getDiscount();
  $discount_sides = database::getDiscountSides();
  $active = database::getActive();
  $active_name = ($active == 0 ? "ON" : "OFF");
  $active_bit = ($active == 0 ? "1" : "0");
  $deployment = database::getLive();
  $deployment_name = ($deployment == 0 ? "LIVE" : "TEST");
  $deployment_bit = ($deployment == 0 ? "1" : "0");
  
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
  <body onload="init()>
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
	    <h3>pizza-get Mission Control</h3>
      </div>
      <div class="login-form">
        <? if ($_SESSION['login'] == $config['cp_guid']) { ?>
        
        <div class="form-group col-xs-4">
          <form method="post" action="missioncontrol.php" id="disFrm">
            <select class="form-control select select-primary" data-toggle="select" name="discount" onchange="processDiscount()">
              <option value="P2" <? if ($discount == 2 and $discount_sides == 0) {echo "selected";} ?>>50% Discount (pizza only)</option>
              <option value="S2" <? if ($discount == 2  and $discount_sides == 1) {echo "selected";} ?>>50% Discount</option>
              <option value="P1.67" <? if ($discount == 1.67  and $discount_sides == 0) {echo "selected";} ?>>40% Discount (pizza only)</option>
              <option value="S1.67" <? if ($discount == 1.67  and $discount_sides == 1) {echo "selected";} ?>>40% Discount</option>
              <option value="P1.50" <? if ($discount == 1.50  and $discount_sides == 0) {echo "selected";} ?>>33% Discount (pizza only)</option>
              <option value="S1.50" <? if ($discount == 1.50  and $discount_sides == 1) {echo "selected";} ?>>33% Discount</option>
              <option value="P1.43" <? if ($discount == 1.43  and $discount_sides == 0) {echo "selected";} ?>>30% Discount (pizza only)</option>
              <option value="S1.43" <? if ($discount == 1.43  and $discount_sides == 1) {echo "selected";} ?>>30% Discount</option>
              <option value="S1" <? if ($discount == 1) {echo "selected";} ?>>0% Discount</option>
            </select>
          </form>
        </div>
        
        <div class="form-group col-xs-4">
          <form method="post" action="missioncontrol.php" id="actFrm">
            <input type="hidden" name="active" value="<?=$active_bit?>">
            <a href="#" class="btn btn-block btn-lg btn-primary" onclick="processActive()">Turn ordering <?= $active_name?></a>
          </form>
        </div>
        
        <div class="form-group col-xs-4">
          <form method="post" action="missioncontrol.php" id="dplyFrm">
            <input type="hidden" name="deployment" value="<?=$deployment_bit?>">
            <a href="#" class="btn btn-block btn-lg btn-primary" onclick="processDeploy()">Set mode to <?= $deployment_name?></a>
          </form>
        </div>
        
        <h4>Active Orders:</h4>

        <div class="form-group">
          <table id="orders">
            <tr>
              <td>Name</td>
              <td>Order</td>
              <td>Price</td>
              <td>Paid</td>
              <td>Entered</td>
              <td>Delete</td>
            </tr>
            <? $result = database::getOrders();
            $subtotal = 0;
            $total = 0;
            foreach ($result as $row) {
              $row_price = $row['price'];
              $row_id = $row['id'];
              
              if (($subtotal + $row_price) > 25000) {
                  echo '<tr><td></td><td>Over £250 web order limit - split here</td><td>' . number_format((float)($subtotal/100), 2, '.', '') . '</td><td></td><td></td><td></td>';
                  $subtotal = 0;
              }
              $subtotal += $row_price;
              $total += $row_price;
              
              echo "<tr id=\"$row_id\">";
              echo '<td>' . htmlspecialchars(substr($row['name'], 0, 15)) . '</td>';
              echo '<td>' . htmlspecialchars($row['order']) . '</td>';
              echo '<td>' . number_format((float)($row_price/100), 2, '.', '') . '</td>';
              echo "<td id=\"mark$row_id\">" . ($row['paid'] == 1 ? "<span class=\"fui-check\"></span>" : "<a class=\"fui-cross ajax-button\" onclick=\"processPaid($row_id)\"></a>") . '</td>';
              
              echo "<td id=\"entered$row_id\">" . ($row['entered'] == 1 ? "<span class=\"fui-check\"></span>" : "<a class=\"fui-cross ajax-button\" onclick=\"processEntered($row_id)\"></a>") . '</td>';
              
              echo "<td><a class=\"fui-cross ajax-button\" onclick=\"processDelete($row_id)\"></a></td>";
              echo '</tr>';
            }
            ?>
            <tr><td></td><td>TOTAL</td><td><?=number_format((float)($total/100), 2, '.', '')?></td><td></td><td></td><td></td></tr>
          </table>
        </div>
        <div class="row">  
          <div class="form-group col-xs-6">
            <form method="post" action="missioncontrol.php">
              <input type="hidden" name="clear" value="1">
              <input type="submit" class="btn btn-danger btn-lg btn-block" value="Clear all orders">
            </form>
          </div>
        
          <div class="form-group col-xs-6">
            <form method="post" action="missioncontrol.php">
              <input type="hidden" name="login" value="2">
              <input type="submit" class="btn btn-danger btn-lg btn-block" value="Log out">
            </form>
          </div>
        </div>
        <script> 
          function processDiscount() {
            document.getElementById("disFrm").submit();
          }
          function processActive() {
            document.getElementById("actFrm").submit();
          }
          function processDeploy() {
            document.getElementById("dplyFrm").submit();
          }
          
          function processDelete(arg) {
            $.ajax({url: 'missioncontrol.php', method: 'POST', data: {'del': arg}})
            .done(function() {
              $('#'+arg).hide('fast');
            });
          }
          
          function processEntered(arg) {
            $.ajax({url: 'missioncontrol.php', method: 'POST', data: {'entered': arg}})
            .done(function() {
              $('#entered'+arg).html("<span class=\"fui-check\"></span>");
            });
          }
          
          function processPaid(arg) {
            $.ajax({url: 'missioncontrol.php', method: 'POST', data: {'mark': arg}})
            .done(function() {
              $('#mark'+arg).html("<span class=\"fui-check\"></span>");
            });
          }
          
          function init() {
            $(".ajax-button").click(function(event){
              event.preventDefault();
            });
          }
        </script>
        
        <style>
        #orders td {
          padding:3px;
        }
        </style>
        
        <? } else { ?>
        <form method="post" action="missioncontrol.php">
          <div class="form-group">
            <input type="password" class="form-control login-field" value="" placeholder="Password" id="pw" name="pw" required />
          </div>
          <input class="btn btn-primary btn-lg btn-block" type="submit" value="Login">
        </form>
        <? } ?>
      </div>
    </div> <!-- /container -->

    <script src="dist/js/vendor/jquery.min.js"></script>
    <script src="dist/js/vendor/video.js"></script>
    <script src="dist/js/flat-ui.min.js"></script>
    <script src="docs/assets/js/application.js"></script>

    <script>
      videojs.options.flash.swf = "dist/js/vendors/video-js.swf"
    </script>
  </body>
</html>
