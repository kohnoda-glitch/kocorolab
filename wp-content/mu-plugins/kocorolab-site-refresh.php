<?php
/**
 * Plugin Name: Kocoro Lab — clearer bilingual site refresh
 * Description: Full bilingual site overlay for production swap. Placeholder nature photos.
 * Version: 1.4.1
 * Author: Kohei Noda
 */

if ( ! defined( 'ABSPATH' ) && php_sapi_name() !== 'cli' ) {
	exit;
}

define( 'KOCOROLAB_REFRESH_DIR', __DIR__ . '/kocorolab-site-refresh' );

require_once KOCOROLAB_REFRESH_DIR . '/copy.php';
require_once KOCOROLAB_REFRESH_DIR . '/publications.php';
require_once KOCOROLAB_REFRESH_DIR . '/chrome.php';

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

function kocorolab_refresh_image_files() {
	return array(
		'hero'        => 'hero-horizon.jpg',
		'spirit'      => 'spirit-sky.jpg',
		'society'     => 'society-green.jpg',
		'environment' => 'environment-ocean.jpg',
	);
}

/**
 * Image lookup, in order:
 * 1. Attachment chosen in Customizer (外観 → カスタマイズ → ココロラボの写真)
 * 2. Same filename dropped into wp-content/uploads/kocorolab-refresh/
 * 3. Bundled placeholder in this plugin's images/ folder
 */
function kocorolab_refresh_image_url( $key ) {
	$files = kocorolab_refresh_image_files();
	if ( ! isset( $files[ $key ] ) ) {
		return '';
	}
	$file = $files[ $key ];

	if ( function_exists( 'get_option' ) ) {
		$attachment_id = absint( get_option( 'kocorolab_img_' . $key ) );
		if ( $attachment_id && function_exists( 'wp_get_attachment_image_url' ) ) {
			$url = wp_get_attachment_image_url( $attachment_id, 'full' );
			if ( $url ) {
				return $url;
			}
		}
	}

	if ( function_exists( 'wp_upload_dir' ) ) {
		$upload = wp_upload_dir();
		$path   = trailingslashit( $upload['basedir'] ) . 'kocorolab-refresh/' . $file;
		if ( is_readable( $path ) ) {
			return trailingslashit( $upload['baseurl'] ) . 'kocorolab-refresh/' . $file;
		}
	}

	if ( defined( 'KOCOROLAB_REFRESH_DIR' ) && is_readable( KOCOROLAB_REFRESH_DIR . '/images/' . $file ) ) {
		if ( function_exists( 'content_url' ) ) {
			return content_url( 'mu-plugins/kocorolab-site-refresh/images/' . $file );
		}
		return 'images/' . $file;
	}

	return 'images/' . $file;
}

function kocorolab_refresh_page_slugs() {
	return array( 'company', 'service', 'member', 'koheinoda', 'hakkou', 'publications', 'contact' );
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
		} else {
			$classes[] = 'kl-refresh-page';
		}
		$classes[] = 'kl-lang-' . kocorolab_refresh_lang();
		return $classes;
	}
);

add_filter(
	'template_include',
	function ( $template ) {
		if ( is_admin() || is_feed() || is_customize_preview() ) {
			return $template;
		}
		if ( function_exists( 'is_login' ) && is_login() ) {
			return $template;
		}
		return KOCOROLAB_REFRESH_DIR . '/wp-view.php';
	},
	99
);

add_action(
	'wp_head',
	function () {
		echo '<style id="kocorolab-refresh-critical">body.kl-refresh #site_wrap{display:block!important}body.kl-refresh #site_loader_overlay,body.kl-refresh #site_loader_spinner{display:none!important}</style>' . "\n";
	},
	0
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
			wp_register_style( 'kocorolab-refresh', false, array(), '1.4.1' );
			wp_enqueue_style( 'kocorolab-refresh' );
			wp_add_inline_style( 'kocorolab-refresh', file_get_contents( $css_file ) );
		}

		wp_add_inline_script(
			'jquery-core',
			'if(window.jQuery&&!jQuery.fn.fullpage){jQuery.fn.fullpage=function(){return this;};}',
			'after'
		);
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
		if ( ! $html ) {
			return $content;
		}
		if ( 'contact' === $post->post_name ) {
			return $html . $content;
		}
		return $html;
	},
	12
);

add_action(
	'customize_register',
	function ( $wp_customize ) {
		$wp_customize->add_section(
			'kocorolab_refresh_images',
			array(
				'title'       => 'ココロラボの写真',
				'description' => 'トップの空・緑・海は、あとから自分で撮った写真に差し替えできます。メディアから選ぶか、wp-content/uploads/kocorolab-refresh/ に同じファイル名で置いてください（hero-horizon.jpg / spirit-sky.jpg / society-green.jpg / environment-ocean.jpg）。',
				'priority'    => 40,
			)
		);

		$labels = array(
			'hero'        => 'トップ（空と海）',
			'spirit'      => '精神（空）',
			'society'     => '社会（緑）',
			'environment' => '環境（海）',
		);

		foreach ( $labels as $key => $label ) {
			$wp_customize->add_setting(
				'kocorolab_img_' . $key,
				array(
					'type'              => 'option',
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Media_Control(
					$wp_customize,
					'kocorolab_img_' . $key,
					array(
						'label'     => $label,
						'section'   => 'kocorolab_refresh_images',
						'mime_type' => 'image',
						'settings'  => 'kocorolab_img_' . $key,
					)
				)
			);
		}
	}
);
