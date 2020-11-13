<main role="main" class="container main main--select-game d-flex flex-column justify-content-center">
	<div class="row justify-content-center">
		<?php
		/**
		 * Data to open and submit the form
		 */
		$dataOpen = array(
			'id' => 'gameform',
			'name' => 'gameform',
			'data-toggle' => 'validator',
			'role' => 'form',
			'class' => 'main--select-game__form form-inline w-100 p-2 flex-nowrap',

		);

		$dataSubmit = array(
			'type' => 'submit',
			'name' => 'gamesubmit',
			'value' => 'Load',
			'class' => 'main--select-game__submit btn btn-outline-light c-btn c-btn--size-auto c-btn--red'
		);

		/**
		 * Data for dropdown
		 *
		 * @var array $games
		 * @var Game_entity $game
		 */
		$gameDropdownOptions = array('' => 'Select a game...');

		foreach ($games as $game) {
			$gameDropdownOptions[$game->getId()] = $game->getName();
		}

		echo form_open('game/play', $dataOpen);
		echo form_dropdown('gameId', $gameDropdownOptions, null, 'class="form-control main--select-game__dropdown" required="required"');
		echo form_submit($dataSubmit) . "\n";
		echo form_close();
		?>
	</div>
</main>
