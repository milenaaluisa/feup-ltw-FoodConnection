<?php declare(strict_types = 1); ?>

<?php 
    function output_single_dish(Dish $dish, array $allergens) { ?>
        <div id="dishes">
            <?php output_dish($dish, $allergens); ?>
        </div>
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
    function output_dish_photo (Dish $dish) { ?>
        <a href="dish.php?id=<?= $dish->idDish ?>">
            <?php if (isset($dish->file)) { ?>
                <img src="../images/dishes/<?= $dish->file ?>" alt="">
            <?php }
            
            else { ?>
                <img src="../images/no_photo.jpg" alt="">
            <?php } ?>
        </a>
<?php } ?>

<?php
    function output_dish(Dish $dish, array $allergens = null) { ?>
        <article class="dish">
            <header>
                <h2><a href="dish.php?id=<?= $dish->idDish ?>"><?= $dish->name ?></a></h2>
            </header>

            <?php output_dish_photo($dish); ?>

            <span class="price"><?= number_format($dish->price, 2) ?></span>
            <span class="rate"><?= $dish->averageRate ?></span>

            <?php if ($dish->is_favourite) { ?>
                <i class="fa fa-heart" data-id=<?=$dish->idDish?>></i>
            <?php } else { ?>
                <i class="fa fa-heart-o" data-id=<?=$dish->idDish?>></i>
            <?php } ?>

            <div class = "edit_options">
                <a href="edit_dish_info.php?id=<?=$dish->idDish?>">Edit Info <i class="fa-regular fa-pen-to-square"></i></a>
                <button data-id="<?= $dish->idDish ?>">Delete dish</button>

            </div>
            
            <?php if((isset($dish->ingredients) && !empty(trim($dish->ingredients))) || isset($allergens) && sizeof($allergens)>0) { ?>
                <div class = "composition">
                    <?php if(isset($dish->ingredients) && !empty(trim($dish->ingredients))) { ?>
                        <h3>Ingredients</h3>
                        <p><?= $dish->ingredients ?></p>
                    <?php } ?>

                    <?php if(isset($allergens) && sizeof($allergens)>0) { ?>
                        <h3>Allergens</h3>
                        <p>
                            <?php foreach($allergens as $allergen) { ?>
                                <?= $allergen->name ?>
                            <?php } ?> 
                        </p>
                    <?php } ?>
                    
                </div>
            <?php } ?>

                <form action="../actions/action_add_to_cart.php?id=<?=$dish->idDish?>" method="post">
                    <input type="hidden" name="idRestaurant" value="<?=$dish->idRestaurant?>">
                    <input type="hidden" name="price" value="<?=$dish->price?>">
                    <input type="hidden" name="name" value="<?=$dish->name?>"> 
                    <input name="quantity" type="number" value="1" min="1" step="1">
                    <button type="submit">
                        Add to cart <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    </button>
                </form>
                <a href="restaurant.php?id=<?= $dish->idRestaurant ?>" class="close"></a>
        </article>
    <?php }
?>