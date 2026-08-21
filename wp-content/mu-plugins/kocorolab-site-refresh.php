<?php
/**
 * Plugin Name: Kocoro Lab — clearer bilingual site refresh
 * Description: Replaces the dated Avalon full-page home with a readable JA/EN layout, and clarifies company, service, and profile copy without oversharing personal detail.
 * Version: 1.0.0
 * Author: Kohei Noda
 */

if ( ! defined( 'ABSPATH' ) && php_sapi_name() !== 'cli' ) {
	exit;
}

define( 'KOCOROLAB_REFRESH_DIR', __DIR__ . '/kocorolab-site-refresh' );

require_once KOCOROLAB_REFRESH_DIR . '/copy.php';

function kocorolab_refresh_lang() {
	if ( isset( $_GET['lang'] ) && 0 === strpos( sanitize_text_field( wp_unslash( $_GET['lang'] ) ), 'en' ) ) {
		return 'en';
	}

	$request = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
	if ( preg_match( '#/(en)(/|\\?|$)#', $request ) ) {
		return 'en';
	}

	if ( function_exists( 'bogo_get_post_locale' ) && function_exists( 'get_the_ID' ) && get_the_ID() ) {
		$loc = bogo_get_post_locale( get_the_ID() );
		if ( $loc && 0 === strpos( $loc, 'en' ) ) {
			return 'en';
		}
	}

	$locale = function_exists( 'determine_locale' ) ? determine_locale() : ( function_exists( 'get_locale' ) ? get_locale() : 'ja' );
	return ( 0 === strpos( $locale, 'en' ) ) ? 'en' : 'ja';
}

function kocorolab_refresh_url( $ja_path, $en_path = null ) {
	$en_path = null === $en_path ? $ja_path : $en_path;
	$path    = ( 'en' === kocorolab_refresh_lang() ) ? $en_path : $ja_path;
	return function_exists( 'home_url' ) ? home_url( $path ) : $path;
}

function kocorolab_refresh_page_slugs() {
	return array( 'company', 'service', 'member', 'koheinoda' );
}

if ( ! function_exists( 'add_filter' ) ) {
	return;
}

add_filter(
	'body_class',
	function ( $classes ) {
		$classes[] = 'kl-refresh';
		if ( is_front_page() ) {
			$classes[] = 'kl-refresh-home';
		}
		if ( is_page( kocorolab_refresh_page_slugs() ) ) {
			$classes[] = 'kl-refresh-page';
		}
		$classes[] = 'kl-lang-' . kocorolab_refresh_lang();
		return $classes;
	}
);

add_filter(
	'template_include',
	function ( $template ) {
		if ( is_front_page() ) {
			return KOCOROLAB_REFRESH_DIR . '/front-page.php';
		}
		return $template;
	}
);

add_action(
	'wp_enqueue_scripts',
	function () {
		if ( is_front_page() ) {
			wp_dequeue_script( 'fullpage.min' );
			wp_dequeue_script( 'easings.min' );
			wp_dequeue_script( 'scrolloverflow.min' );
			wp_dequeue_style( 'fullpage.min' );
		}

		$css_file = KOCOROLAB_REFRESH_DIR . '/refresh.css';
		if ( is_readable( $css_file ) ) {
			wp_register_style( 'kocorolab-refresh', false, array(), '1.0.0' );
			wp_enqueue_style( 'kocorolab-refresh' );
			wp_add_inline_style( 'kocorolab-refresh', file_get_contents( $css_file ) );
		}
	},
	20
);

add_filter(
	'the_content',
	function ( $content ) {
		if ( is_admin() || ! is_singular( 'page' ) || ! in_the_loop() || ! is_main_query() ) {
			return $content;
		}

		$post = get_post();
		if ( ! $post ) {
			return $content;
		}

		$html = kocorolab_refresh_page_html( $post->post_name, kocorolab_refresh_lang() );
		return $html ? $html : $content;
	},
	12
);
