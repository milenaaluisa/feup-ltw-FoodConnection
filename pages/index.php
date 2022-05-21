<?php
  require_once('../database/connection.db.php');
  require_once('../database/categories.db.php');
  require_once('../templates/common.tpl.php');
  require_once('../templates/categories.tpl.php');
  
  $db = getDatabaseConnection();

  $categories = getAllCategories($db);

  output_header();
  output_categories($categories);
  output_footer()
?>