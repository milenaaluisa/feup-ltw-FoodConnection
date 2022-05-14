<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>UberEats 9<!--mudar--></title>
        <meta charset="UTF-8">
        <link href="../css/style.css" rel="stylesheet">
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

        <main>
            <section id = "dishes">
                <article>
                    <header>
                        <h2><a href="dish.php">Dish 1</a></h2>
                    </header>
                    <img src="https://picsum.photos/600/300?city" alt="">
                    <span class="price">7.00</span>
                    <span class="rate"> 4</span>
                    <!---TODO: Like button-->
                    <div class = "composition">
                        <h3>Ingredients</h3>
                        <p>Tosta de pão de sementes, cogumelos, espinafres, ovos escalfados, molho holandês e cebolinho</p>
                        <h3>Allergens</h3>
                        <p>eggs, gluten</p>
                    </div>
                    <form action="action_add_order_item.php" method="post">
                        <input name="quantity" type="number" value="1" min="0" step="1">
                        <button type="submit">
                            Add to cart <img src="https://picsum.photos/600/300?city" alt="">
                        </button>
                    </form>
                    <a href=restaurant.php class="close"></a>
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