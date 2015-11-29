<?
class pizza_helper{
  
  static function get_size_name($size){
    if ($size == "1") {
      return "large";
    } else if ($size == "2") {
      return "medium";
    } else if ($size == "3") {
      return "small";
    } else if ($size == "4") {
      return "personal";
    }
    return false;
  }
  
  static function get_pizza_price($pizza, $size_name){
    return database::getPizza($pizza)[$size_name];
  }
  
  static function get_crust_name($crust, $size){
    if ($crust == "a") {
      return "Normal Crust";
    } else if ($crust == "b" and $size < 4) {
      return "Italian Crust";
    } else if ($crust == "c" and $size < 3) {
      return "Thin and Crispy Crust";
    } else if ($crust == "d" and $size < 3) {
      return "Stuffed Crust";
    } else if ($crust == "e" and $size < 3) {
      return "Hotdog Stuffed Crust";
    } else if ($crust == "f" and $size < 3) {
      return "BBQ Stuffed Crust";
    } else if ($crust == "g" and $size < 3) {
      return "Hotdog Stuffed Crust with Mustard";
    }
    return false;
  }
  
  static function get_crust_price($crust, $size){
    if ($crust == "d" or $crust == "e" or $crust == "f" or $crust == "g") {
      if ($size < 3) {
      return 250;
      } else {
        return false;
      }
    }
    return 0;
  }
  
  static function get_sides_name($post){
    $result = database::getSides();
    $sides = "";
    
    foreach ($result as $row) {
      if (isset($post['side' . $row['id']])) {
        if ($sides == "") {
          $sides = " and " . $row['name'];
        } else {
          $sides = $sides . ', ' . $row['name'];
        }
      }
    }
    return $sides;
  }
  
  static function get_sides_price($post){
    $result = database::getSides();
    $price = 0;
    
    foreach ($result as $row) {
      if (isset($post['side' . $row['id']])) {
        $price += $row['price'];
      }
    }
    return $price;
  }
  
  static function get_toppings_name($post, $pizza){
    $toppings = database::getToppings();
    $ingredients = database::getIngredients($pizza);
    $toppings_name = "";
    $all_toppings = array();
    $base_toppings = array();
    
    foreach ($toppings as $row) {
      if (isset($post['topping' . $row['id']])) {
        $all_toppings[$row['id']] = $row['id'];
      }
    }
    
    foreach ($ingredients as $row){
      $base_toppings[$row['topping']] = $row['topping'];
    }
        
    $toppings_count = 0;
    foreach (array_diff($all_toppings, $base_toppings) as $extra){
      if ($toppings_count == 0) {
        $toppings_name = 'with ' . database::getToppings()[$extra-1]['name'];
      } else {
        $toppings_name = $toppings_name . ', ' . database::getToppings()[$extra-1]['name'];
      }
        $toppings_count++;
    }
    
    $toppings_count = 0;
    foreach (array_diff($base_toppings, $all_toppings) as $extra){
      if ($toppings_count == 0) {
        $toppings_name = $toppings_name . ' but no ' . database::getToppings()[$extra-1]['name'];
      } else {
        $toppings_name = $toppings_name . ', ' . database::getToppings()[$extra-1]['name'];
      }
        $toppings_count++;
    }

    return $toppings_name;
  }
  
  static function get_toppings_price($post, $pizza, $size){
    $toppings = database::getToppings();
    $baseline = database::getIngredientCount($pizza);
    $toppings_count = 0;
    $topping_price = 0;
    $price = 0;
    
    if ($size == "1") {
      $topping_price = 130;
    } else if ($size == "2") {
      $topping_price = 120;
    } else if ($size == "3") {
      $topping_price = 100;
    } else if ($size == "4") {
      $topping_price = 80;
    } 
      
    foreach ($toppings as $row) {
      if (isset($post['topping' . $row['id']])) {
        $topping_count++;
        if ($topping_count > $baseline) {
          $price += $topping_price;
        }
      }
    }
    
    $toppings = database::getToppings();
    $ingredients = database::getIngredients($pizza);
    $all_toppings = array();
    $base_toppings = array();
    
    foreach ($toppings as $row) {
      if (isset($post['topping' . $row['id']])) {
        $all_toppings[$row['id']] = $row['id'];
      }
    }
    
    foreach ($ingredients as $row){
      $base_toppings[$row['topping']] = $row['topping'];
    }
        
    $toppings_count = 0;
    foreach (array_diff($all_toppings, $base_toppings) as $extra){
        $toppings_count++;
    }
    
    $toppings_count_2 = 0;
    foreach (array_diff($base_toppings, $all_toppings) as $extra){
        $toppings_count_2++;
    }
    
    if ($toppings_count > 2 and $toppings_count_2 > 2){
      $price += max($topping_price * (min($toppings_count, $toppings_count_2) - 2), 0);
    }
      
    return $price;
  }
  
  static function get_sauce_name($post){
    if ($post['sauce'] == "on") {
      return "Tomato Sauce";
    } else if ($post['bsauce'] == "on") {
      return "BBQ Sauce";
    }
    return "No Sauce";
  }
}