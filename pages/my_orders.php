<?php
    require_once('../database/connection.db.php');
    require_once('../database/orders.db.php');

    $db = getDatabaseConnection();

    $my_orders = getUserOrders($db, $_GET['id']);

    $ordered_dishes = getOrderDishes($db, $_GET['id'])
    
    $subtotal = 0;

    output_header();
?>

        <section id="orders">
            <header>
                <h1>Order History</h1>
            </header>
            <?php foreach($my_orders as $my_order) { ?>
                <article>
                    <header>
                        <h2><a href="restaurant.php?id=<?= $my_order['idRestaurant'] ?>"><?= $my_order['restName'] ?></a></h2>
                    </header>
                    <a href="restaurant.php?id=<?= $my_order['idRestaurant'] ?>"><img src="https://picsum.photos/id/237/200/300" alt=""></a>
                    <div class = "order_items">
                        <?php foreach($ordered_dishes as $ordered_dish) { ?>
                            <p><span class="quantity"><?= $ordered_dish['quantity'] ?></span> <?= $ordered_dish['name'] ?> </p>
                            <span class="price"><?= $ordered_dish['quantity'] * $ordered_dish['price'] ?></span>
                        <?php $subtotal += $ordered_dish['quantity'] * $ordered_dish['price'];
                            } ?>
                    </div>
                    <p>Subtotal: </p>
                    <span class="price"><?= $subtotal ?>€</span>
                    <span class="date"><?= $my_order['orderDate'] ?></span>
                    <span class="state"><?= $my_order['state'] ?>/span>  
                    <a href="rate_order.php?id=<?= $my_order['idFoodOrder'] ?>">Rate Order </a><!--reorder php vai ser pagina?-->
                    <a href="re_order.php?id=<?= $my_order['idFoodOrder'] ?>"> Re-order </a>   
                </article>
            <?php } ?>
        </section>

        <?php output_footer() ?>