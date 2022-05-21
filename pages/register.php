<?php output_header() ?>
        <main>
            <!--REGISTER FORM-->
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

        <?php output_footer() ?>