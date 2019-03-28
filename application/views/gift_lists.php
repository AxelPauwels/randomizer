<main role="main" class="container main main-gift-lists">
    <div class="home-link">
        <a href="<?php echo site_url('/game/index') ?>"><i class="fas fa-home"></i> Home</a>
    </div>
    <div class="gift-list-link">
        <a href="<?php echo site_url('/game/giftLists') ?>"><i class="fas fa-gift"></i> Gift lists</a>
    </div>
    <div class="row">
        <?php
        /**
         * Data for dropdown
         *
         * @var array $persons
         * @var Person_entity $person
         */
        foreach ($persons as $person): ?>
            <a href="<?php echo site_url('/game/giftList/' . $person->getId()) ?>">
                <?php echo ucfirst($person->getName()) . ' ' . ucfirst($person->getLastname()) ?>
            </a>
        <?php endforeach; ?>
    </div>
</main>
