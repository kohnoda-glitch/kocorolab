<?php
/**
 * JA/EN copy. Public text stays professional.
 * Services stay on one page. Occasional updates (IDEAS, MHQ) go to 活動・新着.
 */

function kocorolab_refresh_copy( $lang = 'ja' ) {
	$ja = array(
		'hero_kicker'    => '株式会社ココロラボ',
		'hero_badge'     => '精神 · 社会 · 環境',
		'hero_title'     => '社会と個人の変容をガイドする',
		'hero_title_accent' => 'Guiding Transformation for Societies and Individuals',
		'hero_lead'      => '個人の心、人と人のしくみ、地球環境。分かれがちな三つを、認知科学と現場の人事実務からつなぎ直します。',
		'hero_cta1'      => 'サービス',
		'hero_cta2'      => '活動・新着',
		'hero_photo_note'=> '写真は仮です。あとから差し替えできます。',
		'cred1'          => 'MIT Sloan IDEAS Asia Pacific regional faculty',
		'cred2'          => 'グロービス経営大学院 教員',
		'cred3'          => '学術博士（東京工業大学）',
		'mission_kicker' => 'MISSION',
		'brand'          => 'Kocoro Laboratory',
		'brand_sub'      => '株式会社ココロラボ',
		'section_world'  => 'こころ・社会・環境',
		'world_lead'     => '個人の心、人と組織のしくみ、地球環境。分かれがちな三つを、一つの仕事として扱います。',
		'domain1_kicker' => '精神',
		'domain1_title'  => '心の状態を、科学で扱う',
		'domain1_body'   => '感情の認知科学とメンタルヘルス検査 MHQ。個人の内側を、感覚だけで終わらせない。',
		'domain2_kicker' => '社会',
		'domain2_title'  => '人と組織のあいだを整える',
		'domain2_body'   => 'リーダーシップ教育、人事、組織づくり。上場前と上場後の事業会社で人事責任者を務めた経験を、現場で使える形にします。',
		'domain3_kicker' => '環境',
		'domain3_title'  => '持続可能な未来とつなぐ',
		'domain3_body'   => 'MIT Sloan IDEAS Asia Pacific や気候変動に関する市民活動など、社会と地球のあいだでも実践します。',
		'section_work'   => 'サービス',
		'work_lead'      => '細かい下層ページは増やしません。必要なものは、この一枚と新着にまとめます。',
		'card1_title'    => 'リーダーシップ教育',
		'card1_body'     => 'グロービス経営大学院と MIT Sloan IDEAS Asia Pacific での教育・研究。U理論などを用いた学び。',
		'card2_title'    => 'メンタルヘルス（MHQ2）',
		'card2_body'     => '現在の検査案内は MHQ2 です。採用や人材育成に使えます。詳細と申し込みは案内ページへ。',
		'card3_title'    => '人事・組織支援',
		'card3_body'     => '人事制度、研修、コーチング、調査研究。',
		'work_link'      => 'サービスを見る',
		'section_news'   => '活動・新着',
		'news_lead'      => 'IDEAS の案内、MHQ の更新、講演や公開資料など、ときどきのお知らせをここに載せます。日記ブログではありません。',
		'news_link'      => '新着一覧',
		'news_empty'     => '新しい案内は、準備ができ次第ここに出します。',
		'section_who'    => '代表',
		'who_body'       => '野田浩平（学術博士）は、株式会社ココロラボ代表取締役、グロービス経営大学院教員、MIT Sloan IDEAS Asia Pacific regional faculty です。',
		'who_hr'         => '人事の実務では、上場前の成長企業と上場後の事業会社の双方で人事責任者を務めてきました。',
		'who_more'       => 'プロフィール',
		'section_pub'    => '発表文献',
		'pub_body'       => '日本認知科学会などでの発表を続けています。2025年は「U理論の認知感情モデル」を第42回大会予稿集（pp. 466-469）に掲載しました。',
		'pub_intro'      => 'ココロラボでは認知科学を基礎に、人間の感情、メンタルヘルス、幸福観、開発教育などについて研究・実践しています。近年はU理論を実践方法論、システム思考を研究方法論に意識的に取り入れ、進めています。',
		'pub_link'       => '文献一覧',
		'contact_link'   => '問い合わせ',
		'company_h2'     => 'ココロラボについて',
		'company_lead'   => '株式会社ココロラボは、精神・社会・環境の分断をほどく研究所です。認知科学と人事実務を橋渡しします。',
		'company_m_h'    => 'ミッション',
		'company_m'      => '社会と個人の変容をガイドする',
		'company_m_other'=> 'Guiding Transformation for Societies and Individuals',
		'company_w_h'    => '活動の柱',
		'company_p_h'    => '代表',
		'overview_h'     => '概要',
		'service_h2'     => 'サービス',
		'service_lead'   => 'サービスはこのページにまとめています。MHQ2 の案内ページと、IDEAS などの資料はそこから辿れます。',
		'svc1_h'         => 'リーダーシップ開発',
		'svc1_b'         => 'U理論などを用いた次世代リーダーシップ開発、組織開発、学びの設計。',
		'svc2_h'         => 'メンタルヘルス検査（MHQ2）',
		'svc2_b'         => 'うつリスクなどの傾向を把握するための MHQ2、および EQ 検査。採用、社内確認、人材育成に使えます。診断の確定を目的としたものではありません。詳細と申し込みは既存の案内ページを使います。',
		'svc2_link'      => 'MHQ2の案内ページへ',
		'svc3_h'         => '人事コンサルティング・コーチング',
		'svc3_b'         => '人事制度、研修、コーチング。事業会社の人事責任者としての実務を踏まえて支援します。',
		'svc4_h'         => '学術研究・統計',
		'svc4_b'         => '認知モデル、心理統計、調査研究。',
		'profile_h2'     => '野田浩平',
		'profile_role'   => '学術博士／産業カウンセラー',
		'profile_now'    => '現在は、グロービス経営大学院教員、MIT Sloan IDEAS Asia Pacific regional faculty、株式会社ココロラボ代表取締役として、教育・研究と実務支援を並行しています。市民気候ロビー（CCL）Japan 代表も務めています。',
		'profile_past'   => 'これまでに人事・組織領域の仕事に携わり、事業会社の人事責任者を務めてきました。',
		'profile_note'   => '研究実績は発表文献、ときどきの案内は活動・新着をご覧ください。',
		'label_name'     => '研究所名',
		'label_ceo'      => '代表取締役',
		'label_addr'     => '所在地',
		'label_founded'  => '設立',
		'label_fy'       => '決算期',
		'label_biz'      => '事業内容',
		'label_bank'     => '取引先銀行',
		'val_name'       => '株式会社ココロラボ　Kocoro Laboratory, Inc.',
		'val_ceo'        => '野田 浩平',
		'val_addr'       => '〒235-0045 神奈川県横浜市磯子区洋光台1-12-41',
		'val_founded'    => '2008年12月1日',
		'val_fy'         => '11月',
		'val_biz'        => '学術研究、人事コンサルティング、研修・コーチング、アセスメント・各種統計分析',
		'val_bank'       => '三菱東京UFJ銀行 表参道支店',
	);

	$en = array(
		'hero_kicker'    => 'Kocoro Laboratory, Inc.',
		'hero_badge'     => 'Mind · Society · Environment',
		'hero_title'     => 'Guiding Transformation for Societies and Individuals',
		'hero_title_accent' => '社会と個人の変容をガイドする',
		'hero_lead'      => 'Inner life, human systems, and the living planet. We reconnect what is too often treated as separate, through cognitive science and practical HR.',
		'hero_cta1'      => 'Services',
		'hero_cta2'      => 'News & activities',
		'hero_photo_note'=> 'Placeholder photos. Swap them later.',
		'cred1'          => 'MIT Sloan IDEAS Asia Pacific regional faculty',
		'cred2'          => 'Globis University, Research Faculty',
		'cred3'          => 'Ph.D., Tokyo Institute of Technology',
		'mission_kicker' => 'MISSION',
		'brand'          => 'Kocoro Laboratory',
		'brand_sub'      => 'Kocoro Laboratory, Inc.',
		'section_world'  => 'Mind, society, environment',
		'world_lead'     => 'Inner life, human systems, and the living planet. We treat the three as one piece of work, not as separate fields.',
		'domain1_kicker' => 'Mind',
		'domain1_title'  => 'Treat inner life with science',
		'domain1_body'   => 'The cognitive science of emotion, and the MHQ mental health questionnaire. Inner states without leaving them as vague feeling alone.',
		'domain2_kicker' => 'Society',
		'domain2_title'  => 'Work the space between people and organizations',
		'domain2_body'   => 'Leadership education, HR, and organization building, informed by work as head of HR in pre-IPO and listed companies.',
		'domain3_kicker' => 'Environment',
		'domain3_title'  => 'Connect to a livable future',
		'domain3_body'   => 'Practice also at the edge of society and planet, including MIT Sloan IDEAS Asia Pacific and climate citizenship.',
		'section_work'   => 'Services',
		'work_lead'      => 'We keep this to one page. Updates and brochures go to News & activities.',
		'card1_title'    => 'Leadership education',
		'card1_body'     => 'Teaching and research at GLOBIS University and MIT Sloan IDEAS Asia Pacific, including Theory U.',
		'card2_title'    => 'Mental health (MHQ2)',
		'card2_body'     => 'The current questionnaire is MHQ2. Use it for hiring and development. Details and application are on the landing page.',
		'card3_title'    => 'HR and organization support',
		'card3_body'     => 'HR systems, training, coaching, and research.',
		'work_link'      => 'View services',
		'section_news'   => 'News & activities',
		'news_lead'      => 'Occasional notes: IDEAS brochures, MHQ updates, talks, and public materials. This is not a diary blog.',
		'news_link'      => 'All news',
		'news_empty'     => 'New notes will appear here when they are ready.',
		'section_who'    => 'Founder',
		'who_body'       => 'Kohei Noda, Ph.D., is President of Kocoro Laboratory, Globis University, Research Faculty, and regional faculty for MIT Sloan IDEAS Asia Pacific.',
		'who_hr'         => 'He served as head of human resources at both a pre-IPO growth company and listed operating companies.',
		'who_more'       => 'Profile',
		'section_pub'    => 'Publications',
		'pub_body'       => 'Ongoing work includes the Japanese Cognitive Science Society. In 2025 he published “The cognitive affective model of theory U” in the 42nd Annual Meeting proceedings (pp. 466-469).',
		'pub_intro'      => 'We study emotion, mental health, well-being, and related practice on a cognitive-science base. In recent years this work has drawn on Theory U as a method of practice and systems thinking as a method of inquiry.',
		'pub_link'       => 'Publication list',
		'contact_link'   => 'Contact',
		'company_h2'     => 'About Kocoro Laboratory',
		'company_lead'   => 'Kocoro Laboratory works to mend the split between mind, society, and environment, bridging cognitive science and HR practice.',
		'company_m_h'    => 'Mission',
		'company_m'      => 'Guiding Transformation for Societies and Individuals',
		'company_m_other'=> '社会と個人の変容をガイドする',
		'company_w_h'    => 'Focus',
		'company_p_h'    => 'Founder',
		'overview_h'     => 'Overview',
		'service_h2'     => 'Services',
		'service_lead'   => 'Everything sits on this one page. The MHQ2 landing page, and occasional materials such as IDEAS, are linked from here.',
		'svc1_h'         => 'Leadership development',
		'svc1_b'         => 'Next-generation leadership, organization development, and learning design, including Theory U.',
		'svc2_h'         => 'Mental health questionnaire (MHQ2)',
		'svc2_b'         => 'MHQ2 and EQ assessments for hiring, internal review, and development. MHQ2 is for risk tendencies, not a clinical diagnosis. Details and application stay on the existing landing page.',
		'svc2_link'      => 'Open the MHQ2 landing page',
		'svc3_h'         => 'HR consulting and coaching',
		'svc3_b'         => 'HR systems, training, and coaching, informed by work as head of HR in operating companies.',
		'svc4_h'         => 'Research and statistics',
		'svc4_b'         => 'Cognitive modeling, psychological statistics, and commissioned studies.',
		'profile_h2'     => 'Kohei Noda',
		'profile_role'   => 'Ph.D. / Certified industrial counselor',
		'profile_now'    => 'He is Globis University, Research Faculty, regional faculty for MIT Sloan IDEAS Asia Pacific, and President of Kocoro Laboratory. He also serves as Japan lead for Citizens’ Climate Lobby.',
		'profile_past'   => 'He later served as head of human resources in operating companies, including a pre-IPO growth company and a listed company.',
		'profile_note'   => 'See Publications for research, and News & activities for occasional notes.',
		'label_name'     => 'Name',
		'label_ceo'      => 'President',
		'label_addr'     => 'Address',
		'label_founded'  => 'Established',
		'label_fy'       => 'Fiscal year-end',
		'label_biz'      => 'Activities',
		'label_bank'     => 'Main bank',
		'val_name'       => 'Kocoro Laboratory, Inc.',
		'val_ceo'        => 'Kohei Noda',
		'val_addr'       => '1-12-41 Yokodai, Isogo, Yokohama, Kanagawa 235-0045 Japan',
		'val_founded'    => '1 December 2008',
		'val_fy'         => 'November',
		'val_biz'        => 'Academic research, HR consulting, training and coaching, assessment and statistical analysis',
		'val_bank'       => 'MUFG Bank, Omotesando branch',
	);

	return ( 'en' === $lang ) ? $en : $ja;
}

function kocorolab_refresh_t( $key, $lang = null ) {
	if ( null === $lang ) {
		$lang = function_exists( 'kocorolab_refresh_lang' ) ? kocorolab_refresh_lang() : 'ja';
	}
	$copy = kocorolab_refresh_copy( $lang );
	return isset( $copy[ $key ] ) ? $copy[ $key ] : $key;
}

function kocorolab_refresh_e( $key ) {
	echo esc_html( kocorolab_refresh_t( $key ) );
}

function kocorolab_refresh_page_html( $slug, $lang = 'ja' ) {
	$c = kocorolab_refresh_copy( $lang );

	if ( 'company' === $slug ) {
		return kocorolab_refresh_company_html( $c, $lang );
	}
	if ( 'service' === $slug ) {
		return kocorolab_refresh_service_html( $c, $lang );
	}
	if ( 'member' === $slug || 'koheinoda' === $slug ) {
		return kocorolab_refresh_profile_html( $c, $lang );
	}
	if ( 'hakkou' === $slug || 'publications' === $slug ) {
		return kocorolab_refresh_publications_html( $lang );
	}
	if ( 'contact' === $slug ) {
		return kocorolab_refresh_contact_intro_html( $c, $lang );
	}
	return '';
}

function kocorolab_refresh_company_html( $c, $lang ) {
	$rows = array(
		array( $c['label_name'], $c['val_name'] ),
		array( $c['label_ceo'], $c['val_ceo'] ),
		array( $c['label_addr'], $c['val_addr'] ),
		array( $c['label_founded'], $c['val_founded'] ),
		array( $c['label_fy'], $c['val_fy'] ),
		array( $c['label_biz'], $c['val_biz'] ),
		array( $c['label_bank'], $c['val_bank'] ),
	);

	ob_start();
	?>
	<div class="kl-page">
		<p class="kl-lead"><?php echo esc_html( $c['company_lead'] ); ?></p>
		<h2><?php echo esc_html( $c['company_m_h'] ); ?></h2>
		<p class="kl-lead"><?php echo esc_html( $c['company_m'] ); ?></p>
		<p class="kl-mission-pair"><?php echo esc_html( $c['company_m_other'] ); ?></p>
		<h2><?php echo esc_html( $c['company_w_h'] ); ?></h2>
		<ul class="kl-list">
			<li><strong><?php echo esc_html( $c['domain1_kicker'] ); ?></strong> — <?php echo esc_html( $c['domain1_body'] ); ?></li>
			<li><strong><?php echo esc_html( $c['domain2_kicker'] ); ?></strong> — <?php echo esc_html( $c['domain2_body'] ); ?></li>
			<li><strong><?php echo esc_html( $c['domain3_kicker'] ); ?></strong> — <?php echo esc_html( $c['domain3_body'] ); ?></li>
		</ul>
		<h2><?php echo esc_html( $c['company_p_h'] ); ?></h2>
		<p><?php echo esc_html( $c['who_body'] ); ?></p>
		<p><?php echo esc_html( $c['who_hr'] ); ?></p>
		<h2><?php echo esc_html( $c['overview_h'] ); ?></h2>
		<table class="kl-table">
			<?php foreach ( $rows as $row ) : ?>
				<tr>
					<th><?php echo esc_html( $row[0] ); ?></th>
					<td><?php echo esc_html( $row[1] ); ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
	<?php
	return ob_get_clean();
}

function kocorolab_refresh_service_html( $c, $lang ) {
	ob_start();
	?>
	<div class="kl-page">
		<p class="kl-lead"><?php echo esc_html( $c['service_lead'] ); ?></p>
		<h2><?php echo esc_html( $c['svc1_h'] ); ?></h2>
		<p><?php echo esc_html( $c['svc1_b'] ); ?></p>
		<h2><?php echo esc_html( $c['svc2_h'] ); ?></h2>
		<p><?php echo esc_html( $c['svc2_b'] ); ?></p>
		<p><a class="kl-btn kl-btn-dark" href="<?php echo esc_url( kocorolab_refresh_mhq_lp_url( $lang ) ); ?>"><?php echo esc_html( $c['svc2_link'] ); ?></a></p>
		<h2><?php echo esc_html( $c['svc3_h'] ); ?></h2>
		<p><?php echo esc_html( $c['svc3_b'] ); ?></p>
		<h2><?php echo esc_html( $c['svc4_h'] ); ?></h2>
		<p><?php echo esc_html( $c['svc4_b'] ); ?></p>
		<p><a href="<?php echo esc_url( kocorolab_refresh_url( '/news/', '/news/?lang=en', $lang ) ); ?>"><?php echo esc_html( $c['news_link'] ); ?></a></p>
	</div>
	<?php
	return ob_get_clean();
}

function kocorolab_refresh_profile_html( $c, $lang ) {
	ob_start();
	?>
	<div class="kl-page">
		<p class="kl-kicker"><?php echo esc_html( $c['profile_role'] ); ?></p>
		<p class="kl-lead"><?php echo esc_html( $c['who_body'] ); ?></p>
		<p><?php echo esc_html( $c['profile_now'] ); ?></p>
		<p><?php echo esc_html( $c['profile_past'] ); ?></p>
		<p><?php echo esc_html( $c['profile_note'] ); ?></p>
		<p>
			<a href="<?php echo esc_url( kocorolab_refresh_url( '/hakkou/', '/en/publications/', $lang ) ); ?>"><?php echo esc_html( $c['pub_link'] ); ?></a>
			·
			<a href="<?php echo esc_url( kocorolab_refresh_url( '/news/', '/news/?lang=en', $lang ) ); ?>"><?php echo esc_html( $c['news_link'] ); ?></a>
		</p>
	</div>
	<?php
	return ob_get_clean();
}

function kocorolab_refresh_contact_intro_html( $c, $lang ) {
	$en = ( 'en' === $lang );
	ob_start();
	?>
	<div class="kl-page">
		<p class="kl-lead"><?php echo $en
			? 'For MHQ2, leadership education, HR support, talks, or research, use the form below or email info@kocorolab.com.'
			: 'メンタルヘルス検査（MHQ2）、リーダーシップ教育、人事支援、講演、研究に関するご相談は、下のフォームまたは info@kocorolab.com へ。'; ?></p>
		<p><a href="<?php echo esc_url( kocorolab_refresh_mhq_lp_url( $lang ) ); ?>"><?php echo $en ? 'MHQ2 landing page' : 'MHQ2の案内ページ'; ?></a></p>
	</div>
	<?php
	return ob_get_clean();
}
