<?php /** @var Person_entity $user */ ?>
<main role="main" class="container main main--home d-flex flex-column justify-content-center">
	<div class="row d-flex flex-column align-items-center justify-content-center main--home__welcome-message welcome-message">
		<p><?php echo 'Welcome back ' . $user->getNickname() . '!' ?></p>
		<p><?php echo 'Make your choice...' ?></p>
	</div>

	<div class="tile--container row justify-content-center">
		<div class="tile tile--play-game d-block text-center pr-3">
			<a class="tile__link d-flex flex-column" href="<?php echo site_url('/game/selectGame') ?>">
				<i class="fas fa-8x fa-dice"></i>
			</a>
			<span class="tile__text tile__text--bottom">Play Game</span>
		</div>
		<div class="tile tile--giftlist d-block text-center pl-3">
			<a class="tile__link d-flex flex-column" href="<?php echo site_url('/game/editList') ?>">
				<i class="fas fa-8x fa-gift"></i>
			</a>
			<span class="tile__text tile__text--bottom">Edit list</span>
		</div>
	</div>
</main>
