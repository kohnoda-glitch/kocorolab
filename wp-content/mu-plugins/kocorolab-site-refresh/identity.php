<?php
/**
 * Bilingual entity graph for Kohei Noda / 野田浩平 and Kocorolab / ココロラボ.
 * Titles match the public site copy. Do not invent ORCID or Scholar URLs.
 */

if ( defined( 'KOCOROLAB_REFRESH_DIR' ) && __DIR__ === KOCOROLAB_REFRESH_DIR ) {

function kocorolab_refresh_absolute_url( $url ) {
	$url = (string) $url;
	if ( '' === $url ) {
		return '';
	}
	if ( 0 === strpos( $url, 'http://' ) || 0 === strpos( $url, 'https://' ) ) {
		return $url;
	}
	$root = function_exists( 'kocorolab_refresh_root' ) ? kocorolab_refresh_root() : 'https://kocorolab.com';
	return rtrim( $root, '/' ) . '/' . ltrim( $url, '/' );
}

function kocorolab_refresh_linkedin_url() {
	return 'https://www.linkedin.com/in/kohnoda';
}

function kocorolab_refresh_company_linkedin_url() {
	return 'https://www.linkedin.com/company/kocoro-laboratory-inc.';
}

function kocorolab_refresh_wikidata_url() {
	return 'https://www.wikidata.org/wiki/Q141170552';
}

function kocorolab_refresh_jglobal_url() {
	return 'https://jglobal.jst.go.jp/detail?JGLOBAL_ID=200901001251787926';
}

function kocorolab_refresh_person_id() {
	return 'https://kocorolab.com/#kohei-noda';
}

function kocorolab_refresh_org_id() {
	return 'https://kocorolab.com/#organization';
}

function kocorolab_refresh_is_llms_path( $path ) {
	$path = strtolower( rtrim( (string) $path, '/' ) );
	return '/llms.txt' === $path || '/.well-known/llms.txt' === $path;
}

function kocorolab_refresh_person_same_as() {
	$urls = array(
		kocorolab_refresh_wikidata_url(),
		kocorolab_refresh_researchmap_url(),
		kocorolab_refresh_jglobal_url(),
		kocorolab_refresh_linkedin_url(),
		kocorolab_refresh_note_url(),
		kocorolab_refresh_medium_url(),
		kocorolab_refresh_ccl_japan_url(),
	);
	return array_values( array_filter( $urls ) );
}

function kocorolab_refresh_identity_graph() {
	$root     = function_exists( 'kocorolab_refresh_root' ) ? kocorolab_refresh_root() : 'https://kocorolab.com';
	$person   = kocorolab_refresh_person_id();
	$org      = kocorolab_refresh_org_id();
	$portrait = kocorolab_refresh_absolute_url( function_exists( 'kocorolab_refresh_image_url' ) ? kocorolab_refresh_image_url( 'portrait' ) : 'https://kocorolab.com/wp-content/mu-plugins/kocorolab-site-refresh/images/kohei-noda.jpg' );
	$logo     = kocorolab_refresh_absolute_url( function_exists( 'kocorolab_refresh_image_url' ) ? kocorolab_refresh_image_url( 'mark' ) : 'https://kocorolab.com/wp-content/mu-plugins/kocorolab-site-refresh/images/kocoro-mark-light.png' );

	return array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			array(
				'@type'            => 'Person',
				'@id'              => $person,
				'name'             => '野田浩平',
				'alternateName'    => array( 'Kohei Noda', 'Noda Kohei', '野田 浩平', 'のだ こうへい', 'Kohei Noda, Ph.D.' ),
				'givenName'        => array( '浩平', 'Kohei' ),
				'familyName'       => array( '野田', 'Noda' ),
				'honorificSuffix'  => 'Ph.D.',
				'jobTitle'         => array(
					'株式会社ココロラボ 代表取締役',
					'Representative Director, Kocorolab Inc.',
					'グロービス経営大学院 専任教員',
					'Associate Professor and Research Faculty, Globis University Graduate School of Management',
					'MIT経営大学院グローバルプログラム IDEAS Asia Pacific リージョナル・ファカルティ',
					'Regional Faculty, MIT Sloan Global Program IDEAS Asia Pacific',
				),
				'description'      => array(
					array(
						'@value'    => '認知科学者。株式会社ココロラボ代表取締役。グロービス経営大学院専任教員。感情の認知科学、メンタルヘルス検査 MHQ、リーダーシップ教育。',
						'@language' => 'ja',
					),
					array(
						'@value'    => 'Cognitive scientist. Representative Director of Kocorolab Inc. Associate Professor and Research Faculty at Globis University. Emotion research, the MHQ mental health questionnaire, and leadership education.',
						'@language' => 'en',
					),
				),
				'url'              => $root . '/member/',
				'image'            => $portrait,
				'worksFor'         => array( '@id' => $org ),
				'affiliation'      => array(
					array( '@id' => $org ),
					array(
						'@type'  => 'EducationalOrganization',
						'name'   => 'グロービス経営大学院',
						'alternateName' => array( 'Globis University Graduate School of Management', 'GLOBIS University' ),
						'url'    => 'https://www.globis.ac.jp',
					),
				),
				'alumniOf'         => array(
					'@type' => 'CollegeOrUniversity',
					'name'  => '東京工業大学',
					'alternateName' => array( 'Tokyo Institute of Technology', 'Institute of Science Tokyo' ),
				),
				'sameAs'           => kocorolab_refresh_person_same_as(),
				'knowsAbout'       => array(
					'認知科学',
					'Cognitive Science',
					'感情',
					'Emotion',
					'メンタルヘルス検査 MHQ',
					'MHQ',
					'MHQ2',
					'U理論',
					'Theory U',
					'システム思考',
					'Systems Thinking',
					'リーダーシップ教育',
					'Leadership education',
				),
				'knowsLanguage'    => array( 'ja', 'en' ),
			),
			array(
				'@type'         => 'Organization',
				'@id'           => $org,
				'name'          => '株式会社ココロラボ',
				'legalName'     => '株式会社ココロラボ',
				'alternateName' => array(
					'Kocorolab',
					'Kocorolab Inc.',
					'Kocoro Laboratory',
					'Kocoro Laboratory Inc.',
					'Kocoro Laboratory, Inc.',
					'ココロラボ',
				),
				'url'           => rtrim( $root, '/' ) . '/',
				'logo'          => $logo,
				'image'         => $logo,
				'email'         => 'info@kocorolab.com',
				'foundingDate'  => '2008-12-01',
				'address'       => array(
					'@type'           => 'PostalAddress',
					'postalCode'      => '235-0045',
					'addressRegion'   => '神奈川県',
					'addressLocality' => '横浜市磯子区',
					'streetAddress'   => '洋光台1-12-41',
					'addressCountry'  => 'JP',
				),
				'founder'       => array( '@id' => $person ),
				'employee'      => array( '@id' => $person ),
				'description'   => array(
					array(
						'@value'    => '精神・社会・環境の分断をほどく研究所。認知科学と人事実務を橋渡しする。ミッションは「社会と個人の変容をガイドする」。',
						'@language' => 'ja',
					),
					array(
						'@value'    => 'A laboratory that reconnects mind, society, and environment. Bridges cognitive science and HR practice. Mission: Guiding Transformation for Societies and Individuals.',
						'@language' => 'en',
					),
				),
				'sameAs'        => array(
					kocorolab_refresh_company_linkedin_url(),
				),
				'makesOffer'    => array( '@id' => $root . '/#mhq2' ),
			),
			array(
				'@type'         => 'Service',
				'@id'           => $root . '/#mhq2',
				'name'          => 'MHQ2',
				'alternateName' => array( 'MHQ', 'Mental Health Questionnaire', 'メンタルヘルス検査 MHQ2', 'メンタルヘルス検査 MHQ' ),
				'url'           => $root . '/mhqlp/',
				'provider'      => array( '@id' => $org ),
				'creator'       => array( '@id' => $person ),
			),
			array(
				'@type'       => 'WebSite',
				'@id'         => $root . '/#website',
				'url'         => rtrim( $root, '/' ) . '/',
				'name'        => 'Kocoro Laboratory / 株式会社ココロラボ',
				'inLanguage'  => array( 'ja', 'en' ),
				'publisher'   => array( '@id' => $org ),
				'about'       => array(
					array( '@id' => $person ),
					array( '@id' => $org ),
				),
			),
		),
	);
}

function kocorolab_refresh_jsonld() {
	$flags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
	if ( defined( 'JSON_PRETTY_PRINT' ) ) {
		$flags |= JSON_PRETTY_PRINT;
	}
	$encode = function_exists( 'wp_json_encode' ) ? 'wp_json_encode' : 'json_encode';
	return $encode( kocorolab_refresh_identity_graph(), $flags );
}

function kocorolab_refresh_jsonld_script() {
	$json = kocorolab_refresh_jsonld();
	if ( ! is_string( $json ) || '' === $json ) {
		return '';
	}
	return '<script type="application/ld+json" id="kocorolab-identity">' . "\n" . $json . "\n" . '</script>' . "\n";
}

function kocorolab_refresh_llms_txt() {
	$person = implode( "\n- ", kocorolab_refresh_person_same_as() );
	return <<<TXT
# Kohei Noda / 野田浩平
> Cognitive scientist. Representative Director of Kocorolab Inc. / 認知科学者。株式会社ココロラボ代表取締役。
> Official pair: Kohei Noda (野田浩平) ↔ Kocorolab (株式会社ココロラボ).

## Overview / 概要
- Name: Kohei Noda (野田浩平 / 野田 浩平 / Noda Kohei)
- Degree: Ph.D. in Cognitive Science / 博士（学術 / 認知科学）, Tokyo Institute of Technology / 東京工業大学
- Specialty: cognitive science of emotion, mental health, systems thinking, leadership education / 感情の認知科学、メンタルヘルス、システム思考、リーダーシップ教育
- Official website: https://kocorolab.com
- Profile: https://kocorolab.com/member/ · https://kocorolab.com/en/member/

## Positions / 役職
- Representative Director, Kocorolab Inc. / 株式会社ココロラボ 代表取締役
- Associate Professor and Research Faculty, Globis University Graduate School of Management / グロービス経営大学院 専任教員
- Regional Faculty, MIT Sloan Global Program IDEAS Asia Pacific / MIT経営大学院グローバルプログラム IDEAS Asia Pacific リージョナル・ファカルティ
- Japan Representative, Citizens’ Climate Lobby Japan / 市民気候ロビージャパン 代表
- Auditor, NPO Seven Generations / NPO法人セブン・ジェネレーションズ 監事

## Organization / 組織
- Legal name: 株式会社ココロラボ
- English names: Kocorolab Inc., Kocoro Laboratory, Kocoro Laboratory Inc.
- Founded: 2008-12-01
- Mission: Guiding Transformation for Societies and Individuals / 社会と個人の変容をガイドする
- Focus: mind · society · environment / 精神・社会・環境
- Company: https://kocorolab.com/company/ · https://kocorolab.com/en/company/

## Key product / 主要プロダクト
- MHQ / MHQ2 (Mental Health Questionnaire / メンタルヘルス検査)
- Landing: https://kocorolab.com/mhqlp/

## Canonical identifiers / 正規ID
- {$person}
- Company LinkedIn: https://www.linkedin.com/company/kocoro-laboratory-inc.

## Writing / 文章
- Japanese: https://note.com/koheinoda
- English: https://medium.com/@koheinoda_11596
- Publications: https://kocorolab.com/publications/ · https://kocorolab.com/en/publications/

## Contact
- info@kocorolab.com
TXT;
}

function kocorolab_refresh_echo_jsonld() {
	echo kocorolab_refresh_jsonld_script();
}

function kocorolab_refresh_serve_llms_txt() {
	if ( function_exists( 'status_header' ) ) {
		status_header( 200 );
	} elseif ( ! headers_sent() ) {
		header( 'HTTP/1.1 200 OK' );
	}
	if ( ! headers_sent() ) {
		header( 'Content-Type: text/plain; charset=utf-8' );
		header( 'X-Robots-Tag: all' );
		header( 'Cache-Control: public, max-age=3600' );
	}
	echo kocorolab_refresh_llms_txt();
	exit;
}

} // identity guard
