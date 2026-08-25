<?php
/**
 * Full publications list from the live site, with the 2025 JCSS sole-author paper first.
 */

function kocorolab_refresh_jcss_pdfs() {
	return array(
		'2025' => 'https://www.jcss.gr.jp/meetings/jcss2025/proceedings/pdf/JCSS2025_P2-37.pdf',
		'2016' => 'https://www.jcss.gr.jp/meetings/jcss2016/proceedings/pdf/JCSS2016_P1-16.pdf',
		'2011' => 'https://www.jcss.gr.jp/meetings/JCSS2011/proceedings/pdf/JCSS2011_P2-26.pdf',
	);
}

function kocorolab_refresh_publications_pdf() {
	$pdfs = kocorolab_refresh_jcss_pdfs();
	return $pdfs['2025'];
}

function kocorolab_refresh_change_management_playlist() {
	return 'https://www.youtube.com/playlist?list=PLiSKEuDit5HplW8JI5fHlWPYA32wQwAxp';
}

function kocorolab_refresh_iccm_2004_pdf() {
	return 'https://iccm-conference.neocities.org/2004/proceedings/abstracts/noda.pdf';
}

function kocorolab_refresh_cogsci_2007_pdf() {
	return 'https://escholarship.org/content/qt7xp559mc/qt7xp559mc.pdf';
}

function kocorolab_refresh_jps_1997_pdf() {
	return 'https://www.jstage.jst.go.jp/article/jpsgaiyo/52.2.4/0/52.2.4_908_4/_pdf';
}

function kocorolab_refresh_tokyotech_2011_guidance_pdf() {
	$file = 'tokyo-tech-job-guidance-2011.pdf';
	if ( function_exists( 'content_url' ) ) {
		return content_url( 'mu-plugins/kocorolab-site-refresh/files/' . $file );
	}
	$root = function_exists( 'kocorolab_refresh_root' ) ? kocorolab_refresh_root() : 'https://kocorolab.com';
	return $root . '/wp-content/mu-plugins/kocorolab-site-refresh/files/' . $file;
}

function kocorolab_refresh_ice_2013_url() {
	return 'https://share.google/OnGq4xL8mDEoGt7E1';
}

function kocorolab_refresh_fukuoka_2013_url() {
	return 'https://www.data-max.co.jp/2013/05/29/2000_13_dm1806_1.html';
}

function kocorolab_refresh_linked_item( $citation, $url, $lang = 'ja', $label = 'PDF' ) {
	$href   = function_exists( 'esc_url' ) ? esc_url( $url ) : $url;
	$linked = '<a href="' . $href . '">' . $citation . '</a>';
	$extra  = '<a href="' . $href . '">' . $label . '</a>';
	return ( 'en' === $lang ) ? $linked . ' (' . $extra . ')' : $linked . ' （' . $extra . '）';
}

function kocorolab_refresh_linked_paper( $citation, $url, $lang = 'ja' ) {
	return kocorolab_refresh_linked_item( $citation, $url, $lang, 'PDF' );
}

function kocorolab_refresh_pub_media() {
	return array(
		'vuca'       => array(
			'url'    => 'https://www.amazon.co.jp/dp/B0DTS8XLPD',
			'img'    => 'https://m.media-amazon.com/images/P/B0DTS8XLPD.01._SCLZZZZZZZ_.jpg',
			'kind'   => 'book',
			'alt_ja' => 'VUCA時代のストレス防衛術',
			'alt_en' => 'Stress Defense Strategies in the VUCA Era',
		),
		'depression' => array(
			'url'    => 'https://www.amazon.co.jp/dp/B0DGFRYHMX',
			'img'    => 'https://m.media-amazon.com/images/P/B0DGFRYHMX.01._SCLZZZZZZZ_.jpg',
			'kind'   => 'book',
			'alt_ja' => '「私、うつになりやすいかも？」と思った時に読む本',
			'alt_en' => 'The book you should read when you think you would be depression',
		),
		'change'     => array(
			'url'    => kocorolab_refresh_change_management_playlist(),
			'img'    => 'https://i.ytimg.com/vi/OrTwN4gGEp0/hqdefault.jpg',
			'kind'   => 'video',
			'alt_ja' => 'ウェルビーイング時代のチェンジマネジメント',
			'alt_en' => 'Change Management under Well-being Era',
		),
		'hiramoto'   => array(
			'url'    => 'https://www.youtube.com/watch?v=5acopoZcYfw',
			'img'    => 'https://img.youtube.com/vi/5acopoZcYfw/hqdefault.jpg',
			'kind'   => 'video',
			'alt_ja' => 'フィリピンの貧困と幸福度の現状',
			'alt_en' => 'Poverty and happiness in the Philippines',
		),
		'reverse'    => array(
			'url'    => 'https://www.amazon.co.jp/dp/4496053454',
			'img'    => 'https://m.media-amazon.com/images/P/4496053454.01._SCLZZZZZZZ_.jpg',
			'kind'   => 'book',
			'alt_ja' => '中小企業のリバースイノベーション',
			'alt_en' => 'Reverse Innovation of Japanese SMEs',
		),
		'quality'    => array(
			'url'    => 'https://www.amazon.co.jp/dp/4788513969',
			'img'    => 'https://cover.openbd.jp/9784788513969.jpg',
			'kind'   => 'book',
			'alt_ja' => '量から質に迫る',
			'alt_en' => 'Approaching quality from quantity',
		),
		'coaching'   => array(
			'url'    => 'https://amzn.asia/d/0boDUx9G',
			'img'    => 'https://m.media-amazon.com/images/P/4779509823.01._SCLZZZZZZZ_.jpg',
			'kind'   => 'book',
			'alt_ja' => 'コーチング心理学概論',
			'alt_en' => 'Introduction to Coaching Psychology',
		),
	);
}

function kocorolab_refresh_with_thumb( $html, $img, $url, $alt, $kind = 'book' ) {
	$href  = function_exists( 'esc_url' ) ? esc_url( $url ) : $url;
	$src   = function_exists( 'esc_url' ) ? esc_url( $img ) : $img;
	$alt   = function_exists( 'esc_attr' ) ? esc_attr( $alt ) : htmlspecialchars( (string) $alt, ENT_QUOTES, 'UTF-8' );
	$class = ( 'video' === $kind ) ? 'kl-pub-thumb kl-pub-thumb--video' : 'kl-pub-thumb kl-pub-thumb--book';
	return '<span class="kl-pub-media"><a class="' . $class . '" href="' . $href . '"><img src="' . $src . '" alt="' . $alt . '" loading="lazy" decoding="async"></a><span class="kl-pub-text">' . $html . '</span></span>';
}

function kocorolab_refresh_media_item( $citation, $key, $lang = 'ja', $label = 'Amazon' ) {
	$media = kocorolab_refresh_pub_media();
	if ( ! isset( $media[ $key ] ) ) {
		return $citation;
	}
	$m    = $media[ $key ];
	$html = kocorolab_refresh_linked_item( $citation, $m['url'], $lang, $label );
	$alt  = ( 'en' === $lang ) ? $m['alt_en'] : $m['alt_ja'];
	return kocorolab_refresh_with_thumb( $html, $m['img'], $m['url'], $alt, $m['kind'] );
}

function kocorolab_refresh_publications_years( $lang = 'ja' ) {
	$pdfs = kocorolab_refresh_jcss_pdfs();
	$ja   = array(
		'2025' => array(
			kocorolab_refresh_linked_paper( '野田浩平 (2025) U理論の認知感情モデル. 日本認知科学会第42回大会予稿集, pp. 466-469.', $pdfs['2025'], 'ja' ),
			kocorolab_refresh_media_item( '野田浩平, まめ, 海下理恵 (2025) VUCA時代のストレス防衛術: うつにならない、ストレスをためない為のTIPs集. (Kohei Noda, Mame, Rie Kaishita (2025) Stress Defense Strategies in the VUCA Era: Tips for Preventing Depression and Accumulating Stress)', 'vuca', 'ja', 'Amazon' ),
		),
		'2024' => array(
			kocorolab_refresh_media_item( '野田浩平 (2024)「私、うつになりやすいかも？」と思った時に読む本', 'depression', 'ja', 'Amazon' ),
			kocorolab_refresh_media_item( '野田浩平, 松村憲, 小島美佳 (2024) ウェルビーイング時代のチェンジマネジメント (Kohei Noda, Ken Matsumura, and Mika Kojima (2024) Change Management under Well-being Era)', 'change', 'ja', 'YouTubeシリーズ' ),
		),
		'2020' => array(
			kocorolab_refresh_with_thumb(
				'野田浩平, 平本あきお (2020) フィリピンの貧困と幸福度の現状 海外で働く日本人, YouTube 平本あきおチャンネル. <a href="https://www.youtube.com/watch?v=5acopoZcYfw">動画</a>（<a href="https://www.youtube.com/@hiramotoakio">チャンネル</a>）',
				kocorolab_refresh_pub_media()['hiramoto']['img'],
				kocorolab_refresh_pub_media()['hiramoto']['url'],
				kocorolab_refresh_pub_media()['hiramoto']['alt_ja'],
				'video'
			),
		),
		'2018' => array(
			kocorolab_refresh_media_item( '吉田健太郎, 野田浩平 (2018) 第10章 サービス業「IT・コールセンター」の事例―フィリピン, 吉田健太郎(編), 中小企業のリバースイノベーション, 同友館', 'reverse', 'ja', 'Amazon' ),
		),
		'2017' => array(
			'Kohei Noda and Maria Katrina Taylo, Normalised purely psychological Happiness national comparisons by UN and Gallup surveys. Internal discussion meeting at Free Bird Institute in Fiji.',
		),
		'2016' => array(
			kocorolab_refresh_linked_paper( '野田浩平, 松岡良彦 (2016) 第二言語としての英語学習におけるReal Life Experience法の提案. 第33回日本認知科学会年次大会', $pdfs['2016'], 'ja' ),
			'Kohei Noda, Happiness Workshop: learning from Filipino — Why Filipino People are always smiling, Cebu Pot Seminar, 24 March 2016, Cebu, Philippines',
			'Kohei Noda and Takashi Maeno, Trend in Happiness of Filipino From the Viewpoint of Comparison to Japanese, The 23rd Congress of the International Association for Cross-Cultural Psychology 2016, 30 July – 3 August, Nagoya, Japan. (Cancelled)',
		),
		'2015' => array(
			'Kohei Noda, About Filipino Business for Japanese, 講演',
			'Kohei Noda, Narratives on HRM experience in the Philippines, Neue Fahne Seminar, 15 December 2016, Tokyo, Japan',
			kocorolab_refresh_media_item( '野田浩平, 西垣悦代 (2015) 国際コーチング心理学会, 西垣悦代, 原正, 原口佳典（編）, 『コーチング心理学概論』, ナカニシヤ出版', 'coaching', 'ja', 'Amazon' ),
		),
		'2014' => array(
			kocorolab_refresh_media_item( '野田浩平 (2014) 感情機構のシミュレーション, 村井源（編）, 『量から質に迫る―人間の複雑な感性をいかに「計る」か』, 新曜社', 'quality', 'ja', 'Amazon' ),
		),
		'2013' => array(
			kocorolab_refresh_linked_item( '野田浩平 (2013) 講師, 福岡市・福岡商工会議所主催「会社合同説明会」内「就活応援セミナー」, 2013年5月28日, 福岡国際会議場.', kocorolab_refresh_fukuoka_2013_url(), 'ja', '報道' ),
			kocorolab_refresh_linked_item( 'Kohei Noda, Plenary Talk, ICE 2013: PELS International Congress on eLearning 2013, 6–7 December 2013, The Heritage Hotel Manila, Philippines', kocorolab_refresh_ice_2013_url(), 'ja', '会議' ),
			'西垣悦代, 堀正, 本間正人, 野田浩平 (2013) 日本におけるコーチング心理学の確立に向けて, 公募シンポジウム, 日本心理学会第77回大会',
		),
		'2012' => array(
			'Noda K. (2012) A cognitive emotional model for “intrinsic motivation”, Proceeding of the 34th Annual Meeting of Cognitive Science Society.',
		),
		'2011' => array(
			kocorolab_refresh_linked_paper( '野田浩平 (2011) 講師, 東京工業大学学生支援センター主催 就職ガイダンス（大岡山）「博士課程学生の就職」, 2011年11月9日, 70周年記念講堂.', kocorolab_refresh_tokyotech_2011_guidance_pdf(), 'ja' ),
			'野田浩平 (2011) 世代間の「価値観」の相違を互いに認め合う ～これからの企業の人材育成課題を探る～, Neue Fahne Journal No. 20.',
			'野田浩平, 児玉義徳 (2011) 日本の起業家の特性及び背景要因の研究, 人材育成学会第9回大会予稿集',
			'野田浩平 (2011) うつ病の増加を止め、絆を取り戻す社会への変化のきっかけ, 東京工業大学大学院社会理工学研究科価値システム専攻15周年記念論考 re-boot 0311→1130 VALDES OPINIONS.',
			kocorolab_refresh_linked_paper( '野田浩平, 宮越大樹, 五十嵐久美子, 平本明武 (2011) 気付きを生み，動機付けを高めるシミュレーション方法の開発, 日本認知科学会第28回大会予稿集', $pdfs['2011'], 'ja' ),
		),
		'2010' => array(
			'Noda K. and Agullo, B. (2010) Simulating Corporate Organizational Performance at the Cognitive Modeling/Architecture Level, Proceeding of the 32nd Annual Meeting of Cognitive Science Society.',
			'野田浩平 (2010) いかに職業価値観を正しく測定するか −身体性記憶を用いた職業価値観の測定法とその知識表現−, 第8回日本人材育成学会年次大会予稿集',
		),
		'2009' => array(
			'Agullo, B. and Noda K. (2009) Agent-based HR cost simulation to aid strategic HRM decision-making: Optimizing the cost balance of hiring and training, 第7回日本人材育成学会年次大会予稿集',
			'野田浩平, 相崎明希子, 岩澤健久 (2009) 企業向け抑うつリスク検査開発の試み, 第14回日本産業カウンセリング学会年次大会予稿集, pp. 138-139.',
		),
		'2008' => array(
			'Noda, K., Hisatsu, G., and Voss, K. (2008) An application of Cognitive Emotional Agent Architecture to model Emotional Intelligence, International Journal of Work, Organization and Emotion, 2(4) pp. 389-406.',
			'Noda, K., Sasaki, K., Noguchi, A. and Yokoi, M. (2008) Modeling emotional intelligence from kansei informatics point of view, Proceedings of the Second International Workshop on Kansei, pp. 12-14.',
			'Noda, K., Takeda, Y. and Yokoi, M. (2008) Cognitive Knowledge, Skills and Abilities (KSAs) to enhance emotional intelligence, Proceeding of the 30th Annual Meeting of Cognitive Science Society.',
		),
		'2007' => array(
			'野田浩平 (2007) 脳に着想を得た感情機構エージェントとその企業人事管理システムへの応用, 東京工業大学博士学位論文.',
			kocorolab_refresh_linked_paper( 'Noda, K. and Hisatsu, G. (2007) An Application of Cognitive Emotional Agent Architecture to Corporate Human Resource Management, Proceedings of 29th annual conference of the cognitive science society, 1824.', kocorolab_refresh_cogsci_2007_pdf(), 'ja' ),
			'Noda, K. (2007) An application of human resource evaluation ontology, Proceedings of Symposium on Large-scale Knowledge Resources (LKR 2007), Tokyo Institute of Technology.',
			'野田浩平, Klaus Voss, 久津豪 (2007) 人事評価情報の可視化, 知識共有への認知科学の応用 — エージェントモデリング及びオントロジーを用いて, 『認知科学』14(1) pp. 78-89.',
		),
		'2006' => array(
			'Noda, K., Voss, K. and Tokosumi, A. (2006) Emotion agent architecture simulating emotional reactions in a recruitment interview, Proceedings of international One-Day conference on “Emotion and Work: Ideas and Progress”, pp. 12-13.',
			'Noda, K. (2006) Emotion Mechanism of Anxiety by Agent Based Simulation on Recruitment Interview, Proceedings of 6th annual meeting of the Japanese Association for Cognitive Therapy, 117.',
			'Noda, K. (2006) Towards a Representational Model of Evaluation Ontology, Proceedings of International Symposium on Large Scale Knowledge Resources: LKR2006, 159-160.',
		),
		'2005' => array(
			'Noda, K. (2005) Chapter 4 “DPI (Diamond Personality Inventory) test” and Recruitment Interview, in Honmyo, H., Oda, M., and Noguchi, K. (eds.), Attitude Ability Handbook, 50-57, 60. Tokyo: Diamond Inc.',
			'Noda, K. and Tokosumi, A. (2005) The Development of Value Ontology, Proceedings of Symposium on Large Scale Knowledge Resources: LKR2005, 179-182.',
		),
		'2004' => array(
			'Noda, K. and Tokosumi, A. (2004) An Embodied Computational Model of Simulating Depression, Proceedings of IEEE 13th International Workshop on Robot and Human Interactive Communication.',
			kocorolab_refresh_linked_paper( 'Noda, K. and Tokosumi, A. (2004) “Artificial brain methodology” and an application of StarLogo, Proceedings of The Sixth International Conference on Cognitive Modeling, 374-375.', kocorolab_refresh_iccm_2004_pdf(), 'ja' ),
		),
		'2002' => array(
			'Noda, K. and Tokosumi, A. (2002) A simulated embodied agent model of depression by Artificial Brain Methodology, Proceeding of the 19th Annual Meeting of the Japanese Cognitive Science Society, 8-9.',
			'Noda, K. (2002) A Computational Model of Depression by Design Approach, Master Thesis, Department of Value and Decision Science, Tokyo Institute of Technology.',
		),
		'2001' => array(
			'Pfeifer, R., Iida, F., Noda, K. (2001) Joint Swiss-Japanese Projects of the AILab, Journal Quarterly Review of Swiss-Japanese Chamber of Commerce, 3.',
			'Noda, K. and Tokosumi, A. (2001) A Double-layered Architecture of Emotion — Artificial Brain Methodology for Depression, Knowledge-Based Intelligent Information Engineering Systems & Allied Technologies KES’2001 Part 2, 1239-1242. Tokyo: Ohmsha.',
			'Noda, K. and Tokosumi, A. (2001) The emergence of depression – A proposal for a methodology of emotion research, Proceedings of the Third International Conference on Cognitive Science, 164. Beijing.',
		),
		'2000' => array(
			'Noda, K. (2000) Leadership generation model from the perspective of emotion（感情から見たリーダーシップ発生モデル）, VALDES Technical paper, Tokyo Institute of Technology.',
			'Noda, K. and Tokosumi, A. (2000) The cognitive model of thinking process under the depression（抑うつ気分における思考過程の認知モデル）, 認知療法ニュース, 15.',
			'Tokosumi, A. and Noda, K. (2000) Design principle of an artificial brain for emotion and kansei. Proceedings of the 11th T.I.T. Brain Research Symposium, pp. 38-45.',
			'Noda, K. and Tokosumi, A. (2000) Brain modeling of depressive feeling and thinking, Proceedings of the 1st Corpus informatics research meeting, pp. 8-11.',
		),
		'1997' => array(
			kocorolab_refresh_linked_paper( '野田浩平, 根本真吾, 梅林正行, 狩野勝弘, Ezoubtchenko A.N., 鈴木正昭, 赤塚洋 (1997) マイクロ波加熱大気圧酸素プラズマの分光診断, 日本物理学会講演概要集 52(2-4), 908.', kocorolab_refresh_jps_1997_pdf(), 'ja' ),
		),
	);

	$en = array(
		'2025' => array(
			kocorolab_refresh_linked_paper( 'Kohei Noda (2025) The cognitive affective model of theory U. Proceedings of the 42nd Annual Meeting of the Japanese Cognitive Science Society, pp. 466-469.', $pdfs['2025'], 'en' ),
			kocorolab_refresh_media_item( 'Kohei Noda, Mame, Rie Kaishita (2025) Stress Defense Strategies in the VUCA Era: Tips for Preventing Depression and Accumulating Stress', 'vuca', 'en', 'Amazon' ),
		),
		'2024' => array(
			kocorolab_refresh_media_item( 'Kohei Noda (2024) The book you should read when you think you would be depression', 'depression', 'en', 'Amazon' ),
			kocorolab_refresh_media_item( 'Kohei Noda, Ken Matsumura, and Mika Kojima (2024) Change Management under Well-being Era', 'change', 'en', 'YouTube series' ),
		),
		'2020' => array(
			kocorolab_refresh_with_thumb(
				'Kohei Noda and Akio Hiramoto (2020) The current status of poverty and happiness in the Philippines, YouTube Hiramoto Akio Channel. <a href="https://www.youtube.com/watch?v=5acopoZcYfw">Video</a> (<a href="https://www.youtube.com/@hiramotoakio">channel</a>)',
				kocorolab_refresh_pub_media()['hiramoto']['img'],
				kocorolab_refresh_pub_media()['hiramoto']['url'],
				kocorolab_refresh_pub_media()['hiramoto']['alt_en'],
				'video'
			),
		),
		'2018' => array(
			kocorolab_refresh_media_item( 'Kentaro Yoshida and Kohei Noda (2018) Chapter 10 The Case of Service industry “IT and Call center” — the Philippines, Reverse Innovation of Japanese SMEs. Doyukan', 'reverse', 'en', 'Amazon' ),
		),
		'2017' => array(
			'Kohei Noda and Maria Katrina Taylo, Normalised purely psychological Happiness national comparisons by UN and Gallup surveys. Internal discussion meeting at Free Bird Institute in Fiji.',
		),
		'2016' => array(
			kocorolab_refresh_linked_paper( 'Kohei Noda, Yoshihiko Matsuoka (2016) Proposal of Real Life Experience Method in English Language as Second Language. 33rd Annual Meeting of the Japanese Cognitive Science Society', $pdfs['2016'], 'en' ),
			'Kohei Noda, Happiness Workshop: learning from Filipino — Why Filipino People are always smiling, Cebu Pot Seminar, 24 March 2016, Cebu, Philippines',
			'Kohei Noda and Takashi Maeno, Trend in Happiness of Filipino From the Viewpoint of Comparison to Japanese, The 23rd Congress of the International Association for Cross-Cultural Psychology 2016, Nagoya, Japan. (Cancelled)',
		),
		'2015' => array(
			'Kohei Noda, Narratives on HRM experience in the Philippines, Neue Fahne Seminar, 15 December 2016, Tokyo, Japan',
			kocorolab_refresh_media_item( 'Kohei Noda and Etsuyo Nishigaki (2015) in Etsuyo Nishigaki et al. (eds.), Introduction to Coaching Psychology, Nakanishiya', 'coaching', 'en', 'Amazon' ),
		),
		'2014' => array(
			kocorolab_refresh_media_item( 'Kohei Noda (2014) Simulation of emotional mechanism, in Gen Murai (ed.), Approaching quality from quantity, Shin-yo-sha', 'quality', 'en', 'Amazon' ),
		),
		'2013' => array(
			kocorolab_refresh_linked_item( 'Kohei Noda (2013) Lecturer, job-hunting support seminar at the company joint briefing hosted by Fukuoka City and the Fukuoka Chamber of Commerce, 28 May 2013, Fukuoka International Congress Center.', kocorolab_refresh_fukuoka_2013_url(), 'en', 'report' ),
			kocorolab_refresh_linked_item( 'Kohei Noda, Plenary Talk, ICE 2013: PELS International Congress on eLearning 2013, 6–7 December 2013, The Heritage Hotel Manila, Philippines', kocorolab_refresh_ice_2013_url(), 'en', 'conference' ),
			'Etsuyo Nishigaki, Tadashi Hori, Masato Honma, Kohei Noda (2013) Toward establishing coaching psychology in Japan, 77th Annual Meeting of the Japanese Psychological Association',
		),
		'2012' => array(
			'Noda K. (2012) A cognitive emotional model for “intrinsic motivation”, Proceeding of the 34th Annual Meeting of Cognitive Science Society.',
		),
		'2011' => array(
			kocorolab_refresh_linked_paper( 'Kohei Noda (2011) Lecture on PhD employment at the Tokyo Institute of Technology (Ookayama) career guidance, Student Support Center, 9 November 2011.', kocorolab_refresh_tokyotech_2011_guidance_pdf(), 'en' ),
			'Noda, K., and Kodama, Y. (2011) Research on the Special Characteristics and Background Elements of Japanese Entrepreneurs, Proceedings of the 9th annual meeting of Japanese Academy of Human Resource Development.',
			kocorolab_refresh_linked_paper( 'Noda, K., Miyakoshi, D., Igarashi, K., and Hiramoto (2011) The development of the mental simulation methodology which enhances mindfulness and motivation, Proceedings of the 28th annual meeting of Japanese Cognitive Science Society', $pdfs['2011'], 'en' ),
		),
		'2010' => array(
			'Noda K. and Agullo, B. (2010) Simulating Corporate Organizational Performance at the Cognitive Modeling/Architecture Level, Proceeding of the 32nd Annual Meeting of Cognitive Science Society.',
			'Noda K. (2010) How to assess work values correctly, Proceedings of the 8th Annual Meeting of the Japanese Academy of Human Resource Development.',
		),
		'2009' => array(
			'Agullo, B. and Noda K. (2009) Agent-based HR cost simulation to aid strategic HRM decision-making, Proceedings of the 7th Annual Meeting of the Japanese Academy of Human Resource Development.',
			'Noda, K., Aizaki, A. and Iwasawa, T. (2009) Attempt to develop a depression survey to use in organizations, Proceedings of the 14th Annual Meeting of the Japanese Association of Industrial Counselors, pp. 138-139.',
		),
		'2008' => array(
			'Noda, K., Hisatsu, G., and Voss, K. (2008) An application of Cognitive Emotional Agent Architecture to model Emotional Intelligence, International Journal of Work, Organization and Emotion, 2(4) pp. 389-406.',
			'Noda, K., Sasaki, K., Noguchi, A. and Yokoi, M. (2008) Modeling emotional intelligence from kansei informatics point of view, Proceedings of the Second International Workshop on Kansei, pp. 12-14.',
			'Noda, K., Takeda, Y. and Yokoi, M. (2008) Cognitive Knowledge, Skills and Abilities (KSAs) to enhance emotional intelligence, Proceeding of the 30th Annual Meeting of Cognitive Science Society.',
		),
		'2007' => array(
			'Noda, K. (2007) Brain Inspired Cognitive Emotional Agent Architecture and its Application to Corporate Human Resource Management System. Doctoral Dissertation, Tokyo Institute of Technology.',
			kocorolab_refresh_linked_paper( 'Noda, K. and Hisatsu, G. (2007) An Application of Cognitive Emotional Agent Architecture to Corporate Human Resource Management, Proceedings of 29th annual conference of the cognitive science society, 1824.', kocorolab_refresh_cogsci_2007_pdf(), 'en' ),
			'Noda, K., Voss, K. and Hisatsu, G. (2007) An application of cognitive science research outcomes to the visualization and the knowledge sharing of human resource evaluation information, Cognitive Studies, 14(1) pp. 78-89.',
		),
		'2006' => array(
			'Noda, K., Voss, K. and Tokosumi, A. (2006) Emotion agent architecture simulating emotional reactions in a recruitment interview, Proceedings of international One-Day conference on “Emotion and Work”.',
			'Noda, K. (2006) Emotion Mechanism of Anxiety by Agent Based Simulation on Recruitment Interview, Proceedings of 6th annual meeting of the Japanese Association for Cognitive Therapy, 117.',
			'Noda, K. (2006) Towards a Representational Model of Evaluation Ontology, Proceedings of International Symposium on Large Scale Knowledge Resources: LKR2006, 159-160.',
		),
		'2005' => array(
			'Noda, K. (2005) Chapter 4 “DPI (Diamond Personality Inventory) test” and Recruitment Interview, Attitude Ability Handbook, 50-57. Tokyo: Diamond Inc.',
			'Noda, K. and Tokosumi, A. (2005) The Development of Value Ontology, Proceedings of Symposium on Large Scale Knowledge Resources: LKR2005, 179-182.',
		),
		'2004' => array(
			'Noda, K. and Tokosumi, A. (2004) An Embodied Computational Model of Simulating Depression, Proceedings of IEEE 13th International Workshop on Robot and Human Interactive Communication.',
			kocorolab_refresh_linked_paper( 'Noda, K. and Tokosumi, A. (2004) “Artificial brain methodology” and an application of StarLogo, Proceedings of The Sixth International Conference on Cognitive Modeling, 374-375.', kocorolab_refresh_iccm_2004_pdf(), 'en' ),
		),
		'2002' => array(
			'Noda, K. and Tokosumi, A. (2002) A simulated embodied agent model of depression by Artificial Brain Methodology, Proceeding of the 19th Annual Meeting of the Japanese Cognitive Science Society, 8-9.',
			'Noda, K. (2002) A Computational Model of Depression by Design Approach, Master Thesis, Tokyo Institute of Technology.',
		),
		'2001' => array(
			'Pfeifer, R., Iida, F., Noda, K. (2001) Joint Swiss-Japanese Projects of the AILab, Journal Quarterly Review of Swiss-Japanese Chamber of Commerce, 3.',
			'Noda, K. and Tokosumi, A. (2001) A Double-layered Architecture of Emotion, Knowledge-Based Intelligent Information Engineering Systems KES’2001 Part 2, 1239-1242. Tokyo: Ohmsha.',
			'Noda, K. and Tokosumi, A. (2001) The emergence of depression – A proposal for a methodology of emotion research, Proceedings of the Third International Conference on Cognitive Science, 164.',
		),
		'2000' => array(
			'Noda, K. (2000) Leadership generation model from the perspective of emotion, VALDES Technical paper, Tokyo Institute of Technology.',
			'Noda, K. and Tokosumi, A. (2000) The cognitive model of thinking process under the depression, cognitive therapy news, 15.',
			'Tokosumi, A. and Noda, K. (2000) Design principle of an artificial brain for emotion and kansei. Proceedings of the 11th T.I.T. Brain Research Symposium, pp. 38-45.',
		),
		'1997' => array(
			kocorolab_refresh_linked_paper( 'Noda, K. et al. (1997) Spectroscopic diagnosis of microwave-heated atmospheric-pressure oxygen plasma, Meeting abstracts of the Physical Society of Japan 52(2-4), 908.', kocorolab_refresh_jps_1997_pdf(), 'en' ),
		),
	);

	return ( 'en' === $lang ) ? $en : $ja;
}

function kocorolab_refresh_publications_html( $lang = 'ja' ) {
	$years = kocorolab_refresh_publications_years( $lang );
	$intro = kocorolab_refresh_t( 'pub_intro', $lang );
	ob_start();
	?>
	<div class="kl-page kl-pubs">
		<p class="kl-lead"><?php echo esc_html( $intro ); ?></p>
		<?php foreach ( $years as $year => $items ) : ?>
			<h2><?php echo esc_html( $year ); ?></h2>
			<?php foreach ( $items as $item ) : ?>
				<p<?php echo ( false !== strpos( $item, 'kl-pub-media' ) ) ? ' class="kl-pub-row"' : ''; ?>><?php echo $item; ?></p>
			<?php endforeach; ?>
		<?php endforeach; ?>
	</div>
	<?php
	return ob_get_clean();
}

function kocorolab_refresh_news_preview_items( $lang = 'ja' ) {
	$ja = array(
		array( '2026-03-01', 'MIT Sloan/UID IDEAS Asia Pacific 3.0 2026参加者推薦を開始致しました。' ),
		array( '2020-12-06', '健康×幸福トーク登壇' ),
		array( '2020-01-01', 'フィリピンの貧困と幸福度の現状' ),
		array( '2020-04-01', 'コロナ禍でのストレスについての寄稿' ),
		array( '2020-01-02', 'SDGs Learning Journey 2020の案内' ),
		array( '2018-01-01', 'SDGs Learning Journey 2018報告' ),
		array( '2013-01-01', 'GBX(Global Business eXperience)の記事' ),
		array( '2009-01-01', 'MHQ(Mental Health 質問票）のバージョン１発売のプレスリリース' ),
	);
	$en = array(
		array( '2026-03-01', 'MIT Sloan/UID IDEAS Asia Pacific 3.0 2026 nominations open' ),
		array( '2020-12-06', 'Talk on health and happiness' ),
		array( '2020-01-01', 'Poverty and happiness in the Philippines' ),
		array( '2020-04-01', 'Note on stress during COVID' ),
		array( '2020-01-02', 'SDGs Learning Journey 2020' ),
		array( '2018-01-01', 'SDGs Learning Journey 2018 report' ),
		array( '2013-01-01', 'GBX (Global Business eXperience)' ),
		array( '2009-01-01', 'MHQ version 1 press release' ),
	);
	return ( 'en' === $lang ) ? $en : $ja;
}

function kocorolab_refresh_news_html( $lang = 'ja' ) {
	$items = kocorolab_refresh_news_preview_items( $lang );
	$c     = kocorolab_refresh_copy( $lang );
	ob_start();
	?>
	<div class="kl-page">
		<p class="kl-lead"><?php echo esc_html( $c['news_lead'] ); ?></p>
		<ul class="kl-news-list">
			<?php foreach ( $items as $item ) : ?>
				<li>
					<time datetime="<?php echo esc_attr( $item[0] ); ?>"><?php echo esc_html( str_replace( '-', '.', substr( $item[0], 0, 10 ) ) ); ?></time>
					<div>
						<span><?php echo esc_html( $item[1] ); ?></span>
						<?php echo kocorolab_refresh_related_links_html( $item[1], $lang ); ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php
	return ob_get_clean();
}
