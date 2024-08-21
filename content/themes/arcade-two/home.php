<?php include  TEMPLATE_PATH . "/includes/header.php" ?>
<?php widget_aside('header') ?>
<div class="container">
	<div class="category-list-global">
		<?php
		$categories = get_all_categories();
		echo '<ul class="category-list-wrapper">';
		foreach ($categories as $cat) {
			$icon = get_category_icon($cat->slug, $category_icons);
			$count = Category::getCategoryCount($cat->id);
			if($count > 0){
				echo '<a href="'. get_permalink('category', $cat->slug) .'">';
				echo '<li class="cat-item"><span class="icon-category"><img src="'.get_template_path().'/images/icon/'.$icon.'.svg" alt="<?php echo $category_title ?>" width="40" height="40"></span><div class="cat-info"><span class="cat-name">'. esc_string($cat->name) .'</span><div class="cat-game-amount">'._t('%a games', Category::getCategoryCount($cat->id)).'</div></div></li>';
				echo '</a>';
			}
		}
		echo '</ul>';
		?>
	</div>
	<?php widget_aside('top-content') ?>
	<!-- Trending section -->
	<?php
	$games = get_game_list('trending', 12, 0, false)['results'];
	if(count($games) > 3){
	?>
	<h3 class="section-title"><?php _e('Trending') ?></h3>
	<div class="row-list-1 grid-container">
		<div class="list-1-wrapper">
			<?php
			foreach ( $games as $game ) { ?>
				<?php include  TEMPLATE_PATH . "/includes/list1.php" ?>
			<?php } ?>
		</div>
			<button type="button" class="b-left btn btn-default btn-circle btn-lg" id="t-prev">
				<i class="bi bi-caret-left-fill"></i>
			</button>
			<button type="button" class="b-right btn btn-default btn-circle btn-lg" id="t-next">
				<i class="bi bi-caret-right-fill"></i>
			</button>
	</div>
	<?php } ?>
	<!-- New games section -->
	<h3 class="section-title"><?php _e('New games') ?></h3>
	<div class="row grid-container" id="new-games-section">
		<?php
		$games = get_game_list('new', 18, 0, false)['results'];
		foreach ( $games as $game ) { ?>
			<?php include  TEMPLATE_PATH . "/includes/grid1.php" ?>
		<?php } ?>
	</div>
	<div class="b-load-more text-center">
		<button class="btn btn-load-more btn-md" id="load-more1"><?php _e('Load More') ?></button>
	</div>
	<!-- Popular games section -->
	<h3 class="section-title"><?php _e('Popular games') ?></h3>
	<div class="row grid-container">
		<?php
		$games = get_game_list('popular', 12, 0, false)['results'];
		foreach ( $games as $game ) { ?>
			<?php include  TEMPLATE_PATH . "/includes/grid2.php" ?>
		<?php } ?>
	</div>
	<!-- Random games section -->
	<h3 class="section-title"><?php _e('You may like') ?></h3>
	<div class="row grid-container">
		<?php
		$games = get_game_list('random', 12, 0, false)['results'];
		foreach ( $games as $game ) { ?>
			<?php include  TEMPLATE_PATH . "/includes/grid3.php" ?>
		<?php } ?>
	</div>
	<?php widget_aside('bottom-content') ?>
	<?php widget_aside('homepage-bottom') ?>
</div>
<?php include  TEMPLATE_PATH . "/includes/footer.php" ?>