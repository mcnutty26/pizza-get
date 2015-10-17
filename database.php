<?php
$config = include('config.php');
define ('HOST', $config['host']);
define ('USERNAME', $config['username']);
define ('PASSWORD', $config['password']);
define ('DBNAME', $config['dbname']);

class database {
    static function query($sql) {
      try {
        $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
        if (!$conn) {
          die('Could not connect to database');
        }
        $result = mysqli_query($conn, $sql);
        if (mysqli_error($conn) != '') {
          return mysqli_error($conn);
        }
        mysqli_close($conn);
        return $result;
      } catch (Exception $e) {
        die("UWCS mysql is down :(");
      }
    }

    static function escape($escapestr) {
      $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
      $result = mysqli_real_escape_string($conn, $escapestr);
      mysqli_close($conn);
      return $result;
    }

    static function getMenu()
    {
      $query = "SELECT *
                FROM hir2_pizza";
      $result = database::query($query);
      return $result;
    }  
    
    static function getActive()
    {
      $query = "SELECT active
                FROM hir2_events
                LIMIT 1";
      $result = database::query($query);
      while ($row = mysqli_fetch_array($result)) {
        return $row['active'];
      }
      return 0;
    }
    
    static function getLive()
    {
      $query = "SELECT live
                FROM hir2_events
                LIMIT 1";
      $result = database::query($query);
      while ($row = mysqli_fetch_array($result)) {
        return $row['live'];
      }
      return 0;
    }  
    
    static function getDiscount()
    {
      $query = "SELECT discount
                FROM hir2_events
                LIMIT 1";
      $result = database::query($query);
      while ($row = mysqli_fetch_array($result)) {
        return $row['discount'];
      }
      return 1;
    }  
    
    static function getPizza($id)
    {
      $query = "SELECT pizza
                FROM hir2_pizza
                WHERE id = $id
                LIMIT 1";
      $result = database::query($query);
      while ($row = mysqli_fetch_array($result)) {
        return $row['pizza'];
      }
      return false;
    }
    
    static function setOrder($name, $order, $price, $paid)
    {
      $query = "INSERT INTO  `mcnutty`.`hir2_orders` (`id` ,`name` ,`order` ,`price` ,`paid`) VALUES (NULL ,  '$name',  '$order',  '$price',  '$paid');";
      database::query($query);
    }
    
    static function setDiscount($val)
    {
      $query = "UPDATE `mcnutty`.`hir2_events` SET `discount`=$val;";
      database::query($query);
    }
    
    static function setActive($val)
    {
      $query = "UPDATE `mcnutty`.`hir2_events` SET `active`=$val;";
      database::query($query);
    }
    
    static function setLive($val)
    {
      $query = "UPDATE `mcnutty`.`hir2_events` SET `live`=$val;";
      database::query($query);
    }
   
    static function setGuid($guid, $name, $order, $price, $price_stripe)
    {
      $query = "INSERT INTO  `mcnutty`.`hir2_sessions` (`id` ,`guid`, `name`, `order` ,`price`, `price_stripe`) VALUES (NULL ,  '$guid', '$name', '$order', $price, $price_stripe);";
      database::query($query);
    }
	
	static function getGuid($guid)
    {
      $query = "SELECT * FROM `mcnutty`.`hir2_sessions` WHERE `guid`='$guid' LIMIT 1";
      $result = database::query($query);
      if ($query == false) {
        return false;
      }
      while ($row = mysqli_fetch_array($result)) {
        database::deleteGuid($guid);
        return array(
          'name'          => $row['name'],
          'order'         => $row['order'],
          'price'         => $row['price'],
          'price_stripe'  => $row['price_stripe']
        );
      }
      return false;
    }
    
    static function deleteGuid($guid)
    {
      $query = "DELETE FROM `mcnutty`.`hir2_sessions` WHERE `guid`='$guid';";
      database::query($query);
    }
    
    static function clearGuid()
    {
      $query = "DELETE FROM `mcnutty`.`hir2_sessions` WHERE 1=1;";
      database::query($query);
    }
    
    static function getOrders()
    {
      $query = "SELECT *
                FROM hir2_orders";
      $result = database::query($query);
      return $result;
    }
    
    static function deleteOrder($id)
    {
      $query = "DELETE FROM `mcnutty`.`hir2_orders` WHERE `id`='$id';";
      database::query($query);
    }
    
    static function clearOrders()
    {
      $query = "DELETE FROM `mcnutty`.`hir2_orders` WHERE 1=1;";
      database::query($query);
    }
    
    static function setPaid($id)
    {
      $query = "UPDATE `mcnutty`.`hir2_orders` SET `paid`=1 WHERE `id`=$id;";
      database::query($query);
    }
    
}
?>