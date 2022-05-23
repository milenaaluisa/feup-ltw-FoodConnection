<?php
    function output_categories($categories) { ?>
        <nav>
            <header>
                <h2><a href="index.php">Categories</a></h2>
            </header>
            <ul>
                <li><a href="category.php?id=0">All restaurants</a></li>
                <?php foreach($categories as $category) { ?>
                    <li><a href="category.php?id=<?= $category['idCategory'] ?>"><?= $category['name'] ?></a></li>
                <?php } ?>
            </ul>
        </nav>
<?php } ?>