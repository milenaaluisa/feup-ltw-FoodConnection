<?php 
    declare(strict_types = 1); 
    include_once('../templates/restaurant.tpl.php');
?>

<?php 
function output_user_orders_list(array $my_orders) { ?>
    <section id= "user_orders">
        <header>
            <h1>Order History</h1>
        </header>

        <?php foreach($my_orders as $my_order) {
            output_user_order($my_order);
        } ?>
    </section>
<?php } ?>


<?php 
function output_user_order(Order $my_order) { ?>
    <article>
        <header>
            <h2><a href="restaurant.php?id=<?= $my_order->restaurant->idRestaurant?>"><?= $my_order->restaurant->name ?></a></h2>
        </header>
 
        <?php output_restaurant_photo($my_order->restaurant); ?>

        <?php output_order_items_list($my_order->items, $my_order->state) ?>
        
        <p>Subtotal: </p>
        <span class="price"><?= number_format($my_order->total, 2)?></span>
        <span class="date"><?= date('d/m/y', $my_order->orderDate) ?></span>
        <span class="state"><?= $my_order->state ?></span>  
        
        <?php if ($my_order->state === "delivered") { ?>
            <?php if ($my_order->rated === false) { ?>
                    <a href="rate_order.php?id=<?= $my_order->idFoodOrder ?>">Rate Order </a>
            <?php } ?>
        
            <a href="../actions/action_reorder.php?id=<?= $my_order->idFoodOrder ?>"> Re-order </a> 
        <?php } ?>
    </article>
<?php } ?>


<?php function output_order_items_list(array $items, string $orderState) { ?>
    <div>
        <?php foreach($items as $item) {
            output_order_item($item, $orderState);
        } ?>
    </div>
<?php } ?>


<?php 
function output_order_item(array $item, string $orderState) { ?>
    <div>
        <p><span class="quantity"><?= $item['quantity'] ?></span> <?= $item['name'] ?> </p>
        <span class="price"><?= number_format($item['quantity'] * $item['price'], 2) ?></span>
        <?php 
            if ($orderState === "delivered" && $item['rated'] === false) { ?>
                <a href="rate_dish.php?id=<?=$item['idDish']?>&order=<?=$item['idFoodOrder']?>"> Rate dish </a>
        <?php } ?>
    </div>
<?php } ?>

