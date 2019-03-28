<main role="main" class="container main main-gift-list">
    <div class="home-link">
        <a href="<?php echo site_url('/game/index') ?>"><i class="fas fa-home"></i> Home</a>
    </div>
    <div class="gift-list-link">
        <a href="<?php echo site_url('/game/giftLists') ?>"><i class="fas fa-gift"></i> Gift lists</a>
    </div>

    <div class="img-wrapper">
        <?php
        /**
         * @var Person_entity $person
         */
        echo image($person->getImage() . '.jpg', 'alt="image of the person"') ?>
    </div>
    <div class="row">
        <ul>
            <?php
            foreach ($wishlist as $item) {
                echo '<li>' . $item . '</li>';
            }
            ?>
        </ul>
    </div>
</main>
