<?php
    $db = new PDO('sqlite:database/database.db');

    $stmt = $db->prepare('SELECT *
                          FROM Restaurant
                          WHERE idRestaurant = ?');
    $stmt->execute(array($_GET['id']));
    $restaurant = $stmt->fetch();

    $stmt = $db->prepare('SELECT *
                          FROM Category
                          JOIN RestaurantCategory USING (idCategory)
                          WHERE idRestaurant = ?');
    $stmt->execute(array($_GET['id']));
    $categories = $stmt->fetchAll();

    $stmt = $db->prepare('SELECT Shift.*
                          FROM Shift
                          JOIN RestaurantShift USING (idShift)
                          WHERE idRestaurant = ?');
    $stmt->execute(array($_GET['id']));
    $shifts = $stmt->fetchAll();

    $stmt = $db->prepare('SELECT idDish, name, price, averageRate, file
                          FROM Dish
                          JOIN Photo USING (idDish)
                          WHERE Dish.idRestaurant = ?');
    $stmt->execute(array($_GET['id']));
    $dishes = $stmt->fetchAll();

    $stmt = $db->prepare('SELECT Review.*
                          FROM Review
                          JOIN Dish USING (idDish)
                          JOIN Restaurant USING (idRestaurant)
                          WHERE Dish.idRestaurant = ?');
    $stmt->execute(array($_GET['id']));
    $reviews = $stmt->fetchAll();
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

        <main>
            <section id="restaurants">
                <article class="restaurant">
                    <header>
                        <h1><a href="restaurant.php?id=<?= $restaurant['idRest'] ?>"><?= $restaurant['name'] ?></a></h1>
                    </header>

                    <img src= "https://picsum.photos/600/300?city">

                    <!---TODO: Like button-->

                    <nav id="categories">
                        <ul>
                            <?php foreach($categories as $category) { ?>
                                <li><a href="category.php?id=<?= $category['idCategory'] ?>"><?= $category['name'] ?></a></li>
                            <?php } ?>
                        </ul>
                    </nav>

                    <section class="info">
                        <h2>Shift:</h2>
                        <?php foreach($shifts as $shift) { ?>
                            <p><?= $shift['day'] ?>: <?= $shift['openingTime'] ?>-<?= $shift['closingTime'] ?></p>
                        <?php } ?>
                        <h2>Address:</h2>
                        <p><?= $restaurant['address'] ?></p>
                        <h2>Tel.:</h2>
                        <p><?= $restaurant['phoneNum'] ?></p>
                    </section>   
                    
                    <section id="dishes"> 
                        <header>Dishes</header>
                        <?php foreach($dishes as $dish) { ?>
                            <article class="dish">
                                <header>
                                    <h1><a href="dish.php?id=<?= $dish['idDish'] ?>"><?= $dish['name'] ?></a></h1>
                                </header>

                                <img src="..\images\<?= $dish['file'] ?>">

                                <span class="price"><?= $dish['price'] ?></span>

                                <span class="rate"><?= $dish['averageRate'] ?></span>

                                <!---TODO: like button-->
                            </article>
                        <?php } ?>
                    </section>

                    <!-- acrescentar codigo order -->

                    <section id="reviews">
                        <h1>Reviews</h1>
                        <?php foreach($reviews as $review) { ?>
                            <article class="review">
                                <span class="user"><?= $review['username'] ?> said:</span>
                                <span class="rate"><?= $review['rate'] ?></span>
                                <p><?= $review['comment'] ?></p>
                                <span class="date"><?= $review['reviewDate'] ?></span>
                            </article> 
                        <?php } ?>
                    </section>

                </article> 
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