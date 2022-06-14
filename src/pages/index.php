<?php
  declare(strict_types = 1);

  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/category.class.php');
  require_once('../templates/common.tpl.php');
  require_once('../templates/category.tpl.php');

  $db = getDatabaseConnection();

  $categories = Category::getAllCategories($db);

  output_header();
  output_categories($categories);
  output_footer();
?>