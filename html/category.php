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

        <nav id="categories">
            <ul>
                <li><a href="category.php">All restaurants</a></li>
                <li><a href="category.php">Category 1</a></li>
                <li><a href="category.php">Category 2</a></li>
                <li><a href="category.php">Category 3</a></li>
                <li><a href="category.php">Category 4</a></li>
            </ul>
        </nav>

        <main>
            <section id="restaurants">
                <header>
                    <h1>Breakfast</h1>
                </header>
                <article>
                    <header>
                        <h2><a href="restaurant.php">Restaurant 1</a></h2>
                    </header>
                    <a href="restaurant.php"><img src="https://picsum.photos/id/237/200/300" alt=""></a>
                    <span class="avgPrice"> €€ </span>
                    <a class="rate" href=restaurant.php#reviews> 4 </a>   
                    <!---TODO: LIKE BUTTON-->
                </article>

                <article>
                    <header>
                        <h2><a href="restaurant.php">Restaurant 2</a></h2>
                    </header>
                    <a href="restaurant.php"><img src="https://picsum.photos/id/237/200/300" alt=""></a>
                    <span class="avgPrice"> €€€ </span>
                    <a class="rate" href=restaurant.php#reviews> 5 </a>   
                    <!---TODO: LIKE BUTTON-->
                </article>

                <article>
                    <header>
                        <h2><a href="restaurant.php">Restaurant 3</a></h2>
                    </header>
                    <a href="restaurant.php"><img src="https://picsum.photos/id/237/200/300" alt=""></a>
                    <span class="avgPrice"> €€ </span>
                    <a class="rate" href=restaurant.php#reviews> 4 </a>   
                    <!---TODO: LIKE BUTTON-->
                </article>

                <article>
                    <header>
                        <h2><a href="restaurant.php">Restaurant 3</a></h2>
                    </header>
                    <a href="restaurant.php"><img src="https://picsum.photos/id/237/200/300" alt=""></a>
                    <span class="avgPrice"> €€ </span>
                    <a class="rate" href=restaurant.php#reviews> 4 </a>   
                    <!---TODO: LIKE BUTTON-->
                </article>

                <article>
                    <header>
                        <h2><a href="restaurant.php">Restaurant 3</a></h2>
                    </header>
                    <a href="restaurant.php"><img src="https://picsum.photos/id/237/200/300" alt=""></a>
                    <span class="avgPrice"> €€ </span>
                    <a class="rate" href=restaurant.php#reviews> 4 </a>   
                    <!---TODO: LIKE BUTTON-->
                </article>

                <article>
                    <header>
                        <h2><a href="restaurant.php">Restaurant 3</a></h2>
                    </header>
                    <a href="restaurant.php"><img src="https://picsum.photos/id/237/200/300" alt=""></a>
                    <span class="avgPrice"> €€ </span>
                    <a class="rate" href=restaurant.php#reviews> 4 </a>   
                    <!---TODO: LIKE BUTTON-->
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