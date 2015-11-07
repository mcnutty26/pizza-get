<?php
$config = include('config.php');
define ('HOST', $config['host']);
define ('USERNAME', $config['username']);
define ('PASSWORD', $config['password']);
define ('DBNAME', $config['dbname']);

class database {
    
    //Open a connection to the database usng PDO
    static function getDbh() {
      $dsn = 'mysql:dbname=' . DBNAME . ';host=' . HOST;
      try {
          $dbh = new PDO($dsn, USERNAME, PASSWORD);
          return $dbh;
      } catch (Exception $e) {
        die("UWCS mysql is down :(");
      }
    }
    
    //Prepare and execute a generic query with no variables
    static function simpleQuery($query) {
      $stmt = database::getDbh()->prepare($query);
      if ($stmt->execute()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }
      return false;
    }
    
    //Prepare and execute a generic query with a single variable
    static function singleArgQuery($query, $arg) {
      $stmt = database::getDbh()->prepare($query);
      $stmt->bindParam(':arg', $arg);
      if ($stmt->execute()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }
      return false;
    }
    
    static function getMenu()
    {
      return database::simpleQuery("SELECT * FROM hir2_pizza");
    }
    
    static function getSides()
    {
      return database::simpleQuery("SELECT * FROM hir2_sides");
    }
    
    static function getToppings()
    {
      return database::simpleQuery("SELECT * FROM hir2_toppings");
    }
    
    static function getActive()
    {     
      return database::simpleQuery("SELECT active FROM hir2_events LIMIT 1")[0]['active'];
    }
    
    static function getLive()
    {
      return database::simpleQuery("SELECT live FROM hir2_events LIMIT 1")[0]['live'];
    }  
    
    static function getDiscount()
    {
      return database::simpleQuery("SELECT discount FROM hir2_events LIMIT 1")[0]['discount'];
    }
    
    static function getDiscountSides()
    {
      return database::simpleQuery("SELECT discountSides FROM hir2_events LIMIT 1")[0]['discountSides'];
    }
    
    static function getOrders()
    {
      return database::simpleQuery("SELECT * FROM hir2_orders");
    }
    
    static function clearGuid()
    {
      return database::simpleQuery("DELETE FROM `mcnutty`.`hir2_sessions` WHERE 1=1;");
    }
    
    static function clearOrders()
    {
      return database::simpleQuery("DELETE FROM `mcnutty`.`hir2_orders` WHERE 1=1;");
    }
    
    static function getPizza($id)
    {
      return database::singleArgQuery("SELECT * FROM hir2_pizza WHERE id = :arg LIMIT 1", $id)[0];
    }
    
    static function getPizzaName($id)
    {
      return database::singleArgQuery("SELECT pizza FROM hir2_pizza WHERE id = :arg LIMIT 1", $id)[0]['pizza'];
    }
    
    static function getGuid($guid)
    {
      return $result = database::singleArgQuery("SELECT * FROM `mcnutty`.`hir2_sessions` WHERE `guid`=:arg LIMIT 1", $guid)[0];
    }
    
    static function setDiscount($val)
    {
      return database::singleArgQuery("UPDATE `mcnutty`.`hir2_events` SET `discount`=:arg;", $val);
    }
    
    static function setDiscountSides($val)
    {
      return database::singleArgQuery("UPDATE `mcnutty`.`hir2_events` SET `discountSides`=:arg;", $val);
    }
    
    static function setActive($val)
    {
      return database::singleArgQuery("UPDATE `mcnutty`.`hir2_events` SET `active`=:arg;", $val);
    }
    
    static function setLive($val)
    {
      return database::singleArgQuery("UPDATE `mcnutty`.`hir2_events` SET `live`=:arg;", $val);
    }
    
    static function setPaid($id)
    {
      return database::singleArgQuery("UPDATE `mcnutty`.`hir2_orders` SET `paid`=1 WHERE `id`=:arg;", $id);
    }
    
    static function setEntered($id)
    {
      return database::singleArgQuery("UPDATE `mcnutty`.`hir2_orders` SET `entered`=1 WHERE `id`=:arg;", $id);
    }
    
    static function deleteOrder($id)
    {
      return database::singleArgQuery("DELETE FROM `mcnutty`.`hir2_orders` WHERE `id`=:arg;", $id);
    }

    static function deleteGuid($guid)
    {
      return database::singleArgQuery("DELETE FROM `mcnutty`.`hir2_sessions` WHERE `guid`=:arg;", $guid);
    }
    
    static function setOrder($name, $order, $price, $paid)
    {
      $stmt = database::getDbh()->prepare("INSERT INTO `mcnutty`.`hir2_orders` (`id` ,`name` ,`order` ,`price` ,`paid`) VALUES (NULL ,  :name,  :order,  :price,  :paid);");
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':order', $order);
      $stmt->bindParam(':price', $price);
      $stmt->bindParam(':paid', $paid);
      if ($stmt->execute()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }
      return false;
    }
    
    static function setLog($name, $order, $price, $paid)
    {
      $stmt = database::getDbh()->prepare("INSERT INTO `mcnutty`.`hir2_log` (`id` ,`name` ,`order` ,`price` ,`cardTransaction`) VALUES (NULL ,  :name,  :order,  :price,  :cardTransaction);");
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':order', $order);
      $stmt->bindParam(':price', $price);
      $stmt->bindParam(':cardTransaction', $paid);
      if ($stmt->execute()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }
      return false;
    }

    static function setGuid($guid, $name, $order, $price, $price_stripe)
    {
      $stmt = database::getDbh()->prepare("INSERT INTO  `mcnutty`.`hir2_sessions` (`id` ,`guid`, `name`, `order` ,`price`, `price_stripe`) VALUES (NULL ,  :guid, :name, :order, :price, :price_stripe);");
      $stmt->bindParam(':guid', $guid);
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':order', $order);
      $stmt->bindParam(':price', $price);
      $stmt->bindParam(':price_stripe', $price_stripe);
      if ($stmt->execute()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }
      return false;
    }
}
?>