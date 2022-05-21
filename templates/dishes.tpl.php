<?php 
    function output_single_dish($dish, $allergens) { ?>
        <main>
            <section id=dish>
                <?php output_dish($dish, $allergens); ?>
            </section>
        </main>
    <?php }

    function output_dish_list($dishes) { ?>
        <section id="dishes"> 
            <header>Dishes</header>
            <?php foreach($dishes as $dish) {
                output_dish($dish);
            } ?>
        </section>
    <?php }

    function output_dish($dish, $allergens = null) { ?>
        <article class="dish">
            <header>
                <h1><a href="dish.php?id=<?= $dish['idDish'] ?>"><?= $dish['name'] ?></a></h1>
            </header>

            <img src="..\images\dishes\<?= $dish['file'] ?>">

            <section class="info">
                <span class="price"><?= $dish['price'] ?></span>
                <span class="rate"><?= $dish['averageRate'] ?></span>
            </section>

            <!---TODO: like button-->
            
            <?php if(isset($allergens)) { ?>
                <div class = "composition">
                    <h3>Ingredients</h3>
                    <p><?= $dish['ingredients'] ?></p>
                    <h3>Allergens</h3>
                    <p>
                    <?php foreach($allergens as $allergen) { ?>
                        <?= $allergen['name'] ?>
                    <?php } ?> </p>
                </div>

                <form action="action_add_order_item.php" method="post">
                    <input name="quantity" type="number" value="1" min="0" step="1">
                    <button type="submit">
                        Add to cart <!-- ICON DO CARRINHO-->
                    </button>
                </form>
            <?php } ?>
        </article>
    <?php }
?>