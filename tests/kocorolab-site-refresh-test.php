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

$ja_home = kocorolab_refresh_copy( 'ja' );
$en_home = kocorolab_refresh_copy( 'en' );
$ja_company = kocorolab_refresh_page_html( 'company', 'ja' );
$en_company = kocorolab_refresh_page_html( 'company', 'en' );
$ja_service = kocorolab_refresh_page_html( 'service', 'ja' );
$en_profile = kocorolab_refresh_page_html( 'member', 'en' );

$forbidden = array( '自死', 'グリーフ', '崩壊', '父の病気', '兄の下', 'Inner Transition', 'のタルヘルス' );

$blob = $ja_home['who_hr'] . $ja_home['who_body'] . $en_home['who_hr'] . $ja_company . $en_company . $ja_service . $en_profile;

$checks = array(
	'JA names Gulliver INTLOOP Change' => ( false !== strpos( $ja_home['who_hr'], 'ガリバー' ) && false !== strpos( $ja_home['who_hr'], 'イントループ' ) && false !== strpos( $ja_home['who_hr'], 'チェンジ' ) ),
	'EN names Gulliver INTLOOP Change' => ( false !== strpos( $en_home['who_hr'], 'Gulliver' ) && false !== strpos( $en_home['who_hr'], 'INTLOOP' ) && false !== strpos( $en_home['who_hr'], 'Change' ) ),
	'JA has Globis associate professor' => false !== strpos( $ja_home['who_body'], 'グロービス経営大学院准教授' ),
	'EN has MIT regional faculty' => false !== strpos( $en_home['who_body'], 'Regional Faculty' ),
	'JA mentions pre/post listing HR' => ( false !== strpos( $ja_home['who_hr'], '上場前' ) && false !== strpos( $ja_home['who_hr'], '上場後' ) ),
	'company table present' => false !== strpos( $ja_company, 'kl-table' ) && false !== strpos( $ja_company, '2008' ),
	'service has MHQ without typo' => false !== strpos( $ja_service, 'MHQ' ) && false === strpos( $ja_service, 'のタルヘルス' ),
	'profile omits personal chronology' => false === strpos( $en_profile, 'West Germany' ) && false === strpos( $ja_company, 'ハンブルク' ),
	'other slugs untouched' => '' === kocorolab_refresh_page_html( 'contact', 'ja' ),
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
