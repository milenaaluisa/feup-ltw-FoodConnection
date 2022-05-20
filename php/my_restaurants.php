<?php
    require_once('./database/connection.db.php');
    require_once('./database/restaurants.db.php');
  
    $db = getDatabaseConnection();

    $my_restaurants = getUserRestaurants($db, $_GET['id']);
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
            <a href="index.php"><img class="logo" src="https://picsum.photos/600/300?city" alt="Logo"></a>

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

        <section id="restaurants">
            <header>
                <h2>My Restaurants</h2>
            </header>
            <?php foreach($my_restaurants as $my_restaurant) { ?>
                <article>
                    <header>
                        <h2><a href="restaurant.php"><?= $my_restaurant['name'] ?></a></h2>
                    </header>
                    <a href="restaurant.php"><img src="https://picsum.photos/id/237/200/300" alt=""></a>
                    <section class="info">
                        <h2>Tel.:</h2>
                        <p><?= $my_restaurant['phoneNum'] ?></p>
                        <h2>Address: </h2>
                        <p><?= $my_restaurant['address'] ?></p>    
                    </section>   
                </article>
            <?php } ?>
        </section>
        <a href="action_register_restaurant.php">Add new restaurant</a>

        <footer>
            <img src="https://picsum.photos/600/300?city" alt="FB Logo">
            <img src="https://picsum.photos/600/300?city" alt="IG Logo">
            <span>Privacy Policy</span>
            <span>Terms</span>
            <span>Pricing</span>
        </footer>
    </body>
</html>