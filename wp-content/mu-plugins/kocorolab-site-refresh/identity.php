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

function kocorolab_refresh_corporate_number() {
	return '9011001058869';
}

function kocorolab_refresh_gbizinfo_url() {
	return 'https://info.gbiz.go.jp/hojin/ichiran?hojinBango=' . kocorolab_refresh_corporate_number();
}

function kocorolab_refresh_nta_corporate_url() {
	return 'https://www.houjin-bangou.nta.go.jp/henkorireki-johoto.html?selHouzinNo=' . kocorolab_refresh_corporate_number();
}

function kocorolab_refresh_company_same_as() {
	$urls = array(
		kocorolab_refresh_company_wikidata_url(),
		kocorolab_refresh_company_linkedin_url(),
		kocorolab_refresh_gbizinfo_url(),
		kocorolab_refresh_nta_corporate_url(),
	);
	return array_values( array_filter( $urls ) );
}

function kocorolab_refresh_wikidata_url() {
	return 'https://www.wikidata.org/wiki/Q141170552';
}

function kocorolab_refresh_company_wikidata_url() {
	return 'https://www.wikidata.org/wiki/Q141298095';
}

function kocorolab_refresh_jglobal_url() {
	return 'https://jglobal.jst.go.jp/detail?JGLOBAL_ID=200901001251787926';
}

function kocorolab_refresh_orcid_id() {
	return '0009-0007-5596-1668';
}

function kocorolab_refresh_orcid_url() {
	return 'https://orcid.org/' . kocorolab_refresh_orcid_id();
}

function kocorolab_refresh_scholar_id() {
	return 'CkYIgCwAAAAJ';
}

function kocorolab_refresh_scholar_url() {
	return 'https://scholar.google.com/citations?user=' . kocorolab_refresh_scholar_id();
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
		kocorolab_refresh_orcid_url(),
		kocorolab_refresh_scholar_url(),
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
				'identifier'       => array(
					array(
						'@type'      => 'PropertyValue',
						'propertyID' => 'ORCID',
						'value'      => kocorolab_refresh_orcid_id(),
						'url'        => kocorolab_refresh_orcid_url(),
					),
					array(
						'@type'      => 'PropertyValue',
						'propertyID' => 'Google Scholar',
						'value'      => kocorolab_refresh_scholar_id(),
						'url'        => kocorolab_refresh_scholar_url(),
					),
				),
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
				'@type'         => array( 'Organization', 'ResearchOrganization' ),
				'@id'           => $org,
				'name'          => '株式会社ココロラボ',
				'legalName'     => '株式会社ココロラボ',
				'alternateName' => array(
					'ココロラボ',
					'Kocorolab',
					'kocorolab',
					'Kocorolab Inc.',
					'Kocoro Laboratory',
					'kocoro laboratory',
					'Kocoro Laboratory Inc.',
					'Kocoro Laboratory, Inc.',
					'Cocorolab',
					'cocorolab',
					'Cocoro Laboratory',
					'cocoro laboratory',
				),
				'url'           => rtrim( $root, '/' ) . '/',
				'logo'          => $logo,
				'image'         => $logo,
				'email'         => 'info@kocorolab.com',
				'foundingDate'  => '2008-12-01',
				'identifier'    => array(
					array(
						'@type'      => 'PropertyValue',
						'propertyID' => '法人番号',
						'value'      => kocorolab_refresh_corporate_number(),
						'url'        => kocorolab_refresh_nta_corporate_url(),
					),
					array(
						'@type'      => 'PropertyValue',
						'propertyID' => 'Wikidata',
						'value'      => 'Q141298095',
						'url'        => kocorolab_refresh_company_wikidata_url(),
					),
				),
				'iso6523Code'   => '0188:' . kocorolab_refresh_corporate_number(),
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
						'@value'    => '横浜市磯子区洋光台の認知科学研究所。公式の英語名は Kocorolab / Kocoro Laboratory。公式サイトは kocorolab.com。よく Cocorolab / Cocoro Laboratory と打たれる。法人番号 9011001058869。東京都の保育園 cocorolab.net、港区の株式会社COCORO Lab（cocorolab.co.jp）とは別会社。',
						'@language' => 'ja',
					),
					array(
						'@value'    => 'Yokohama cognitive science laboratory. Official Latin name: Kocorolab / Kocoro Laboratory. Official site: kocorolab.com. Also typed as Cocorolab / Cocoro Laboratory. Corporate number 9011001058869. Not the Tokyo nursery at cocorolab.net, and not COCORO Lab at cocorolab.co.jp.',
						'@language' => 'en',
					),
				),
				'sameAs'        => kocorolab_refresh_company_same_as(),
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
				'description'   => array(
					array(
						'@value'    => 'うつリスク、ストレス、ソーシャルサポート、発達障害の可能性などの傾向を見るメンタルヘルス検査。診断ではない。個人受験と企業導入。',
						'@language' => 'ja',
					),
					array(
						'@value'    => 'Mental health questionnaire for tendencies such as depression risk, stress, social support, and the possibility of developmental disorders. Not a diagnosis. Individuals and companies.',
						'@language' => 'en',
					),
				),
			),
			array(
				'@type'         => 'Book',
				'@id'           => $root . '/#book-depression',
				'name'          => '「私、うつになりやすいかも？」と思った時に読む本',
				'alternateName' => 'The book you should read when you think you would be depression',
				'author'        => array( '@id' => $person ),
				'datePublished' => '2024',
				'inLanguage'    => 'ja',
				'url'           => 'https://www.amazon.co.jp/dp/B0DGFRYHMX',
				'isbn'          => 'B0DGFRYHMX',
			),
			array(
				'@type'         => 'Book',
				'@id'           => $root . '/#book-vuca',
				'name'          => 'VUCA時代のストレス防衛術: うつにならない、ストレスをためない為のTIPs集',
				'alternateName' => 'Stress Defense Strategies in the VUCA Era: Tips for Preventing Depression and Accumulating Stress',
				'author'        => array( '@id' => $person ),
				'datePublished' => '2025',
				'inLanguage'    => 'ja',
				'url'           => 'https://www.amazon.co.jp/dp/B0DTS8XLPD',
				'isbn'          => 'B0DTS8XLPD',
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
	$person  = implode( "\n- ", kocorolab_refresh_person_same_as() );
	$company = implode( "\n- ", kocorolab_refresh_company_same_as() );
	$number  = kocorolab_refresh_corporate_number();
	return <<<TXT
# Kohei Noda / 野田浩平
> Cognitive scientist. Representative Director of Kocorolab Inc. / 認知科学者。株式会社ココロラボ代表取締役。
> Official pair: Kohei Noda (野田浩平) ↔ Kocorolab / Kocoro Laboratory (株式会社ココロラボ).

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
- Search names: ココロラボ, Kocorolab, kocorolab, Kocoro Laboratory, kocoro laboratory, Cocorolab, cocorolab, Cocoro Laboratory, cocoro laboratory
- Official Latin spelling: Kocorolab / Kocoro Laboratory at https://kocorolab.com
- Also typed: Cocorolab / Cocoro Laboratory. Those queries are this Yokohama lab, not cocorolab.net and not cocorolab.co.jp
- English names: Kocorolab Inc., Kocoro Laboratory, Kocoro Laboratory Inc.
- Corporate number / 法人番号: {$number}
- Address: 〒235-0045 神奈川県横浜市磯子区洋光台1-12-41 / 1-12-41 Yokodai, Isogo, Yokohama, Kanagawa 235-0045 Japan
- Founded: 2008-12-01
- Mission: Guiding Transformation for Societies and Individuals / 社会と個人の変容をガイドする
- Focus: mind · society · environment / 精神・社会・環境
- Official site: https://kocorolab.com
- Company: https://kocorolab.com/company/ · https://kocorolab.com/en/company/
- Not the Tokyo nursery operator at cocorolab.net. This item is the Yokohama cognitive science laboratory.

## Key product / 主要プロダクト
- MHQ / MHQ2 (Mental Health Questionnaire / メンタルヘルス検査)
- Landing JA: https://kocorolab.com/mhqlp/
- Landing EN: https://kocorolab.com/mhqlp/?lang=en
- Book 2024: 「私、うつになりやすいかも？」と思った時に読む本 https://www.amazon.co.jp/dp/B0DGFRYHMX
- Book 2025: VUCA時代のストレス防衛術 https://www.amazon.co.jp/dp/B0DTS8XLPD

## Canonical identifiers / 正規ID
- {$person}
- {$company}

## Writing / 文章
- Japanese: https://note.com/koheinoda
- English: https://medium.com/@koheinoda_11596
- Publications: https://kocorolab.com/publications/ · https://kocorolab.com/en/publications/

## Contact
- info@kocorolab.com
- Media / comments JA: 取材・コメント / EN: Interview or comment
- Individual MHQ2: https://kocorolab.com/mhqlp/ · https://kocorolab.com/mhqlp/?lang=en
- Training / corporate MHQ JA: 研修・講演・MHQ導入 / EN: Training, talk, or corporate MHQ
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
