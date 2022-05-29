<?php declare(strict_types = 1); ?>

<?php function output_rate_order_form() { ?>
    <main>
        <section id="user_forms">
            <article>
                <header>
                    <h1>Rate Your Order</h1>
                </header>
                <form action="action_rate_order.php" method="post">
                    <input name="quantity" type="number" value="1" min="1" max="5" step="1">
                    <textarea name="comment" placeholder="your comment"></textarea>
                    <a href="my_orders.php">Cancel</a>
                    <button type="submit">Post</button>
                </form>
            </article>
        </section>
    </main>
<?php }  ?>


<?php
    function output_login_form() { ?>
        <main>
            <section id="user_forms">
                <article>
                    <header>
                        <h1><a href="login.php">Login</a></h1>
                    </header>
                    <form action="../actions/action_login.php" method="post">
                        <input type="text" name="username" placeholder="username" required="required">
                        <input type="password" name="password" placeholder="password" required="required">
                        <a href="index.php">Cancel</a>
                        <button type="submit">Login</button>
                    </form>
                </article>
            </section>
        </main>
<?php } ?>


<?php
    function output_register_form() { ?>
        <main>
            <section id="user_forms">
                <article>
                    <header>
                        <h1><a href="register.php">Register</a></h1>
                    </header>
                    <form action = "action_new_profile.php" method = "post">
                        <!--FALTA: INPUT DA FOTO-->
                        <input type="text" name="name" placeholder="name" required="required" minlenght="6">
                        <input type="text" name="email" placeholder="email" required="required">  
                        <input type="number" name="phoneNum" placeholder="phone number" required="required">
                        <input type="text" name="adress" placeholder="adress" required="required">
                        <input type="text" name="city" placeholder="city" required="required">
                        <input type="text" name="zipCode" placeholder="zip code" required="required" minlenght="6">
                        <input type="text" name="username" placeholder="username" required="required">
                        <input type="password" name="password" placeholder="password" required="required">
                        <a href="index.php">Cancel</a>
                        <button type="submit">Register</button>
                    </form>
                </article>
            </section>
        </main>
<?php } ?>


<?php
    function output_new_restaurant_form() { ?>
        <main>
                <section id="owner_forms">
                    <article>
                        <header>
                            <h1>Add new restaurant</h1>
                        </header>
                        <form action="action_add_restaurant.php" method="post">
                            <input type="file" name="file" accept="image/png,image/jpeg">
                            <input type="text" name="name" placeholder="name" required="required">
                            <input type="number" name="number" placeholder="phone number" required="required">
                            <input type="text" name="address" placeholder="address" required="required">
                            <input type="text" name="city" placeholder="city" required="required">
                            <input type="text" name="zipCode" placeholder="zip code" required="required">
                            <select name="category" multiple>
                                <option value="" disabled selected>category</option>
                                <option value="Breakfast">Breakfast</option>
                                <option value="Vegetarian">Vegetarian</option>
                                <option value="Vegan">Vegan</option>
                                <option value="Japanese">Japanese</option>
                                <option value="Mexican">Mexican</option>
                                <option value="Indian">Indian</option>
                                <option value="Portuguese">Portuguese</option>
                                <option value="Fast-food">Fast-food</option>
                                <option value="Healthy">Healthy</option>
                                <option value="Dessert">Dessert</option>
                                <option value="Bakery">Bakery</option>
                                <option value="Drinks">Drinks</option>
                            </select>
                            <a href="my_restaurants.php">Cancel</a>
                            <button type="submit">Save</button>
                        </form>
                    </article>
                </section>
            </main>
<?php } ?>


<?php
    function output_new_dish_form() { ?>
        <main>
            <section id="owner_forms">
                <article>
                    <header>
                        <h1>Add new dish</h1>
                    </header>
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
                </article>
            </section>
        </main>
<?php } ?>    