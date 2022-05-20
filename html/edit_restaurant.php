<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>UberEats 9<!--mudar--></title>
        <meta charset="UTF-8">
        <link href="../css/style.css" rel="stylesheet">
        <link href="../css/layout.css" rel="stylesheet">
        <link href="../css/forms.css" rel="stylesheet">
        <link href="../css/edit_restaurant.css" rel="stylesheet">
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
        
        <nav>
                <ul>
                    <li><a href="category.php">Category 1</a></li>
                    <li><a href="category.php">Category 2</a></li>
                    <li><a href="category.php">Category 3</a></li>
                    <li><a href="category.php">Category 4</a></li>
                    <li><a href="category.php">Category 5</a></li>
                    <li><a href="category.php">Category 6</a></li>
                    <li><a href="category.php">Category 7</a></li>
                    <li><a href="category.php">Category 8</a></li>
                    <li><a href="category.php">Category 9</a></li>
                    <li><a href="category.php">Category 10</a></li>
                    <li><a href="category.php">Category 11</a></li>
                    <li><a href="category.php">Category 12</a></li>
                    <li><a href="category.php">Category 13</a></li>
                </ul>
        </nav>

        <main>
            <section id="restaurants">
                <article>
                    <header>
                        <h1><a href="restaurant.php">Restaurant 1</a></h1>
                    </header>
                    <a href="restaurant.php"><img src="https://picsum.photos/id/237/200/300" alt=""></a>
                    <div class = "edit_options">
                        <a href="edit_info_restaurant.php">Edit Info</a>
                        <a href="add_dish.php">Add Dish</a>
                    </div>

                    <section class="info">
                        <h2>Shift:</h2>
                        <p> 8h00-12h00</p>
                        <h2>Address: </h2>
                        <p>Rua do Passeio Alegre,368</p>
                        <h2>Tel.:</h2>
                        <p>226170009</p>
                    </section>
                    
                    <section id="dishes"> 
                        <header>Dishes</header>
                    
                        <article>
                            <header>
                                <h1><a href="dish.php">Dish 1</a></h1>
                            </header>
                            <a href="dish.php"><img src="https://picsum.photos/600/300?city" alt=""></a>
                            <span class="price">7.00</span>
                            <span class="rate"> 4</span>
                            <div class = "edit_options">
                                <a href="edit_info_dish.php">Edit Info</a>
                            </div>
                        </article>

                        <article>
                            <header>
                                <h1><a href="dish.php">Dish 2</a></h1>
                            </header>
                            <a href="dish.php"><img src="https://picsum.photos/600/300?city" alt=""></a>
                            <span class="price">6.00</span>
                            <span class="rate">5</span>
                            <div class = "edit_options">
                                <a href="edit_info_dish.php">Edit Info</a>
                            </div>
                        </article>

                        <article>
                            <header>
                                <h1><a href="dish.php">Dish 3</a></h1>
                            </header>
                            <a href="dish.php"><img src="https://picsum.photos/600/300?city" alt=""></a>
                            <span class="price">5.00</span>
                            <span class="rate">4</span>
                            <div class = "edit_options">
                                <a href="edit_info_dish.php">Edit Info</a>
                            </div>
                        </article>

                        <article>
                            <header>
                                <h1><a href="dish.php">Dish 4</a></h1>
                            </header>
                            <a href="dish.php"><img src="https://picsum.photos/600/300?city" alt=""></a>
                            <span class="price">4.50</span>
                            <span class="rate">3</span>
                            <div class = "edit_options">
                                <a href="edit_info_dish.php">Edit Info</a>
                            </div>
                        </article>

                        <article>
                            <header>
                                <h1><a href="dish.php">Dish 5</a></h1>
                            </header>
                            <a href="dish.php"><img src="https://picsum.photos/600/300?city" alt=""></a>
                            <span class="price">3.50</span>
                            <span class="rate">4</span>
                            <div class = "edit_options">
                                <a href="edit_info_dish.php">Edit Info</a>
                            </div>
                        </article>

                        <article>
                            <header>
                                <h1><a href="dish.php">Dish 6</a></h1>
                            </header>
                            <a href="dish.php"><img src="https://picsum.photos/600/300?city" alt=""></a>
                            <span class="price">3.25</span>
                            <span class="rate">4</span>
                            <div class = "edit_options">
                                <a href="edit_info_dish.php">Edit Info</a>
                            </div>
                        </article>
                    </section>

                    <section id="reviews">
                        <h2>Reviews</h2>
                        <article>
                            <div> 
                                <img src="https://picsum.photos/600/300?city" class ="profile_photo" alt = "profile photo">
                                <span class="user">user1</span>
                                <span class="rate">3</span>
                                <span class="date">1m</span>
                                <p>Aliquam maximus commodo dui, ut viverra urna vulputate et. Donec posuere vitae sem sed vehicula. Sed in erat eu diam fringilla sodales. Aenean lacinia vulputate nisl, dignissim dignissim nisl. Nam at nibh mollis, facilisis nibh sit amet, mattis urna. Maecenas.</p>
                            </div> 
                        </article> 

                        <article>
                            <div> 
                                <img src="https://picsum.photos/600/200?city" class ="profile_photo" alt = "profile photo">
                                <span class="user">user2</span>
                                <span class="rate">4</span>
                                <span class="date">3w</span>
                                <p>Aliquam maximus commodo dui, ut viverra urna vulputate et. Donec posuere vitae sem sed vehicula. Sed in erat eu diam fringilla sodales. Aenean lacinia vulputate nisl, dignissim dignissim nisl. Nam at nibh mollis, facilisis nibh sit amet, mattis urna. Maecenas.</p>
                            </div>
                            <img src= "https://picsum.photos/300/200?city" alt = "review photo">
                        </article> 

                        <article>
                            <div> 
                                <img src="https://picsum.photos/600/200?city" class ="profile_photo" alt = "profile photo">
                                <span class="user">user3</span>
                                <span class="rate">4</span>
                                <span class="date">1m</span>
                                <p>Aliquam maximus commodo dui, ut viverra urna vulputate et. Donec posuere vitae sem sed vehicula. Sed in erat eu diam fringilla sodales. Aenean lacinia vulputate nisl, dignissim dignissim nisl. Nam at nibh mollis, facilisis nibh sit amet, mattis urna. Maecenas.</p>
                            </div>
                            <img src= "https://picsum.photos/300/200?city" alt = "review photo">
                        </article> 
                    </section> 
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