<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<?php $site_header = get_field('header', 'options'); ?>

	<header class="site-header-wrapp">
		<?php get_template_part('template-parts/site/header', null, [
			'currency' => get_field('currency', 'options'),
			'data' => $site_header
		]) ?>

		<?php get_template_part('template-parts/site/menu', null, [
			'countries' => get_terms([
				'taxonomy' => CTCORE_TAXONOMY_COUNTRY,
				'hide_empty' => false,
			]),
			'themes' => get_terms([
				'taxonomy' => 'villa_theme',
				'hide_empty' => false,
			]),
			'primary_button' => get_field('header', 'options')['primary_button'],
			'secondary_button' => get_field('header', 'options')['secondary_button'],
			'social' => get_field('header', 'options')['social'],
		]) ?>
	</header>

	<main class="site-main-section">