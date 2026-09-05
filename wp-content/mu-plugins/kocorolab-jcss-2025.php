<?php
/**
 * Plugin Name: Kocoro Lab — JCSS 2025 publication
 * Description: Adds Kohei Noda's 2025 JCSS proceedings paper to the Japanese and English Publications pages if it is not already listed.
 * Version: 1.0.0
 * Author: Kohei Noda
 */

if ( ! defined( 'ABSPATH' ) && php_sapi_name() !== 'cli' ) {
	exit;
}

/**
 * Official PDF of the 2025 JCSS paper (P2-37, pp. 466-469).
 */
function kocorolab_jcss_2025_pdf_url() {
	return 'https://www.jcss.gr.jp/meetings/jcss2025/proceedings/pdf/JCSS2025_P2-37.pdf';
}

function kocorolab_jcss_2025_pdf_href() {
	$url = kocorolab_jcss_2025_pdf_url();
	return function_exists( 'esc_url' ) ? esc_url( $url ) : $url;
}

function kocorolab_jcss_2025_already_listed( $content ) {
	return false !== strpos( $content, 'JCSS2025_P2-37' )
		|| ( false !== strpos( $content, 'U理論の認知感情モデル' ) && false !== strpos( $content, '第42回' ) )
		|| false !== strpos( $content, 'cognitive affective model of theory U' );
}

/**
 * Japanese 発表文献 page: keep the existing 2025 book entry and insert this paper first.
 */
function kocorolab_jcss_2025_ja_html() {
	$url = kocorolab_jcss_2025_pdf_href();
	return '<p><a href="' . $url . '">野田浩平 (2025) U理論の認知感情モデル. 日本認知科学会第42回大会予稿集, pp. 466-469.</a><br />' . "\n"
		. '<a href="' . $url . '">(Kohei Noda (2025) The cognitive affective model of theory U. Proceedings of the 42nd Annual Meeting of the Japanese Cognitive Science Society, pp. 466-469.)</a></p>' . "\n";
}

/**
 * English Publications page: English citation only, matching the current year-line style.
 */
function kocorolab_jcss_2025_en_html() {
	$url = kocorolab_jcss_2025_pdf_href();
	return '<a href="' . $url . '">Kohei Noda (2025) The cognitive affective model of theory U. Proceedings of the 42nd Annual Meeting of the Japanese Cognitive Science Society, pp. 466-469.</a><br />' . "\n";
}

function kocorolab_jcss_2025_inject( $content, $slug ) {
	if ( kocorolab_jcss_2025_already_listed( $content ) ) {
		return $content;
	}

	if ( 'hakkou' === $slug && false !== strpos( $content, '<h2>2025：</h2>' ) ) {
		return preg_replace(
			'/(<h2>2025：<\/h2>)/u',
			'$1' . "\n" . kocorolab_jcss_2025_ja_html(),
			$content,
			1
		);
	}

	if ( 'publications' === $slug && preg_match( '/<p>2025:\s*/', $content ) ) {
		return preg_replace(
			'/(<p>2025:\s*)/',
			'$1' . kocorolab_jcss_2025_en_html(),
			$content,
			1
		);
	}

	return $content;
}

if ( function_exists( 'add_filter' ) ) {
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

			return kocorolab_jcss_2025_inject( $content, $post->post_name );
		}
	);
}
