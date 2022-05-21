<?php output_header() ?>

        <main>
            <!--REVIEW FORM-->
            <section id="rate_order">
                <h1>Rate Your Order</h1>
                <form action="action_rate_order.php" method="post">
                    <input name="quantity" type="number" value="1" min="1" max="5" step="1">
                    <textarea name="comment" placeholder="your comment"></textarea>
                    <a href="my_orders.php">Cancel</a>
                    <button type="submit">Post</button>
                </form>
            </section>
        </main>

        <?php output_footer() ?>