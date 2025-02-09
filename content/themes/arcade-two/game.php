<?php include  TEMPLATE_PATH . "/includes/header.php" ?>
<div class="container game-wrapper">
	<div class="game-container">
		<div class="game-content" data-id="<?php echo $game->id ?>">
			<?php
			$allow_mobile_version = get_option('arcade-two-mobile-version');
			if(is_null($allow_mobile_version) || $allow_mobile_version == 'true') {
				echo '<div id="allow_mobile_version"></div>';
			}
			?>
			<div id="mobile-play" style="display: none;">
				<div class="mobile-thumb-play">
					<img src="<?php echo $game->thumb_1 ?>">
				</div>
				<div id="mobile-play-btn">
					<i class="bi bi-play-circle-fill"></i>
				</div>
			</div>
			<div class="game-iframe-container" id="game-player">
				<div id="mobile-back-button" draggable="true">
					<i class="bi bi-x-circle-fill"></i>
				</div>
				<iframe class="game-iframe" id="game-area" src="<?php echo get_game_url($game); ?>" width="<?php echo esc_int($game->width); ?>" height="<?php echo esc_int($game->height); ?>" scrolling="none" frameborder="0" allowfullscreen></iframe>
			</div>
		</div>
		<div class="game-info">
			<div class="header-left">
				<h1 class="single-title"><?php echo htmlspecialchars( $game->title )?></h1>
				<span><?php _e('Played %a times.', esc_int($game->views)) ?></span>
				<div class="rating">
					<?php
					$rating = get_rating('5-decimal', $game);
					for ($i=0; $i < 5; $i++) { 
						if($i < $rating){
							echo '<i class="bi bi-star-fill star-on"></i>';
						} else {
							echo '<i class="bi bi-star-fill star-off"></i>';
						}
					}
					?>
					<?php echo $rating ?> (<?php echo $game->upvote+$game->downvote ?> <?php _e('Reviews') ?>)
				</div>
			</div>
			<div class="header-right">
				<div class="b-action">
					<?php if($login_user){
						$favorited_class = '';
						if(is_favorited_game($game->id)){
							$favorited_class = 'color-red';
						}
						?>
					<a href="#" class="btn btn-capsule <?php echo $favorited_class ?>" id="favorite" data-id="<?php echo $game->id ?>"><i class="bi bi-heart"></i></a>
					<?php } ?>
					<a href="#" class="btn btn-capsule" id="upvote" data-id="<?php echo $game->id ?>"><i class="bi bi-hand-thumbs-up"></i></a>
					<a href="#" class="btn btn-capsule" id="downvote" data-id="<?php echo $game->id ?>"><i class="bi bi-hand-thumbs-down"></i></a>
					<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo htmlspecialchars(get_cur_url()); ?>" target="_blank" class="btn-share"><img src="<?php echo DOMAIN . TEMPLATE_PATH . '/images/facebook.png' ?>" alt="share" class="social-icon" width="40" height="40"></a>
					<a href="https://twitter.com/intent/tweet?url=<?php echo htmlspecialchars(get_cur_url()); ?>" target="_blank" class="btn-share"><img src="<?php echo DOMAIN . TEMPLATE_PATH . '/images/twitter.png' ?>" alt="share" class="social-icon" width="40" height="40"></a>
					<?php if(is_plugin_exist('game-reports')){ ?>
					<a href="#" class="btn btn-capsule" id="report-game"><i class="bi bi-bug b-icon"></i><?php _e('Report') ?></a>
					<?php } ?>
				</div>
				<div class="b-action2">
					<a href="<?php echo get_permalink('full', $game->slug); ?>" target="_blank" class="btn btn-capsule"><i class="bi bi-window-stack b-icon"></i><?php _e('Open in new window') ?></a>
					<a href="#" onclick="open_fullscreen()" class="btn btn-capsule"><i class="bi bi-arrows-fullscreen b-icon"></i><?php _e('Fullscreen') ?></a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<?php widget_aside('top-content') ?>
	<div class="content-wrapper">
		<div class="row">
			<div class="col-md-9 game-content">
				<h5 class="highlight-text"><?php _e('Description') ?>:</h5>
				<div class="single-description">
					<?php echo nl2br( $game->description )?>
				</div>
				<br>
				<h5 class="highlight-text"><?php _e('Instructions') ?>:</h5>
				<div class="single-instructions">
					<?php echo nl2br( $game->instructions )?>
				</div>
				<br>
				<div class="single-leaderboard">
					<div id="content-leaderboard" class="table-responsive" data-id="<?php echo $game->id ?>"></div>
				</div>
				<br>
				<h5 class="highlight-text"><?php _e('Categories') ?>:</h5>
				<p class="cat-list"> 
					<?php if ( $game->category ) {
						echo '<ul class="category-list-game">';
						$categories = commas_to_array($game->category);
						foreach ($categories as $cat) {
							$category = Category::getByName($cat);
							$icon = get_category_icon($category->slug, $category_icons);
							$count = Category::getCategoryCount($category->id);
							if($count > 0){
								echo '<a href="'. get_permalink('category', $category->slug) .'">';
								echo '<li class="cat-item"><span class="icon-category"><img src="'.get_template_path().'/images/icon/'.$icon.'.svg" alt="<?php echo $category_title ?>" width="40" height="40"></span><span class="cat-name">'. esc_string($category->name) .'</span></li>';
								echo '</a>';
							}
						}
						echo '</ul>';
					} ?>
				</p>
				<?php if($options['comments'] === 'true'){
					?>
					<div class="comments-container">
						<div id="comments">
							
						</div>
					</div>
					<?php
				} ?>
				<div class="single-comments">
				</div>
			</div>
			<div class="col-md-3">
				<?php include  TEMPLATE_PATH . "/parts/sidebar.php" ?>
			</div>
		</div>
	</div>
	<div class="bottom-container">
		<h3 class="item-title"><?php _e('Similar games') ?></h3>
		<?php list_games_by_categories($categories, 12) ?>
	</div>
	<?php widget_aside('bottom-content') ?>
</div>
<?php include  TEMPLATE_PATH . "/includes/footer.php" ?>