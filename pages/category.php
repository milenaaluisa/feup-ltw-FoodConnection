<?php
  require_once('../database/connection.db.php');
  require_once('../database/categories.db.php');
  require_once('../database/restaurants.db.php');
  require_once('../templates/common.tpl.php');
  require_once('../templates/categories.tpl.php');
  require_once('../templates/restaurants.tpl.php');

  
  $db = getDatabaseConnection();

  $categories = getAllOtherCategories($db, $_GET['id']);

  if($_GET['id'] == 0) $restaurants = getAllRestaurants($db);
  else $restaurants = getCategoryRestaurants($db, $_GET['id']);

  output_header();
  output_categories($categories);
  output_restaurant_list($restaurants);
  output_footer();
?>