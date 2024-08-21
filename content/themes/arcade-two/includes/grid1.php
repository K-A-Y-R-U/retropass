<div class="col-md-2 col-sm-3 col-4 grid-1">
	<a href="<?php echo get_permalink('game', $game->slug) ?>">
	<div class="game-item">
		<div class="list-game">
			<div class="list-thumbnail"><img src="<?php echo get_small_thumb($game) ?>" class="small-thumb img-rounded" alt="<?php echo esc_string($game->title) ?>"></div>
			<div class="list-info">
				<div class="list-title"><?php echo esc_string($game->title); ?></div>
			</div>
		</div>
	</div>
	</a>
</div>