<?php
/**
 * Header
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<!-- Set up Meta -->
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>

	<!-- Set the viewport width to device width for mobile -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=yes">
	<!-- Remove Microsoft Edge's & Safari phone-email styling -->
	<meta name="format-detection" content="telephone=no,email=no,url=no">

	<!-- Add external fonts below (GoogleFonts / Typekit) -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

	<?php wp_head(); ?>
</head>

<body <?php body_class('no-outline body'); ?>>
<?php wp_body_open(); ?>

<!-- BEGIN of header -->
<header class="header">
	<div class="grid-container menu-grid-container">
		<div class="grid-x grid-margin-x align-middle">
			<div class="medium-4 small-12 cell">
				<div class="logo text-center medium-text-left">
					<h1><?php \App\functions\ThemeImages::show_custom_logo(); ?><span class="css-clip"><?php echo get_bloginfo( 'name' ); ?></span></h1>
				</div>
			</div>
			<div class="medium-8 small-12 cell">
				<?php if ( has_nav_menu( 'header-menu' ) ) : ?>
					<div class="title-bar hide-for-medium" data-responsive-toggle="main-menu" data-hide-for="medium">
						<button class="menu-icon" type="button" data-toggle aria-label="<?php _e('Menu','default'); ?>" aria-controls="main-menu"><span></span></button>
						<div class="title-bar-title"><?php _e('Menu','default'); ?></div>
					</div>
					<nav class="top-bar" id="main-menu">
						<?php wp_nav_menu( array(
							'theme_location' => 'header-menu',
							'menu_class'     => 'menu header-menu',
							'items_wrap'     => '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion medium-dropdown" data-submenu-toggle="true" data-multi-open="false" data-close-on-click-inside="false">%3$s</ul>',
							'walker'         => new \App\Setup\ThemeWalkerNav()
						) ); ?>
					</nav>
				<?php endif; ?>
			</div>
		</div>
	</div>
</header>
<!-- END of header -->
