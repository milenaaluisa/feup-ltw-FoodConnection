<?php function output_rate_order_form() { ?>
    <main>
        <section id="user_forms">
            <article>
                <header>
                    <h1>Rate Your Order</h1>
                </header>
                <form action="action_rate_order.php" method="post">
                    <input name="quantity" type="number" value="1" min="1" max="5" step="1">
                    <textarea name="comment" placeholder="your comment"></textarea>
                    <a href="my_orders.php">Cancel</a>
                    <button type="submit">Post</button>
                </form>
            </article>
        </section>
    </main>
<?php } 

    function output_login_form() { ?>
        <main>
            <section id="user_forms">
                <article>
                    <header>
                        <h1><a href="login.php">Login</a></h1>
                    </header>
                    <form action="../actions/action_login.php" method="post">
                        <input type="text" name="username" placeholder="username" required="required">
                        <input type="password" name="password" placeholder="password" required="required">
                        <a href="index.php">Cancel</a>
                        <button type="submit">Login</button>
                    </form>
                </article>
            </section>
        </main>
<?php }

    function output_register_form() { ?>
        <main>
            <section id="user_forms">
                <article>
                    <header>
                        <h1><a href="register.php">Register</a></h1>
                    </header>
                    <form action = "action_new_profile.php" method = "post">
                        <!--FALTA: INPUT DA FOTO-->
                        <input type="text" name="name" placeholder="name" required="required" minlenght="6">
                        <input type="text" name="email" placeholder="email" required="required">  
                        <input type="number" name="phoneNum" placeholder="phone number" required="required">
                        <input type="text" name="adress" placeholder="adress" required="required">
                        <input type="text" name="city" placeholder="city" required="required">
                        <input type="text" name="zipCode" placeholder="zip code" required="required" minlenght="6">
                        <input type="text" name="username" placeholder="username" required="required">
                        <input type="password" name="password" placeholder="password" required="required">
                        <a href="index.php">Cancel</a>
                        <button type="submit">Register</button>
                    </form>
                </article>
            </section>
        </main>
<?php } ?>