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

        <main>
            <!--REGISTER FORM-->
            <section id="register">
                <h1><a href="register.php">Register</a></h1>
                <form action = "action_new_profile.php" method = "post">
                    <!--FALTA: INPUT DA FOTO-->
                    <input type="text" name="name" placeholder="name" required="required">
                    <input type="text" name="email" placeholder="email" required="required">  
                    <input type="number" name="phoneNum" placeholder="phone number" required="required">
                    <input type="text" name="adress" placeholder="adress" required="required">
                    <input type="text" name="city" placeholder="city" required="required">
                    <input type="text" name="zipCode" placeholder="zip code" required="required">
                    <input type="text" name="username" placeholder="username" required="required">
                    <input type="password" name="password" placeholder="password" required="required">
                    <a href="index.php">Cancel</a>
                    <button type="submit">Register</button>
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