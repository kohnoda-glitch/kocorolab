<?php
/**
 * Plugin Name: Kocoro Lab — clearer bilingual site refresh
 * Description: Full bilingual site overlay for production swap. Placeholder nature photos.
 * Version: 1.6.2
 * Author: Kohei Noda
 */

if ( ! defined( 'ABSPATH' ) && php_sapi_name() !== 'cli' ) {
	exit;
}

define( 'KOCOROLAB_REFRESH_DIR', __DIR__ . '/kocorolab-site-refresh' );

require_once KOCOROLAB_REFRESH_DIR . '/copy.php';
require_once KOCOROLAB_REFRESH_DIR . '/publications.php';
require_once KOCOROLAB_REFRESH_DIR . '/links.php';
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

function kocorolab_refresh_root() {
	if ( function_exists( 'get_option' ) ) {
		return untrailingslashit( get_option( 'home' ) );
	}
	return 'https://kocorolab.com';
}

function kocorolab_refresh_url( $ja_path, $en_path = null, $lang = null ) {
	$en_path = null === $en_path ? $ja_path : $en_path;
	if ( null === $lang ) {
		$lang = kocorolab_refresh_lang();
	}
	$path = ( 'en' === $lang ) ? $en_path : $ja_path;
	if ( function_exists( 'kocorolab_preview_href' ) || ! function_exists( 'get_option' ) ) {
		return function_exists( 'home_url' ) ? home_url( $path ) : $path;
	}
	return kocorolab_refresh_root() . $path;
}

if ( ! function_exists( 'kocorolab_refresh_publications_url' ) ) {
	function kocorolab_refresh_publications_url( $lang = null ) {
		return kocorolab_refresh_url( '/publications/', '/en/publications/', $lang );
	}
}

function kocorolab_refresh_request_path_from( $uri ) {
	$path = parse_url( (string) $uri, PHP_URL_PATH );
	if ( ! is_string( $path ) || '' === $path ) {
		return '';
	}
	return '/' . trim( $path, '/' );
}

function kocorolab_refresh_is_legacy_hakkou_path( $path ) {
	return '/hakkou' === $path;
}

function kocorolab_refresh_is_ja_publications_path( $path ) {
	return '/publications' === $path;
}

function kocorolab_refresh_news_permalink( $post = null ) {
	$url = function_exists( 'get_permalink' ) ? get_permalink( $post ) : '';
	if ( ! $url ) {
		return '#';
	}
	$url = preg_replace( '#/en/news/#', '/news/', $url );
	if ( 'en' === kocorolab_refresh_lang() ) {
		if ( function_exists( 'remove_query_arg' ) ) {
			$url = remove_query_arg( 'lang', $url );
		}
		$url = function_exists( 'add_query_arg' ) ? add_query_arg( 'lang', 'en', $url ) : $url;
	}
	return $url;
}

function kocorolab_refresh_ml_text( $text, $lang = null ) {
	if ( ! is_string( $text ) || ( false === strpos( $text, '[:' ) && false === strpos( $text, '<!--:' ) ) ) {
		return $text;
	}
	if ( null === $lang ) {
		$lang = function_exists( 'kocorolab_refresh_lang' ) ? kocorolab_refresh_lang() : 'ja';
	}
	$parts = array();
	if ( preg_match_all( '/\[:([a-z]{2})\](.*?)(?=\[:[a-z]{2}\]|\[:\]|$)/s', $text, $matches, PREG_SET_ORDER ) ) {
		foreach ( $matches as $row ) {
			$parts[ $row[1] ] = $row[2];
		}
	}
	if ( preg_match_all( '/<!--:([a-z]{2})-->(.*?)<!--:-->/s', $text, $matches, PREG_SET_ORDER ) ) {
		foreach ( $matches as $row ) {
			$parts[ $row[1] ] = $row[2];
		}
	}
	$want = ( 'en' === $lang ) ? array( 'en' ) : array( 'ja', 'jp' );
	foreach ( $want as $code ) {
		if ( isset( $parts[ $code ] ) && '' !== trim( strip_tags( $parts[ $code ] ) ) ) {
			return $parts[ $code ];
		}
	}
	if ( isset( $parts['ja'] ) ) {
		return $parts['ja'];
	}
	if ( isset( $parts['jp'] ) ) {
		return $parts['jp'];
	}
	if ( isset( $parts['en'] ) ) {
		return $parts['en'];
	}
	return preg_replace( '/\[:[a-z]{0,2}\]|<!--:[a-z]{0,2}-->|<!--:-->/', '', $text );
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

/**
 * Avalon’s custom head field starts with a leftover “HTML” label in front of
 * JSON-LD. Browsers move that text node out of <head> to the top-left of the page.
 */
function kocorolab_refresh_strip_stray_head_html( $html ) {
	if ( ! is_string( $html ) || false === strpos( $html, 'HTML' ) ) {
		return $html;
	}
	return preg_replace( '/(?:^|\r?\n)[ \t]*HTML[ \t]*(?=\r?\n|$)/u', '', $html );
}

if ( ! function_exists( 'add_filter' ) ) {
	return;
}

add_filter(
	'option_dp_options',
	function ( $opts ) {
		if ( is_array( $opts ) && ! empty( $opts['custom_head'] ) ) {
			$opts['custom_head'] = kocorolab_refresh_strip_stray_head_html( $opts['custom_head'] );
		}
		return $opts;
	}
);

add_action(
	'wp_head',
	function () {
		ob_start( 'kocorolab_refresh_strip_stray_head_html' );
	},
	PHP_INT_MIN
);

add_action(
	'wp_head',
	function () {
		if ( ob_get_level() ) {
			ob_end_flush();
		}
	},
	PHP_INT_MAX
);

add_filter(
	'request',
	function ( $query_vars ) {
		$uri  = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
		$path = kocorolab_refresh_request_path_from( $uri );
		if ( kocorolab_refresh_is_ja_publications_path( $path ) ) {
			$query_vars['pagename'] = 'hakkou';
			unset( $query_vars['name'], $query_vars['error'] );
		}
		return $query_vars;
	}
);

add_action(
	'template_redirect',
	function () {
		if ( is_admin() ) {
			return;
		}
		$uri  = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
		$path = kocorolab_refresh_request_path_from( $uri );
		if ( kocorolab_refresh_is_legacy_hakkou_path( $path ) ) {
			wp_safe_redirect( kocorolab_refresh_publications_url( 'ja' ), 301 );
			exit;
		}
	},
	0
);

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
		echo '<style id="kocorolab-refresh-critical">html,body{margin:0;padding:0;background:#f5f8fa}#site_wrap{display:block!important}#site_loader_overlay,#site_loader_spinner{display:none!important}</style>' . "\n";
	},
	0
);

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_dequeue_script( 'fullpage.min' );
		wp_dequeue_script( 'easings.min' );
		wp_dequeue_script( 'scrolloverflow.min' );
		wp_dequeue_style( 'fullpage.min' );

		$css_file = KOCOROLAB_REFRESH_DIR . '/refresh.css';
		if ( is_readable( $css_file ) ) {
			wp_register_style( 'kocorolab-refresh', false, array(), '1.6.2' );
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

add_action(
	'wp_footer',
	function () {
		echo '<script id="kocorolab-refresh-topgap">document.addEventListener("DOMContentLoaded",function(){var b=document.body;if(!b||!b.classList.contains("kl-refresh"))return;while(b.firstChild&&b.firstChild.nodeType===3){if(!/^\\s*(HTML)?\\s*$/i.test(b.firstChild.nodeValue||""))break;b.removeChild(b.firstChild);}if(b.firstChild&&b.firstChild.nodeType===3){b.firstChild.nodeValue=(b.firstChild.nodeValue||"").replace(/^\\s*HTML\\s*/i,"");}});</script>' . "\n";
	},
	1
);

add_filter(
	'the_content',
	function ( $content ) {
		if ( is_admin() ) {
			return $content;
		}
		return kocorolab_refresh_public_text( $content );
	},
	1
);

add_filter(
	'the_content',
	function ( $content ) {
		if ( is_admin() ) {
			return $content;
		}
		return kocorolab_refresh_public_text( $content );
	},
	101
);

add_filter(
	'the_title',
	function ( $title ) {
		if ( is_admin() ) {
			return $title;
		}
		return kocorolab_refresh_ml_text( $title );
	},
	1
);

add_filter(
	'the_title',
	function ( $title ) {
		if ( is_admin() ) {
			return $title;
		}
		return kocorolab_refresh_ml_text( $title );
	},
	101
);

add_filter( 'the_excerpt', 'kocorolab_refresh_public_text', 1 );
add_filter( 'the_excerpt', 'kocorolab_refresh_public_text', 101 );
add_filter( 'widget_text', 'kocorolab_refresh_ml_text', 1 );
add_filter( 'term_description', 'kocorolab_refresh_ml_text', 1 );

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
