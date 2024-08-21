<div class="col-lg-4 col-md-6 grid-2">
	<a href="<?php echo get_permalink('game', $game->slug) ?>">
	<div class="game-item">
		<div class="list-game">
			<div class="list-thumbnail"><img src="<?php echo get_small_thumb($game) ?>" class="small-thumb img-rounded" alt="<?php echo esc_string($game->title) ?>"></div>
			<div class="list-info">
				<div class="list-title"><?php echo esc_string($game->title) ?></div>
				<div class="list-category"><?php echo str_replace(',', ', ', esc_string($game->category)) ?></div>
				<div class="list-rating">
					<i class="bi bi-star-fill"></i>
					<?php echo get_rating('5-decimal', $game) ?>/5
				</div>
			</div>
		</div>
	</div>
	</a>
</div>