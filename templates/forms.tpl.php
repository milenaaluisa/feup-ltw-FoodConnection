<?php function output_rate_order() { ?>
    <main>
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
<?php } 

    function output_login() { ?>
        <main>
            <section id="login">
                <h1><a href="login.php">Login</a></h1>
                <form action="action_login.php" method="post">
                    <input type="text" name="username" placeholder="username" required="required">
                    <input type="password" name="password" placeholder="password" required="required">
                    <a href="index.php">Cancel</a>
                    <button type="submit">Login</button>
                </form>
            </section>
        </main>
<?php }

    function output_register() { ?>
        <main>
            <section id="register">
                <h1><a href="register.php">Register</a></h1>
                <form action = "action_new_profile.php" method = "post">
                    <!--FALTA: INPUT DA FOTO-->
                    <input type="text" name="name" placeholder="name" required="required">
                    <input type="text" name="email" placeholder="email" required="required">  
                    <input type="number" name="phoneNum" placeholder="phone number" required="required">
                    <input type="text" name="adress" placeholder="adress" required="required">
                    <input type="text" name="city" placeholder="city" required="required">
                    <input type="text" name="zipCode" placeholder="zip code" required="required">
                    <input type="text" name="username" placeholder="username" required="required">
                    <input type="password" name="password" placeholder="password" required="required">
                    <a href="index.php">Cancel</a>
                    <button type="submit">Register</button>
                </form>
            </section>
        </main>
<?php } ?>