<?php
    $db = new PDO('sqlite:database/database.db');

    $stmt = $db->prepare('SELECT FavRestaurant.username, Restaurant.*
                          FROM FavRestaurant
                          JOIN Restaurant USING (idRestaurant)
                          WHERE username /* QUANDO TRATAR DAS SESSOES*/');
    $stmt->execute(array($_GET['id']));
    $favourite_restaurants = $stmt->fetchAll();

    $stmt = $db->prepare('SELECT FavDish.username, Dish.*
                          FROM FavDish
                          JOIN Dish USING (idDish)
                          WHERE username /* QUANDO TRATAR DAS SESSOES*/');
    $stmt->execute(array($_GET['id']));
    $favourite_dishes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>UberEats 9</title><!--mudar-->
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

        <section id="favorites">
            <header>
                <h1>My Favourites</h1>
            </header>
            <section id="restaurants">
                <header>
                    <h2>Restaurants</h2>
                </header>
                <?php foreach($favourite_restaurants as $favourite_restaurant) { ?>
                    <article>
                        <header>
                            <h1><a href="restaurant.php?id=<?= $favourite_restaurant['idRestaurant'] ?>"><?= $favourite_restaurant['name'] ?></a></h1>
                        </header>

                        <img src="https://picsum.photos/id/237/200/300">

                        <?php if($favourite_restaurant['averagePrice'] < 5) { ?> <!-- TODO: definir estes valores -->
                                <span class="avgPrice"> € </span>
                        <?php }
                              else if($favourit_restaurante['averagePrice'] <= 10 || $favourite_restaurant['averagePrice'] >= 5) { ?>
                                <span class="avgPrice"> €€ </span>
                        <?php }
                              else { ?>
                                <span class="avgPrice"> €€€ </span>
                        <?php } ?>
                        
                        <a class="rate" href=restaurant.php#reviews><?= $favourite_restaurant['averageRate'] ?></span>
                        
                        <!---TODO: DISLIKE BUTTON-->
                    </article>
                <?php } ?>
            </section>

            <section id= "dishes">
                <header>
                    <h2>Dishes</h2>
                </header> 
                <?php foreach($favourite_dishes as $favourite_dish) { ?>
                    <article class="dish">
                        <header>
                            <h1><a href="dish.php?id=<?= $favourite_dish['idDish'] ?>"><?= $favourite_dish['name'] ?></a></h1>
                        </header>

                        <img src="..\images\<?= $favourite_dish['file'] ?>">

                        <span class="price"><?= $favourite_dish['price'] ?></span>

                        <span class="rate"><?= $favourite_dish['averageRate'] ?></span>

                        <!---TODO: dislike button-->
                    </article>
                <?php } ?>
            </section>
        </section>    
            
        <footer>
            <img src="https://picsum.photos/600/300?city" alt="FB Logo">
            <img src="https://picsum.photos/600/300?city" alt="IG Logo">
            <span>Privacy Policy</span>
            <span>Terms</span>
            <span>Pricing</span>
        </footer>
    </body>
</html>