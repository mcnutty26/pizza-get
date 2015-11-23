<select class="form-control select select-primary" data-toggle="select" name="pizzaA">
  <? $result = database::getMenu();
  foreach ($result as $row) {
    if ($row['large'] != 0) {
      echo '<option value="' . $row['id'] . '" >' . $row['pizza'] . '</option>';
    }
  } ?>
</select>

(£<?=number_format((float)$price/$config['discount'], 2, '.', '')?>)