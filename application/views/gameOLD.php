<main role="main" class="container main main-game">
    <div class="row image-wrapper">
        <div class="col-5 img-left">
            <?= image('empty.jpg',
                'alt="image of the person that will choose" class="img-lg img-person-that-will-choose"') ?>
        </div>
        <div class="col-2 arrow-middle">
            <div class="arrow-to-right"></div>
        </div>
        <div class="col-5 img-right">
            <?= image('empty.jpg', 'alt="image of the person that will choose" class="img-lg img-choosen-person"') ?>
        </div>
    </div>

    <div class="row controls-wrapper">
<!--        <div class="col-4 ">-->
<!--            --><?php
//            /**
//             * Data for dropdown for choosing the player (person who plays)
//             *
//             * @var Game_entity $game
//             * @var array $persons
//             * @var Person_entity $person
//             */
//            if (sizeof($persons) > 0): ?>
<!--                <select id="select-yourself-dropdown" name="select-yourself-dropdown" class="form-control"-->
<!--                        required="required">-->
<!--                    <option value="" data-image="blank">I am ...</option>-->
<!--                    --><?php //foreach ($persons as $person): ?>
<!--                        <option value="--><?//= $person->getId() ?><!--"-->
<!--                                data-image="--><?//= $person->getImage() ?><!--"-->
<!--                                data-token="--><?//= $person->getHasChosenPersonId() ?><!--"-->
<!--                                data-game-id="--><?//= $game->getId() ?><!--"-->
<!--                                data-access-code="--><?//= $person->getAccessCode() ?><!--"> --><?//= ucfirst($person->getNickname()) ?><!--</option>-->
<!--                    --><?php //endforeach; ?>
<!--                </select>-->
<!--            --><?php //endif; ?>
<!--        </div>-->
<!--        <div class="col-4 ">-->
<!--            <input type="number" id="accessCode" class="form-control" required="required" disabled="disabled">-->
<!--        </div>-->
        <div class="col-12 ">
            <button id="start-game" type="button" class="btn btn-outline-light" disabled="disabled">&nbsp;</button>
        </div>
    </div>
    <div class="row message-wrapper">
        <p class="message"> Randomizing ...</p>
    </div>
    <div class="row result-wrapper">
        <p class="result"></p>
        <p class="result-ps"></p>
    </div>
    <div class="row error-wrapper">
        <p class="message">You have already chosen.</p>
    </div>
</main>
