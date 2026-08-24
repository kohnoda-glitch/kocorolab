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
$blob       = implode( ' ', array( $ja['who_hr'], $ja['who_body'], $ja['profile_now'], $ja['profile_past'], $en['who_hr'], $en['who_body'], $en['profile_now'], $en['profile_past'], $ja_company, $ja_service, $en_profile ) );

$forbidden = array( '自死', 'グリーフ', '崩壊', '父の病気', '兄の下', 'Inner Transition', 'のタルヘルス', 'ガリバー', 'イントループ', 'チェンジ', 'Gulliver', 'INTLOOP', '准教授', 'リージョナルファカルティ', 'Associate Professor', 'Regional Faculty' );

$images = array( 'hero-horizon.jpg', 'spirit-sky.jpg', 'society-green.jpg', 'environment-ocean.jpg' );
$img_ok = true;
foreach ( $images as $file ) {
	$img_ok = $img_ok
		&& is_readable( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/images/' . $file )
		&& is_readable( dirname( __DIR__ ) . '/wp-content/uploads/kocorolab-refresh/' . $file );
}

$checks = array(
	'JA uses GLOBIS faculty' => ( false !== strpos( $ja['who_body'], '教員' ) && false !== strpos( $ja['cred2'], '教員' ) ),
	'EN uses GLOBIS faculty' => false !== strpos( $en['who_body'], 'GLOBIS faculty' ),
	'research faculty JA' => false !== strpos( $ja['cred1'], 'research faculty' ) && false !== strpos( $ja['who_body'], 'research faculty' ),
	'research faculty EN' => false !== strpos( $en['cred1'], 'research faculty' ),
	'JA mind society environment' => ( false !== strpos( $ja['hero_title'], '精神' ) && false !== strpos( $ja['hero_title'], '社会' ) && false !== strpos( $ja['hero_title'], '環境' ) ),
	'news is activities not diary' => false !== strpos( $ja['news_lead'], 'IDEAS' ) && false !== strpos( $ja['news_lead'], 'MHQ' ) && false !== strpos( $ja['news_lead'], '日記ブログではありません' ),
	'services stay on one page' => false !== strpos( $ja['work_lead'], '下層ページは増やしません' ),
	'service page points to news' => false !== strpos( $ja_service, '/news/' ),
	'company table present' => false !== strpos( $ja_company, 'kl-table' ),
	'JA pubs include JCSS 2025 and 1997' => ( false !== strpos( $ja_pubs, 'JCSS2025_P2-37' ) && false !== strpos( $ja_pubs, '1997' ) && false !== strpos( $ja_pubs, 'VUCA' ) ),
	'EN pubs include JCSS 2025 and 1997' => ( false !== strpos( $en_pubs, 'JCSS2025_P2-37' ) && false !== strpos( $en_pubs, '1997' ) ),
	'placeholder images present' => $img_ok,
	'image helper falls back' => 'images/hero-horizon.jpg' === kocorolab_refresh_image_url( 'hero' ),
	'other slugs untouched' => '' === kocorolab_refresh_page_html( 'mhqlp', 'ja' ),
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
