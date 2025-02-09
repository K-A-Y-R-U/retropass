<?php include  TEMPLATE_PATH . "/includes/header.php" ?>
<div class="container">
	<div class="game-container">
		<?php widget_aside('top-content') ?>
		<div class="content-wrapper">
			<h3 class="item-title">
				<?php
				$icon = get_category_icon($active_category, $category_icons);
				?>
				<span class="g-icon"><img src="<?php echo get_template_path(); ?>/images/icon/<?php echo $icon; ?>.svg" alt=""></span>
				<?php _e('%a Games', esc_string($archive_title)) ?>
			</h3>
			<p><?php _e('%a games in total.', esc_int($total_games)) ?> <?php _e('Page %a of %b', esc_int($cur_page), esc_int($total_page)) ?></p>
			<?php
			if($category->description != ''){
				echo '<p class="category-description">';
				echo "$category->description</p>";
			}
			?>
			<div class="game-container">
				<div class="row">
					<?php foreach ( $games as $game ) { ?>
					<?php include  TEMPLATE_PATH . "/includes/grid3.php" ?>
					<?php } ?>
				</div>
			</div>
			<div class="pagination-wrapper">
				<nav aria-label="Page navigation">
					<ul class="pagination justify-content-center">
						<?php
						$cur_page = 1;
						if(isset($_GET['page'])){
							$cur_page = esc_string($_GET['page']);
						}
						if($total_page){
							$max = 8;
							$start = 0;
							$end = $max;
							if($max > $total_page){
								$end = $total_page;
							} else {
								$start = $cur_page-$max/2;
								$end = $cur_page+$max/2;
								if($start < 0){
									$start = 0;
								}
								if($end - $start < $max-1){
									$end = $max;
								}
								if($end > $total_page){
									$end = $total_page;
								}
							}
							if($start > 0){
								echo '<li class="page-item"><a class="page-link" href="'. get_permalink('category', $_GET['slug'], array('page' => 1)) .'">1</a></li>';
								echo('<li class="page-item disabled"><span class="page-link">...</span></li>');
							}
							for($i = $start; $i<$end; $i++){
								$disabled = '';
								if($cur_page){
									if($cur_page == ($i+1)){
										$disabled = 'disabled';
									}
								}
								echo '<li class="page-item '.$disabled.'"><a class="page-link" href="'. get_permalink('category', $_GET['slug'], array('page' => $i+1)) .'">'.($i+1).'</a></li>';
							}
							if($end < $total_page){
								echo('<li class="page-item disabled"><span class="page-link">...</span></li>');
								echo '<li class="page-item"><a class="page-link" href="'. get_permalink('category', $_GET['slug'], array('page' => $total_page)) .'">'.$total_page.'</a></li>';
							}
						}
						?>
					</ul>
				</nav>
			</div>
		</div>
		<?php widget_aside('bottom-content') ?>
	</div>
</div>
<?php include  TEMPLATE_PATH . "/includes/footer.php" ?>