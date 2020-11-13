<main role="main" class="container main main--edit-giftlist d-flex flex-column justify-content-center">
	<div class="row d-flex flex-column align-items-center justify-content-center main--edit-giftlist__welcome-message welcome-message">
		<p><?php echo 'Edit your own whishlist' ?></p>
		<p><?php echo 'Enter a item on each next line' ?></p>
	</div>

	<div class="form--container row justify-content-center">
		<form class="w-100 p-2 form text-center" method="POST" action="<?php echo site_url('/game/updateWishlist') ?>">
			<textarea class="w-100 h-100 p-2" type="text" id="wishlist" name="wishlist"><?php echo ltrim($wishlist) ?></textarea>
			<button type="submit"class="btn btn-success c-btn c-btn--sm c-btn--red c--btn--pill">
				Save
			</button>
		</form>
	</div>
</main>
