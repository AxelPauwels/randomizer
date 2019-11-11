<main role="main" class="container main main-home">
    <div class="home-link">
        <a href="<?php echo site_url('/game/index') ?>"><i class="fas fa-home"></i> Home</a>
    </div>
    <div class="gift-list-link">
        <a href="<?php echo site_url('/game/giftLists') ?>"><i class="fas fa-gift"></i> Gift lists</a>
    </div>
    <div class="row">
        <?php
        /**
         * Data to open and submit the form
         */
        $dataOpen = array(
            'id' => 'gameform',
            'name' => 'gameform',
            'data-toggle' => 'validator',
            'role' => 'form',
            'class' => 'form-inline',

        );

        $dataSubmit = array(
            'type' => 'submit',
            'name' => 'gamesubmit',
            'value' => 'GO !',
            'class' => 'btn btn-outline-light'
        );

        /**
         * Data for dropdown
         *
         * @var array $games
         * @var Game_entity $game
         */
        $gameDropdownOptions = array('' => '--- Select a randomizer ---');

        foreach ($games as $game) {
            $gameDropdownOptions[$game->getId()] = $game->getName() . ' ' . $game->getYear();
        }

        echo form_open('game/play', $dataOpen);
        echo form_dropdown('gameId', $gameDropdownOptions, null, 'class="form-control" required="required"');
        echo form_submit($dataSubmit) . "\n";
        echo form_close();
        ?>
    </div>
</main>
