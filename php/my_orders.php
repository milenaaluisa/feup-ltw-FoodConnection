<?php
    $db = new PDO('sqlite:database/database.db');

    $stmt = $db->prepare('SELECT FoodOrder.*, Restaurant.name as restName
                          FROM FoodOrder
                          JOIN Selection USING (idFoodOrder)
                          JOIN Dish USING (idDish)
                          JOIN Restaurant USING (idRestaurant)
                          WHERE username /*QUANDO TRATAR DAS SESSOES*/');
    $stmt->execute(array($_GET['id']));
    $my_orders = $stmt->fetchAll();

    $stmt = $db->prepare('SELECT Dish.*, Selection.*, FoodOrder.*
                          FROM Dish
                          JOIN Selection USING (idDish)
                          JOIN FoodOrder USING (idFoodOrder)
                          WHERE username /*QUANDO TRATAR DAS SESSOES*/');
    $stmt->execute(array($_GET['id']));
    $ordered_dishes = $stmt->fetchAll();
    
    $subtotal = 0;
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

        <section id="orders">
            <header>
                <h1>Order History</h1>
            </header>
            <?php foreach($my_orders as $my_order) { ?>
                <article>
                    <header>
                        <h2><a href="restaurant.php?id=<?= $my_order['idRestaurant'] ?>"><?= $my_order['restName'] ?></a></h2>
                    </header>
                    <a href="restaurant.php?id=<?= $my_order['idRestaurant'] ?>"><img src="https://picsum.photos/id/237/200/300" alt=""></a>
                    <div class = "order_items">
                        <?php foreach($ordered_dishes as $ordered_dish) { ?>
                            <p><span class="quantity"><?= $ordered_dish['quantity'] ?></span> <?= $ordered_dish['name'] ?> </p>
                            <span class="price"><?= $ordered_dish['quantity'] * $ordered_dish['price'] ?></span>
                        <?php $subtotal += $ordered_dish['quantity'] * $ordered_dish['price'];
                            } ?>
                    </div>
                    <p>Subtotal: </p>
                    <span class="price"><?= $subtotal ?>€</span>
                    <span class="date"><?= $my_order['orderDate'] ?></span>
                    <span class="state"><?= $my_order['state'] ?>/span>  
                    <a href="rate_order.php?id=<?= $my_order['idFoodOrder'] ?>">Rate Order </a><!--reorder php vai ser pagina?-->
                    <a href="re_order.php?id=<?= $my_order['idFoodOrder'] ?>"> Re-order </a>   
                </article>
            <?php } ?>
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