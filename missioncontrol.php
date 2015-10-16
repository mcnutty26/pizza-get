<? 
session_save_path('/home/mcnutty/pizza-get-sessions');
session_start();
require_once 'database.php'; 
$config = include('config.php');

if ($_POST['login'] == 2) {
  session_destroy();
  header( 'Location: missioncontrol.php' ) ;
}

if ($_POST['pw'] == $config['cp_pass']) {
    $_SESSION['login'] = 1;
  }

if ($_SESSION['login'] == 1) {
  if (isset($_POST['discount'])) {
    database::setDiscount(database::escape($_POST['discount']));
  }
  if (isset($_POST['active'])) {
    if ($_POST['active'] == '1') {
      database::setActive(1);
    } else {
      database::setActive(0);
      database::clearGuid();
    }
  }
  
  if (isset($_POST['mark'])) {
    database::setPaid(database::escape($_POST['mark']));
  }
  
  if (isset($_POST['del'])) {
    database::deleteOrder(database::escape($_POST['del']));
  }
  
  if ($_POST['clear'] == 1) {
    database::clearOrders();
  }
  
  $discount = database::getDiscount();
  $active = database::getActive();
  $active_name = ($active == 0 ? "ON" : "OFF");
  $active_bit = ($active == 0 ? "1" : "0");
  
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
	    <h3>pizza-get Mission Control</h3>
      </div>
      <div class="login-form">
        <? if ($_SESSION['login'] == 1) { ?>
        
        <div class="form-group col-xs-6">
          <form method="post" action="missioncontrol.php" id="disFrm">
            <select class="form-control select select-primary" data-toggle="select" name="discount" onchange="processDiscount()">
              <option value="2" <? if ($discount == 2) {echo "selected";} ?>>50% Discount</option>
              <option value="1.5" <? if ($discount == 1.5) {echo "selected";} ?>>33% Discount</option>
              <option value="1" <? if ($discount == 1) {echo "selected";} ?>>0% Discount</option>
            </select>
          </form>
        </div>
        
        <div class="form-group col-xs-6">
          <form method="post" action="missioncontrol.php" id="actFrm">
            <input type="hidden" name="active" value="<?=$active_bit?>">
            <a href="#" class="btn btn-block btn-lg btn-primary" onclick="processActive()">Turn ordering <?= $active_name?></a>
          </form>
        </div>
        
        <h4>Active Orders:</h4>

        <div class="form-group">
          <table style="width:100%;" border="1" id="orders">
            <tr>
              <td>Name</td>
              <td>Order</td>
              <td>Price</td>
              <td>Paid</td>
              <td>Delete</td>
            </tr>
            <? $result = database::getOrders();
            while ($row = mysqli_fetch_array($result)) {
              $row_price = $row['price'];
              $row_id = $row['id'];
              echo '<tr>';
              echo '<td>' . substr($row['name'], 0, 15) . '</td>';
              echo '<td>' . $row['order'] . '</td>';
              echo '<td>' . number_format((float)($row_price/100), 2, '.', '') . '</td>';
              echo '<td>' . ($row['paid'] == 1 ? "<span class=\"fui-check\"></span>" : "<form method=\"post\" action=\"missioncontrol.php\"><input type=\"hidden\" name=\"mark\" value=\"$row_id\"><a class=\"fui-cross\" onclick=\"processTable(this)\" href=\"#\"></a></form>") . '</td>';
              echo "<td><form method=\"post\" action=\"missioncontrol.php\"><input type=\"hidden\" name=\"del\" value=\"$row_id\"><a class=\"fui-cross\" onclick=\"processTable(this)\" href=\"#\"></a></form></td>";
              echo '</tr>';
            }
            ?>
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
          function processTable(arg) {
            arg.parentNode.submit();
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
    <script src="js/jquery-1.11.3.min.js"></script>

    <script>
      videojs.options.flash.swf = "dist/js/vendors/video-js.swf"
    </script>
  </body>
</html>