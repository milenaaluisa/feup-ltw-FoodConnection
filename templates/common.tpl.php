<?php declare(strict_types = 1); ?>
<?php require_once('../templates/user.tpl.php'); ?>

<?php 
    function output_header(array $css_files = null) { ?>
<!DOCTYPE html>
    <html lang="en-US">
    <head>
        <title>Food Connection</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/212cf37a16.js" crossorigin="anonymous"></script>
        <script src="../javascript/rate_stars.js" defer></script>
        <script src="../javascript/order_state.js" defer></script>
        <script src="../javascript/favorite_restaurant.js" defer></script>
        <script src="../javascript/favorite_dish.js" defer></script>
        <link href="../css/style.css" rel="stylesheet">
        <link href="../css/layout.css" rel="stylesheet">
        <link href="../css/forms.css" rel="stylesheet">
        <link href="../css/responsive.css" rel="stylesheet">
        <script src="../javascript/script.js" defer></script>
        <script src="../javascript/search_restaurant.js" defer></script>
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
                if (isset($_SESSION['idUser'])) output_logout($_SESSION['name']);
                else output_login();
            ?>

            <nav id="menu">
                <input type="checkbox" id="hamburger">
                <label for="hamburger">
                    <i class="fa fa-list" id="button"></i>
                    <i class="fa fa-close" id="cancel"></i>
                </label>
                <div class="sidebar">
                    <?php
                        if (isset($_SESSION['idUser'])) output_user_menu_options();
                        else output_guest_menu_options();
                    ?>
                </div>
            </nav>
        </header>
        <main>
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


<?php function output_guest_menu_options () { ?> 
    <ul>
        <li><a href="login.php">Sign in</a></li>
        <li><a href="register.php">Sign up</a></li>
    </ul>
<?php } ?>


<?php function output_user_menu_options () { ?> 
    <ul>
        <li><a href="edit_profile.php">
            <?php output_profile_photo($_SESSION['file'])?>
        </a></li>
        <li><a href="edit_profile.php"><?=$_SESSION['name']?></a></li>
        <li><a href="index.php">Home</a></li>
        <li><a href="favourites.php">Favourites</a></li>
        <li><a href="order_history.php">Order History</a></li>
        <li><a href="my_restaurants.php">My restaurants</a></li>
        <li><a href="edit_profile.php">Edit profile</a></li>
        <li><a href="logout.php">Sign Out</a></li>
    </ul>
<?php } ?>


<?php
    function output_footer() { ?>
        </main>
        <footer>
            <div>
                <a href = "https://github.com/FEUP-LTW-2022/ltw-t09-g01"> 
                    <i class="fa-brands fa-github"></i>
                    Follow us
                </a>
            </div>
            <div>
                <p>Privacy Policy</p>
                <p>Terms</p>
                <p>Pricing</p>
            </div>
            <div>
                <p>Copyright &copy; 2022 Food Connection</p>
            </div>
        </footer>
        </body>
    </html>
    <?php }
?>