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
                    <form action = "../actions/action_new_profile.php" method = "post">
                        <!--FALTA: INPUT DA FOTO-->
                        <input type="text" name="name" placeholder="name" required="required">
                        <input type="email" name="email" placeholder="email" required="required">  
                        <input type="number" name="phoneNum" placeholder="phone number" required="required">
                        <input type="text" name="address" placeholder="address" required="required">
                        <input type="text" name="city" placeholder="city" required="required">
                        <input type="text" name="zipCode" placeholder="zip code" required="required">
                        <input type="text" name="username" placeholder="username" required="required" minlenght="6">
                        <input type="password" name="password" placeholder="password" required="required" minlenght="8">
                        <a href="index.php">Cancel</a>
                        <button type="submit">Register</button>
                    </form>
                </article>
            </section>
        </main>
<?php } ?>


<?php
    function output_new_restaurant_form(array $categories) { ?>
        <main>
                <section id="owner_forms">
                    <article>
                        <header>
                            <h1>Add new restaurant</h1>
                        </header>
                        <form action="../actions/action_add_restaurant.php" method="post">
                            <input type="file" name="file" accept="image/png,image/jpeg">
                            <input type="text" name="name" placeholder="name" required="required">
                            <input type="number" name="number" placeholder="phone number" required="required">
                            <input type="text" name="address" placeholder="address" required="required">
                            <input type="text" name="city" placeholder="city" required="required">
                            <input type="text" name="zipCode" placeholder="zip code" required="required">
                            <select name="categories[]" multiple>
                                <option value="" disabled selected>category</option>
                                <?php foreach ($categories as $category) { ?>
                                    <option value="<?=$category['idCategory']?>"><?=$category['name']?></option>
                                <?php } ?>
                            </select>
                            <a href="my_restaurants.php">Cancel</a>
                            <button type="submit">Save</button>
                        </form>
                    </article>
                </section>
            </main>
<?php } ?>


<?php
    function output_new_dish_form(array $allergens, array $categories, int $idRestaurant) { ?>
        <main>
            <section id="owner_forms">
                <article>
                    <header>
                        <h1>Add new dish</h1>
                    </header>
                    <form action="../actions/action_add_dish.php" method="post">
                        <input type="hidden" name="idRestaurant" value="<?=$idRestaurant?>">
                        <input type="file" name="file" accept="image/png,image/jpeg">
                        <input type="text" name="name" placeholder="name" required="required">
                        <input type="number" name="price" placeholder="price" step = 0.01 required="required">
                        <input type="text" name="ingredients" placeholder="ingredients">
                        <select name="allergens[]" multiple>
                            <option value="" disabled selected>allergens</option>
                                <?php foreach ($allergens as $allergen) { ?>
                                    <option value="<?=$allergen['idAllergen']?>"><?=$allergen['name']?></option>
                                <?php } ?>
                        </select>

                        <select name="categories[]" multiple>
                                <option value="" disabled selected>category</option>
                                <?php foreach ($categories as $category) { ?>
                                    <option value="<?=$category['idCategory']?>"><?=$category['name']?></option>
                                <?php } ?>
                        </select>

                        <a href="my_restaurants.php">Cancel</a>
                        <button type="submit">Save</button>
                    </form>
                </article>
            </section>
        </main>
<?php } ?>  

<?php 
    function output_profile_form ($user) { ?>
        <main>
            <section>
                <article>
                    <header>
                        <h1><a href="edit_profile.php">Edit Profile</a></h1>
                    </header>
                    <form action = "../actions/action_edit_profile.php" method = "post" class = "edit_form">
                        <!--FALTA: INPUT DA FOTO-->
                        <label for="name">Name:</label>
                        <input type="text" name="name" value='<?=$user['name']?>' required="required">
                        
                        <label for="email">Email:</label>
                        <input type="email" name="email" value=<?=$user['email']?> required="required">  

                        <label for="phoneNum">Phone Number:</label>
                        <input type="number" name="phoneNum" value=<?=$user['phoneNum']?> required="required">

                        <label for="address">Address:</label>
                        <input type="text" name="address" value='<?=$user['address']?>' required="required">

                        <label for="city">City:</label>
                        <input type="text" name="city" value='<?=$user['city']?>' required="required">

                        <label for="zipCode">ZipCode:</label>
                        <input type="text" name="zipCode" value=<?=$user['zipCode']?> required="required">

                        <label for="username">Username:</label>
                        <input type="text" name="username" value=<?=$user['username']?> required="required" minlenght="6">

                        <label for="password">Password:</label>
                        <input type="password" name="password"  minlenght="8">

                        <a href="index.php">Cancel</a>
                        <button type="submit">Save</button>
                    </form>
                </article>
            </section>
        </main>

<?php } ?>