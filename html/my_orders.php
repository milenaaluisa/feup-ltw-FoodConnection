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
            <article>
                <header>
                    <h2><a href="restaurant.php">Restaurant 1</a></h2>
                </header>
                <a href="restaurant.php"><img src="https://picsum.photos/id/237/200/300" alt=""></a>
                <div class = "order_items">
                    <p><span class="quantity">2</span> copo 1 bola </p>
                    <span class="price">4.80</span>
                </div>
                <p>Subtotal: </p>
                <span class="price">4.80</span>
                <span class="date">27/04/2022</span>
                <span class="state">delivered</span>  
                <a href="rate_order.php">Rate Order </a>
                <a href="re_order.php"> Re-order </a>   
            </article>

            <article>
                <header>
                    <h2><a href="restaurant.php">Restaurant 2</a></h2>
                </header>
                <a href="restaurant.php"><img src="https://picsum.photos/id/237/200/300" alt=""></a>
                <div class = "order_items">
                    <p><span class="quantity">1</span>Pizza Diavola</p>
                    <span class="price">13.00</span>
                    <p><span class="quantity">1</span>Cheesecake de Framboesa</p>
                    <span class="price">5.00</span>
                </div>
                <p>Subtotal: </p>
                <span class="price">18.00</span>
                <span class="date">29/04/2022</span>
                <span class="state">ready</span>  
                <a href="rate_order.php">Rate Order </a>
                <a href="re_order.php">Re-order </a>  
            </article>
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