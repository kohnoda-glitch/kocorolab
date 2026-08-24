<?php
/**
 * Build a static JA/EN preview of the Kocoro Lab refresh.
 *
 * Usage: php preview-site/build.php
 */
$root = dirname(__DIR__);
$out  = __DIR__;

$GLOBALS['KOCORO_PREVIEW_LANG'] = 'ja';
$GLOBALS['KOCORO_PREVIEW_EN']   = false;
$GLOBALS['KOCORO_PREVIEW_PAGE'] = 'home';
$GLOBALS['KOCORO_PREVIEW_POST'] = null;

function esc_html( $s ) {
	return htmlspecialchars( (string) $s, ENT_QUOTES, 'UTF-8' );
}
function esc_attr( $s ) {
	return htmlspecialchars( (string) $s, ENT_QUOTES, 'UTF-8' );
}
function esc_url( $url ) {
	return htmlspecialchars( (string) $url, ENT_QUOTES, 'UTF-8' );
}

function kocorolab_preview_page_file( $key, $for_en ) {
	$ja = array(
		'home'    => 'index.html',
		'service' => 'service.html',
		'news'    => 'news.html',
		'hakkou'  => 'hakkou.html',
		'company' => 'company.html',
		'member'  => 'member.html',
		'contact' => 'contact.html',
	);
	$en = array(
		'home'    => 'index.html',
		'service' => 'service.html',
		'news'    => 'news.html',
		'hakkou'  => 'publications.html',
		'company' => 'company.html',
		'member'  => 'member.html',
		'contact' => 'contact.html',
	);
	return $for_en ? $en[ $key ] : $ja[ $key ];
}

function kocorolab_preview_href( $key ) {
	$en = ! empty( $GLOBALS['KOCORO_PREVIEW_EN'] );
	$file = kocorolab_preview_page_file( $key, $en );
	return $file;
}

function kocorolab_preview_lang_href() {
	$en      = ! empty( $GLOBALS['KOCORO_PREVIEW_EN'] );
	$page    = $GLOBALS['KOCORO_PREVIEW_PAGE'];
	$other   = kocorolab_preview_page_file( $page, ! $en );
	return $en ? ( '../' . kocorolab_preview_page_file( $page, false ) ) : ( 'en/' . $other );
}

function home_url( $path = '/' ) {
	$map = array(
		'/'                  => 'home',
		'/en/'               => 'home',
		'/service/'          => 'service',
		'/en/service/'       => 'service',
		'/news/'             => 'news',
		'/en/news/'          => 'news',
		'/hakkou/'           => 'hakkou',
		'/en/publications/'  => 'hakkou',
		'/company/'          => 'company',
		'/en/company/'       => 'company',
		'/member/'           => 'member',
		'/en/member/'        => 'member',
		'/contact/'          => 'contact',
		'/en/contact/'       => 'contact',
	);
	$path = (string) $path;
	if ( isset( $map[ $path ] ) ) {
		$key = $map[ $path ];
		$want_en = ( 0 === strpos( $path, '/en/' ) ) || $path === '/en/';
		$here_en = ! empty( $GLOBALS['KOCORO_PREVIEW_EN'] );
		$file    = kocorolab_preview_page_file( $key, $want_en );
		if ( $here_en && $want_en ) {
			return $file;
		}
		if ( $here_en && ! $want_en ) {
			return '../' . $file;
		}
		if ( ! $here_en && $want_en ) {
			return 'en/' . $file;
		}
		return $file;
	}
	if ( $path === '/mhqlp/' ) {
		return 'https://kocorolab.com/mhqlp/';
	}
	return 'https://kocorolab.com' . $path;
}

function kocorolab_refresh_lang() {
	return ( $GLOBALS['KOCORO_PREVIEW_LANG'] === 'en' ) ? 'en' : 'ja';
}

function kocorolab_refresh_url( $ja_path, $en_path = null ) {
	$en_path = ( null === $en_path ) ? $ja_path : $en_path;
	$path    = ( 'en' === kocorolab_refresh_lang() ) ? $en_path : $ja_path;
	return home_url( $path );
}

function kocorolab_refresh_image_url( $key ) {
	$files = array(
		'hero'        => 'hero-horizon.jpg',
		'spirit'      => 'spirit-sky.jpg',
		'society'     => 'society-green.jpg',
		'environment' => 'environment-ocean.jpg',
	);
	$file   = isset( $files[ $key ] ) ? $files[ $key ] : 'hero-horizon.jpg';
	$prefix = ! empty( $GLOBALS['KOCORO_PREVIEW_EN'] ) ? '../images/' : 'images/';
	return $prefix . $file;
}

function get_posts( $args = array() ) {
	$en = ( 'en' === kocorolab_refresh_lang() );
	$items = $en
		? array(
			array( '2026-03-01', 'MIT Sloan IDEAS Asia Pacific brochure', 'news.html' ),
			array( '2025-09-06', 'Paper at the 42nd JCSS annual meeting', 'publications.html' ),
		)
		: array(
			array( '2026-03-01', 'MIT Sloan IDEAS Asia Pacific のパンフレット', 'news.html' ),
			array( '2025-09-06', '日本認知科学会第42回大会で発表', 'hakkou.html' ),
		);
	$out = array();
	foreach ( $items as $item ) {
		$p = new stdClass();
		$p->post_title = $item[1];
		$p->post_date  = $item[0] . ' 00:00:00';
		$p->permalink  = $item[2];
		$out[] = $p;
	}
	return $out;
}

function setup_postdata( $post ) {
	$GLOBALS['KOCORO_PREVIEW_POST'] = $post;
}

function wp_reset_postdata() {
	$GLOBALS['KOCORO_PREVIEW_POST'] = null;
}

function get_the_date( $fmt = 'Y-m-d' ) {
	$post = $GLOBALS['KOCORO_PREVIEW_POST'];
	$ts   = $post ? strtotime( $post->post_date ) : time();
	if ( 'Y-m-d' === $fmt ) {
		return date( 'Y-m-d', $ts );
	}
	return date( 'Y.m.d', $ts );
}

function the_permalink() {
	$post = $GLOBALS['KOCORO_PREVIEW_POST'];
	echo esc_url( $post ? $post->permalink : '#' );
}

function the_title() {
	$post = $GLOBALS['KOCORO_PREVIEW_POST'];
	echo esc_html( $post ? $post->post_title : '' );
}

function get_header() {
}

function get_footer() {
}

require $root . '/wp-content/mu-plugins/kocorolab-site-refresh/copy.php';
require $root . '/wp-content/mu-plugins/kocorolab-site-refresh/chrome.php';

function kocorolab_preview_extra_css() {
	return <<<'CSS'
body.kcl-preview{margin:0;background:#f5f8fa;}
.kcl-banner{margin:0;padding:8px 22px;background:#0e2a36;color:#d7f0ea;font-size:12px;letter-spacing:.04em;line-height:1.5}
.kcl-banner a{color:#7ee0d2}
.kl-page{padding-top:2rem}
CSS;
}

function kocorolab_preview_wrap( $lang, $title, $body, $is_home = false ) {
	$en  = ( $lang === 'en' );
	$css = file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/refresh.css' );
	$cls = $is_home ? 'kl-refresh kl-refresh-home kcl-preview' : 'kl-refresh kl-refresh-page kcl-preview';
	$banner = $en
		? 'Wide landing preview · English — placeholder nature photos. The live site has not changed yet.'
		: 'ワイドなランディングのプレビュー · 日本語 — 自然の写真は仮です。本番サイトはまだ変わっていません。';
	$html  = '<!DOCTYPE html><html lang="' . ( $en ? 'en' : 'ja' ) . '"><head><meta charset="utf-8">';
	$html .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
	$html .= '<title>' . esc_html( $title ) . '</title>';
	$html .= '<link rel="preconnect" href="https://fonts.googleapis.com">';
	$html .= '<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">';
	$html .= '<style>' . $css . kocorolab_preview_extra_css() . '</style></head>';
	$html .= '<body class="' . $cls . '">';
	$html .= '<p class="kcl-banner">' . esc_html( $banner ) . '</p>';
	$html .= $body;
	$html .= '</body></html>';
	return $html;
}

function kocorolab_preview_write( $path, $html ) {
	$dir = dirname( $path );
	if ( ! is_dir( $dir ) ) {
		mkdir( $dir, 0755, true );
	}
	file_put_contents( $path, $html );
	echo 'Wrote ' . $path . ' (' . strlen( $html ) . " bytes)\n";
}

$img_src = $root . '/wp-content/mu-plugins/kocorolab-site-refresh/images';
$img_dst = $out . '/images';
if ( ! is_dir( $img_dst ) ) {
	mkdir( $img_dst, 0755, true );
}
foreach ( array( 'hero-horizon.jpg', 'spirit-sky.jpg', 'society-green.jpg', 'environment-ocean.jpg' ) as $img ) {
	copy( "$img_src/$img", "$img_dst/$img" );
}

$news_ja = '<div class="kl-page"><p class="kl-lead">日記ブログではなく、仕事の節目だけを置く場所です。IDEAS のパンフレットや、メンタルヘルスケア資格の更新といった、たまにしか起きない動きをここに載せます。</p><ul class="kl-news-list"><li><time datetime="2026-03-01">2026.03.01</time><span>MIT Sloan IDEAS Asia Pacific のパンフレットを公開しました。詳細は本番サイトの活動・新着をご覧ください。</span></li><li><time datetime="2025-09-06">2025.09.06</time><span>日本認知科学会第42回大会で「U理論の認知感情モデル」を発表しました。</span></li><li><time>更新予定</time><span>メンタルヘルスケア資格（MHQ）関連の更新は、独立したサービス下層ではなく、この活動・新着にまとめます。</span></li></ul></div>';

$news_en = '<div class="kl-page"><p class="kl-lead">This is not a diary. It is a quiet log of occasional work notes — an IDEAS brochure, an MHQ credential update — rather than extra service pages.</p><ul class="kl-news-list"><li><time datetime="2026-03-01">2026.03.01</time><span>MIT Sloan IDEAS Asia Pacific brochure. See the live Updates page for the original post.</span></li><li><time datetime="2025-09-06">2025.09.06</time><span>Presented “The cognitive affective model of theory U” at the 42nd Annual Meeting of the Japanese Cognitive Science Society.</span></li><li><time>Upcoming</time><span>Mental healthcare qualification (MHQ) notes will also live here, not as a separate service page.</span></li></ul></div>';

$pub_ja = '<div class="kl-page"><p class="kl-lead">研究と現場のあいだで書いてきたものを、年ごとに置いています。2025年の先頭に、日本認知科学会第42回大会の単著発表を追加します。</p><h2>2025</h2><p>野田浩平 (2025). U理論の認知感情モデル. 日本認知科学会第42回大会予稿集, pp. 466-469.<br><a href="https://www.jcss.gr.jp/meetings/jcss2025/proceedings/pdf/JCSS2025_P2-37.pdf">PDF</a></p><p>そのほかの文献は、本番サイトの <a href="https://kocorolab.com/hakkou/">発表文献</a> をご覧ください。</p></div>';

$pub_en = '<div class="kl-page"><p class="kl-lead">Writing from between research and practice, listed by year. A 2025 sole-author paper for the Japanese Cognitive Science Society is added at the top of that year.</p><h2>2025</h2><p>Kohei Noda (2025). The cognitive affective model of theory U. Proceedings of the 42nd Annual Meeting of the Japanese Cognitive Science Society, pp. 466-469.<br><a href="https://www.jcss.gr.jp/meetings/jcss2025/proceedings/pdf/JCSS2025_P2-37.pdf">PDF</a></p><p>The full list remains on the live <a href="https://kocorolab.com/en/publications/">Publications</a> page.</p></div>';

$contact_ja = '<div class="kl-page"><p class="kl-lead">本プレビューではフォームは動きません。本番のお問い合わせは <a href="https://kocorolab.com/contact/">kocorolab.com/contact/</a> をご利用ください。</p><p>メール：info@kocorolab.com</p></div>';
$contact_en = '<div class="kl-page"><p class="kl-lead">This preview does not send messages. Please use the live form at <a href="https://kocorolab.com/en/contact/">kocorolab.com/en/contact/</a>.</p><p>Email: info@kocorolab.com</p></div>';

function kocorolab_preview_render_home() {
	ob_start();
	include dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/front-page.php';
	return ob_get_clean();
}

function kocorolab_preview_render_inner( $lang, $title, $content_html ) {
	if ( preg_match( '/<div class="kl-page">/', $content_html ) ) {
		$content_html = preg_replace( '/<div class="kl-page">/', '<div class="kl-page"><h1>' . esc_html( $title ) . '</h1>', $content_html, 1 );
	} else {
		$content_html = '<div class="kl-page"><h1>' . esc_html( $title ) . '</h1>' . $content_html . '</div>';
	}
	ob_start();
	kocorolab_refresh_site_header();
	echo $content_html;
	kocorolab_refresh_site_footer();
	$body = ob_get_clean();
	$full_title = $title . ( $lang === 'en' ? ' | Kocoro Lab' : ' | ココロラボ' );
	return kocorolab_preview_wrap( $lang, $full_title, $body, false );
}

// Japanese pages
$GLOBALS['KOCORO_PREVIEW_LANG'] = 'ja';
$GLOBALS['KOCORO_PREVIEW_EN']   = false;

$GLOBALS['KOCORO_PREVIEW_PAGE'] = 'home';
kocorolab_preview_write( "$out/index.html", kocorolab_preview_wrap( 'ja', '株式会社ココロラボ', kocorolab_preview_render_home(), true ) );

$GLOBALS['KOCORO_PREVIEW_PAGE'] = 'service';
kocorolab_preview_write( "$out/service.html", kocorolab_preview_render_inner( 'ja', 'サービス', kocorolab_refresh_page_html( 'service', 'ja' ) ) );

$GLOBALS['KOCORO_PREVIEW_PAGE'] = 'news';
kocorolab_preview_write( "$out/news.html", kocorolab_preview_render_inner( 'ja', '活動・新着', $news_ja ) );

$GLOBALS['KOCORO_PREVIEW_PAGE'] = 'hakkou';
kocorolab_preview_write( "$out/hakkou.html", kocorolab_preview_render_inner( 'ja', '発表文献', $pub_ja ) );

$GLOBALS['KOCORO_PREVIEW_PAGE'] = 'company';
kocorolab_preview_write( "$out/company.html", kocorolab_preview_render_inner( 'ja', '会社概要', kocorolab_refresh_page_html( 'company', 'ja' ) . kocorolab_refresh_page_html( 'member', 'ja' ) ) );

$GLOBALS['KOCORO_PREVIEW_PAGE'] = 'member';
kocorolab_preview_write( "$out/member.html", kocorolab_preview_render_inner( 'ja', 'プロフィール', kocorolab_refresh_page_html( 'member', 'ja' ) ) );

$GLOBALS['KOCORO_PREVIEW_PAGE'] = 'contact';
kocorolab_preview_write( "$out/contact.html", kocorolab_preview_render_inner( 'ja', 'お問い合わせ', $contact_ja ) );

// English pages
$GLOBALS['KOCORO_PREVIEW_LANG'] = 'en';
$GLOBALS['KOCORO_PREVIEW_EN']   = true;

$GLOBALS['KOCORO_PREVIEW_PAGE'] = 'home';
kocorolab_preview_write( "$out/en/index.html", kocorolab_preview_wrap( 'en', 'Kocoro Laboratory', kocorolab_preview_render_home(), true ) );

$GLOBALS['KOCORO_PREVIEW_PAGE'] = 'service';
kocorolab_preview_write( "$out/en/service.html", kocorolab_preview_render_inner( 'en', 'Services', kocorolab_refresh_page_html( 'service', 'en' ) ) );

$GLOBALS['KOCORO_PREVIEW_PAGE'] = 'news';
kocorolab_preview_write( "$out/en/news.html", kocorolab_preview_render_inner( 'en', 'News & activities', $news_en ) );

$GLOBALS['KOCORO_PREVIEW_PAGE'] = 'hakkou';
kocorolab_preview_write( "$out/en/publications.html", kocorolab_preview_render_inner( 'en', 'Publications', $pub_en ) );

$GLOBALS['KOCORO_PREVIEW_PAGE'] = 'company';
kocorolab_preview_write( "$out/en/company.html", kocorolab_preview_render_inner( 'en', 'Company', kocorolab_refresh_page_html( 'company', 'en' ) . kocorolab_refresh_page_html( 'member', 'en' ) ) );

$GLOBALS['KOCORO_PREVIEW_PAGE'] = 'member';
kocorolab_preview_write( "$out/en/member.html", kocorolab_preview_render_inner( 'en', 'Profile', kocorolab_refresh_page_html( 'member', 'en' ) ) );

$GLOBALS['KOCORO_PREVIEW_PAGE'] = 'contact';
kocorolab_preview_write( "$out/en/contact.html", kocorolab_preview_render_inner( 'en', 'Contact', $contact_en ) );

file_put_contents( "$out/.nojekyll", "" );
echo "Done.\n";
