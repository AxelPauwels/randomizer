<main role="main" class="container main main--giftlists d-flex justify-content-center">
	<div class="row flex-column justify-content-center align-items-center text-center w-100 main--giftlists__item">
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
