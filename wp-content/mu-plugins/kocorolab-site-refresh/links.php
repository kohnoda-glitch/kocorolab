<?php
/**
 * Repair dead external URLs in news (Wayback / still-live mirrors)
 * and restore missing YouTube / report links on the page itself.
 */

if ( defined( 'KOCOROLAB_REFRESH_DIR' ) && __DIR__ === KOCOROLAB_REFRESH_DIR ) {

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
	return 'https://medium.com/@koheinoda_11596';
}

function kocorolab_refresh_researchmap_url() {
	return 'https://researchmap.jp/kohnoda';
}

function kocorolab_refresh_spea_archive_url() {
	return 'https://www.pro-japan.jp/school/spea/';
}

function kocorolab_refresh_spea_brochure_url() {
	return 'https://m.pro-japan.jp/images/upload/sc_ref/116/SPEAnew22019.pdf';
}

function kocorolab_refresh_spea_rle_press_url() {
	return 'https://www.value-press.com/pressrelease/165730';
}

function kocorolab_refresh_spea_ed_press_url() {
	return 'https://www.value-press.com/pressrelease/183306';
}

function kocorolab_refresh_spea_youtube_url() {
	return 'https://www.youtube.com/@Speastartingpoitenglishacademy';
}

function kocorolab_refresh_spea_intro_video_url() {
	return 'https://www.youtube.com/watch?v=n_Wcw5cKZ6A';
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

function kocorolab_refresh_mhq_lp_prices_url( $lang = null ) {
	return kocorolab_refresh_mhq_lp_url( $lang ) . '#mhq-prices';
}

function kocorolab_refresh_mhq2_url( $lang = null ) {
	return kocorolab_refresh_mhq_lp_url( $lang );
}

function kocorolab_refresh_mhq_read_url( $lang = null ) {
	return kocorolab_refresh_url( '/mhq-read/', '/en/mhq-read/', $lang );
}

function kocorolab_refresh_mbcc_spotify_episode_url() {
	return 'https://open.spotify.com/episode/03qbS6FrSXI0Bmg9bZWaLQ';
}

function kocorolab_refresh_mbcc_podcast_notes_url() {
	return 'https://mbcc-c.com/media/podcast-20260408.html';
}

function kocorolab_refresh_hansenken_url() {
	return 'https://www.sohten.co.jp/hansenken.html';
}

function kocorolab_refresh_bps_139_url() {
	return 'https://web.archive.org/web/20190826043307/http://llp-bps.net/2017/12/14/%E7%AC%AC139%E5%9B%9E%EF%BD%82%EF%BD%90%EF%BD%93%EF%BC%8820171207%EF%BC%89%E6%B4%BB%E5%8B%95%E5%A0%B1%E5%91%8A/';
}

function kocorolab_refresh_plip_url() {
	return 'https://web.archive.org/web/20130128092802/http://www.productiveleader.jim.titech.ac.jp/news/index.html';
}

function kocorolab_refresh_idea_league_url() {
	return 'https://idealeague.org/';
}

function kocorolab_refresh_globis_u_curve_url() {
	return 'https://globis.jp/article/hu8z0vv3bb_i/';
}

function kocorolab_refresh_yokohama_connect_198_url() {
	return 'https://community.venturecafe-yokohamaconnect.org/sessions/198';
}

function kocorolab_refresh_globis_chiyozaki_url() {
	return 'https://mba.globis.ac.jp/knowledge/detail-25752.html';
}

function kocorolab_refresh_globis_fukudome_url() {
	return 'https://globis.jp/article/xll9i38vmmjf/';
}

function kocorolab_refresh_mbcc_idgs_2022_url() {
	return 'https://mbcc-c.com/event/20220917.html';
}

function kocorolab_refresh_can_japan_3263_url() {
	return 'https://www.can-japan.org/events-ja/3263';
}

function kocorolab_refresh_kenko_happiness_talk_url() {
	return 'https://web.archive.org/web/20201128083739/https://peraichi.com/landing_pages/view/kenkoxkoufukutalk';
}

function kocorolab_refresh_source_catalog() {
	return array(
		array(
			'keys'  => array( 'U字カーブ', 'hu8z0vv3bb_i', '現場が動かない', 'U-curve', 'workplace will not move' ),
			'links' => array(
				array(
					'url' => kocorolab_refresh_globis_u_curve_url(),
					'ja'  => 'グロービス知見録（U字カーブの歩き方）',
					'en'  => 'GLOBIS article (how to walk the U-curve)',
				),
			),
		),
		array(
			'keys'  => array( 'YOKOHAMA CONNÉCT', 'venturecafe-yokohamaconnect', 'Tri-sector innovation', 'sessions/198' ),
			'links' => array(
				array(
					'url' => kocorolab_refresh_yokohama_connect_198_url(),
					'ja'  => 'YOKOHAMA CONNÉCT #36 セッション',
					'en'  => 'YOKOHAMA CONNÉCT #36 session',
				),
			),
		),
		array(
			'keys'  => array( 'detail-25752', '千代崎', 'すべての人が能力を発揮', 'Toga Chiyozaki', 'everyone can use their abilities' ),
			'links' => array(
				array(
					'url' => kocorolab_refresh_globis_chiyozaki_url(),
					'ja'  => 'グロービス卒業生インタビュー（千代崎透我さん）',
					'en'  => 'GLOBIS alumni interview (Toga Chiyozaki)',
				),
			),
		),
		array(
			'keys'  => array( 'xll9i38vmmjf', '志の力', '福留大士', 'Daishi Fukudome', 'power of kokorozashi' ),
			'links' => array(
				array(
					'url' => kocorolab_refresh_globis_fukudome_url(),
					'ja'  => 'グロービス知見録（志の力）',
					'en'  => 'GLOBIS article (the power of kokorozashi)',
				),
			),
		),
		array(
			'keys'  => array( 'IDGｓと人間性', 'Inner Development Goals', '20220917', 'マンスリーMiLI' ),
			'links' => array(
				array(
					'url' => kocorolab_refresh_mbcc_idgs_2022_url(),
					'ja'  => 'マンスリーMiLI（IDGs）案内',
					'en'  => 'Monthly MiLI (IDGs) event page',
				),
			),
		),
		array(
			'keys'  => array( 'events-ja/3263', 'カーボンプライシング', 'IPCC第6次', 'carbon pricing', 'IPCC AR6' ),
			'links' => array(
				array(
					'url' => kocorolab_refresh_can_japan_3263_url(),
					'ja'  => 'CAN-Japanウェビナー案内',
					'en'  => 'CAN-Japan webinar page',
				),
			),
		),
		array(
			'keys'  => array( 'ICE 2013', 'Heritage Hotel Manila', 'PELS International Congress', 'OnGq4xL8mDEoGt7E1' ),
			'links' => array(
				array(
					'url' => kocorolab_refresh_ice_2013_url(),
					'ja'  => '会議案内',
					'en'  => 'Conference page',
				),
				array(
					'url' => kocorolab_refresh_ice_2013_plenary_photo_url(),
					'ja'  => 'プレナリー写真',
					'en'  => 'Plenary photo',
				),
				array(
					'url' => kocorolab_refresh_ice_2013_hotel_photo_url(),
					'ja'  => '会場写真',
					'en'  => 'Venue photo',
				),
			),
		),
		array(
			'keys'  => array( 'TIME-IMAGE-CREATIVITY', 'Pinto Art Gallery', 'Antipolo', 'Keisuke Taketani' ),
			'links' => array(
				array(
					'url' => kocorolab_refresh_antipolo_2013_flyer_url(),
					'ja'  => 'ワークショップ案内',
					'en'  => 'Workshop notice',
				),
				array(
					'url' => kocorolab_refresh_antipolo_2013_workshop_photo_url(),
					'ja'  => 'ワークショップ写真',
					'en'  => 'Workshop photo',
				),
				array(
					'url' => kocorolab_refresh_antipolo_2013_keisuke_photo_url(),
					'ja'  => 'けいすけとの写真',
					'en'  => 'Photo with Keisuke',
				),
				array(
					'url' => kocorolab_refresh_antipolo_2013_poster_url(),
					'ja'  => 'ポスター',
					'en'  => 'Poster',
				),
			),
		),
		array(
			'keys'  => array( '共助なき社会', 'society without mutual aid', '03qbS6FrSXI0Bmg9bZWaLQ', 'podcast-20260408' ),
			'links' => array(
				array(
					'url' => kocorolab_refresh_mbcc_spotify_episode_url(),
					'ja'  => 'Spotify（MBCC 未来をひらくラジオ）',
					'en'  => 'Spotify (MBCC radio)',
				),
				array(
					'url' => kocorolab_refresh_mbcc_podcast_notes_url(),
					'ja'  => '番組案内（MBCC）',
					'en'  => 'Episode notes (MBCC)',
				),
			),
		),
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
			'keys'  => array( 'SS-055', 'コーチング心理学の確立', '77th Annual Meeting of the Japanese Psychological Association' ),
			'links' => array(
				array(
					'url' => kocorolab_refresh_jpa_2013_ss055_pdf(),
					'ja'  => '大会発表PDF（J-STAGE）',
					'en'  => 'Conference abstract (J-STAGE PDF)',
				),
				array(
					'url' => kocorolab_refresh_jpa_2013_photo_url(),
					'ja'  => '登壇写真',
					'en'  => 'Panel photo',
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
			'keys'  => array( 'MHQ1', 'バージョン１発売', 'version 1 press', '3238' ),
			'links' => array(
				array(
					'url' => 'https://service.jinjibu.jp/news/detl/3238/',
					'ja'  => 'MHQ1発売のプレスリリース',
					'en'  => 'MHQ version 1 press release',
				),
			),
		),
		array(
			'keys'  => array( 'シュビキ', 'Shubiki', '3980', 'メンタルヘルス支援サービス開始' ),
			'links' => array(
				array(
					'url' => 'https://service.jinjibu.jp/news/detl/3980/',
					'ja'  => 'シュビキ提携のプレスリリース',
					'en'  => 'Shubiki partnership press release',
				),
			),
		),
		array(
			'keys'  => array( 'ヒトメディア', 'hitomedia', '20130725', 'アジアビジネス成功の4ステップ' ),
			'links' => array(
				array(
					'url' => 'https://hitomedia.jp/news/2013-07-25-20130725_1/',
					'ja'  => 'ヒトメディアのセミナー案内',
					'en'  => 'hitomedia seminar note',
				),
			),
		),
		array(
			'keys'  => array( 'SPEAnew22019', '学校案内PDF（2019', 'school brochure PDF (2019' ),
			'links' => array(
				array(
					'url' => kocorolab_refresh_spea_brochure_url(),
					'ja'  => 'SPEAの学校案内PDF（2019）',
					'en'  => 'SPEA school brochure PDF (2019)',
				),
			),
		),
		array(
			'keys'  => array( '体験型学習（RLE）', 'Real Life Experience (RLE)', '165730', 'RLE-Labo' ),
			'links' => array(
				array(
					'url' => kocorolab_refresh_spea_rle_press_url(),
					'ja'  => 'RLE研究開始のプレスリリース',
					'en'  => 'RLE research press release',
				),
			),
		),
		array(
			'keys'  => array( 'IDEAリーグ', 'IDEA League doctoral-school', '日本の起業状況', 'entrepreneurship in Japan', 'productiveleader' ),
			'links' => array(
				array(
					'url' => kocorolab_refresh_plip_url(),
					'ja'  => '東工大PLIP（保存版）',
					'en'  => 'Tokyo Tech PLIP (archived)',
				),
				array(
					'url' => kocorolab_refresh_tokyo_tech_idea_league_2012_photo_url(),
					'ja'  => '講演写真',
					'en'  => 'Talk photo',
				),
				array(
					'url' => kocorolab_refresh_idea_league_url(),
					'ja'  => 'IDEA League',
					'en'  => 'IDEA League',
				),
			),
		),
		array(
			'keys'  => array( 'フィリピン（セブ）留学、そして異文化体験', 'Philippines (Cebu) study abroad', '第139回ＢＰＳ', 'llp-bps' ),
			'links' => array(
				array(
					'url' => kocorolab_refresh_bps_139_url(),
					'ja'  => 'BPS第139回活動報告（保存版）',
					'en'  => 'BPS 139th meeting report (archived)',
				),
			),
		),
		array(
			'keys'  => array( '幸福論トークセッション', '1908002519517088', 'visiting Dumaguete', '来訪記念' ),
			'links' => array(
				array(
					'url' => kocorolab_refresh_spea_nagasaki_2017_event_url(),
					'ja'  => 'Facebookイベント（2017）',
					'en'  => 'Facebook event (2017)',
				),
			),
		),
		array(
			'keys'  => array( 'happiness1122', 'フィジー人に学ぶ幸福の習慣', 'learning happiness habits from Fijians', '1716882' ),
			'links' => array(
				array(
					'url' => kocorolab_refresh_nagasaki_2020_peatix_url(),
					'ja'  => 'Peatix（2020）',
					'en'  => 'Peatix (2020)',
				),
			),
		),
		array(
			'keys'  => array( 'フィリピン教育留学', 'Philippines education study', '183306' ),
			'links' => array(
				array(
					'url' => kocorolab_refresh_spea_ed_press_url(),
					'ja'  => 'フィリピン教育留学のプレスリリース',
					'en'  => 'Philippines education study press release',
				),
			),
		),
		array(
			'keys'  => array( 'セブポットセミナー', 'しあわせワークショップ', 'Cebu Pot seminar', 'Happiness Workshop', 'cebupot-happiness-workshop-2016' ),
			'links' => array(
				array(
					'url' => kocorolab_refresh_cebupot_2016_magazine_pdf(),
					'ja'  => 'セブポット紙面原稿（2016）',
					'en'  => 'Cebu Pot magazine notice (2016)',
				),
				array(
					'url' => kocorolab_refresh_cebupot_facebook_url(),
					'ja'  => 'セブポットのFacebook（当時のイベント告知）',
					'en'  => 'Cebu Pot Facebook (event announcements)',
				),
			),
		),
		array(
			'keys'  => array( '第15回ミニ・フォーラム', '15th mini-forum', 'About Filipino Business', 'mini-forum-2015-12-15' ),
			'links' => array(
				array(
					'url' => kocorolab_refresh_neue_fahne_2015_forum_pdf(),
					'ja'  => 'ミニ・フォーラム案内PDF（2015）',
					'en'  => 'Mini-forum flyer PDF (2015)',
				),
			),
		),
		array(
			'keys'  => array( 'グローバル人材400万人', 'Journal No.50', 'Journal No. 50', 'mid-level global talent' ),
			'links' => array(
				array(
					'url' => kocorolab_refresh_neue_fahne_journal_50_pdf(),
					'ja'  => 'Neue Fahne Journal No.50（本文PDF）',
					'en'  => 'Neue Fahne Journal No. 50 (PDF)',
				),
			),
		),
		array(
			'keys'  => array( 'Journal No.20', 'Journal No. 20', '世代間の「価値観」', 'journal20' ),
			'links' => array(
				array(
					'url' => kocorolab_refresh_neue_fahne_journal_20_pdf(),
					'ja'  => 'Neue Fahne Journal No.20（本文PDF）',
					'en'  => 'Neue Fahne Journal No. 20 (PDF)',
				),
			),
		),
		array(
			'keys'  => array( 'モチベーション3.0とは何か', 'What is Motivation 3.0', 'hansenken', '販売戦略検討会' ),
			'links' => array(
				array(
					'url' => kocorolab_refresh_hansenken_url(),
					'ja'  => '販売戦略検討会（講演記録）',
					'en'  => 'Sales Strategy Study Group (talk record)',
				),
			),
		),
		array(
			'keys'  => array( 'n-fahne', 'mental01', '廣済堂×ココロラボ' ),
			'links' => array(
				array(
					'url' => 'http://www.n-fahne.jp/pdf/mental01.pdf',
					'ja'  => 'MHQセミナー案内PDF（2011）',
					'en'  => 'MHQ seminar flyer PDF (2011)',
				),
			),
		),
		array(
			'keys'  => array( '感情から見たリーダーシップ発生モデル', 'Leadership generation model from the perspective of emotion', 'VALDES Technical paper', 'valdes-leadership-generation-2000' ),
			'links' => array(
				array(
					'url' => kocorolab_refresh_valdes_leadership_2000_url(),
					'ja'  => 'VALDESテクニカルペーパー（本文PDF）',
					'en'  => 'VALDES technical paper (PDF)',
				),
			),
		),
		array(
			'keys'  => array( '役割アイデンティティのない状況下', 'without role identity', 'niigata-tit-leadership-2000', '交流ディスカッション' ),
			'links' => array(
				array(
					'url' => kocorolab_refresh_niigata_tit_2000_resume_url(),
					'ja'  => '新潟大・東工大交流の発表レジュメ',
					'en'  => 'Niigata–Tokyo Tech discussion resume',
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
	if ( preg_match( '#(?:www\.)?jinjibu\.jp/news/detl/(3238|3980)#i', $url, $m ) && false === strpos( $url, 'service.jinjibu.jp' ) ) {
		return array(
			'https://service.jinjibu.jp/news/detl/' . $m[1] . '/',
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

}
