<?php /**@var Person_entity $currentPerson */ ?>
<?php /**@var Person_entity $chosenPerson */ ?>
<?php /**@var Game_entity $game */ ?>
<main role="main" class="container main main--game d-flex flex-column justify-content-center">
	<?php
	if ($chosenPerson) {
		if ($chosenPerson->getNickname() === $chosenPerson->getName()) {
			$resultMessage = 'You picked ' . ucfirst($chosenPerson->getName()) . ' ' . ucfirst($chosenPerson->getLastname()) . '!';
		} else {
			$resultMessage = 'You picked ' . ucfirst($chosenPerson->getName()) . ' ' . ucfirst($chosenPerson->getLastname()) .
			' aka "' . ucFirst($chosenPerson->getNickname()) . '" !';
		}
		?>
		<div class="row d-block result-wrapper p-2">
			<p class="result"><?php echo $resultMessage ?></p>
			<?php
			$sex = 'him';
			if (!$chosenPerson->getIsMale()) {
				$sex = 'her';
			}
			?>
			<p class="result-ps">You can surprise <?php echo $sex ?> with a gift of <span style="white-space:nowrap">€20.</span></p>
		</div>
	<?php } else { ?>
	<div class="row d-block result-wrapper p-2">
		<p class="result"></p>
		<p class="result-ps"></p>
	</div>

	<div class="row h-100 d-flex flex-column align-items-center justify-content-center">

		<div class="row w-100 d-flex flex-column flex-md-row flex-nowrap align-items-center justify-content-center main--game__image-wrapper ">
			<div class="main--game__image main--game__image--left">
				<?php echo image($currentPerson->getName() . '_' . $currentPerson->getLastname() . '.jpg',
					'alt="image of the person that will choose" class="img-lg img-person-that-will-choose"'
				) ?>
			</div>
			<div class="main--game__image-spacer position-relative">
				<div class="arrow-to-right position-absolute"></div>
			</div>
			<div class="main--game__image main--game__image--right">
				<?php echo image(
					'empty.jpg',
					'alt="image of the person that will choose" class="img-lg img-chosen-person"'
				) ?>
			</div>
		</div>

		<div class="row controls-wrapper w-100 mt-3 text-center">
			<input hidden id="person-id" name="person-id" value="<?php echo $currentPerson->getId() ?>"/>
			<input hidden id="game-id" name="game-id" value="<?php echo $game->getId() ?>"/>
			<button id="start-game" type="button" class="btn btn-success c-btn c-btn--sm c-btn--red c-btn--pill">PLAY
			</button>
		</div>
	</div>
	<?php }?>

</main>
