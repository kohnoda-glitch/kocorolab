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

function esc_attr( $text ) {
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
$ja_profile = kocorolab_refresh_page_html( 'member', 'ja' );
$en_profile = kocorolab_refresh_page_html( 'member', 'en' );
$ja_contact = kocorolab_refresh_page_html( 'contact', 'ja' );
$ja_pubs    = kocorolab_refresh_page_html( 'hakkou', 'ja' );
$en_pubs    = kocorolab_refresh_page_html( 'publications', 'en' );
$ja_bio     = kocorolab_refresh_bio_tabs_html( 'home', 'ja' );
$en_bio     = kocorolab_refresh_bio_tabs_html( 'home', 'en' );
$contact    = kocorolab_refresh_contact_section_html( 'ja' );
$blob       = implode( ' ', array( $ja['who_hr'], $ja['who_body'], $ja['profile_now'], $ja['profile_past'], $ja['profile_note'], $en['who_hr'], $en['who_body'], $en['profile_now'], $en['profile_past'], $en['profile_note'], $ja_company, $ja_service, $ja_profile, $en_profile ) );

$forbidden = array( '自死', 'グリーフ', '崩壊', '父の病気', '兄の下', 'Inner Transition', 'のタルヘルス', 'ガリバー', 'イントループ', 'Gulliver', 'INTLOOP', '准教授', 'リージョナルファカルティ', '触れません', '公開しません', 'does not discuss individual', 'does not describe individual' );

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
	'JA uses official GLOBIS title' => ( false !== strpos( $ja['cred3'], 'グロービス経営大学院 専任教員' ) && false !== strpos( $ja['who_body'], 'グロービス経営大学院 専任教員' ) ),
	'EN uses Associate Professor and Research Faculty' => false !== strpos( $en['cred3'], 'Associate Professor and Research Faculty' ) && false !== strpos( $en['who_body'], 'Globis University Graduate School of Management' ),
	'JA uses official MIT title' => false !== strpos( $ja['cred4'], 'MIT経営大学院グローバルプログラム IDEAS Asia Pacific リージョナル・ファカルティ' ) && false !== strpos( $ja['who_body'], 'リージョナル・ファカルティ' ),
	'EN uses Regional Faculty MIT Sloan Global Program' => false !== strpos( $en['cred4'], 'Regional Faculty, MIT Sloan Global Program IDEAS Asia Pacific' ) && false !== strpos( $en['who_body'], 'Regional Faculty for MIT Sloan Global Program IDEAS Asia Pacific' ),
	'JA doctorate title' => '博士（学術 / 認知科学）' === $ja['cred1'] && false !== strpos( $ja['who_body'], '博士（学術 / 認知科学）' ),
	'EN doctorate title' => 'Ph.D. in Cognitive Science' === $en['cred1'],
	'JA representative director' => false !== strpos( $ja['cred2'], '株式会社ココロラボ 代表取締役' ),
	'hero is company not personal CV' => ( false === strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/front-page.php' ), 'kl-creds' ) && false === strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/front-page.php' ), 'kocorolab_refresh_titles' ) && false === strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/front-page.php' ), 'cred1' ) ),
	'titles stay on named profile' => ( false !== strpos( $ja_profile, '野田' ) && false !== strpos( $ja_profile, '博士（学術 / 認知科学）' ) && false !== strpos( $ja_bio, '野田 浩平' ) ),
	'hero hides placeholder photo notes' => ( false === strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/front-page.php' ), 'hero_photo_note' ) && false === strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/front-page.php' ), 'kl-photo-note' ) && false === strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/copy.php' ), '写真は仮です' ) && false === strpos( file_get_contents( dirname( __DIR__ ) . '/preview-site/build.php' ), '写真は仮です' ) ),
	'JA bio has wellbeing and systems' => ( false !== strpos( $ja['bio_p2_ja'], '認知科学' ) && false !== strpos( $ja['bio_p2_ja'], '万物のウェルビーイング' ) && false !== strpos( $ja['bio_p2_ja'], '地球システム' ) ),
	'EN bio has wellbeing and systems' => ( false !== strpos( $en['bio_p2_en'], 'cognitive science' ) && false !== strpos( $en['bio_p2_en'], 'well-being' ) && false !== strpos( $en['bio_p2_en'], 'planetary system' ) ),
	'JA page includes English Bio tab' => ( false !== strpos( $ja_profile, 'English Bio' ) && false !== strpos( $ja_profile, 'Kohei Noda, Ph.D.' ) && false !== strpos( $ja_profile, 'kl-bio-tab' ) ),
	'EN page includes Japanese bio tab' => ( false !== strpos( $en_profile, '野田 浩平' ) && false !== strpos( $en_profile, '万物のウェルビーイング' ) ),
	'home bio defaults to Japanese' => ( false !== strpos( $ja_bio, 'kl-bio-home-ja' ) && false !== strpos( $ja_bio, 'checked' ) && false !== strpos( $ja_bio, 'English Bio' ) ),
	'EN bio defaults to English' => ( false !== strpos( $en_bio, 'kl-bio-home-en' ) && preg_match( '/id="kl-bio-home-en"[^>]*checked/', $en_bio ) ),
	'contact section has mailto' => ( false !== strpos( $contact, 'mailto:info@kocorolab.com' ) && false !== strpos( $contact, 'id="direct-contact"' ) ),
	'contact lists inquiry topics' => ( false !== strpos( $contact, '講演・研修依頼' ) && false !== strpos( $contact, '組織開発・人財育成コンサルティング' ) && false !== strpos( $contact, '共同研究' ) && false !== strpos( $contact, 'メンタルヘルス / EQアセスメント導入' ) ),
	'contact page has mailto and topics' => ( false !== strpos( $ja_contact, 'mailto:info@kocorolab.com' ) && false !== strpos( $ja_contact, '講演・研修依頼' ) ),
	'contact uses kocorolab.com not retired xsrv' => ( false === strpos( $contact, 'knoda.xsrv.jp' ) && 'info@kocorolab.com' === kocorolab_refresh_contact_email() ),
	'rewrites retired xsrv inbox' => ( false !== strpos( kocorolab_refresh_retire_xsrv_email( 'ご連絡は info@knoda.xsrv.jp または noda@knoda.xsrv.jp へ。' ), 'info@kocorolab.com' ) && false === strpos( kocorolab_refresh_retire_xsrv_email( 'ご連絡は info@knoda.xsrv.jp へ。' ), 'knoda.xsrv.jp' ) ),
	'CSS covers bio tabs and contact' => ( false !== strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/refresh.css' ), '.kl-bio-tabs' ) && false !== strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/refresh.css' ), '.kl-contact' ) && false !== strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/refresh.css' ), '@media (max-width: 900px)' ) ),
	'JA mind society environment' => ( false !== strpos( $ja['hero_badge'], '精神' ) && false !== strpos( $ja['hero_badge'], '社会' ) && false !== strpos( $ja['hero_badge'], '環境' ) ),
	'news is activities not diary' => false !== strpos( $ja['news_lead'], 'IDEAS' ) && false !== strpos( $ja['news_lead'], 'MHQ' ) && false !== strpos( $ja['news_lead'], '日記ブログではありません' ),
	'services stay on one page' => false !== strpos( $ja['work_lead'], '下層ページは増やしません' ),
	'service page points to news' => false !== strpos( $ja_service, '/news/' ),
	'service page links to MHQ2 LP' => false !== strpos( $ja_service, '/mhqlp/' ) && false !== strpos( $ja['svc2_h'], 'MHQ2' ),
	'EN service links to MHQ2 LP' => false !== strpos( kocorolab_refresh_page_html( 'service', 'en' ), '/mhqlp/?lang=en' ),
	'pubs link Hiramoto video and JCSS 2011 PDF' => ( false !== strpos( $ja_pubs, '5acopoZcYfw' ) && false !== strpos( $ja_pubs, 'JCSS2011_P2-26.pdf' ) ),
	'2011 and 2016 JCSS citations are fully linked' => (
		false !== strpos( $ja_pubs, '<a href="https://www.jcss.gr.jp/meetings/jcss2016/proceedings/pdf/JCSS2016_P1-16.pdf">野田浩平, 松岡良彦 (2016)' )
		&& false !== strpos( $ja_pubs, '<a href="https://www.jcss.gr.jp/meetings/JCSS2011/proceedings/pdf/JCSS2011_P2-26.pdf">野田浩平, 宮越大樹' )
		&& false !== strpos( $en_pubs, 'JCSS2016_P1-16.pdf' )
		&& false !== strpos( $en_pubs, '<a href="https://www.jcss.gr.jp/meetings/JCSS2011/proceedings/pdf/JCSS2011_P2-26.pdf">Noda, K., Miyakoshi' )
	),
	'2024 change management links to YouTube series' => (
		false !== strpos( $ja_pubs, 'PLiSKEuDit5HplW8JI5fHlWPYA32wQwAxp' )
		&& false !== strpos( $ja_pubs, '<a href="https://www.youtube.com/playlist?list=PLiSKEuDit5HplW8JI5fHlWPYA32wQwAxp">野田浩平, 松村憲, 小島美佳 (2024)' )
		&& false !== strpos( $en_pubs, 'YouTube series' )
	),
	'publications page has no leftover related-links box' => (
		false === strpos( $ja_pubs, 'kl-related-links' )
		&& false === strpos( kocorolab_refresh_public_text( $ja_pubs ), 'kl-related-links' )
		&& false === strpos( kocorolab_refresh_public_text( $en_pubs ), 'kl-related-links' )
	),
	'JA publications URL is /publications/' => (
		false !== strpos( $ja_profile, '/publications/' )
		&& false === strpos( $ja_profile, '/hakkou/' )
		&& 'https://kocorolab.com/publications/' === kocorolab_refresh_publications_url( 'ja' )
		&& 'https://kocorolab.com/en/publications/' === kocorolab_refresh_publications_url( 'en' )
	),
	'legacy hakkou path maps to publications' => (
		kocorolab_refresh_is_legacy_hakkou_path( kocorolab_refresh_request_path_from( '/hakkou/' ) )
		&& kocorolab_refresh_is_ja_publications_path( kocorolab_refresh_request_path_from( '/publications/' ) )
		&& ! kocorolab_refresh_is_ja_publications_path( kocorolab_refresh_request_path_from( '/en/publications/' ) )
		&& false !== strpos( kocorolab_refresh_page_html( 'publications', 'ja' ), 'JCSS2025_P2-37' )
	),
	'news related links include change-management playlist' => false !== strpos( kocorolab_refresh_related_links_html( 'ウェルビーイング時代のチェンジマネジメントの対談です。', 'ja' ), 'PLiSKEuDit5HplW8JI5fHlWPYA32wQwAxp' ),
	'rewrites AMD link to Wayback' => ( false !== strpos( kocorolab_refresh_repair_external_links( '<a href="https://amd.tokyo/project/3228">https://amd.tokyo/project/3228</a>' ), 'web.archive.org/web/20240809025928' ) && false !== strpos( kocorolab_refresh_repair_external_links( '<a href="https://amd.tokyo/project/3228">https://amd.tokyo/project/3228</a>' ), '保存版' ) ),
	'rewrites Peraichi and HR article to Wayback' => ( false !== strpos( kocorolab_refresh_repair_external_links( '<a href="https://peraichi.com/landing_pages/view/kenkoxkoufukutalk">x</a>' ), '20201128083739' ) && false !== strpos( kocorolab_refresh_repair_external_links( '<a href="https://www.hrm-service.net/column/article120/">x</a>' ), '20230325203317' ) ),
	'rewrites jinjibu to live service URL' => false !== strpos( kocorolab_refresh_repair_external_links( '<a href="https://www.jinjibu.jp/news/detl/3238/">x</a>' ), 'service.jinjibu.jp/news/detl/3238' ),
	'adds Hiramoto YouTube when missing' => false !== strpos( kocorolab_refresh_enrich_news_links( '代表の野田がコーチの平本さんとの対談です。' ), '5acopoZcYfw' ),
	'adds Hiramoto YouTube for 平本さん without あきお' => false !== strpos( kocorolab_refresh_related_links_html( '代表の野田がコーチの平本さんとの対談でフィリピンの幸福度と開発の現状をお話ししました。', 'ja' ), '5acopoZcYfw' ),
	'wraps bare AMD URL with Wayback' => false !== strpos( kocorolab_refresh_repair_external_links( 'AMDさんの報告ページです。 https://amd.tokyo/project/3228' ), 'web.archive.org/web/20240809025928' ),
	'news page shows Wayback and YouTube in the list' => ( false !== strpos( kocorolab_refresh_news_html( 'ja' ), '5acopoZcYfw' ) && false !== strpos( kocorolab_refresh_news_html( 'ja' ), '20240809025928' ) && false !== strpos( kocorolab_refresh_news_html( 'ja' ), '20230325203317' ) ),
	'company table present' => false !== strpos( $ja_company, 'kl-table' ),
	'JA pubs include JCSS 2025 and 1997' => ( false !== strpos( $ja_pubs, 'JCSS2025_P2-37' ) && false !== strpos( $ja_pubs, '1997' ) && false !== strpos( $ja_pubs, 'VUCA' ) ),
	'EN pubs include JCSS 2025 and 1997' => ( false !== strpos( $en_pubs, 'JCSS2025_P2-37' ) && false !== strpos( $en_pubs, '1997' ) ),
	'placeholder images present' => $img_ok,
	'image helper falls back' => 'images/hero-horizon.jpg' === kocorolab_refresh_image_url( 'hero' ),
	'other slugs untouched' => '' === kocorolab_refresh_page_html( 'mhqlp', 'ja' ),
	'shows site wrap instead of loader' => false !== strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/refresh.css' ), 'body.kl-refresh #site_wrap' ),
	'hero keeps photo color without full wash' => ( false === strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/refresh.css' ), 'rgba(6, 16, 28, 0.82)' ) && false !== strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/refresh.css' ), '.kl-hero-copy' ) && false === strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/front-page.php' ), 'kl-hero-glow' ) ),
	'overlay skips Avalon header' => false !== strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/wp-view.php' ), 'Standalone overlay' ) && false === strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/wp-view.php' ), 'get_header();' ),
	'strips qTranslate JA tags' => '本文です。' === trim( kocorolab_refresh_ml_text( '[:ja]本文です。[:en]Body text.[:]', 'ja' ) ),
	'strips qTranslate EN tags' => 'Body text.' === trim( kocorolab_refresh_ml_text( '[:ja]本文です。[:en]Body text.[:]', 'en' ) ),
	'strips MHQ1 ja-only tags' => ( false === strpos( kocorolab_refresh_ml_text( '[:ja]2009年のMHQ1の発売のプレスリリースです。 https://example.com/[:]', 'ja' ), '[:' ) && false !== strpos( kocorolab_refresh_ml_text( '[:ja]2009年のMHQ1の発売のプレスリリースです。 https://example.com/[:]', 'ja' ), 'MHQ1' ) ),
	'EN news uses lang query' => false !== strpos( kocorolab_refresh_page_html( 'service', 'en' ), 'lang=en' ),
	'strips stray HTML label from custom head' => (
		! preg_match( '/^HTML$/m', kocorolab_refresh_strip_stray_head_html( "verify\" />\r\n\r\nHTML\r\n<script type=\"application/ld+json\">\r\n{}\r\n" ) )
		&& false !== strpos( kocorolab_refresh_strip_stray_head_html( "HTML\r\n<script type=\"application/ld+json\">" ), 'application/ld+json' )
		&& false !== strpos( kocorolab_refresh_strip_stray_head_html( '<script src="html5.js"></script>' ), 'html5.js' )
	),
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
