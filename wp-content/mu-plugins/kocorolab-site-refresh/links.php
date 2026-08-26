<?php
/**
 * Repair dead external URLs in news (Wayback / still-live mirrors)
 * and restore missing YouTube / report links on the page itself.
 */

function kocorolab_refresh_ccl_japan_url() {
	return 'https://japan.citizensclimatelobby.org/';
}

function kocorolab_refresh_seven_generations_url() {
	return 'https://sevengenerations.or.jp/';
}

function kocorolab_refresh_note_url() {
	return 'https://note.com/koheinoda';
}

function kocorolab_refresh_medium_url() {
	return 'https://medium.com/@koheinoda';
}

function kocorolab_refresh_gbx_report_url() {
	return 'https://www.atpress.ne.jp/news/37250';
}

function kocorolab_refresh_is_retired_gbx_path( $path ) {
	return (bool) preg_match( '#(^|/)gbx#i', (string) $path );
}

function kocorolab_refresh_mhq_lp_url( $lang = null ) {
	if ( null === $lang && function_exists( 'kocorolab_refresh_lang' ) ) {
		$lang = kocorolab_refresh_lang();
	}
	$lang = $lang ? $lang : 'ja';
	return kocorolab_refresh_url( '/mhqlp/', '/mhqlp/?lang=en', $lang );
}

function kocorolab_refresh_source_catalog() {
	return array(
		array(
			'keys'  => array( 'フィリピンの貧困', '平本', 'poverty and happiness', 'Hiramoto', '5acopoZcYfw' ),
			'links' => array(
				array(
					'url' => 'https://www.youtube.com/watch?v=5acopoZcYfw',
					'ja'  => 'YouTube動画（平本あきおチャンネル）',
					'en'  => 'YouTube video (Hiramoto Akio Channel)',
				),
			),
		),
		array(
			'keys'  => array( 'U理論の認知感情モデル', 'cognitive affective model of theory U', 'JCSS2025', '日本認知科学会第42回' ),
			'links' => array(
				array(
					'url' => 'https://www.jcss.gr.jp/meetings/jcss2025/proceedings/pdf/JCSS2025_P2-37.pdf',
					'ja'  => '大会予稿PDF',
					'en'  => 'Conference paper (PDF)',
				),
			),
		),
		array(
			'keys'  => array( 'VUCA時代のストレス', 'Stress Defense Strategies in the VUCA', 'B0DTS8XLPD' ),
			'links' => array(
				array(
					'url' => 'https://www.amazon.co.jp/dp/B0DTS8XLPD',
					'ja'  => 'Amazon（VUCA時代のストレス防衛術）',
					'en'  => 'Amazon (Stress Defense Strategies in the VUCA Era)',
				),
			),
		),
		array(
			'keys'  => array( 'うつになりやすいかも', 'would be depression', 'B0DGFRYHMX' ),
			'links' => array(
				array(
					'url' => 'https://www.amazon.co.jp/dp/B0DGFRYHMX',
					'ja'  => 'Amazon（「私、うつになりやすいかも？」と思った時に読む本）',
					'en'  => 'Amazon (the book you should read when you think you would be depression)',
				),
			),
		),
		array(
			'keys'  => array( 'ウェルビーイング時代のチェンジマネジメント', 'Change Management under Well-being', 'PLiSKEuDit5HplW8JI5fHlWPYA32wQwAxp' ),
			'links' => array(
				array(
					'url' => 'https://www.youtube.com/playlist?list=PLiSKEuDit5HplW8JI5fHlWPYA32wQwAxp',
					'ja'  => 'YouTubeシリーズ（ウェルビーイング時代のチェンジマネジメント）',
					'en'  => 'YouTube series (Change Management under Well-being Era)',
				),
			),
		),
		array(
			'keys'  => array( 'amd.tokyo', 'Learning Journey 2018', 'sdgs-learning-journey-2018', '2018報告' ),
			'links' => array(
				array(
					'url' => 'https://web.archive.org/web/20240809025928/https://amd.tokyo/project/3228',
					'ja'  => 'AMD報告ページ（保存版）',
					'en'  => 'AMD report (archived copy)',
				),
			),
		),
		array(
			'keys'  => array( 'kenkoxkoufukutalk', '健康×幸福', '健康x幸福', 'health and happiness' ),
			'links' => array(
				array(
					'url' => 'https://web.archive.org/web/20201128083739/https://peraichi.com/landing_pages/view/kenkoxkoufukutalk',
					'ja'  => '健康×幸福トーク案内（保存版）',
					'en'  => 'Health × happiness talk (archived copy)',
				),
			),
		),
		array(
			'keys'  => array( 'learningjourney2019', 'Learning Journey 2020', 'sdgs-learning-journey-2020' ),
			'links' => array(
				array(
					'url' => 'https://web.archive.org/web/20210513000519/https://peraichi.com/landing_pages/view/learningjourney2019',
					'ja'  => 'SDGs Learning Journey 2020案内（保存版）',
					'en'  => 'SDGs Learning Journey 2020 (archived copy)',
				),
			),
		),
		array(
			'keys'  => array( 'hrm-service', 'article120', 'コロナ禍でのストレス', 'stress during COVID' ),
			'links' => array(
				array(
					'url' => 'https://web.archive.org/web/20230325203317/https://www.hrm-service.net/column/article120/',
					'ja'  => '寄稿本文（保存版）',
					'en'  => 'COVID stress article (archived copy)',
				),
			),
		),
		array(
			'keys'  => array( 'jinjibu', 'MHQ1', 'バージョン１発売', 'version 1 press' ),
			'links' => array(
				array(
					'url' => 'https://service.jinjibu.jp/news/detl/3238/',
					'ja'  => 'MHQ1発売のプレスリリース',
					'en'  => 'MHQ version 1 press release',
				),
			),
		),
		array(
			'keys'  => array( 'atpress', 'GBX', 'Global Business eXperience' ),
			'links' => array(
				array(
					'url' => 'https://www.atpress.ne.jp/news/37250',
					'ja'  => 'GBXのレポート',
					'en'  => 'GBX report',
				),
			),
		),
	);
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

function kocorolab_refresh_related_links_for( $haystack, $lang = 'ja' ) {
	$en  = ( 'en' === $lang );
	$hay = (string) $haystack;
	$out = array();
	foreach ( kocorolab_refresh_source_catalog() as $row ) {
		$hit = false;
		foreach ( $row['keys'] as $key ) {
			$found = function_exists( 'mb_stripos' ) ? mb_stripos( $hay, $key ) : stripos( $hay, $key );
			if ( false !== $found ) {
				$hit = true;
				break;
			}
		}
		if ( ! $hit ) {
			continue;
		}
		foreach ( $row['links'] as $link ) {
			$out[] = array(
				'url'   => $link['url'],
				'label' => $en ? $link['en'] : $link['ja'],
			);
		}
	}
	return $out;
}

function kocorolab_refresh_related_links_html( $haystack, $lang = 'ja' ) {
	$links = kocorolab_refresh_related_links_for( $haystack, $lang );
	if ( ! $links ) {
		return '';
	}
	$heading = ( 'en' === $lang ) ? 'Links' : '関連リンク';
	$html    = '<div class="kl-related-links"><p class="kl-related-kicker">' . esc_html( $heading ) . '</p><ul>';
	foreach ( $links as $link ) {
		$html .= '<li><a href="' . esc_url( $link['url'] ) . '">' . esc_html( $link['label'] ) . '</a></li>';
	}
	$html .= '</ul></div>';
	return $html;
}

function kocorolab_refresh_current_news_haystack( $content = '' ) {
	$hay = (string) $content;
	if ( function_exists( 'get_post' ) ) {
		$post = get_post();
		if ( $post ) {
			$hay .= ' ' . $post->post_title . ' ' . $post->post_name . ' ' . $post->post_content;
		}
	}
	return $hay;
}

function kocorolab_refresh_repair_external_links( $content, $lang = null ) {
	if ( ! is_string( $content ) || '' === $content ) {
		return $content;
	}
	if ( null === $lang ) {
		$lang = function_exists( 'kocorolab_refresh_lang' ) ? kocorolab_refresh_lang() : 'ja';
	}
	$label = ( 'en' === $lang ) ? 'archived copy' : '保存版';

	$content = preg_replace_callback(
		'#<a\s[^>]*href=(["\'])(https?://[^"\']+)\1[^>]*>.*?</a>#is',
		function ( $m ) use ( $label ) {
			$mapped = kocorolab_refresh_remap_url( $m[2] );
			if ( ! $mapped ) {
				return $m[0];
			}
			$out = preg_replace(
				'#href=(["\'])(https?://[^"\']+)\1#i',
				'href=$1' . $mapped[0] . '$1',
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

	return preg_replace_callback(
		'#(<a\s[^>]*>.*?</a>)|(https?://[^\s<]+)#is',
		function ( $m ) use ( $label ) {
			if ( ! empty( $m[1] ) ) {
				return $m[1];
			}
			$mapped = kocorolab_refresh_remap_url( $m[2] );
			if ( ! $mapped ) {
				return $m[0];
			}
			$out = '<a href="' . esc_url( $mapped[0] ) . '">' . esc_html( $m[2] ) . '</a>';
			if ( 'archive' === $mapped[1] ) {
				$out .= '（' . $label . '）';
			}
			return $out;
		},
		$content
	);
}

function kocorolab_refresh_is_publications_markup( $content ) {
	return is_string( $content ) && false !== strpos( $content, 'kl-pubs' );
}

function kocorolab_refresh_is_publications_page() {
	if ( isset( $GLOBALS['KOCORO_PREVIEW_PAGE'] ) && in_array( $GLOBALS['KOCORO_PREVIEW_PAGE'], array( 'hakkou', 'publications' ), true ) ) {
		return true;
	}
	if ( function_exists( 'is_page' ) && is_page( array( 'hakkou', 'publications' ) ) ) {
		return true;
	}
	return false;
}

function kocorolab_refresh_enrich_news_links( $content, $lang = null, $haystack = null ) {
	if ( ! is_string( $content ) ) {
		return $content;
	}
	if ( kocorolab_refresh_is_publications_markup( $content ) || kocorolab_refresh_is_publications_page() ) {
		return $content;
	}
	if ( false !== strpos( $content, 'kl-page' ) || false !== strpos( $content, 'kl-bio' ) || false !== strpos( $content, 'kl-home' ) ) {
		return $content;
	}
	if ( function_exists( 'is_singular' ) && function_exists( 'is_page' ) && is_page() && ! is_singular( 'news' ) ) {
		return $content;
	}
	if ( null === $lang ) {
		$lang = function_exists( 'kocorolab_refresh_lang' ) ? kocorolab_refresh_lang() : 'ja';
	}
	$hay = null !== $haystack ? $haystack : kocorolab_refresh_current_news_haystack( $content );
	if ( false !== strpos( $content, 'kl-related-links' ) ) {
		return $content;
	}
	$box = kocorolab_refresh_related_links_html( $hay, $lang );
	if ( $box ) {
		$content .= "\n" . $box;
	}
	return $content;
}

function kocorolab_refresh_public_text( $content ) {
	$content = kocorolab_refresh_ml_text( $content );
	$content = kocorolab_refresh_retire_xsrv_email( $content );
	$content = kocorolab_refresh_enrich_news_links( $content );
	if ( function_exists( 'make_clickable' ) ) {
		$content = make_clickable( $content );
	}
	$content = kocorolab_refresh_repair_external_links( $content );
	return $content;
}

function kocorolab_refresh_retire_xsrv_email( $content ) {
	$next = kocorolab_refresh_contact_email();
	$content = preg_replace( '/[A-Z0-9._%+-]+@knoda\.xsrv\.jp/i', $next, $content );
	return $content;
}
