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
            <a href="index.php"><img src="https://picsum.photos/600/300?city" alt="Logo"></a>

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

        <main>
            <section id="form">
                <h1>Add new dish</h1>
                <form action="action_add_restaurant.php" method="post">
                    <input type="file" name="file" accept="image/png,image/jpeg">
                    <input type="text" name="name" placeholder="name" required="required">
                    <input type="number" name="price" placeholder="price" step = 0.01 required="required">
                    <input type="text" name="ingredients" placeholder="ingredients">
                    <select name="allergens" multiple>
                        <option value="" disabled selected>allergens</option>
                        <option value="Celery">Celery</option>
                        <option value="Crustaceans">Crustaceans</option>
                        <option value="Dairy">Dairy</option>
                        <option value="Eggs">Eggs</option>
                        <option value="Fish">Fish</option>
                        <option value="Gluten">Gluten</option>
                        <option value="Lupin">Lupin</option>
                        <option value="Mustard">Mustard</option>
                        <option value="Peanuts">Peanuts</option>
                        <option value="Sesame">Sesame</option>
                        <option value="Soy">Soy</option>
                        <option value="Sulphur dioxide and sulphites">Sulphur dioxide and sulphites</option>
                        <option value="Nuts">Nuts</option>
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