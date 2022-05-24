<?php
    declare(strict_types = 1);

    session_start();

  require_once('../database/connection.db.php');
  require_once('../database/categories.db.php');
  require_once('../database/restaurants.db.php');
  require_once('../templates/common.tpl.php');
  require_once('../templates/categories.tpl.php');
  require_once('../templates/restaurants.tpl.php');

  
  $db = getDatabaseConnection();

  $categories = getAllOtherCategories($db, intval($_GET['id']));

  if(intval($_GET['id']) == 0) $restaurants = getAllRestaurants($db);
  else $restaurants = getCategoryRestaurants($db, intval($_GET['id']));

  $css_files = array('restaurants_list.css');

  output_header($css_files);
  output_categories($categories);
  output_restaurant_list($restaurants);
  output_footer();
?>