<?php
    function output_categories($categories) { ?>
        <nav id="categories">
            <header>
                <h2><a href="index.php">Categories</a></h2>
            </header>
            <ul>
                <li><a href="category.php">All restaurants</a></li>
                <?php foreach($categories as $category) { ?>
                    <li><a href="category.php?id=<?= $category['idCategory'] ?>"><?= $category['name'] ?></a></li>
                <?php } ?>
            </ul>
        </nav>
<?php } ?>