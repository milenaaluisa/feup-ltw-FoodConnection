<?php
  $db = new PDO('sqlite:database/database.db');

  $stmt = $db->prepare('SELECT *
                        FROM Category 
                        WHERE idCategory <> ?');
  $stmt->execute(array($_GET['id']));
  $categories = $stmt->fetchAll();

  $id = $_GET['id'];

  if($id == 0) {
    $stmt = $db->prepare('SELECT Restaurant.idRestaurant as idRest, name, averagePrice, averageRate
                          FROM Restaurant');
    $stmt->execute();
    $restaurants = $stmt->fetchAll();
  }

  else {
    $stmt = $db->prepare('SELECT Restaurant.idRestaurant as idRest, name, averagePrice, averageRate
                          FROM Restaurant
                          JOIN RestaurantCategory USING (idRestaurant) 
                          WHERE idCategory = ?');
    $stmt->execute(array($_GET['id']));
    $restaurants = $stmt->fetchAll();
  }
?>

<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>UberEats 9<!--mudar--></title>
        <meta charset="UTF-8">
        <link href="style.css" rel="stylesheet">
        <link href="layout.css" rel="stylesheet">
    </head>
    <body>
        <header>
            <a href="index.php"><img id="logo" src="https://picsum.photos/600/300?city" alt="Logo"></a>

            <div id="sign">
                <a href="login.php">Sign in</a> 
                <a href="register.php">Sign up</a>
            </div>

            <div id="search_bar">
                <form action="action_page.php">
                    <img src="https://picsum.photos/600/300?city" alt="search icon">
                    <input type="text" placeholder="Search..." name="search">
                </form>
            </div>

            <nav id="menu">
                <input type="checkbox" id="hamburger"> 
                <label class="hamburger" for="hamburger"></label>
                <ul>
                    <li><a href="user_profile.php"><img src="https://picsum.photos/600/300?city" class ="profile_photo" alt = "profile photo"></a></li>
                    <li><a href="user_profile.php">Luís Lima</a></li>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="favourites.php">Favourites</a></li>
                    <li><a href="order_history.php">Order History</a></li>
                    <li><a href="my_restaurants.php">My restaurants</a></li>
                    <li><a href="edit_profile.php">Edit profile</a></li>
                    <li><a href="logout.php">Sign Out</a></li>
                </ul>
            </nav>
        </header>

        <nav id="categories">
            <header>
                <h2><a href="index.php">Categories</a></h2>
            </header>
            <ul>
                <li><a href="category.php">All restaurants</a></li>
                <?php foreach($categories as $category) { ?>
                    <li><a href="category.php?id=<?= $category['idCategory'] ?>"><?= $category['name'] ?></a></li>
                <?php } ?>
            </ul>
        </nav>

        <main>
            <section id="restaurants">
                <h1>Restaurants</h1>
                <?php foreach($restaurants as $restaurant) { ?>
                    <article>
                        <header>
                            <h1><a href="restaurant.php?id=<?= $restaurant['idRest'] ?>"><?= $restaurant['name'] ?></a></h1>
                        </header>

                        <img src="https://picsum.photos/id/237/200/300">

                        <?php if($restaurant['averagePrice'] =< 10) { ?> <!-- TODO: definir estes valores -->
                                <span class="avgPrice"> € </span>
                        <?php }
                              else if($restaurant['averagePrice'] > 10 && $restaurant['averagePrice'] <= 45) { ?>
                                <span class="avgPrice"> €€ </span>
                        <?php }
                              else { ?>
                                <span class="avgPrice"> €€€ </span>
                        <?php } ?>
                        
                        <a class="rate" href=restaurant.php#reviews><?= $restaurant['averageRate'] ?></span>
                        
                        <!---TODO: LIKE BUTTON-->
                    </article>
                <?php } ?>
            </section>
        </main>

        <footer>
            <img src="https://picsum.photos/600/300?city" alt="FB Logo">
            <img src="https://picsum.photos/600/300?city" alt="IG Logo">
            <span>Privacy Policy</span>
            <span>Terms</span>
            <span>Pricing</span>
        </footer>
    </body>
</html>