<?php /** @var Person_entity $person */ ?>
<main role="main" class="container main main--giftlist d-flex flex-column justify-content-center">
	<div class="row flex-column justify-content-center align-items-center text-center w-100 main--giftlist__image">
		<?php if ($person) { ?>
			<div class="main--giftlist__image-wrapper">
				<?php echo image(
					$person->getImage() . '.jpg',
					'alt="image of ' . $person->getNickname() . '"'
				) ?>
			</div>
		<?php } ?>
	</div>
	<div class="row flex-column justify-content-center align-items-center text-center w-100 main--giftlist__list">
		<?php if ($wishlist) { ?>
			<div class="row">
				<ul class="text-left p-0 pt-5">
					<?php foreach ($wishlist as $item) { ?>
						<li class="main--giftlist__list-item">
							<i class="fas fa-caret-right"></i>
							<?php echo $item ?>
						</li>
					<?php } ?>
				</ul>
			</div>
		<?php } ?>
	</div>
	<?php if ($showEditBtn) { ?>
		<div class="row text-center d-flex flex-row justify-content-center">
			<form method="POST" action="<?php echo site_url('/game/editList') ?>">
				<button type="submit" class="btn btn-success c-btn c-btn--red c--btn--pill">
					Edit your own list
				</button>
			</form>
		</div>
	<?php } ?>
</main>
