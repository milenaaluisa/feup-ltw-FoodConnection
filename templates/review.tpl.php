<?php 
    declare(strict_types = 1);
    include_once('../templates/forms.tpl.php');  
?>


<?php
    function output_restaurant_reviews_list(array $reviews) { ?>
        <section id="reviews">
            <header>
                <h2>What People Say</h2>
            </header>

            <?php foreach($reviews as $review) { 
                output_restaurant_review($review);
            } ?>

        </section>
<?php } ?>


<?php
    function output_restaurant_review(Review $review) { ?> 
    <article>
        <div>
            <?php output_profile_photo($review->profilePhoto); ?>

            <span class="user"><?= $review->username ?></span>
            <span class="rate"><?= $review->rate ?></span>
            <span class="date"><?= date('d/m/y', $review->reviewDate) ?></span>
            <p><?= $review->comment ?></p>  
        </div>

        <?php output_review_photo ($review->file); ?>

        <?php if (isset($review->reply) && !empty($review->reply)) { ?>
            <div>
                <h3> Response from the owner: </h3>
                <p><?=$review->reply?></p>
            </div>
        <?php } 

        else {
            output_reply_review_form($review); 
        } ?>
             
    </article>
<?php } ?>


<?php
    function output_review_photo($file) { ?> 
    <?php if (isset($restaurant->file)) { ?>
            <img src="../images/reviews/<?=$file?>">
    <?php } ?>        
<?php } ?>  