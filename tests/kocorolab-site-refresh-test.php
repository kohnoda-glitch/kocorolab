<?php
/**
 * Run: php tests/kocorolab-site-refresh-test.php
 */

if ( php_sapi_name() !== 'cli' ) {
	fwrite( STDERR, "Run from CLI.\n" );
	exit( 1 );
}

function esc_html( $text ) {
	return htmlspecialchars( (string) $text, ENT_QUOTES, 'UTF-8' );
}

function esc_url( $url ) {
	return $url;
}

function home_url( $path = '' ) {
	return 'https://kocorolab.com' . $path;
}

require dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh.php';

$ja = kocorolab_refresh_copy( 'ja' );
$en = kocorolab_refresh_copy( 'en' );
$ja_company = kocorolab_refresh_page_html( 'company', 'ja' );
$ja_service = kocorolab_refresh_page_html( 'service', 'ja' );
$en_profile = kocorolab_refresh_page_html( 'member', 'en' );
$ja_pubs    = kocorolab_refresh_page_html( 'hakkou', 'ja' );
$en_pubs    = kocorolab_refresh_page_html( 'publications', 'en' );
$blob       = implode( ' ', array( $ja['who_hr'], $ja['who_body'], $ja['profile_now'], $ja['profile_past'], $ja['profile_note'], $en['who_hr'], $en['who_body'], $en['profile_now'], $en['profile_past'], $en['profile_note'], $ja_company, $ja_service, $en_profile ) );

$forbidden = array( '自死', 'グリーフ', '崩壊', '父の病気', '兄の下', 'Inner Transition', 'のタルヘルス', 'ガリバー', 'イントループ', 'チェンジ', 'Gulliver', 'INTLOOP', '准教授', 'リージョナルファカルティ', 'Associate Professor', 'Regional Faculty', '触れません', '公開しません', 'does not discuss individual', 'does not describe individual' );

$images = array( 'hero-horizon.jpg', 'spirit-sky.jpg', 'society-green.jpg', 'environment-ocean.jpg' );
$img_ok = true;
foreach ( $images as $file ) {
	$img_ok = $img_ok
		&& is_readable( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/images/' . $file )
		&& is_readable( dirname( __DIR__ ) . '/wp-content/uploads/kocorolab-refresh/' . $file );
}

$checks = array(
	'JA mission slogan' => '社会と個人の変容をガイドする' === $ja['company_m'] && 'Guiding Transformation for Societies and Individuals' === $ja['company_m_other'],
	'EN mission slogan' => 'Guiding Transformation for Societies and Individuals' === $en['company_m'] && '社会と個人の変容をガイドする' === $en['company_m_other'],
	'JA hero uses live slogan pair' => '社会と個人の変容をガイドする' === $ja['hero_title'] && 'Guiding Transformation for Societies and Individuals' === $ja['hero_title_accent'],
	'EN hero uses live slogan pair' => 'Guiding Transformation for Societies and Individuals' === $en['hero_title'] && '社会と個人の変容をガイドする' === $en['hero_title_accent'],
	'JA uses GLOBIS faculty' => ( false !== strpos( $ja['who_body'], '教員' ) && false !== strpos( $ja['cred2'], '教員' ) ),
	'EN uses Globis University, Research Faculty' => false !== strpos( $en['cred2'], 'Globis University, Research Faculty' ) && false !== strpos( $en['who_body'], 'Globis University, Research Faculty' ),
	'MIT regional faculty JA' => false !== strpos( $ja['cred1'], 'regional faculty' ) && false !== strpos( $ja['who_body'], 'regional faculty' ),
	'MIT regional faculty EN' => false !== strpos( $en['cred1'], 'regional faculty' ) && false !== strpos( $en['who_body'], 'regional faculty' ),
	'JA mind society environment' => ( false !== strpos( $ja['hero_badge'], '精神' ) && false !== strpos( $ja['hero_badge'], '社会' ) && false !== strpos( $ja['hero_badge'], '環境' ) ),
	'news is activities not diary' => false !== strpos( $ja['news_lead'], 'IDEAS' ) && false !== strpos( $ja['news_lead'], 'MHQ' ) && false !== strpos( $ja['news_lead'], '日記ブログではありません' ),
	'services stay on one page' => false !== strpos( $ja['work_lead'], '下層ページは増やしません' ),
	'service page points to news' => false !== strpos( $ja_service, '/news/' ),
	'service page links to MHQ2 LP' => false !== strpos( $ja_service, '/mhqlp/' ) && false !== strpos( $ja['svc2_h'], 'MHQ2' ),
	'EN service links to MHQ2 LP' => false !== strpos( kocorolab_refresh_page_html( 'service', 'en' ), '/mhqlp/?lang=en' ),
	'pubs link Hiramoto video and JCSS 2011 PDF' => ( false !== strpos( $ja_pubs, '5acopoZcYfw' ) && false !== strpos( $ja_pubs, 'JCSS2011_P2-26.pdf' ) ),
	'rewrites AMD link to Wayback' => ( false !== strpos( kocorolab_refresh_repair_external_links( '<a href="https://amd.tokyo/project/3228">https://amd.tokyo/project/3228</a>' ), 'web.archive.org/web/20240809025928' ) && false !== strpos( kocorolab_refresh_repair_external_links( '<a href="https://amd.tokyo/project/3228">https://amd.tokyo/project/3228</a>' ), '保存版' ) ),
	'rewrites Peraichi and HR article to Wayback' => ( false !== strpos( kocorolab_refresh_repair_external_links( '<a href="https://peraichi.com/landing_pages/view/kenkoxkoufukutalk">x</a>' ), '20201128083739' ) && false !== strpos( kocorolab_refresh_repair_external_links( '<a href="https://www.hrm-service.net/column/article120/">x</a>' ), '20230325203317' ) ),
	'rewrites jinjibu to live service URL' => false !== strpos( kocorolab_refresh_repair_external_links( '<a href="https://www.jinjibu.jp/news/detl/3238/">x</a>' ), 'service.jinjibu.jp/news/detl/3238' ),
	'adds Hiramoto YouTube when missing' => false !== strpos( kocorolab_refresh_enrich_news_links( '代表の野田がコーチの平本あきおさんとの対談です。' ), '5acopoZcYfw' ),
	'company table present' => false !== strpos( $ja_company, 'kl-table' ),
	'JA pubs include JCSS 2025 and 1997' => ( false !== strpos( $ja_pubs, 'JCSS2025_P2-37' ) && false !== strpos( $ja_pubs, '1997' ) && false !== strpos( $ja_pubs, 'VUCA' ) ),
	'EN pubs include JCSS 2025 and 1997' => ( false !== strpos( $en_pubs, 'JCSS2025_P2-37' ) && false !== strpos( $en_pubs, '1997' ) ),
	'placeholder images present' => $img_ok,
	'image helper falls back' => 'images/hero-horizon.jpg' === kocorolab_refresh_image_url( 'hero' ),
	'other slugs untouched' => '' === kocorolab_refresh_page_html( 'mhqlp', 'ja' ),
	'shows site wrap instead of loader' => false !== strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/refresh.css' ), 'body.kl-refresh #site_wrap' ),
	'overlay skips Avalon header' => false !== strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/wp-view.php' ), 'Standalone overlay' ) && false === strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/wp-view.php' ), 'get_header();' ),
	'strips qTranslate JA tags' => '本文です。' === trim( kocorolab_refresh_ml_text( '[:ja]本文です。[:en]Body text.[:]', 'ja' ) ),
	'strips qTranslate EN tags' => 'Body text.' === trim( kocorolab_refresh_ml_text( '[:ja]本文です。[:en]Body text.[:]', 'en' ) ),
	'strips MHQ1 ja-only tags' => ( false === strpos( kocorolab_refresh_ml_text( '[:ja]2009年のMHQ1の発売のプレスリリースです。 https://example.com/[:]', 'ja' ), '[:' ) && false !== strpos( kocorolab_refresh_ml_text( '[:ja]2009年のMHQ1の発売のプレスリリースです。 https://example.com/[:]', 'ja' ), 'MHQ1' ) ),
	'EN news uses lang query' => false !== strpos( kocorolab_refresh_page_html( 'service', 'en' ), 'lang=en' ),
);

foreach ( $forbidden as $word ) {
	$checks[ "forbidden:$word" ] = false === strpos( $blob, $word );
}

$failed = 0;
foreach ( $checks as $label => $ok ) {
	echo ( $ok ? 'OK  ' : 'FAIL' ) . " $label\n";
	if ( ! $ok ) {
		$failed++;
	}
}

if ( $failed ) {
	exit( 1 );
}

echo "All checks passed.\n";
