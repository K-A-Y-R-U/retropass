<?php

$category_icons = json_decode( file_get_contents(ABSPATH . TEMPLATE_PATH . '/includes/category-icons.json'), true);
$active_category = '';
if(isset($category)){
	$active_category = $url_params[1];
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=0.9, shrink-to-fit=no" />
		<title><?php echo htmlspecialchars( $page_title )?></title>
		<meta name="description" content="<?php echo substr(esc_string($meta_description), 0, 160) ?>">
		<?php
			if(isset($game)){ //Game page
				?>
				<meta name="twitter:card" content="summary_large_image" />
				<meta name="twitter:title" content="<?php echo htmlspecialchars( $page_title )?>" />
				<meta name="twitter:description" content="<?php echo substr(esc_string($meta_description), 0, 200) ?>" />
				<?php
				if(isset($game->thumb_1)){
					$thumb = $game->thumb_1;
					if(substr($thumb, 0, 1) == '/'){
						$thumb = DOMAIN . substr($thumb, 1);
					}
					echo('<meta name="twitter:image:src" content="'.$thumb.'">');
					echo('<meta property="og:image" content="'.$thumb.'">');
				}
			}
		?>
		<?php load_plugin_headers() ?>
		<link rel="stylesheet" type="text/css" href="<?php echo DOMAIN . TEMPLATE_PATH; ?>/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo DOMAIN . TEMPLATE_PATH; ?>/css/jquery-comments.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo DOMAIN . TEMPLATE_PATH; ?>/css/user.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo DOMAIN . TEMPLATE_PATH; ?>/css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo DOMAIN . TEMPLATE_PATH; ?>/css/custom.css" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
		<!-- Font Awesome icons (free version)-->
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
		<!-- Google fonts-->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
		<?php widget_aside('head') ?>
	</head>
	<body id="page-top">
		<!-- Navigation-->
		<nav class="navbar navbar-expand-lg navbar-dark top-nav" id="mainNav">
			<div class="container">
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav-menu" aria-controls="nav-menu" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<a class="navbar-brand js-scroll-trigger" href="<?php echo DOMAIN ?>"><img src="<?php echo DOMAIN .SITE_LOGO ?>" class="site-logo" alt="site-logo"></a>
				<div class="d-lg-none">
					<?php
					if(is_null($login_user)){
						if(isset($options['show_login']) && $options['show_login'] == 'true'){
							echo('<a class="nav-link" href="'.get_permalink('login').'"><div class="btn btn-circle b-white b-login"><i class="bi bi-person"></i></div></a>');
						}
					}
					?>
					<?php show_user_profile_header() ?>
				</div>
				<div class="navbar-collapse collapse" id="nav-menu">
					<ul class="navbar-nav">
						<?php render_nav_menu('top_nav', array(
							'no_ul'				=> true,
							'li_class_parent'	=> 'dropdown',
							'li_class'			=> 'nav-item',
							'a_class'			=> 'nav-link',
							'a_class_parent'	=> 'dropdown-toggle',
							'bs-5'				=> true,
							'after_parent'		=> '',
							'children'			=> array(
								'li_class'			=> '',
								'a_class'			=> 'dropdown-item',
							)
						)); ?>
					</ul>
					<form class="form-inline my-2 my-lg-0 search-bar" action="/index.php">
						<div class="input-group">
							<input type="hidden" name="viewpage" value="search" />
							<i class="bi bi-search"></i>
							<input type="text" class="form-control search" placeholder="<?php _e('Search game') ?>" name="slug" minlength="2" required />
						</div>
					</form>
				</div>
				<div class="d-none d-lg-block">
					<?php
					if(is_null($login_user)){
						if(isset($options['show_login']) && $options['show_login'] == 'true'){
							echo('<a class="nav-link" href="'.get_permalink('login').'"><div class="btn btn-circle b-white b-login"><i class="bi bi-person"></i></div></a>');
						}
					}
					?>
					<?php show_user_profile_header() ?>
				</div>
			</div>
		</nav>