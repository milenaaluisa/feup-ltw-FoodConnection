<?php declare(strict_types = 1); ?>

<?php 
    function output_single_dish($dish, array $allergens) { ?>
        <main>
            <section id="dishes">
                <?php output_dish($dish, $allergens); ?>
            </section>
        </main>
    <?php } ?>

<?php 
    function output_dish_list(array $dishes) { ?>
        <section id="dishes"> 
            <header>
                <h2>Dishes </h2>
            </header>
            <?php foreach($dishes as $dish) {
                output_dish($dish);
            } ?>
        </section>
    <?php } ?>

<?php
    function output_dish_photo ($dish) { ?>
        <a href="dish.php?id=<?= $dish['idDish'] ?>">
            <?php if (isset($dish['file'])) { ?>
                <img src="..\images\dishes\<?= $dish['file'] ?>">
            <?php }
            
            else { ?>
                <img src="..\images\no_photo.jpg">
            <?php } ?>
        </a>
<?php } ?>

<?php
    function output_dish($dish, array $allergens = null) { ?>
        <article class="dish">
            <header>
                <h2><a href="dish.php?id=<?= $dish['idDish'] ?>"><?= $dish['name'] ?></a></h2>
            </header>

            <?php output_dish_photo($dish); ?>

            <span class="price"><?= $dish['price'] ?></span>
            <span class="rate"><?= $dish['averageRate'] ?></span>

            <!---TODO: like button-->
            <div class = "edit_options">
                <a href="edit_info_dish.php">Edit Info</a>
            </div>
            
            <div class = "composition">
                <h3>Ingredients</h3>
                <p><?= $dish['ingredients'] ?></p>
                <?php if(isset($allergens) && sizeof($allergens)>0) { ?>
                    <h3>Allergens</h3>
                    <p>
                    <?php foreach($allergens as $allergen) { ?>
                        <?= $allergen['name'] ?>
                    <?php } ?> </p>
                <?php } ?>
            </div>
            

                <form action="action_add_order_item.php" method="post">
                    <input name="quantity" type="number" value="1" min="0" step="1">
                    <button type="submit">
                        Add to cart <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    </button>
                </form>
                <a href="restaurant.php?id=<?= $dish['idRestaurant'] ?>" class="close"></a>
        </article>
    <?php }
?>