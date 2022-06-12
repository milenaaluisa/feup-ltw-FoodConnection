<?php declare(strict_types = 1); ?>

<?php
    function output_login_form() { ?>
        <div id="user_forms">
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
        </div>
<?php } ?>


<?php
    function output_register_form() { ?>
        <div id="user_forms">
            <article>
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
                    <input type="text" name="username" placeholder="username" required="required">
                    <input type="password" name="password" placeholder="password" required="required">
                    <a href="index.php">Cancel</a>
                    <button type="submit">Register</button>
                </form>
            </article>
        </div>
<?php } ?>

<?php 
    function output_profile_form (User $user) { ?>
        <div id="user_forms">
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
                    <input type="text" name="name" value="<?=$user->name?>" required="required" id="name">
                    
                    <label for="email">Email:</label>
                    <input type="email" name="email" value="<?=$user->email?>" required="required" id="email">  

                    <label for="phoneNum">Phone Number:</label>
                    <input type="number" name="phoneNum" value="<?=$user->phoneNum?>" required="required" id="phoneNum">

                    <label for="address">Address:</label>
                    <input type="text" name="address" value="<?=$user->address?>" required="required" id="address">

                    <label for="city">City:</label>
                    <input type="text" name="city" value="<?=$user->city?>" required="required" id="city">

                    <label for="zipCode">ZipCode:</label>
                    <input type="text" name="zipCode" value="<?=$user->zipCode?>" required="required" id= zipCode>

                    <label for="username">Username:</label>
                    <input type="text" name="username" value="<?=$user->username?>" required="required" id="username">

                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password">

                    <a href="index.php">Cancel</a>
                    <button type="submit">Save</button>
                </form>
            </article>
        </div>
<?php } ?>


<?php
    function output_new_restaurant_form(array $categories) { ?>
            <div id="owner_forms">
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
            </div>
<?php } ?>

<?php
    function output_edit_restaurant_form(Restaurant $restaurant) { ?>
        <div id="owner_forms">
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
                    <input type="text" name="name" value='<?=$restaurant->name?>' required="required" id="name">

                    <label for="number">Phone number:</label>
                    <input type="number" name="number" value='<?=$restaurant->phoneNum?>' required="required" id="number">

                    <label for="address">Address:</label>
                    <input type="text" name="address" value='<?=$restaurant->address?>' required="required" id="address">

                    <label for="city">City:</label>
                    <input type="text" name="city" value='<?=$restaurant->city?>' required="required"  id="city">

                    <label for="zipCode">Zip code:</label>
                    <input type="text" name="zipCode" value='<?=$restaurant->zipCode?>' required="required" id="zipCode">

                    <a href="edit_restaurant.php?id=<?=$restaurant->idRestaurant?>">Cancel</a>
                    <button type="submit">Save</button>
                </form>
            </article>
        </div>
<?php } ?>

<?php
    function output_new_dish_form(array $allergens, array $categories, int $idRestaurant) { ?>
        <div id="owner_forms">
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
        </div>
<?php } ?>  

<?php
    function output_edit_dish_form(Dish $dish) { ?>
        <div id="owner_forms">
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
                    <input type="text" name="name" value='<?=$dish->name?>' required="required" id="name">

                    <label for="price">Price:</label>
                    <input type="number" name="price" value='<?=$dish->price?>' step = 0.01 required="required" id="price">

                    <label for="ingredients">Ingredients:</label>
                    <input type="text" name="ingredients" value='<?=$dish->ingredients?>' id="ingredients">

                    <a href = "edit_restaurant.php?id=<?=$dish->idRestaurant?>">Cancel</a>
                    <button type="submit">Save</button>
                </form>
            </article>
        </div>
<?php } ?>  

<?php function output_rate_order_form(int $idFoodOrder) { ?>
    <div id="user_forms">
        <article>
            <header>
                <h1>Rate Your Order</h1>
            </header>
            <form action="../actions/action_rate_order.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="idFoodOrder" value="<?=$idFoodOrder?>">
            <div class="stars">
                <?php 
                    for ($i = 1; $i <= 5; $i++) { ?>
                        <input type="radio" name="rate" value="<?=$i?>" id="star<?=$i?>" required> 
                        <label for= "star<?=$i?>"> <i class="fa-solid fa-star"></i> </label>
                <?php }?>
            </div>
            <textarea name="comment" rows="3" placeholder="your comment"></textarea>
            <input type="file" name="photo" id ="file">
            <label for="file">insert photo (optional)<i class="fa-solid fa-camera"></i></label>
            <a href="order_history.php">Cancel</a>
            <button type="submit">Post</button>
            </form>
        </article>
    </div>
<?php } ?>

<?php function output_rate_dish_form(Dish $dish, Order $order) { ?>
    <div id="user_forms">
        <article>
            <header>
                <h1><?=$dish->name?></h1>
            </header>
            <form action="../actions/action_rate_dish.php" method="post">
            <input type="hidden" name="idDish" value="<?=$dish->idDish?>">
            <input type="hidden" name="idFoodOrder" value="<?=$order->idFoodOrder?>">
            <div class = "stars">
                <?php 
                    for ($i = 1; $i <= 5; $i++) { ?>
                        <input type="radio" name="rate" value="<?=$i?>" id="star<?=$i?>" required> 
                        <label for="star<?=$i?>"> <i class="fa-solid fa-star"></i> </label>
                <?php }?>
            </div>
            <a href="order_history.php">Cancel</a>
            <button type="submit">Post</button>
            </form>
        </article>
    </div>
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
