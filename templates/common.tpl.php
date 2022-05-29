<?php declare(strict_types = 1); ?>

<?php 
    function output_header(array $css_files = null) { ?>
        <!DOCTYPE html>
    <html lang="en-US">
    <head>
        <title>Food Connection</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
        <link href="../css/layout.css" rel="stylesheet">
        <link href="../css/forms.css" rel="stylesheet">
        <link href="../css/responsive.css" rel="stylesheet">
        <?php if(isset ($css_files)) {
            foreach ($css_files as $css_file) {
                $css_file = "../css/" . "$css_file"; ?>
                <link href= <?=$css_file?> rel="stylesheet">
           <?php }
        } ?>
    </head>
    <body>
        <header>
            <a href="index.php"><img src="../images/FoodConnection.jpg" alt="Logo"></a>

            <?php
                if (isset($_SESSION['username'])) output_logout($_SESSION['name']);
                else output_login();
            ?>

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
    <?php } ?>


 <?php function output_login() { ?>
    <div>
        <a href="login.php">Sign in</a> 
        <a href="register.php">Sign up</a>
    </div>
<?php } ?>


<?php function output_logout (string $name) { ?> 
    <div>
        <?=$_SESSION['name']?>
        <a href="../actions/action_logout.php">Logout</a>
    </div>
<?php } ?>


<?php
    function output_footer() { ?>
        <footer>
            <i class="fa fa-facebook" alt="FB Logo"></i>
            <i class="fa fa-instagram" alt="IG Logo"></i>
            <span>Privacy Policy</span>
            <span>Terms</span>
            <span>Pricing</span>
        </footer>
        </body>
    </html>
    <?php }
?>