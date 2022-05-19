<?php
    $db = new PDO('sqlite:database/database.db');
    
    $all_dishes = $stmt->fetchAll();

    $stmt = $db->prepare('SELECT Dish.*, file
                          FROM Dish
                          JOIN Photo USING (idDish)
                          WHERE Dish.idDish = ?');
    $stmt->execute(array($_GET['id']));
    $dish = $stmt->fetch();

    $stmt = $db->prepare('SELECT name
                          FROM DishAllergen
                          JOIN Allergen Using (idAllergen)
                          WHERE idDish = ?');
    $stmt->execute(array($_GET['id']));
    $allergens = $stmt->fetchAll();
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
            <section id=dish>
                <img src="..\images\<?= $dish['file'] ?>">

                <!---TODO: Like button-->
                
                <header>
                    <h1><a href="dish.php?id=<?= $dish['idDish'] ?>"><?php $dish['name'] ?></a></h1>
                </header>

                <section class="info">
                    <span class="price"><?php $dish['price'] ?></span>
                    <span class="rate"><?php $dish['averageRate'] ?></span>
                </section>

                <!---TODO: Like button-->

                <div class = "composition">
                    <h3>Ingredients</h3>
                    <p><?= $dish['ingredients'] ?></p>
                    <h3>Allergens</h3>
                    <p>
                    <?php foreach($allergens as $allergen) { ?>
                        <?= $allergen['name'] ?>
                    <?php } ?> </p>
                </div>

                <form action="action_add_order_item.php" method="post">
                    <input name="quantity" type="number" value="1" min="0" step="1">
                    <button type="submit">
                        Add to cart <!-- ICON DO CARRINHO-->
                    </button>
                </form>
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