<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>UberEats 9<!--mudar--></title>
        <meta charset="UTF-8">
        <link href="../css/style.css" rel="stylesheet">
        <link href="../css/layout.css" rel="stylesheet">
        <link href="../css/forms.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <header>
            <a href="index.php"><img src="../images/FoodConnection.jpg" alt="Logo"></a>

            <div>
                <a href="login.php">Sign in</a> 
                <a href="register.php">Sign up</a>
            </div>

            <div>
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

        <nav>
            <h2><a href="index.php">Categories</a></h2>
            <ul>
                <li><a href="category.php">All restaurants</a></li>
                <li><a href="category.php">Category 1</a></li>
                <li><a href="category.php">Category 2</a></li>
                <li><a href="category.php">Category 3</a></li>
                <li><a href="category.php">Category 4</a></li>
                <li><a href="category.php">Category 4</a></li>
                <li><a href="category.php">Category 4</a></li>
                <li><a href="category.php">Category 4</a></li>
                <li><a href="category.php">Category 4</a></li>  
            </ul>
        </nav>
        
        <footer>
            <i class="fa fa-facebook" alt="FB Logo"></i>
            <i class="fa fa-instagram" alt="IG Logo"></i>
            <span>Privacy Policy</span>
            <span>Terms</span>
            <span>Pricing</span>
        </footer>
    </body>
</html>