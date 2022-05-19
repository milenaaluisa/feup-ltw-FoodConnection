<?php
  $db = new PDO('sqlite:database.db');

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
                    <li><a href="user_profile.php">LuÃ­s Lima</a></li>
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
            <section id=form>
                <h1>Add new restaurant</h1>
                <form action="action_add_restaurant.php" method="post">
                    <input type="file" name="file" accept="image/png,image/jpeg">
                    <input type="text" name="name" placeholder="name" required="required">
                    <input type="number" name="number" placeholder="phone number" required="required">
                    <input type="text" name="address" placeholder="address" required="required">
                    <input type="text" name="city" placeholder="city" required="required">
                    <input type="text" name="zipCode" placeholder="zip code" required="required">
                    <select name="category" multiple>
                        <option value="" disabled selected>category</option>
                        <option value="Breakfast">Breakfast</option>
                        <option value="Vegetarian">Vegetarian</option>
                        <option value="Vegan">Vegan</option>
                        <option value="Japanese">Japanese</option>
                        <option value="Mexican">Mexican</option>
                        <option value="Indian">Indian</option>
                        <option value="Portuguese">Portuguese</option>
                        <option value="Fast-food">Fast-food</option>
                        <option value="Healthy">Healthy</option>
                        <option value="Dessert">Dessert</option>
                        <option value="Bakery">Bakery</option>
                        <option value="Drinks">Drinks</option>
                    </select>
                    <a href="my_restaurants.php">Cancel</a>
                    <button type="submit">Save</button>
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