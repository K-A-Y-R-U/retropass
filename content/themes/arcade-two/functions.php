<?php

function list_games($type, $amount, $count = false){
	echo '<div class="row gamelist-widget">';
	$data = get_game_list($type, $amount, 0, $count);
	$games = $data['results'];
	foreach ( $games as $game ) { ?>
	<div class="col-4 list-grid">
		<a href="<?php echo get_permalink('game', $game->slug) ?>">
			<div class="list-game">
				<div class="list-thumbnail"><img src="<?php echo get_small_thumb($game) ?>" class="small-thumb img-rounded" alt="<?php echo esc_string($game->title) ?>"></div>
			</div>
		</a>
	</div>
	<?php }
	echo '</div>';
}
function list_games_vertical($type, $amount, $count = false){
	echo '<div class="row gamelist-vertical-widget">';
	$data = get_game_list($type, $amount, 0, $count);
	$games = $data['results'];
	foreach ( $games as $game ) { ?>
	<div class="list-vertical">
		<a href="<?php echo get_permalink('game', $game->slug) ?>">
			<div class="col-12 list-game">
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
		</a>
	</div>
	<?php }
	echo '</div>';
}
function list_games_by_category($cat, $amount){
	echo '<div class="row">';
	$data = get_game_list_category($cat, $amount);
	$games = $data['results'];
	foreach ( $games as $game ) { ?>
		<?php include  TEMPLATE_PATH . "/includes/grid1.php" ?>
	<?php }
	echo '</div>';
}
function list_games_by_categories($cat, $amount){
	echo '<div class="row">';
	$data = get_game_list_categories($cat, $amount);
	$games = $data['results'];
	foreach ( $games as $game ) { ?>
		<?php include  TEMPLATE_PATH . "/includes/grid2.php" ?>
	<?php }
	echo '</div>';
}

function show_user_profile_header(){
	global $login_user;

	if($login_user){
	?>
	<div class="user-avatar">
		<img src="<?php echo get_user_avatar() ?>">
	</div>
	<ul class="user-links hidden">
		<li>
			<strong>
				<?php echo $login_user->username ?>
			</strong>
			<div class="label-xp"><?php echo $login_user->xp ?>xp</div>
		</li>
		<hr>
		<a href="<?php echo get_permalink('user', $login_user->username) ?>">
			<li><?php _e('My Profile') ?></li>
		</a>
		<a href="<?php echo get_permalink('user', $login_user->username, array('edit' => 'edit')) ?>">
			<li><?php _e('Edit Profile') ?></li>
		</a>
		<hr>
		<a href="<?php echo DOMAIN ?>admin.php?action=logout">
			<li class="text-danger"><?php _e('Log Out') ?></li>
		</a>
	</ul>
	<?php
	}
}

register_sidebar(array(
	'name' => 'Head',
	'id' => 'head',
	'description' => 'HTML element before &#x3C;/head&#x3E;',
));

register_sidebar(array(
	'name' => 'Header',
	'id' => 'header',
	'description' => 'Header placement for Header widget',
));

register_sidebar(array(
	'name' => 'Sidebar 1',
	'id' => 'sidebar-1',
	'description' => 'Right sidebar',
));

register_sidebar(array(
	'name' => 'Footer 1',
	'id' => 'footer-1',
	'description' => 'Footer 1',
));

register_sidebar(array(
	'name' => 'Footer 2',
	'id' => 'footer-2',
	'description' => 'Footer 2',
));

register_sidebar(array(
	'name' => 'Footer 3',
	'id' => 'footer-3',
	'description' => 'Footer 3',
));

register_sidebar(array(
	'name' => 'Top Content',
	'id' => 'top-content',
	'description' => 'Above main content element. Recommended for Ad banner placement.',
));

register_sidebar(array(
	'name' => 'Bottom Content',
	'id' => 'bottom-content',
	'description' => 'Under main content element. Recommended for Ad banner placement.',
));

register_sidebar(array(
	'name' => 'Homepage Bottom',
	'id' => 'homepage-bottom',
	'description' => 'Bottom content on homepage. Can be used to show site description or explaining about your site.',
));

register_sidebar(array(
	'name' => 'Footer Copyright',
	'id' => 'footer-copyright',
	'description' => 'Copyright section.',
));

class widget_game_list extends Widget {
	function __construct() {
 		$this->name = 'Game List';
 		$this->id_base = 'game-list';
 		$this->description = 'Show game list ( Grid ). Is recommended to put this on sidebar.';
	}
	public function widget( $instance, $args = array() ){
		$label = isset($instance['label']) ? $instance['label'] : '';
		$class = isset($instance['class']) ? $instance['class'] : 'widget';
		$type = isset($instance['type']) ? $instance['type'] : 'new';
		$amount = isset($instance['amount']) ? $instance['amount'] : 9;

		echo '<div class="'.$class.'">';

		if($label != ''){
			echo '<h4 class="widget-title">'.$label.'</h4>';
		}
		list_games($type, (int)$amount);
		echo '</div>';
	}

	public function form( $instance = array() ){

		if(!isset( $instance['label'] )){
			$instance['label'] = '';
		}
		if(!isset( $instance['type'] )){
			$instance['type'] = 'new';
		}
		if(!isset( $instance['amount'] )){
			$instance['amount'] = 9;
		}
		if(!isset( $instance['class'] )){
			$instance['class'] = 'widget';
		}
		?>
		<div class="form-group">
			<label><?php _e('Widget label/title (optional)') ?>:</label>
			<input type="text" class="form-control" name="label" placeholder="NEW GAMES" value="<?php echo $instance['label'] ?>">
		</div>
		<div class="form-group">
			<label><?php _e('Sort game list by') ?>:</label>
			<select class="form-control" name="type">
				<?php

				$opts = array(
					'new' => 'New',
					'popular' => 'Popular',
					'random' => 'Random',
					'likes' => 'Likes',
					'trending' => 'Trending'
				);

				foreach ($opts as $key => $value) {
					$selected = '';
					if($key == $instance['type']){
						$selected = 'selected';
					}
					echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
				}
				?>
			</select>
		</div>
		<div class="form-group">
			<label><?php _e('Amount') ?>:</label>
			<input type="number" class="form-control" name="amount" placeholder="9" min="1" value="<?php echo $instance['amount'] ?>">
		</div>
		<div class="form-group">
			<label><?php _e('Div class (Optional)') ?>:</label>
			<input type="text" class="form-control" name="class" placeholder="widget" value="<?php echo $instance['class'] ?>">
		</div>
		<?php
	}
}

register_widget( 'widget_game_list' );

class widget_game_list_vertical extends Widget {
	function __construct() {
 		$this->name = 'Game List Vertical';
 		$this->id_base = 'game-list-vertical';
 		$this->description = 'Show game list ( Vertical ). Is recommended to put this on sidebar.';
	}
	public function widget( $instance, $args = array() ){
		$label = isset($instance['label']) ? $instance['label'] : '';
		$class = isset($instance['class']) ? $instance['class'] : 'widget';
		$type = isset($instance['type']) ? $instance['type'] : 'new';
		$amount = isset($instance['amount']) ? $instance['amount'] : 6;

		echo '<div class="'.$class.'">';

		if($label != ''){
			echo '<h4 class="widget-title">'.$label.'</h4>';
		}
		list_games_vertical($type, (int)$amount);
		echo '</div>';
	}

	public function form( $instance = array() ){

		if(!isset( $instance['label'] )){
			$instance['label'] = '';
		}
		if(!isset( $instance['type'] )){
			$instance['type'] = 'new';
		}
		if(!isset( $instance['amount'] )){
			$instance['amount'] = 6;
		}
		if(!isset( $instance['class'] )){
			$instance['class'] = 'widget';
		}
		?>
		<div class="form-group">
			<label><?php _e('Widget label/title (optional)') ?>:</label>
			<input type="text" class="form-control" name="label" placeholder="NEW GAMES" value="<?php echo $instance['label'] ?>">
		</div>
		<div class="form-group">
			<label><?php _e('Sort game list by') ?>:</label>
			<select class="form-control" name="type">
				<?php

				$opts = array(
					'new' => 'New',
					'popular' => 'Popular',
					'random' => 'Random',
					'likes' => 'Likes',
					'trending' => 'Trending'
				);

				foreach ($opts as $key => $value) {
					$selected = '';
					if($key == $instance['type']){
						$selected = 'selected';
					}
					echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
				}
				?>
			</select>
		</div>
		<div class="form-group">
			<label><?php _e('Amount') ?>:</label>
			<input type="number" class="form-control" name="amount" placeholder="6" min="1" value="<?php echo $instance['amount'] ?>">
		</div>
		<div class="form-group">
			<label><?php _e('Div class (Optional)') ?>:</label>
			<input type="text" class="form-control" name="class" placeholder="widget" value="<?php echo $instance['class'] ?>">
		</div>
		<?php
	}
}

register_widget( 'widget_game_list_vertical' );

class Widget_Header extends Widget {
	function __construct() {
 		$this->name = 'Header';
 		$this->id_base = 'header';
 		$this->description = 'Put this widget on Header placement';
	}
	public function widget( $instance, $args = array() ){
		$_style = '';

		if(isset($instance['bg-img']) && $instance['bg-img'] != ''){
			$_style = 'style="background: url('.$instance['bg-img'].'); background-position: center;"';
		}

		?>
		<section class="section-header">
			<div class="container">
				<div class="header-area">
					<div class="masthead-title">
						<h1><?php echo htmlspecialchars($instance['title']) ?></h1>
					</div>
					<div class="masthead-description">
						<h3><?php echo $instance['content'] ?></h3>
					</div>
				</div>
			</div>
		</section>
		<?php
	}

	public function form( $instance = array() ){
		if(!isset( $instance['title'] )){
			$instance['title'] = '';
		}
		if(!isset( $instance['content'] )){
			$instance['content'] = '';
		}
		?>
		<div class="form-group">
			<label>Header Title:</label>
			<input type="text" class="form-control" name="title" value="<?php echo $instance['title'] ?>">
		</div>
		<div class="form-group">
			<label>Description (HTML Allowed):</label>
			<textarea class="form-control" rows="5" name="content"><?php echo $instance['content'] ?></textarea>
		</div>
		<?php
	}
}

register_widget( 'Widget_Header' );

class Widget_Category extends Widget {
	function __construct() {
 		$this->name = 'Categories';
 		$this->id_base = 'categories';
 		$this->description = 'Show all categories';
	}
	public function widget( $instance, $args = array() ){
		$label = isset($instance['label']) ? $instance['label'] : '';
		?>
		<div class="widget">
			<?php
			if($label != ''){
				echo '<h4 class="widget-title">'.$label.'</h4>';
			}
			?>
			<div class="category-wrapper">
				<?php
				global $category_icons;
				$categories = get_all_categories();
				echo '<ul class="category-item">';
				foreach ($categories as $cat) {
					$icon = get_category_icon($cat->slug, $category_icons);
					$count = Category::getCategoryCount($cat->id);
					if($count > 0){
						echo '<a href="'. get_permalink('category', $cat->slug) .'"><li><span class="icon-category"><img src="'.get_template_path().'/images/icon/'.$icon.'.svg" alt="<?php echo $category_title ?>" width="40" height="40"></span>'. esc_string($cat->name) .'</li></a>';
					}
				}
				echo '</ul>';
				?>
			</div>
		</div>
		<div class="clearfix"></div>
		<?php
	}

	public function form( $instance = array() ){
		if(!isset( $instance['label'] )){
			$instance['label'] = '';
		}
		?>
		<div class="form-group">
			<label><?php _e('Widget label/title (optional)') ?>:</label>
			<input type="text" class="form-control" name="label" placeholder="Categories" value="<?php echo $instance['label'] ?>">
		</div>
		<?php
	}
}

register_widget( 'Widget_Category' );

if(file_exists(ABSPATH . TEMPLATE_PATH . '/includes/custom.php')){
	include(ABSPATH . TEMPLATE_PATH . '/includes/custom.php');
}

?>