<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>UberEats 9</title><!--mudar-->
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

        <section id="favorites">
            <header>
                <h1>My Favourites</h1>
            </header>
            <section id="restaurants" class = "light_bg_color">
                <header>
                    <h2>Restaurants</h2>
                </header>
                <article>
                    <header>
                        <h3><a href="restaurant.php">Restaurant 1</a></h3>
                    </header>
                    <a href="restaurant.php"><img src="https://picsum.photos/id/237/200/300" alt=""></a>
                    <span class="avgPrice"> €€ </span>
                    <span class="rate"> 4 </span>   
                    <!---TODO: LIKE BUTTON-->
                </article>

                <article>
                    <header>
                        <h3><a href="restaurant.php">Restaurant 2</a></h3>
                    </header>
                    <a href="restaurant.php"><img src="https://picsum.photos/id/237/200/300" alt=""></a>
                    <span class="avgPrice"> €€€ </span>
                    <span class="rate"> 5 </span>   
                    <!---TODO: LIKE BUTTON-->
                </article>

                <article>
                    <header>
                        <h3><a href="restaurant.php">Restaurant 3</a></h3>
                    </header>
                    <a href="restaurant.php"><img src="https://picsum.photos/id/237/200/300" alt=""></a>
                    <span class="avgPrice"> €€ </span>
                    <span class="rate"> 4 </span>   
                    <!---TODO: LIKE BUTTON-->
                </article>
            </section>

            <section id= "dishes" class = "light_bg_color">
                <header>
                    <h2>Dishes</h2>
                </header> 
                <article>
                    <header>
                        <h3><a href="dish.php">Dish 1</a></h3>
                    </header>
                    <a href="dish.php"><img src="https://picsum.photos/600/300?city" alt=""></a>
                    <span class="price">7.00</span>
                    <span class="rate"> 4</span>
                    <!---TODO: like button-->
                </article>

                <article>
                    <header>
                        <h3><a href="dish.php">Dish 2</a></h3>
                    </header>
                    <a href="dish.php"><img src="https://picsum.photos/600/300?city" alt=""></a>
                    <span class="price">6.00</span>
                    <span class="rate">5</span>
                    <!---TODO: like button-->
                </article>

                <article>
                    <header>
                        <h3><a href="dish.php">Dish 3</a></h3>
                    </header>
                    <a href="dish.php"><img src="https://picsum.photos/600/300?city" alt=""></a>
                    <span class="price">5.00</span>
                    <span class="rate">4</span>
                    <!---TODO: like button-->
                </article>
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