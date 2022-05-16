<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>UberEats 9<!--mudar--></title>
        <meta charset="UTF-8">
        <link href="../css/style.css" rel="stylesheet">
        <link href="../css/layout.css" rel="stylesheet">
        <link href="../css/forms.css" rel="stylesheet">
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

        <section id="restaurants" class="my_restaurants_page">
            <header>
                <h2>My Restaurants</h2>
            </header>
            <article>
                <header>
                    <h2><a href="restaurant.php">Restaurant 1</a></h2>
                </header>
                <a href="restaurant.php"><img src="https://picsum.photos/id/237/200/300" alt=""></a>
                <section class="info">
                    <h2>Shift:</h2>
                    <p> Business days: 8h00- 12h00 </p>
                    <p> Saturday: 13h00 - 14h30 </p>
                    <h2>Tel.:</h2>
                    <p>226170009</p>
                    <h2>Address: </h2>
                    <p>Rua do Passeio Alegre,368</p>    
                </section>   
            </article>

            <article>
                <header>
                    <h2><a href="restaurant.php">Restaurant 2</a></h2>
                </header>
                <a href="restaurant.php"><img src="https://picsum.photos/id/237/200/300" alt=""></a>
                <section class="info">
                    <h2>Shift:</h2>
                    <p> Business days: 12h00- 14h30 </p>
                    <p> Saturday: 13h00 - 14h30 </p>
                    <p> Sunday: 13h00 - 15h00 </p>
                    <h2>Tel.:</h2>
                    <p>967307887</p>
                    <h2>Address: </h2>
                    <p>Norteshopping, Rua Sara Afonso, 105-117</p>    
                </section>   
            </article>
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