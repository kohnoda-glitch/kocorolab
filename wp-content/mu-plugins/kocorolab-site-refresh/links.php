<?php
/**
 * Repair dead external URLs in news (Wayback / still-live mirrors)
 * and restore missing YouTube / report links.
 */

function kocorolab_refresh_mhq_lp_url( $lang = null ) {
	if ( null === $lang && function_exists( 'kocorolab_refresh_lang' ) ) {
		$lang = kocorolab_refresh_lang();
	}
	$lang = $lang ? $lang : 'ja';
	return kocorolab_refresh_url( '/mhqlp/', '/mhqlp/?lang=en', $lang );
}

function kocorolab_refresh_remap_url( $url ) {
	$url = html_entity_decode( (string) $url, ENT_QUOTES, 'UTF-8' );
	if ( false !== strpos( $url, 'web.archive.org/' ) ) {
		return null;
	}
	if ( preg_match( '#amd\.tokyo/project/3228#i', $url ) ) {
		return array(
			'https://web.archive.org/web/20240809025928/https://amd.tokyo/project/3228',
			'archive',
		);
	}
	if ( preg_match( '#peraichi\.com/landing_pages/view/kenkoxkoufukutalk#i', $url ) ) {
		return array(
			'https://web.archive.org/web/20201128083739/https://peraichi.com/landing_pages/view/kenkoxkoufukutalk',
			'archive',
		);
	}
	if ( preg_match( '#peraichi\.com/landing_pages/view/learningjourney2019#i', $url ) ) {
		return array(
			'https://web.archive.org/web/20210513000519/https://peraichi.com/landing_pages/view/learningjourney2019',
			'archive',
		);
	}
	if ( preg_match( '#hrm-service\.net/column/article120#i', $url ) ) {
		return array(
			'https://web.archive.org/web/20230325203317/https://www.hrm-service.net/column/article120/',
			'archive',
		);
	}
	if ( preg_match( '#(?:www\.)?jinjibu\.jp/news/detl/3238#i', $url ) && false === strpos( $url, 'service.jinjibu.jp' ) ) {
		return array(
			'https://service.jinjibu.jp/news/detl/3238/',
			'live',
		);
	}
	return null;
}

function kocorolab_refresh_repair_external_links( $content, $lang = null ) {
	if ( ! is_string( $content ) || '' === $content ) {
		return $content;
	}
	if ( null === $lang ) {
		$lang = function_exists( 'kocorolab_refresh_lang' ) ? kocorolab_refresh_lang() : 'ja';
	}
	$label = ( 'en' === $lang ) ? 'archived copy' : '保存版';

	return preg_replace_callback(
		'#<a\s[^>]*href=(["\'])(https?://[^"\']+)\1[^>]*>.*?</a>#is',
		function ( $m ) use ( $label ) {
			$mapped = kocorolab_refresh_remap_url( $m[2] );
			if ( ! $mapped ) {
				return $m[0];
			}
			$target = $mapped[0];
			$out    = preg_replace(
				'#href=(["\'])(https?://[^"\']+)\1#i',
				'href=$1' . $target . '$1',
				$m[0],
				1
			);
			if ( 'archive' === $mapped[1] && false === strpos( $out, $label ) && false === strpos( $out, '保存版' ) && false === strpos( $out, 'archived copy' ) ) {
				$out .= '（' . $label . '）';
			}
			return $out;
		},
		$content
	);
}

function kocorolab_refresh_enrich_news_links( $content, $lang = null, $haystack = null ) {
	if ( ! is_string( $content ) ) {
		return $content;
	}
	if ( null === $lang ) {
		$lang = function_exists( 'kocorolab_refresh_lang' ) ? kocorolab_refresh_lang() : 'ja';
	}
	$en  = ( 'en' === $lang );
	$hay = null !== $haystack ? $haystack : $content;
	if ( function_exists( 'get_post' ) ) {
		$post = get_post();
		if ( $post ) {
			$hay .= ' ' . $post->post_title . ' ' . $post->post_name;
		}
	}

	$add = array();
	$has = function ( $needle ) use ( $content ) {
		return false !== strpos( $content, $needle );
	};

	if ( preg_match( '/フィリピンの貧困|平本あきお|poverty and happiness|Hiramoto Akio/iu', $hay ) && ! $has( '5acopoZcYfw' ) ) {
		$add[] = $en
			? '<p><a href="https://www.youtube.com/watch?v=5acopoZcYfw">YouTube video (Hiramoto Akio Channel)</a></p>'
			: '<p><a href="https://www.youtube.com/watch?v=5acopoZcYfw">YouTube動画（平本あきおチャンネル）</a></p>';
	}

	if ( preg_match( '/amd\.tokyo|Learning Journey 2018|sdgs-learning-journey-2018/iu', $hay ) && ! $has( '20240809025928' ) && ! $has( 'amd.tokyo/project/3228' ) ) {
		$add[] = $en
			? '<p><a href="https://web.archive.org/web/20240809025928/https://amd.tokyo/project/3228">AMD report (archived copy)</a></p>'
			: '<p><a href="https://web.archive.org/web/20240809025928/https://amd.tokyo/project/3228">AMDさんの報告ページ（保存版）</a></p>';
	}

	if ( preg_match( '/kenkoxkoufukutalk|健康.?幸福トーク/u', $hay ) && ! $has( 'kenkoxkoufukutalk' ) && ! $has( '20201128083739' ) ) {
		$add[] = $en
			? '<p><a href="https://web.archive.org/web/20201128083739/https://peraichi.com/landing_pages/view/kenkoxkoufukutalk">Health × happiness talk page (archived copy)</a></p>'
			: '<p><a href="https://web.archive.org/web/20201128083739/https://peraichi.com/landing_pages/view/kenkoxkoufukutalk">健康×幸福トーク案内（保存版）</a></p>';
	}

	if ( preg_match( '/learningjourney2019|Learning Journey 2020|sdgs-learning-journey-2020/iu', $hay ) && ! $has( 'learningjourney2019' ) && ! $has( '20210513000519' ) ) {
		$add[] = $en
			? '<p><a href="https://web.archive.org/web/20210513000519/https://peraichi.com/landing_pages/view/learningjourney2019">SDGs Learning Journey 2020 page (archived copy)</a></p>'
			: '<p><a href="https://web.archive.org/web/20210513000519/https://peraichi.com/landing_pages/view/learningjourney2019">SDGs Learning Journey 2020案内（保存版）</a></p>';
	}

	if ( preg_match( '/hrm-service|コロナ禍でのストレス|stress during COVID|article120/iu', $hay ) && ! $has( 'article120' ) && ! $has( '20230325203317' ) ) {
		$add[] = $en
			? '<p><a href="https://web.archive.org/web/20230325203317/https://www.hrm-service.net/column/article120/">COVID stress article (archived copy)</a></p>'
			: '<p><a href="https://web.archive.org/web/20230325203317/https://www.hrm-service.net/column/article120/">寄稿本文（保存版）</a></p>';
	}

	if ( preg_match( '/MHQ1|バージョン１発売|version 1 press|jinjibu/iu', $hay ) && ! $has( 'jinjibu.jp/news/detl/3238' ) ) {
		$add[] = $en
			? '<p><a href="https://service.jinjibu.jp/news/detl/3238/">MHQ version 1 press release</a></p>'
			: '<p><a href="https://service.jinjibu.jp/news/detl/3238/">MHQ1発売のプレスリリース</a></p>';
	}

	if ( preg_match( '/GBX|Global Business eXperience|atpress/iu', $hay ) && ! $has( 'atpress.ne.jp/news/37250' ) ) {
		$add[] = $en
			? '<p><a href="https://www.atpress.ne.jp/news/37250">GBX report</a></p>'
			: '<p><a href="https://www.atpress.ne.jp/news/37250">GBXのレポート</a></p>';
	}

	if ( $add ) {
		$content .= "\n" . implode( "\n", $add );
	}
	return $content;
}

function kocorolab_refresh_public_text( $content ) {
	$content = kocorolab_refresh_ml_text( $content );
	$content = kocorolab_refresh_enrich_news_links( $content );
	if ( function_exists( 'make_clickable' ) ) {
		$content = make_clickable( $content );
	}
	$content = kocorolab_refresh_repair_external_links( $content );
	return $content;
}
