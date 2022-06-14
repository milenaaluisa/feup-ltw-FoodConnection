<?php declare(strict_types = 1); ?>

<?php
    function output_categories(array $categories) { ?>
        <nav>
            <header>
                <h2><a href="index.php">Categories</a></h2>
            </header>
            <ul>
                <li><a href="category.php?id=0">All restaurants</a></li>
                <?php foreach($categories as $category) { ?>
                    <li><a href="category.php?id=<?= $category->idCategory ?>"><?= $category->name ?></a></li>
                <?php } ?>
            </ul>
        </nav>
<?php } ?>


<?php
    function output_restaurant_categories(Restaurant $restaurant, array $categories) { ?>
        <nav>
            <ul>
                <?php foreach($categories as $category) { ?>
                    <li><a href="restaurant.php?id=<?= $restaurant->idRestaurant ?>"><?= $category->name ?></a></li>
                <?php } ?>
            </ul>
        </nav>
<?php } ?>