<?php /** @var Person_entity $person */ ?>
<main role="main" class="container main main--giftlist d-flex justify-content-center">
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
				<ul class="text-left p-0">
					<?php foreach ($wishlist as $item) { ?>
						<li class="main--giftlist__list-item">
							<i class="fas fa-caret-right"></i>
							<?php echo $item ?>
						</li>
					<?php } ?>
				</ul>
			</div>
		<?php } ?>
</main>
