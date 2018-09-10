<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Editorial_Mag
 */

?>
<!doctype html>
<html <?php language_attributes();?> <?php fsmag_html_tag_schema();?>>
<head>
	<meta charset="<?php bloginfo('charset');?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

<?php
function theme_get_customizer_css()
{
    ob_start();

    $text_color = get_theme_mod('text_color', '');
    if (!empty($text_color)) {
        ?>
      body {
        color: <?php echo $text_color; ?>;
      }
      <?php
}

    $link_color = get_theme_mod('link_color', '');
    if (!empty($link_color)) {
        ?>
      a {
        color: <?php echo $link_color; ?>;
        border-bottom-color: <?php echo $link_color; ?>;
      }
      <?php
}

    $link_hover_color = get_theme_mod('link_hover_color', '');
    if (!empty($link_hover_color)) {
        ?>
      a:hover {
        color: <?php echo $link_hover_color; ?> !important;
        border-bottom-color: <?php echo $link_hover_color; ?> !important;
      }
      <?php
}

    $border_color = get_theme_mod('border_color', '');
    if (!empty($border_color)) {
        ?>
      input,
      textarea {
        border-color: <?php echo $border_color; ?>;
      }
      <?php
}

    $tag_hover_color = get_theme_mod('tag_hover_color', '');
    if (!empty($tag_hover_color)) {
        ?>
	#emag-tags a:hover, .widget_tag_cloud .tagcloud a:hover {
    background: <?php echo $tag_hover_color; ?> !important;
}
	<?php
}
    $accent_color = get_theme_mod('accent_color', '');
    if (!empty($accent_color)) {
        ?>
      a:hover {
        color: <?php echo $accent_color; ?>;
        border-bottom-color: <?php echo $accent_color; ?>;
      }

      button,
      input[type="submit"] {
        background-color: <?php echo $accent_color; ?>;
      }
      <?php
}

    $tag_hover_color = get_theme_mod('tag_hover_color', '');
    if (!empty($tag_hover_color)) {
        ?>
			#emag-tags a:hover, .widget_tag_cloud .tagcloud a:hover {
				color: <?php echo $tag_hover_color; ?> !important;
			}
			<?php
}

    $sidebar_background = get_theme_mod('sidebar_background', '');
    if (!empty($sidebar_background)) {
        ?>
      .sidebar {
        background-color: <?php echo $sidebar_background; ?>;
      }
      <?php
}

    $css = ob_get_clean();
    return $css;
}

// Modify our styles registration like so:

function theme_enqueue_styles()
{
//  wp_enqueue_style( 'theme-styles', get_stylesheet_uri() ); // This is where you enqueue your theme's main stylesheet
    $custom_css = theme_get_customizer_css();
    wp_add_inline_style('theme-styles', $custom_css);
}

add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
?>

	<?php wp_head();?>
</head>

<body <?php body_class();?>>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'fsmag');?></a>

	<?php
/**
 * Header Before Blank Hooks
 */
do_action('fsmag_header_before', 5);
?>

	<header id="masthead" class="site-header header-bgimg <?php if (has_header_image()) {echo 'headerimage';}?>" itemscope="itemscope" itemtype="http://schema.org/WPHeader">
		<div class="sticky-menu">
			<div class="sparkle-wrapper">
				<nav class="main-navigation">
					<div class="toggle-button">
						<span class="toggle-bar1"></span>
						<span class="toggle-bar2"></span>
						<span class="toggle-bar3"></span>
					</div>
					<div class="nav-menu">
						<?php
wp_nav_menu(array(
    'theme_location' => 'menu-1',
    'menu_id' => 'primary-menu',
));
?>
					</div>
				</nav>
			</div>
		</div><!-- STICKY MENU -->

		<div class="top-header">
			<div class="sparkle-wrapper">
				<div class="top-nav">
					<?php
wp_nav_menu(array(
    'theme_location' => 'menu-2',
    'menu_id' => 'top-menu',
    'depth' => 2,
));
?>
				</div>
				<div class="top-right">
					<div class="date-time"></div>
					<div class="temprature">
						<?php
$facebook = get_theme_mod('fsmag_social_facebook');
$twitter = get_theme_mod('fsmag_social_twitter');
$linkedin = get_theme_mod('fsmag_social_linkedin');
$youtube = get_theme_mod('fsmag_social_youtube');
?>
						<?php if (!empty($facebook)) {?>
							<a href="<?php echo esc_url($facebook); ?>" target="_blank">
								<i class="icofont fa fa-facebook"></i>
							</a>
						<?php }if (!empty($twitter)) {?>
							<a href="<?php echo esc_url($twitter); ?>" target="_blank">
								<i class="icofont fa fa-twitter"></i>
							</a>
						<?php }if (!empty($youtube)) {?>
							<a href="<?php echo esc_url($youtube); ?>" target="_blank">
								<i class="icofont fa fa-youtube-play"></i>
							</a>
						<?php }if (!empty($linkedin)) {?>
							<a href="<?php echo esc_url($linkedin); ?>" target="_blank">
								<i class="icofont fa fa-linkedin"></i>
							</a>
						<?php }?>
					</div>
				</div>
			</div>
		</div> <!-- TOP HEADER -->
		<div class="bottom-header">
			<div class="sparkle-wrapper">
				<div class="site-logo site-branding">
					<?php the_custom_logo();?>
					<h1 class="site-title">
						<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
							<?php bloginfo('name');?>
						</a>
					</h1>
					<?php
$description = get_bloginfo('description', 'display');
if ($description || is_customize_preview()) {?>
							<p class="site-description">
								<?php echo $description; /* WPCS: xss ok. */ ?>
							</p>
					<?php }?>
				</div> <!-- .site-branding -->

				<div class="header-ad-section">
					<?php
if (is_active_sidebar('headerads')) {
    dynamic_sidebar('headerads');
}
?>
				</div>
			</div>
		</div> <!-- BOTTOM HEADER -->

		<div class="nav-wrap nav-left-align">
			<div class="sparkle-wrapper">
				<nav class="main-navigation">
					<div class="toggle-button">
						<span class="toggle-bar1"></span>
						<span class="toggle-bar2"></span>
						<span class="toggle-bar3"></span>
					</div>
					<div class="nav-menu">
						<?php
wp_nav_menu(array(
    'theme_location' => 'menu-1',
    'menu_id' => 'primary-menu',
));
?>
					</div>
				</nav>

				<div class="nav-icon-wrap">
					<div class="search-wrap">
						<i class="icofont fa fa-search"></i>
						<div class="search-form-wrap">
							<?php get_search_form();?>
						</div>
					</div>
				</div>
			</div>
		</div> <!-- MAIN NAVIGATION -->
	</header>

	<?php
/**
 * Header After Blank Hooks
 */
do_action('fsmag_header_after', 10);

/**
 * Header Breaking News Section
 */
do_action('fsmag_breaking_news', 5);
?>

	<div id="content" class="site-content">
