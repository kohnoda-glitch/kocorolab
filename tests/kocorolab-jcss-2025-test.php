<?php
/**
 * Offline check for the JCSS 2025 insertion (not loaded by WordPress).
 * Run: php tests/kocorolab-jcss-2025-test.php
 */

if ( php_sapi_name() !== 'cli' ) {
	fwrite( STDERR, "Run from CLI.\n" );
	exit( 1 );
}

require dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-jcss-2025.php';

$ja = '<p>intro</p><h2>2025：</h2>' . "\n"
	. '<p><a href="https://amzn.asia/d/3AspZLs">野田浩平, まめ, 海下理恵(2025)</a>VUCA時代のストレス防衛術</p>';

$en = '<p>In our lab.</p><p>2025: Kohei Noda, Mame, Rie Kaishita (2025) Stress Defense Strategies in the VUCA Era: Tips for Preventing Depression and Accumulating Stress</p>';

$ja_out = kocorolab_jcss_2025_inject( $ja, 'hakkou' );
$en_out = kocorolab_jcss_2025_inject( $en, 'publications' );

$ja_before_title = explode( 'U理論', $ja_out )[0];

$checks = array(
	'JA has Japanese title' => false !== strpos( $ja_out, 'U理論の認知感情モデル' ),
	'JA has sole author before title' => false !== strpos( $ja_before_title, '野田浩平 (2025)' ) && false === strpos( $ja_before_title, 'まめ' ),
	'JA keeps existing 2025 book' => false !== strpos( $ja_out, 'VUCA時代のストレス防衛術' ),
	'JA links official PDF' => false !== strpos( $ja_out, 'JCSS2025_P2-37.pdf' ),
	'JA has pages' => false !== strpos( $ja_out, 'pp. 466-469' ),
	'EN has English title' => false !== strpos( $en_out, 'The cognitive affective model of theory U' ),
	'EN has sole author' => false !== strpos( $en_out, 'Kohei Noda (2025) The cognitive affective model' ),
	'EN keeps existing 2025 book' => false !== strpos( $en_out, 'Mame, Rie Kaishita' ),
	'EN has pages' => false !== strpos( $en_out, 'pp. 466-469' ),
	'idempotent JA' => $ja_out === kocorolab_jcss_2025_inject( $ja_out, 'hakkou' ),
	'idempotent EN' => $en_out === kocorolab_jcss_2025_inject( $en_out, 'publications' ),
	'other pages untouched' => $ja === kocorolab_jcss_2025_inject( $ja, 'company' ),
);

$failed = 0;
foreach ( $checks as $label => $ok ) {
	echo ( $ok ? 'OK  ' : 'FAIL' ) . " $label\n";
	if ( ! $ok ) {
		$failed++;
	}
}

if ( $failed ) {
	fwrite( STDERR, "\n--- JA ---\n$ja_out\n--- EN ---\n$en_out\n" );
	exit( 1 );
}

echo "All checks passed.\n";
