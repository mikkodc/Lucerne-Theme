<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package lucerne
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
	//Get Article Type
	$article_type = get_field("article_type");
?>

	<div class="header-type clearfix <?php echo $article_type == 1 ? "linked-article" : "" ?>">

		<?php if(is_user_logged_in()) { ?>
		<!-- Start Sliding Reading List -->
		<div id="reading-list" class="text-light close">
			<div class="button-container">
				<button type="button" name="close-read-list" id="close-read-list"><span class="glyphicon glyphicon-remove"></span></button>
			</div>

			<h3 class="section-title text-light text-center">Reading List</h3>
			<div id="readlist-container"></div>
			</div>
		</div>
		<!-- End Sliding Reading List -->

		<div class="top-bar">
			<div class="container-fluid">
				<ul class="inline-list pull-right">
					<li><a class="reading-link"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>Reading List</a></li>
				</ul>
			</div>
		</div>
		<?php } ?>
		<!-- Start Site Header -->

		<header id="main-header" style="margin-top: <?php echo is_user_logged_in() ? '' : '0'; ?>">

			<div class="logo-bar">
				<div class="container">
					<a href="<?php bloginfo('url') ?>">
						<img src="<?php echo bloginfo('template_directory'); ?>/library/src/img/Lucerne-Logo-Top120.png" alt="">
					</a>
				</div>
			</div>
			<div class="title-bar text-center">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xs-4 col-md-4 text-left">
							<a id="back"><span class="glyphicon glyphicon-chevron-left"></span><span class="hidden-xs">BACK</span></a>
						</div>
						<div class="col-xs-4 col-md-4">
							<h1>Investor Library</h1>
						</div>
						<div class="col-xs-4 visible-xs text-center">
							<ul class="inline-list">
								<li><a class="search-icon"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></li>
								<li><a class="reading-link"><span class="glyphicon glyphicon-list" aria-hidden="true"></span></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="toggle-search">
				<div class="container-fluid">
					<?php get_search_form(); ?>
				</div>
			</div>
		</header>
		<!-- End Site Header --></div>
