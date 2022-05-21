<?php output_header() ?>

        <main>
            <!--LOGIN FORM-->
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

        <?php output_footer() ?>