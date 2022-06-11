<?php declare(strict_types = 1); ?>

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
                <article class = "register">
                    <header>
                        <h1><a href="register.php">Register</a></h1>
                    </header>
                    <form action = "../actions/action_new_profile.php" method = "post" enctype="multipart/form-data">
                        <input type="file" name="photo" id ="file">
                        <label for="file">insert photo <i class="fa-solid fa-camera"></i></label>

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
    function output_profile_form (User $user) { ?>
        <main>
            <section id="user_forms">
                <article>
                    <header>
                        <h1><a href="edit_profile.php">Edit Profile</a></h1>
                    </header>
                    <form action = "../actions/action_edit_profile.php" method = "post" enctype="multipart/form-data">
                        <?php 
                            if (isset($user->file)) { ?>
                                <img src="../images/users/<?= $user->file ?>" alt="">
                                <input type="file" name="photo" id ="file">
                                <label for="file">change photo <i class="fa-solid fa-pen-to-square"></i></label>
                            <?php }
                            
                            else { ?>
                                <input type="file" name="photo" id ="file">
                                <label for="file">insert photo <i class="fa-solid fa-camera"></i></label>
                        <?php } ?>
                        <label for="name">Name:</label>
                        <input type="text" name="name" value="<?=$user->name?>" required="required">
                        
                        <label for="email">Email:</label>
                        <input type="email" name="email" value="<?=$user->email?>" required="required">  

                        <label for="phoneNum">Phone Number:</label>
                        <input type="number" name="phoneNum" value="<?=$user->phoneNum?>" required="required">

                        <label for="address">Address:</label>
                        <input type="text" name="address" value="<?=$user->address?>" required="required">

                        <label for="city">City:</label>
                        <input type="text" name="city" value="<?=$user->city?>" required="required">

                        <label for="zipCode">ZipCode:</label>
                        <input type="text" name="zipCode" value="<?=$user->zipCode?>" required="required">

                        <label for="username">Username:</label>
                        <input type="text" name="username" value="<?=$user->username?>" required="required" minlenght="6">

                        <label for="password">Password:</label>
                        <input type="password" name="password"  minlenght="8">

                        <a href="index.php">Cancel</a>
                        <button type="submit">Save</button>
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
                        <form action="../actions/action_add_restaurant.php" method="post" enctype="multipart/form-data">
                            <input type="file" name="photo" id ="file">
                            <label for="file">insert photo <i class="fa-solid fa-camera"></i></label>

                            <input type="text" name="name" placeholder="name" required="required">
                            <input type="number" name="number" placeholder="phone number" required="required">
                            <input type="text" name="address" placeholder="address" required="required">
                            <input type="text" name="city" placeholder="city" required="required">
                            <input type="text" name="zipCode" placeholder="zip code" required="required">
                            <select name="categories[]" multiple>
                                <option value="" disabled selected>category</option>
                                <?php foreach ($categories as $category) { ?>
                                    <option value="<?=$category->idCategory?>"><?=$category->name?></option>
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
    function output_edit_restaurant_form(Restaurant $restaurant) { ?>
        <main>
                <section id="owner_forms">
                    <article>
                        <header>
                            <h1>Edit restaurant</h1>
                        </header>
                        <form action="../actions/action_edit_restaurant.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="idRestaurant" value="<?=$restaurant->idRestaurant?>">
                            <?php 
                                if (isset($restaurant->file)) { ?>
                                    <img src="../images/restaurants/<?= $restaurant->file ?>" alt="">
                                    <input type="file" name="photo" id ="file">
                                    <label for="file">change photo <i class="fa-solid fa-pen-to-square"></i></label>
                                <?php }
                                
                                else { ?>
                                    <input type="file" name="photo" id ="file">
                                    <label for="file">insert photo <i class="fa-solid fa-camera"></i></label>
                            <?php } ?>
                            

                            <label for="name">Name:</label>
                            <input type="text" name="name" value='<?=$restaurant->name?>' required="required">

                            <label for="number">Phone number:</label>
                            <input type="number" name="number" value='<?=$restaurant->phoneNum?>' required="required">

                            <label for="address">Address:</label>
                            <input type="text" name="address" value='<?=$restaurant->address?>' required="required">

                            <label for="city">City:</label>
                            <input type="text" name="city" value='<?=$restaurant->city?>' required="required">

                            <label for="zipCode">Zip code:</label>
                            <input type="text" name="zipCode" value='<?=$restaurant->zipCode?>' required="required">

                            <a href="edit_restaurant.php?id=<?=$restaurant->idRestaurant?>">Cancel</a>
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
                    <form action="../actions/action_add_dish.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="photo" id ="file">
                        <label for="file">insert photo <i class="fa-solid fa-camera"></i></label>

                        <input type="hidden" name="idRestaurant" value="<?=$idRestaurant?>">
                        <input type="text" name="name" placeholder="name" required="required">
                        <input type="number" name="price" placeholder="price" step = 0.01 required="required">
                        <input type="text" name="ingredients" placeholder="ingredients">
                        <select name="allergens[]" multiple>
                            <option value="" disabled selected>allergens</option>
                                <?php foreach ($allergens as $allergen) { ?>
                                    <option value="<?=$allergen->idAllergen?>"><?=$allergen->name?></option>
                                <?php } ?>
                        </select>

                        <select name="categories[]" multiple>
                                <option value="" disabled selected>category</option>
                                <?php foreach ($categories as $category) { ?>
                                    <option value="<?=$category->idCategory?>"><?=$category->name?></option>
                                <?php } ?>
                        </select>

                        <a href = "edit_restaurant.php?id=<?=$idRestaurant?>">Cancel</a>
                        <button type="submit">Save</button>
                    </form>
                </article>
            </section>
        </main>
<?php } ?>  

<?php
    function output_edit_dish_form(Dish $dish) { ?>
        <main>
            <section id="owner_forms">
                <article>
                    <header>
                        <h1>Edit dish</h1>
                    </header>
                    <form action="../actions/action_edit_dish.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="idDish" value='<?=$dish->idDish?>'>
                        <input type="hidden" name="idRestaurant" value='<?=$dish->idRestaurant?>'>
                        <?php 
                            if (isset($dish->file)) { ?>
                                <img src="../images/dishes/<?= $dish->file ?>" alt="">
                                <input type="file" name="photo" id ="file">
                                <label for="file">change photo <i class="fa-solid fa-pen-to-square"></i></label>
                            <?php }
                            
                            else { ?>
                                <input type="file" name="photo" id ="file">
                                <label for="file">insert photo <i class="fa-solid fa-camera"></i></label>
                        <?php } ?>

                        <label for="name">Name:</label>
                        <input type="text" name="name" value='<?=$dish->name?>' required="required">

                        <label for="price">Price:</label>
                        <input type="number" name="price" value='<?=$dish->price?>' step = 0.01 required="required">

                        <label for="ingredients">Ingredients:</label>
                        <input type="text" name="ingredients" value='<?=$dish->ingredients?>'>

                        <a href = "edit_restaurant.php?id=<?=$dish->idRestaurant?>">Cancel</a>
                        <button type="submit">Save</button>
                    </form>
                </article>
            </section>
        </main>
<?php } ?>  

<?php function output_rate_order_form(int $idFoodOrder) { ?>
    <main>
        <section id="user_forms">
            <article>
                <header>
                    <h1>Rate Your Order</h1>
                </header>
                <form action="../actions/action_rate_order.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="idFoodOrder" value="<?=$idFoodOrder?>">
                <div>
                    <?php 
                        for ($i = 1; $i <= 5; $i++) { ?>
                            <input type="radio" name="rate" value="<?=$i?>" id="star<?=$i?>" required> 
                            <label for= "star<?=$i?>" class = "fa fa-star"> </label>
                    <?php }?>
                </div>
                <textarea name="comment" rows="3" placeholder="your comment"></textarea>
                <input type="file" name="photo" id ="file">
                <label for="file">insert photo (optional)<i class="fa-solid fa-camera"></i></label>
                <a href="order_history.php">Cancel</a>
                <button type="submit">Post</button>
                </form>
            </article>
        </section>
    </main>
<?php } ?>


<?php 
function output_reply_review_form(Review $review) { ?>
    <div class="reply_form">
        <form action="../actions/action_reply_review.php" method="post">
            <input type="hidden" name="idReview" value="<?=$review->idReview?>">
            <textarea rows="1" cols="50" name="reply" placeholder="your comment"></textarea>
            <button type="submit">Post</button>
        </form>
    </div>
<?php } ?>
