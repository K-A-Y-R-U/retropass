<div class="col-lg-2 col-md-4 col-6 grid-3">
	<a href="<?php echo get_permalink('game', $game->slug) ?>">
	<div class="game-item">
		<div class="list-game">
			<div class="list-thumbnail"><img src="<?php echo $game->thumb_1 ?>" alt="<?php echo esc_string($game->title) ?>"></div>
			<div class="list-info">
				<div class="list-title"><?php echo esc_string($game->title) ?></div>
				<span><?php _e('%a plays', $game->views) ?></span>
			</div>
		</div>
	</div>
	</a>
</div>