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

function wp_unslash( $value ) {
	return $value;
}

function sanitize_text_field( $value ) {
	return is_string( $value ) ? trim( $value ) : $value;
}

$overlay_dir = dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh';
$stray_tmp   = sys_get_temp_dir() . '/kl-stray-' . uniqid();
mkdir( $stray_tmp );
$stray_files = array( 'archive-news.php', 'single-news.php', 'front-page.php', 'copy.php', 'chrome.php', 'links.php', 'publications.php', 'wp-view.php' );
foreach ( $stray_files as $stray ) {
	copy( $overlay_dir . '/' . $stray, $stray_tmp . '/' . $stray );
	ob_start();
	include $stray_tmp . '/' . $stray;
	ob_end_clean();
}

require dirname( __DIR__ ) . '/wp-content/mu-plugins/0-kocorolab-refresh-guard.php';
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
$ja_lp      = kocorolab_refresh_page_html( 'mhqlp', 'ja' );
$en_lp      = kocorolab_refresh_page_html( 'mhqlp', 'en' );
$en_contact = kocorolab_refresh_page_html( 'contact', 'en' );
$blob       = implode( ' ', array( $ja['who_hr'], $ja['who_body'], $ja['profile_now'], $ja['profile_past'], $ja['profile_note'], $en['who_hr'], $en['who_body'], $en['profile_now'], $en['profile_past'], $en['profile_note'], $ja_company, $ja_service, $ja_profile, $en_profile, $ja_contact, $en_contact, $ja_lp, $en_lp ) );

$forbidden = array( '自死', 'グリーフ', '崩壊', '父の病気', '兄の下', 'Inner Transition', 'のタルヘルス', 'ガリバー', 'イントループ', 'Gulliver', 'INTLOOP', '准教授', 'リージョナルファカルティ', '特任教授', 'リードファカルティ', 'Lead Faculty', '触れません', '公開しません', 'does not discuss individual', 'does not describe individual' );

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
	'profile links CCL Japan, Seven Generations, note, and Medium' => (
		false !== strpos( $ja_profile, 'japan.citizensclimatelobby.org' )
		&& false !== strpos( $ja_profile, 'sevengenerations.or.jp' )
		&& false !== strpos( $ja_profile, 'note.com/koheinoda' )
		&& false !== strpos( $ja_profile, 'medium.com/@koheinoda_11596' )
		&& false !== strpos( $ja_profile, '市民気候ロビージャパン' )
		&& false !== strpos( $ja_profile, '超党派の対話' )
		&& false !== strpos( $ja_profile, 'セブン・ジェネレーションズ' )
		&& false !== strpos( $en_profile, 'Citizens’ Climate Lobby Japan' )
		&& false !== strpos( $en_profile, 'nonpartisan citizen dialogue' )
		&& false !== strpos( $en_profile, 'NPO Seven Generations' )
		&& false !== strpos( $en_profile, 'medium.com/@koheinoda_11596' )
	),
	'home and company bios also link civic roles' => (
		false !== strpos( $ja_bio, 'japan.citizensclimatelobby.org' )
		&& false !== strpos( $ja_bio, 'note.com/koheinoda' )
		&& false !== strpos( $ja_bio, 'medium.com/@koheinoda_11596' )
		&& false !== strpos( $ja_company, 'japan.citizensclimatelobby.org' )
		&& false !== strpos( $ja_company, 'sevengenerations.or.jp' )
		&& false !== strpos( $ja['cred5'], '市民気候ロビージャパン' )
		&& false !== strpos( $ja['cred6'], 'セブン・ジェネレーションズ' )
	),
	'profile includes education and career' => (
		false !== strpos( $ja_profile, '東京工業大学' )
		&& false !== strpos( $ja_profile, 'SPEA' )
		&& false !== strpos( $ja_profile, 'ドゥマゲテ' )
		&& false !== strpos( $ja_profile, 'pro-japan.jp/school/spea' )
		&& false !== strpos( $ja_profile, 'SPEAnew22019.pdf' )
		&& false !== strpos( $ja_profile, '学校案内PDF（2019）' )
		&& false !== strpos( $en_profile, '2019 school brochure PDF' )
		&& false !== strpos( $ja_profile, 'youtube.com/watch?v=n_Wcw5cKZ6A' )
		&& false !== strpos( $ja_profile, 'youtube.com/@Speastartingpoitenglishacademy' )
		&& false !== strpos( $ja_profile, 'researchmap.jp/kohnoda' )
		&& false === strpos( $ja_profile, 'フェリス' )
		&& false === strpos( $ja_profile, '非常勤' )
		&& false === strpos( $ja_profile, '大学を設立' )
		&& false === strpos( $ja_profile, 'K-12' )
		&& false === strpos( $ja_profile, 'ラーニングジャーニー' )
		&& false === strpos( $ja_profile, '廉価' )
		&& false !== strpos( $ja_profile, 'グリーン・スクール' )
		&& false !== strpos( $ja_profile, '現地の人' )
		&& false === strpos( $ja_profile, 'u.lab 2x' )
		&& false === strpos( $ja_profile, 'シュタイナー' )
		&& false === strpos( $ja_profile, 'ジュリー' )
		&& false === strpos( $en_profile, 'Julie Arts' )
		&& false === strpos( $en_profile, 'Societal Transformation Lab' )
		&& false === strpos( $en_profile, 'Steiner' )
		&& false !== strpos( $ja['education_essence'], '公教育' )
		&& false !== strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/front-page.php' ), 'education_essence' )
		&& false !== strpos( $en_profile, 'Starting Point English Academy' )
		&& false !== strpos( $en_profile, 'Dumaguete' )
		&& false !== strpos( $en_profile, 'Green School' )
		&& false !== strpos( $en_profile, 'local families' )
		&& false !== strpos( $ja_profile, '株式会社グロービス' )
		&& false !== strpos( $ja_profile, 'MHQ' )
		&& false === strpos( $ja_profile, '学歴' )
		&& false === strpos( $ja_profile, '職歴' )
		&& false === strpos( $en_profile, '<h3>Education' )
		&& false === strpos( $en_profile, '<h3>Career' )
		&& false !== strpos( $en_profile, 'Tokyo Institute of Technology' )
		&& false !== strpos( $en_profile, 'Philippines' )
		&& false !== strpos( $en_profile, 'GLOBIS Corporation' )
		&& false === strpos( $ja_profile, 'アンダーセン' )
		&& false === strpos( $ja_profile, 'リクルート' )
		&& false === strpos( $en_profile, 'Andersen' )
		&& false === strpos( $en_profile, 'Recruit' )
	),
	'hero hides placeholder photo notes' => ( false === strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/front-page.php' ), 'hero_photo_note' ) && false === strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/front-page.php' ), 'kl-photo-note' ) && false === strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/copy.php' ), '写真は仮です' ) && false === strpos( file_get_contents( dirname( __DIR__ ) . '/preview-site/build.php' ), '写真は仮です' ) ),
	'JA bio has wellbeing and systems' => ( false !== strpos( $ja['bio_p2_ja'], '認知科学' ) && false !== strpos( $ja['bio_p2_ja'], '万物のウェルビーイング' ) && false !== strpos( $ja['bio_p2_ja'], '地球システム' ) ),
	'EN bio has wellbeing and systems' => ( false !== strpos( $en['bio_p2_en'], 'cognitive science' ) && false !== strpos( $en['bio_p2_en'], 'well-being' ) && false !== strpos( $en['bio_p2_en'], 'planetary system' ) ),
	'JA page includes English Bio tab' => ( false !== strpos( $ja_profile, 'English Bio' ) && false !== strpos( $ja_profile, 'Kohei Noda, Ph.D.' ) && false !== strpos( $ja_profile, 'kl-bio-tab' ) ),
	'EN page includes Japanese bio tab' => ( false !== strpos( $en_profile, '野田 浩平' ) && false !== strpos( $en_profile, '万物のウェルビーイング' ) ),
	'home bio defaults to Japanese' => ( false !== strpos( $ja_bio, 'kl-bio-home-ja' ) && false !== strpos( $ja_bio, 'checked' ) && false !== strpos( $ja_bio, 'English Bio' ) ),
	'EN bio defaults to English' => ( false !== strpos( $en_bio, 'kl-bio-home-en' ) && preg_match( '/id="kl-bio-home-en"[^>]*checked/', $en_bio ) ),
	'contact section has mailto' => ( false !== strpos( $contact, 'mailto:info@kocorolab.com' ) && false !== strpos( $contact, 'id="direct-contact"' ) ),
	'contact lists inquiry topics' => ( false !== strpos( $contact, '講演・研修依頼' ) && false !== strpos( $contact, '組織開発・人財育成コンサルティング' ) && false !== strpos( $contact, '共同研究' ) && false !== strpos( $contact, 'MHQ2（企業導入 / 個人受験）' ) && false !== strpos( $contact, 'メディア取材・寄稿' ) ),
	'MHQ2 is also for individuals' => (
		false !== strpos( $ja['card2_body'], '個人でも受験' )
		&& false !== strpos( $ja['card2_body'], '特性' )
		&& false !== strpos( $ja['svc2_b'], '個人でも受験' )
		&& false !== strpos( $ja['svc2_b'], '診断の確定を目的としたものではありません' )
		&& false !== strpos( $ja_service, '個人向けランディング' )
		&& false !== strpos( $ja_service, '/mhqlp/' )
		&& false === strpos( $ja_service, '/mhq2/' )
		&& false !== strpos( $ja_service, '/mhq-read/' )
		&& false !== strpos( $ja_service, '数字は病名ではありません' )
		&& false !== strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/front-page.php' ), 'kocorolab_refresh_mhq_lp_url' )
		&& false === strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/front-page.php' ), '<a class="kl-soft-card"' )
		&& false !== strpos( $en['card2_body'], 'individuals' )
		&& false !== strpos( kocorolab_refresh_page_html( 'service', 'en' ), '/mhqlp/?lang=en' )
		&& false === strpos( kocorolab_refresh_page_html( 'service', 'en' ), '/en/mhq2/' )
		&& false !== strpos( kocorolab_refresh_page_html( 'service', 'en' ), 'not a diagnosis' )
	),
	'one B2C landing on /mhqlp/ with current profile' => (
		false !== strpos( $ja_lp, '自分の特性に、注意を向ける' )
		&& false !== strpos( $ja_lp, '120問' )
		&& false !== strpos( $ja_lp, 'フィードバックセッション' )
		&& false !== strpos( $ja_lp, '簡易版' )
		&& false !== strpos( $ja_lp, 'ストレス環境' )
		&& false !== strpos( $ja_lp, 'B0DGFRYHMX' )
		&& false !== strpos( $ja_lp, 'B0DTS8XLPD' )
		&& false !== strpos( $ja_lp, '近年の2冊' )
		&& false !== strpos( $ja_lp, '/mhq-read/' )
		&& false !== strpos( $ja_lp, '診断ではなく' )
		&& false !== strpos( $ja_lp, '専任教員' )
		&& false !== strpos( $ja_lp, 'リージョナル・ファカルティ' )
		&& false !== strpos( $ja_lp, '/member/' )
		&& false !== strpos( $ja_lp, '企業導入' )
		&& false === strpos( $ja_lp, '読解セッション' )
		&& false === strpos( $ja_lp, 'この先数週' )
		&& false === strpos( $ja_lp, 'リサーチファカルティ' )
		&& false === strpos( $ja_lp, '特任教授' )
		&& false === strpos( $ja_lp, 'リードファカルティ' )
		&& $ja_lp === kocorolab_refresh_page_html( 'mhq2', 'ja' )
		&& false !== strpos( kocorolab_refresh_page_html( 'mhq-read', 'ja' ), '見本' )
		&& false !== strpos( kocorolab_refresh_page_html( 'mhq-read', 'ja' ), '本番の結果画面ではありません' )
		&& false !== strpos( kocorolab_refresh_page_html( 'mhq-read', 'ja' ), '/mhqlp/' )
		&& false === strpos( kocorolab_refresh_page_html( 'mhq-read', 'ja' ), '気分の沈み' )
		&& 'mhqlp' === kocorolab_refresh_slug_from_path( '/mhqlp' )
		&& 'mhqlp' === kocorolab_refresh_slug_from_path( '/mhq' )
		&& 'mhq-read' === kocorolab_refresh_slug_from_path( '/en/mhq-read' )
		&& kocorolab_refresh_is_legacy_mhq2_path( '/mhq2' )
		&& kocorolab_refresh_is_legacy_mhq2_path( '/en/mhq2' )
		&& ! kocorolab_refresh_is_virtual_page_path( '/mhq2' )
		&& ! kocorolab_refresh_is_forced_overlay_path( '/mhq2' )
		&& kocorolab_refresh_is_virtual_page_path( '/mhq-read' )
		&& kocorolab_refresh_is_mhq_lp_path( '/mhqlp' )
		&& 'https://kocorolab.com/mhqlp/' === kocorolab_refresh_mhq2_url( 'ja' )
		&& 'https://kocorolab.com/mhqlp/?lang=en' === kocorolab_refresh_mhq2_url( 'en' )
	),
	'virtual MHQ sample does not fake a WordPress post' => (function () {
		$prev_uri = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : null;
		$prev_q   = isset( $GLOBALS['wp_query'] ) ? $GLOBALS['wp_query'] : null;
		$prev_p   = isset( $GLOBALS['post'] ) ? $GLOBALS['post'] : null;
		$_SERVER['REQUEST_URI'] = '/mhq-read/';
		$GLOBALS['wp_query']    = (object) array( 'is_404' => true, 'is_page' => true, 'is_singular' => true, 'queried_object' => (object) array( 'ID' => 1 ) );
		$GLOBALS['post']        = (object) array( 'ID' => 2147483000 );
		kocorolab_refresh_mark_not_404();
		$ok = (
			false === $GLOBALS['wp_query']->is_404
			&& false === $GLOBALS['wp_query']->is_page
			&& false === $GLOBALS['wp_query']->is_singular
			&& empty( $GLOBALS['wp_query']->queried_object )
			&& ! isset( $GLOBALS['post'] )
		);
		if ( null === $prev_uri ) {
			unset( $_SERVER['REQUEST_URI'] );
		} else {
			$_SERVER['REQUEST_URI'] = $prev_uri;
		}
		$GLOBALS['wp_query'] = $prev_q;
		if ( null === $prev_p ) {
			unset( $GLOBALS['post'] );
		} else {
			$GLOBALS['post'] = $prev_p;
		}
		return $ok;
	} )(),
	'press kit uses official titles and English interviews' => (
		false !== strpos( $ja_profile, 'id="media"' )
		&& false !== strpos( $ja_profile, '日本語と英語の取材に応じます' )
		&& false !== strpos( $ja_profile, '専任教員' )
		&& false !== strpos( $ja_profile, 'リージョナル・ファカルティ' )
		&& false === strpos( $ja_profile, '特任教授' )
		&& false === strpos( $ja_profile, 'リードファカルティ' )
		&& false !== strpos( $ja_contact, 'id="media"' )
		&& false !== strpos( $en_contact, 'Interviews are available in Japanese and English' )
		&& false !== strpos( $en_profile, 'Regional Faculty' )
		&& false === strpos( $en_profile, 'Lead Faculty' )
		&& false !== strpos( $contact, '#media' )
	),
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
	'2004 ICCM, 2007 CogSci, and 1997 JPS abstracts are fully linked' => (
		false !== strpos( $ja_pubs, '<a href="https://iccm-conference.neocities.org/2004/proceedings/abstracts/noda.pdf">Noda, K. and Tokosumi, A. (2004)' )
		&& false !== strpos( $en_pubs, 'iccm-conference.neocities.org/2004/proceedings/abstracts/noda.pdf' )
		&& false !== strpos( $ja_pubs, 'escholarship.org/content/qt7xp559mc/qt7xp559mc.pdf' )
		&& false !== strpos( $en_pubs, 'qt7xp559mc.pdf' )
		&& false !== strpos( $ja_pubs, '52.2.4_908_4/_pdf' )
		&& false !== strpos( $en_pubs, 'jpsgaiyo/52.2.4' )
	),
	'2013 Fukuoka seminar and 2011 Tokyo Tech PhD guidance are listed' => (
		false !== strpos( $ja_pubs, '福岡商工会議所' )
		&& false !== strpos( $ja_pubs, '就活応援セミナー' )
		&& false !== strpos( $ja_pubs, '博士課程学生の就職' )
		&& false !== strpos( $ja_pubs, 'tokyo-tech-job-guidance-2011.pdf' )
		&& false !== strpos( $en_pubs, 'Fukuoka Chamber of Commerce' )
		&& false !== strpos( $en_pubs, 'PhD employment' )
		&& false !== strpos( $ja_pubs, 'data-max.co.jp/2013/05/29/2000_13_dm1806_1.html' )
		&& false !== strpos( $ja_pubs, '福岡国際会議場' )
		&& is_readable( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/files/tokyo-tech-job-guidance-2011.pdf' )
		&& false !== strpos( $ja_pubs, 'グローバル人材400万人時代を見据えた人材育成' )
		&& false !== strpos( $ja_pubs, 'neue-fahne-journal-no50-2013-03-11.pdf' )
		&& false !== strpos( $en_pubs, 'Neue Fahne Journal No. 50' )
		&& false !== strpos( $ja_pubs, '2015年12月15日' )
		&& false !== strpos( $en_pubs, '15 December 2015' )
		&& false === strpos( $ja_pubs, '15 December 2016' )
		&& false === strpos( $en_pubs, '15 December 2016' )
		&& false !== strpos( $ja_pubs, 'neue-fahne-mini-forum-2015-12-15.pdf' )
		&& false !== strpos( $ja_pubs, 'About Filipino Business for Japanese' )
		&& 1 === substr_count( $ja_pubs, 'About Filipino Business for Japanese' )
		&& false === strpos( $ja_pubs, 'Narratives on HRM experience' )
		&& false === strpos( $en_pubs, 'Narratives on HRM experience' )
		&& is_readable( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/files/neue-fahne-journal-no50-2013-03-11.pdf' )
		&& is_readable( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/files/neue-fahne-mini-forum-2015-12-15.pdf' )
		&& false !== strpos( $ja_pubs, 'フィリピン人から学ぶしあわせワークショップ' )
		&& false !== strpos( $ja_pubs, 'cebupot-happiness-workshop-2016-03-24.pdf' )
		&& false !== strpos( $en_pubs, 'Cebu Pot Seminar' )
		&& is_readable( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/files/cebupot-happiness-workshop-2016-03-24.pdf' )
		&& false !== strpos( $ja_pubs, '世代間の「価値観」の相違を互いに認め合う' )
		&& false !== strpos( $ja_pubs, 'neue-fahne-journal-no20-2011-12-26.pdf' )
		&& false !== strpos( $en_pubs, 'Neue Fahne Journal No. 20' )
		&& is_readable( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/files/neue-fahne-journal-no20-2011-12-26.pdf' )
	),
	'ICE 2013 plenary links to the conference page' => (
		false !== strpos( $ja_pubs, 'share.google/OnGq4xL8mDEoGt7E1' )
		&& false !== strpos( $ja_pubs, 'Heritage Hotel Manila' )
		&& false !== strpos( $en_pubs, 'conference' )
	),
	'2013 JPA SS-055 symposium links to the J-STAGE PDF' => (
		false !== strpos( $ja_pubs, '77_SS-055/_pdf' )
		&& false !== strpos( $ja_pubs, 'コーチング心理学の確立に向けて' )
		&& false !== strpos( $ja_pubs, '<a href="https://www.jstage.jst.go.jp/article/pacjpa/77/0/77_SS-055/_pdf/-char/ja">西垣悦代, 堀正, 本間正人, 野田浩平 (2013)' )
		&& false !== strpos( $en_pubs, '77th Annual Meeting of the Japanese Psychological Association' )
		&& false !== strpos( $en_pubs, 'pacjpa/77/0/77_SS-055' )
		&& false !== strpos( $ja_pubs, '1908002519517088' )
		&& false !== strpos( $ja_pubs, '永崎裕麻氏来訪記念幸福論トークセッション' )
		&& false !== strpos( $en_pubs, 'Yuma Nagasaki' )
		&& false !== strpos( $ja_pubs, 'Free Bird Institute' )
		&& false !== strpos( $ja_pubs, 'happiness1122.peatix.com' )
		&& false !== strpos( $ja_pubs, 'フィジー人に学ぶ' )
		&& false !== strpos( $en_pubs, 'learning happiness habits from Fijians' )
	),
	'2024 change management links to YouTube series' => (
		false !== strpos( $ja_pubs, 'PLiSKEuDit5HplW8JI5fHlWPYA32wQwAxp' )
		&& false !== strpos( $ja_pubs, '<a href="https://www.youtube.com/playlist?list=PLiSKEuDit5HplW8JI5fHlWPYA32wQwAxp">野田浩平, 松村憲, 小島美佳 (2024)' )
		&& false !== strpos( $en_pubs, 'YouTube series' )
	),
	'YouTube and books show link thumbnails when available' => (
		false !== strpos( $ja_pubs, 'kl-pub-thumb--video' )
		&& false !== strpos( $ja_pubs, 'img.youtube.com/vi/5acopoZcYfw/hqdefault.jpg' )
		&& false !== strpos( $ja_pubs, 'i.ytimg.com/vi/OrTwN4gGEp0/hqdefault.jpg' )
		&& false !== strpos( $ja_pubs, 'B0DGFRYHMX' )
		&& false !== strpos( $ja_pubs, 'B0DTS8XLPD' )
		&& false !== strpos( $ja_pubs, '4496053454' )
		&& false !== strpos( $ja_pubs, 'cover.openbd.jp/9784788513969.jpg' )
		&& false !== strpos( $ja_pubs, '4779509823' )
		&& false !== strpos( $ja_pubs, 'amzn.asia/d/0boDUx9G' )
		&& false !== strpos( $en_pubs, 'kl-pub-thumb--book' )
	),
	'overlay zeros body top gap' => (
		false !== strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/refresh.css' ), 'padding: 0 !important' )
		&& false !== strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/wp-view.php' ), 'html,body{margin:0;padding:0' )
		&& false !== strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh.php' ), 'kocorolab-refresh-topgap' )
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
	'news list includes recent books and YouTube' => (
		false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'VUCA時代のストレス防衛術' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'B0DTS8XLPD' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'うつになりやすいかも' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'B0DGFRYHMX' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'PLiSKEuDit5HplW8JI5fHlWPYA32wQwAxp' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'JCSS2025_P2-37.pdf' )
	),
	'news list includes MHQ1 and Shubiki jinjibu press' => (
		false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'service.jinjibu.jp/news/detl/3238' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'service.jinjibu.jp/news/detl/3980' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'MHQ1' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'シュビキ' )
		&& false !== strpos( kocorolab_refresh_news_html( 'en' ), 'Shubiki' )
		&& false === strpos( kocorolab_refresh_page_html( 'mhqlp', 'ja' ), 'シュビキ' )
		&& false === strpos( kocorolab_refresh_page_html( 'mhqlp', 'ja' ), 'detl/3238' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'n-fahne.jp/pdf/mental01.pdf' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), '廣済堂' )
		&& false === strpos( kocorolab_refresh_page_html( 'mhqlp', 'ja' ), 'n-fahne.jp' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'atpress.ne.jp/news/37250' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'GBX' )
		&& false === strpos( kocorolab_refresh_page_html( 'mhqlp', 'ja' ), '37250' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'hitomedia.jp/news/2013-07-25-20130725_1' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'ヒトメディア' )
		&& false === strpos( kocorolab_refresh_page_html( 'mhqlp', 'ja' ), 'hitomedia' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'value-press.com/pressrelease/165730' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), '体験型学習（RLE）' )
		&& false !== strpos( kocorolab_refresh_news_html( 'en' ), 'Real Life Experience (RLE)' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'value-press.com/pressrelease/183306' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'フィリピン教育留学' )
		&& false !== strpos( kocorolab_refresh_news_html( 'en' ), 'Philippines education study' )
		&& false === strpos( kocorolab_refresh_page_html( 'mhqlp', 'ja' ), '165730' )
		&& false === strpos( kocorolab_refresh_page_html( 'mhqlp', 'ja' ), '183306' )
		&& false === strpos( kocorolab_refresh_page_html( 'mhqlp', 'ja' ), 'SPEAnew22019' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'SPEAnew22019.pdf' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), '学校案内PDF（2019' )
		&& false !== strpos( kocorolab_refresh_news_html( 'en' ), 'school brochure PDF (2019' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'グローバル人材400万人' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'neue-fahne-journal-no50-2013-03-11.pdf' )
		&& false !== strpos( kocorolab_refresh_news_html( 'en' ), 'Journal No. 50' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), '第15回ミニ・フォーラム' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'About Filipino Business' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'neue-fahne-mini-forum-2015-12-15.pdf' )
		&& false === strpos( kocorolab_refresh_page_html( 'mhqlp', 'ja' ), 'Journal No.50' )
		&& false === strpos( kocorolab_refresh_page_html( 'mhqlp', 'ja' ), 'ミニ・フォーラム' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'Journal No.20' )
		&& false === strpos( kocorolab_refresh_news_html( 'ja' ), '役割アイデンティティ' )
		&& false === strpos( kocorolab_refresh_news_html( 'ja' ), '交流ディスカッション' )
		&& false === strpos( kocorolab_refresh_news_html( 'en' ), 'without role identity' )
		&& false === strpos( kocorolab_refresh_news_html( 'ja' ), 'niigata-tit-leadership-2000-resume.jpg' )
		&& false === strpos( kocorolab_refresh_news_html( 'ja' ), 'valdes-leadership-generation-2000.pdf' )
		&& false === strpos( kocorolab_refresh_page_html( 'mhqlp', 'ja' ), '役割アイデンティティ' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'セブポットセミナー' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'しあわせワークショップ' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'cebupot-happiness-workshop-2016-03-24.pdf' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'facebook.com/cebupot.jp' )
		&& false === strpos( kocorolab_refresh_news_html( 'ja' ), 'ikeda@cebupot.com' )
		&& false === strpos( kocorolab_refresh_page_html( 'mhqlp', 'ja' ), 'cebupot-happiness-workshop' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'SS-055' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'コーチング心理学の確立' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), '77_SS-055/_pdf' )
		&& false !== strpos( kocorolab_refresh_news_html( 'en' ), '77th Annual Meeting of the Japanese Psychological Association' )
		&& false === strpos( kocorolab_refresh_page_html( 'mhqlp', 'ja' ), 'SS-055' )
		&& false === strpos( kocorolab_refresh_page_html( 'mhqlp', 'ja' ), 'pacjpa' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), '永崎裕麻' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'facebook.com/events/1908002519517088' )
		&& false !== strpos( kocorolab_refresh_news_html( 'en' ), 'Yuma Nagasaki' )
		&& false === strpos( kocorolab_refresh_page_html( 'mhqlp', 'ja' ), '1908002519517088' )
		&& false === strpos( kocorolab_refresh_news_html( 'ja' ), '創業' )
		&& false === strpos( kocorolab_refresh_news_html( 'ja' ), '設立者' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'フィジー人に学ぶ幸福の習慣' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'happiness1122.peatix.com' )
		&& false !== strpos( kocorolab_refresh_news_html( 'en' ), 'learning happiness habits from Fijians' )
		&& false === strpos( kocorolab_refresh_page_html( 'mhqlp', 'ja' ), 'happiness1122' )
		&& false === strpos( kocorolab_refresh_news_html( 'ja' ), '創業者' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'Journal No.20' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), '世代間の「価値観」' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'neue-fahne-journal-no20-2011-12-26.pdf' )
		&& false !== strpos( kocorolab_refresh_news_html( 'en' ), 'Journal No. 20' )
		&& false === strpos( kocorolab_refresh_page_html( 'mhqlp', 'ja' ), 'Journal No.20' )
		&& false === strpos( kocorolab_refresh_page_html( 'mhqlp', 'ja' ), 'journal-no20' )
	),
	'rewrites jinjibu 3980 to live service URL' => false !== strpos( kocorolab_refresh_repair_external_links( '<a href="https://jinjibu.jp/news/detl/3980/">x</a>' ), 'service.jinjibu.jp/news/detl/3980' ),
	'news overlay still appears when WordPress posts exist' => ( function () {
		$post              = new stdClass();
		$post->post_title  = 'MIT Sloan/UID IDEAS Asia Pacific 3.0 2026参加者推薦を開始致しました。';
		$post->post_date   = '2026-03-01 00:00:00';
		$post->post_name   = 'ideas';
		$post->post_content = '';
		$post->permalink   = '/news/ideas/';
		$html              = kocorolab_refresh_news_list_html( kocorolab_refresh_news_feed_items( 'ja', array( $post ) ), 'ja' );
		return false !== strpos( $html, 'VUCA時代のストレス防衛術' ) && false !== strpos( $html, '/news/ideas/' )
			&& false !== strpos( $html, 'service.jinjibu.jp/news/detl/3238' )
			&& false !== strpos( $html, 'service.jinjibu.jp/news/detl/3980' )
			&& false !== strpos( $html, 'n-fahne.jp/pdf/mental01.pdf' )
			&& false !== strpos( $html, 'atpress.ne.jp/news/37250' )
			&& false !== strpos( $html, 'hitomedia.jp/news/2013-07-25-20130725_1' )
			&& false !== strpos( $html, 'value-press.com/pressrelease/165730' )
			&& false !== strpos( $html, 'value-press.com/pressrelease/183306' )
			&& false !== strpos( $html, 'SPEAnew22019.pdf' )
			&& false !== strpos( $html, 'neue-fahne-journal-no50-2013-03-11.pdf' )
			&& false !== strpos( $html, 'neue-fahne-mini-forum-2015-12-15.pdf' )
			&& false !== strpos( $html, 'cebupot-happiness-workshop-2016-03-24.pdf' )
			&& false !== strpos( $html, '77_SS-055/_pdf' )
			&& false !== strpos( $html, 'facebook.com/events/1908002519517088' )
			&& false !== strpos( $html, 'happiness1122.peatix.com' )
			&& false !== strpos( $html, 'neue-fahne-journal-no20-2011-12-26.pdf' )
			&& false === strpos( $html, 'niigata-tit-leadership-2000-resume.jpg' )
			&& false === strpos( $html, '交流ディスカッション' );
	} )(),
	'GBX news title goes to the atpress report not the old WP page' => ( function () {
		$post               = new stdClass();
		$post->post_title   = 'GBX(Global Business eXperience)の記事';
		$post->post_date    = '2013-01-01 00:00:00';
		$post->post_name    = 'gbxglobal-business-experience';
		$post->post_content = '';
		$post->permalink    = '/news/gbxglobal-business-experience/';
		$html               = kocorolab_refresh_news_list_html( kocorolab_refresh_news_feed_items( 'ja', array( $post ) ), 'ja' );
		return false !== strpos( $html, 'https://www.atpress.ne.jp/news/37250' )
			&& false === strpos( $html, '/news/gbxglobal-business-experience/' )
			&& kocorolab_refresh_is_retired_gbx_path( '/news/gbxglobal-business-experience/' );
	} )(),
	'profile overlay does not grow a GBX related-links box' => (
		false === strpos( kocorolab_refresh_enrich_news_links( kocorolab_refresh_page_html( 'member', 'ja' ) . ' GBX Global Business eXperience' ), 'GBXのレポート' )
		&& false !== strpos( kocorolab_refresh_enrich_news_links( 'GBX(Global Business eXperience)の記事' ), 'atpress.ne.jp' )
	),
	'EN member path maps to the overlay profile' => (
		'member' === kocorolab_refresh_slug_from_path( '/en/member' )
		&& 'member' === kocorolab_refresh_slug_from_path( '/member/' )
		&& false !== strpos( kocorolab_refresh_page_html( 'member', 'en' ), 'Ph.D. in Cognitive Science' )
		&& false !== strpos( kocorolab_refresh_page_html( 'member', 'en' ), 'kl-bio-profile-en' )
	),
	'/en/member/ is treated as English' => ( function () {
		$prev = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : null;
		$_SERVER['REQUEST_URI'] = '/en/member/';
		unset( $_GET['lang'] );
		$lang = kocorolab_refresh_lang();
		if ( null === $prev ) {
			unset( $_SERVER['REQUEST_URI'] );
		} else {
			$_SERVER['REQUEST_URI'] = $prev;
		}
		return 'en' === $lang;
	} )(),
	'English profile URL is not canonical-redirected to Japanese' => (
		kocorolab_refresh_is_en_profile_path( '/en/member' )
		&& kocorolab_refresh_is_en_profile_path( '/en/koheinoda' )
		&& ! kocorolab_refresh_is_en_profile_path( '/member' )
		&& false === kocorolab_refresh_filter_canonical_redirect( 'https://kocorolab.com/member/', 'https://kocorolab.com/en/member/' )
		&& false === kocorolab_refresh_filter_canonical_redirect( 'https://kocorolab.com/member/', 'https://kocorolab.com/en/koheinoda/' )
		&& 'https://kocorolab.com/member/' === kocorolab_refresh_filter_canonical_redirect( 'https://kocorolab.com/member/', 'https://kocorolab.com/member/' )
	),
	'English overlay paths skip WordPress 404 guessing' => (
		kocorolab_refresh_is_en_overlay_path( '/en/member' )
		&& kocorolab_refresh_is_en_overlay_path( '/en/service' )
		&& kocorolab_refresh_is_en_overlay_path( '/en/company' )
		&& kocorolab_refresh_is_en_overlay_path( '/en/contact' )
		&& kocorolab_refresh_is_en_overlay_path( '/en/publications' )
		&& ! kocorolab_refresh_is_en_overlay_path( '/en' )
		&& ! kocorolab_refresh_is_en_overlay_path( '/member' )
		&& 'member' === kocorolab_refresh_en_overlay_pagename( '/en/koheinoda' )
		&& 'hakkou' === kocorolab_refresh_en_overlay_pagename( '/en/publications' )
	),
	'news titles hyperlink to Amazon, YouTube, and PDFs' => (
		false !== strpos( kocorolab_refresh_news_html( 'ja' ), '<a href="https://www.amazon.co.jp/dp/B0DTS8XLPD">『VUCA時代のストレス防衛術』を刊行しました。</a>' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), '<a href="https://www.youtube.com/watch?v=5acopoZcYfw">フィリピンの貧困と幸福度の現状</a>' )
		&& false !== strpos( kocorolab_refresh_news_html( 'ja' ), 'href="https://www.jcss.gr.jp/meetings/jcss2025/proceedings/pdf/JCSS2025_P2-37.pdf"' )
	),
	'language switch stays on the current page' => ( function () {
		$prev_uri = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : null;
		$prev_get = isset( $_GET['lang'] ) ? $_GET['lang'] : null;
		$_SERVER['REQUEST_URI'] = '/member/';
		unset( $_GET['lang'] );
		$ja_to_en = kocorolab_refresh_lang_switch_url();
		$_SERVER['REQUEST_URI'] = '/en/service/';
		$en_to_ja = kocorolab_refresh_lang_switch_url();
		$_SERVER['REQUEST_URI'] = '/news/';
		$news_to_en = kocorolab_refresh_lang_switch_url();
		$_GET['lang'] = 'en';
		$_SERVER['REQUEST_URI'] = '/news/?lang=en';
		$news_to_ja = kocorolab_refresh_lang_switch_url();
		if ( null === $prev_uri ) {
			unset( $_SERVER['REQUEST_URI'] );
		} else {
			$_SERVER['REQUEST_URI'] = $prev_uri;
		}
		if ( null === $prev_get ) {
			unset( $_GET['lang'] );
		} else {
			$_GET['lang'] = $prev_get;
		}
		return false !== strpos( $ja_to_en, '/en/member/' )
			&& false !== strpos( $en_to_ja, '/service/' )
			&& false === strpos( $en_to_ja, '/en/service/' )
			&& false !== strpos( $news_to_en, 'lang=en' )
			&& false !== strpos( $news_to_ja, '/news/' )
			&& false === strpos( $news_to_ja, 'lang=en' );
	} )(),
	'company table present' => false !== strpos( $ja_company, 'kl-table' ),
	'JA pubs include JCSS 2025 and 1997' => ( false !== strpos( $ja_pubs, 'JCSS2025_P2-37' ) && false !== strpos( $ja_pubs, '1997' ) && false !== strpos( $ja_pubs, 'VUCA' ) && false !== strpos( $ja_pubs, '役割アイデンティティのない状況下' ) && false !== strpos( $ja_pubs, 'niigata-tit-leadership-2000-resume.jpg' ) && false !== strpos( $ja_pubs, 'VALDES Technical paper' ) && false !== strpos( $ja_pubs, 'valdes-leadership-generation-2000.pdf' ) && false !== strpos( $ja_pubs, '感情から見たリーダーシップ発生モデル' ) && false === strpos( $ja_pubs, 'テクニカルペーパーの1ページ' ) ),
	'EN pubs include JCSS 2025 and 1997' => ( false !== strpos( $en_pubs, 'JCSS2025_P2-37' ) && false !== strpos( $en_pubs, '1997' ) && false !== strpos( $en_pubs, 'without role identity' ) && false !== strpos( $en_pubs, 'valdes-leadership-generation-2000.pdf' ) && false === strpos( $en_pubs, 'page 1 of the same technical paper' ) ),
	'placeholder images present' => $img_ok,
	'image helper falls back' => 'images/hero-horizon.jpg' === kocorolab_refresh_image_url( 'hero' ),
	'other slugs untouched' => '' === kocorolab_refresh_page_html( 'foobar', 'ja' ),
	'shows site wrap instead of loader' => false !== strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/refresh.css' ), 'body.kl-refresh #site_wrap' ),
	'hero keeps photo color without full wash' => ( false === strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/refresh.css' ), 'rgba(6, 16, 28, 0.82)' ) && false !== strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/refresh.css' ), '.kl-hero-copy' ) && false === strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/front-page.php' ), 'kl-hero-glow' ) ),
	'overlay skips Avalon header' => false !== strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/wp-view.php' ), 'Standalone overlay' ) && false === strpos( file_get_contents( dirname( __DIR__ ) . '/wp-content/mu-plugins/kocorolab-site-refresh/wp-view.php' ), 'get_header();' ),
	'strips qTranslate JA tags' => '本文です。' === trim( kocorolab_refresh_ml_text( '[:ja]本文です。[:en]Body text.[:]', 'ja' ) ),
	'strips qTranslate EN tags' => 'Body text.' === trim( kocorolab_refresh_ml_text( '[:ja]本文です。[:en]Body text.[:]', 'en' ) ),
	'strips MHQ1 ja-only tags' => ( false === strpos( kocorolab_refresh_ml_text( '[:ja]2009年のMHQ1の発売のプレスリリースです。 https://example.com/[:]', 'ja' ), '[:' ) && false !== strpos( kocorolab_refresh_ml_text( '[:ja]2009年のMHQ1の発売のプレスリリースです。 https://example.com/[:]', 'ja' ), 'MHQ1' ) ),
	'EN news uses lang query' => false !== strpos( kocorolab_refresh_page_html( 'service', 'en' ), 'lang=en' ),
	'flattened overlay templates abort before the loader defines helpers' => is_dir( $stray_tmp ),
	'preview build defines overlay dir before requiring templates' => false !== strpos( file_get_contents( dirname( __DIR__ ) . '/preview-site/build.php' ), "define( 'KOCOROLAB_REFRESH_DIR'" ),
	'guard plugin ships next to the overlay loader' => is_readable( dirname( __DIR__ ) . '/wp-content/mu-plugins/0-kocorolab-refresh-guard.php' ),
	'guard removes flattened overlay copies from mu-plugins root' => ( function () {
		$tmp = sys_get_temp_dir() . '/kl-mu-' . uniqid();
		mkdir( $tmp );
		file_put_contents( $tmp . '/archive-news.php', "<?php\nkocorolab_refresh_lang();\n" );
		file_put_contents( $tmp . '/hero-horizon.jpg', 'fake' );
		file_put_contents( $tmp . '/keep-other.php', "<?php\n" );
		$removed = kocorolab_refresh_remove_stray_mu_plugins( $tmp );
		$ok      = in_array( 'archive-news.php', $removed, true )
			&& in_array( 'hero-horizon.jpg', $removed, true )
			&& ! is_file( $tmp . '/archive-news.php' )
			&& ! is_file( $tmp . '/hero-horizon.jpg' )
			&& is_file( $tmp . '/keep-other.php' );
		@unlink( $tmp . '/keep-other.php' );
		@rmdir( $tmp );
		return $ok;
	} )(),
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
