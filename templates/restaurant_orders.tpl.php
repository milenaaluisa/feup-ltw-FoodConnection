<?php 
    declare(strict_types = 1); 
    include_once('../templates/restaurant.tpl.php');
?>


<?php
function output_restaurant_orders_list(array $restaurantOrders, Restaurant $restaurant) { ?>
    <div id = "restaurants">
        <article>
            <header>
                <h1><a href="restaurant.php"><?=$restaurant->name?></a></h1>
            </header>

            <?php output_restaurant_photo($restaurant); ?>

            <section id ="orders">
                <header> 
                    <h2>Orders: </h2> 
                </header>

                <?php foreach($restaurantOrders as $order) {
                    output_restaurant_order($order);
                } ?>
            </section>
        </article>  
    </div>
    
<?php } ?>


<?php 
function output_restaurant_order(Order $order) { ?>
    <?php $states = array('received', 'preparing','ready','delivered');?>
    <article>

        <?php output_order_items_list($order->items) ?>
        
        <p>Subtotal: </p>
        <span class="price"><?= number_format($order->total, 2)?></span>
        <span class="date"><?= date('d/m/y h:m',$order->orderDate) ?></span>
        <select name="state" data-id="<?=$order->idFoodOrder?>">
            <?php
                foreach($states as $state) {
                    if ($state === $order->state)
                        echo "<option value= . $state . selected> $state</option>";
                     else
                         echo "<option value= .$state> $state</option>";
                    } ?>  
        </select>  
    </article>
<?php } ?>


<?php function output_order_items_list(array $items) { ?>
    <div>
        <?php foreach($items as $item) {
            output_order_item($item);
        } ?>
    </div>
<?php } ?>


<?php 
function output_order_item(array $item) { ?>
    <div>
        <p><span class="quantity"><?= $item['quantity'] ?></span> <?= $item['name'] ?> </p>
        <span class="price"><?= number_format($item['quantity'] * $item['price'], 2) ?></span>
    </div>
<?php } ?>
