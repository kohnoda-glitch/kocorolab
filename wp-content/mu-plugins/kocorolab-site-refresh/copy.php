<?php
/**
 * JA/EN copy for the site refresh. Keep public text professional:
 * current roles + named HR posts, no personal chronology or third-party detail.
 */

function kocorolab_refresh_copy( $lang = 'ja' ) {
	$ja = array(
		'hero_kicker'  => '株式会社ココロラボ',
		'hero_title'   => '社会と個人の変容をガイドする',
		'hero_lead'    => '認知科学の研究と、事業会社での人事実務のあいだで働いています。リーダーシップ教育、メンタルヘルス、組織づくりを、わかりやすい言葉と再現できる方法で支えます。',
		'hero_cta1'    => 'サービス',
		'hero_cta2'    => '発表文献',
		'section_work' => 'いま、できること',
		'card1_title'  => 'リーダーシップ教育',
		'card1_body'   => 'グロービス経営大学院と MIT Sloan IDEAS Asia Pacific での教育・研究を軸に、U理論などを用いた次世代リーダーシップの学びを提供します。',
		'card2_title'  => 'メンタルヘルス（MHQ）',
		'card2_body'   => '学術的知見に基づくメンタルヘルス検査 MHQ を、採用、人材育成、職場の健康管理に使えます。うつリスクなどの傾向把握を目的とした検査です。',
		'card3_title'  => '人事・組織支援',
		'card3_body'   => '人事制度、研修、コーチング、調査研究。事業会社の人事責任者としての経験を踏まえ、現場で使える形に落とします。',
		'section_who'  => '代表について',
		'who_body'     => '野田浩平（学術博士）は、株式会社ココロラボ代表取締役、グロービス経営大学院准教授、MIT Sloan IDEAS Asia Pacific リージョナルファカルティです。専門は感情の認知科学、メンタルヘルス、リーダーシップと組織変革です。',
		'who_hr'       => '人事の実務では、上場前の成長企業と上場後の事業会社の双方で人事責任者を務めてきました。担当した会社はガリバー、イントループ、チェンジです。ここでは個別案件や当時の関係者には触れません。',
		'who_more'     => 'プロフィール',
		'section_pub'  => '研究',
		'pub_body'     => '日本認知科学会をはじめ、感情モデル、幸福、リーダーシップに関する発表を続けています。2025年は「U理論の認知感情モデル」を日本認知科学会第42回大会予稿集に掲載しました。',
		'pub_link'     => '発表文献を見る',
		'contact_link' => '問い合わせる',
		'company_h2'   => 'ココロラボについて',
		'company_lead' => '株式会社ココロラボは、認知科学と人事実務を橋渡しする研究所です。個人の心の状態と、組織・社会のしくみを分けずに考えることを大切にしています。',
		'company_m_h'  => 'ミッション',
		'company_m'    => '社会と個人の変容をガイドする。',
		'company_w_h'  => '活動の柱',
		'company_p_h'  => '代表',
		'overview_h'   => '概要',
		'service_h2'   => 'サービス',
		'service_lead' => '教育、検査、人事支援、研究を、必要に応じて組み合わせて提供します。',
		'svc1_h'       => 'リーダーシップ開発',
		'svc1_b'       => 'U理論などを用いた次世代リーダーシップ開発、組織開発、新規事業に向けた学びの設計と伴走。',
		'svc2_h'       => 'メンタルヘルス検査（MHQ）',
		'svc2_b'       => 'うつリスクなどの傾向を把握するためのオリジナル検査 MHQ、および EQ 検査群。採用、社内確認、人材育成に使えます。診断の確定を目的としたものではありません。',
		'svc3_h'       => '人事コンサルティング・コーチング',
		'svc3_b'       => '人事制度、研修、エグゼクティブ／ビジネスコーチング。事業会社の人事責任者としての実務を踏まえて支援します。',
		'svc4_h'       => '学術研究・統計',
		'svc4_b'       => '認知モデル、心理統計、官公庁・大学・医療機関などとの調査研究。',
		'profile_h2'   => '野田浩平',
		'profile_role' => '学術博士／産業カウンセラー',
		'profile_now'  => '現在は、グロービス経営大学院准教授、MIT Sloan IDEAS Asia Pacific リージョナルファカルティ、株式会社ココロラボ代表取締役として、教育・研究と実務支援を並行しています。市民気候ロビー（CCL）Japan 代表も務めています。',
		'profile_past' => 'これまでに、アンダーセンコンサルティング、PwC、リンクアンドモチベーションなどで人事・組織領域の仕事に携わりました。その後、事業会社の人事責任者として、ガリバー（上場前）、イントループ、チェンジ（上場企業）の人事を担当しました。',
		'profile_note' => '個別のプロジェクトや、当時ご一緒した方々の詳細は公開しません。研究実績は発表文献をご覧ください。',
		'label_name'   => '研究所名',
		'label_ceo'    => '代表取締役',
		'label_addr'   => '所在地',
		'label_founded'=> '設立',
		'label_fy'     => '決算期',
		'label_biz'    => '事業内容',
		'label_bank'   => '取引先銀行',
		'val_name'     => '株式会社ココロラボ　Kocoro Laboratory, Inc.',
		'val_ceo'      => '野田 浩平',
		'val_addr'     => '〒235-0045 神奈川県横浜市磯子区洋光台1-12-41',
		'val_founded'  => '2008年12月1日',
		'val_fy'       => '11月',
		'val_biz'      => '学術研究、人事コンサルティング、研修・コーチング、アセスメント・各種統計分析',
		'val_bank'     => '三菱東京UFJ銀行 表参道支店',
	);

	$en = array(
		'hero_kicker'  => 'Kocoro Laboratory, Inc.',
		'hero_title'   => 'Guiding transformation for societies and individuals',
		'hero_lead'    => 'We work between cognitive science and practical HR. We support leadership education, mental health, and organization building in clear language and usable methods.',
		'hero_cta1'    => 'Services',
		'hero_cta2'    => 'Publications',
		'section_work' => 'What we do',
		'card1_title'  => 'Leadership education',
		'card1_body'   => 'Teaching and research at GLOBIS University and MIT Sloan IDEAS Asia Pacific, including Theory U and related approaches to next-generation leadership.',
		'card2_title'  => 'Mental health (MHQ)',
		'card2_body'   => 'MHQ is a research-informed mental health questionnaire for hiring, development, and workplace health. It is intended to surface risk tendencies, not to replace a clinical diagnosis.',
		'card3_title'  => 'HR and organization support',
		'card3_body'   => 'HR systems, training, coaching, and research. We draw on experience as head of human resources in operating companies.',
		'section_who'  => 'The founder',
		'who_body'     => 'Kohei Noda, Ph.D., is President of Kocoro Laboratory, Associate Professor at GLOBIS University, and Regional Faculty for MIT Sloan IDEAS Asia Pacific. His work covers the cognitive science of emotion, mental health, leadership, and organizational change.',
		'who_hr'       => 'In industry he served as head of human resources at both a pre-IPO growth company and listed operating companies: Gulliver, INTLOOP, and Change. This site does not discuss individual cases or people from those roles.',
		'who_more'     => 'Profile',
		'section_pub'  => 'Research',
		'pub_body'     => 'He continues to publish on emotion models, well-being, and leadership, including at the Japanese Cognitive Science Society. In 2025 he published “The cognitive affective model of theory U” in the proceedings of the 42nd Annual Meeting (pp. 466–469).',
		'pub_link'     => 'View publications',
		'contact_link' => 'Contact',
		'company_h2'   => 'About Kocoro Laboratory',
		'company_lead' => 'Kocoro Laboratory connects cognitive science with HR practice. We treat individual mental life and organizational systems as related, not separate.',
		'company_m_h'  => 'Mission',
		'company_m'    => 'Guiding transformation for societies and individuals.',
		'company_w_h'  => 'Focus',
		'company_p_h'  => 'Founder',
		'overview_h'   => 'Overview',
		'service_h2'   => 'Services',
		'service_lead' => 'Education, assessment, HR support, and research can be combined as needed.',
		'svc1_h'       => 'Leadership development',
		'svc1_b'       => 'Next-generation leadership, organization development, and learning design, including Theory U.',
		'svc2_h'       => 'Mental health questionnaire (MHQ)',
		'svc2_b'       => 'Original MHQ and EQ assessments for hiring, internal review, and development. MHQ is for understanding risk tendencies such as depression risk. It is not a clinical diagnosis.',
		'svc3_h'       => 'HR consulting and coaching',
		'svc3_b'       => 'HR systems, training, and executive or business coaching, informed by work as head of HR in operating companies.',
		'svc4_h'       => 'Research and statistics',
		'svc4_b'       => 'Cognitive modeling, psychological statistics, and commissioned studies with universities, public agencies, and medical institutions.',
		'profile_h2'   => 'Kohei Noda',
		'profile_role' => 'Ph.D. / Certified industrial counselor',
		'profile_now'  => 'He is Associate Professor at GLOBIS University, Regional Faculty for MIT Sloan IDEAS Asia Pacific, and President of Kocoro Laboratory. He also serves as Japan lead for Citizens’ Climate Lobby.',
		'profile_past' => 'Earlier work includes HR and organization roles at Andersen Consulting, PwC, and Link and Motivation. He later served as head of human resources at Gulliver (pre-IPO), INTLOOP, and Change (a listed company).',
		'profile_note' => 'This page does not describe individual projects or colleagues from those roles. Publications are listed separately.',
		'label_name'   => 'Name',
		'label_ceo'    => 'President',
		'label_addr'   => 'Address',
		'label_founded'=> 'Established',
		'label_fy'     => 'Fiscal year-end',
		'label_biz'    => 'Activities',
		'label_bank'   => 'Main bank',
		'val_name'     => 'Kocoro Laboratory, Inc.',
		'val_ceo'      => 'Kohei Noda',
		'val_addr'     => '1-12-41 Yokodai, Isogo, Yokohama, Kanagawa 235-0045 Japan',
		'val_founded'  => '1 December 2008',
		'val_fy'       => 'November',
		'val_biz'      => 'Academic research, HR consulting, training and coaching, assessment and statistical analysis',
		'val_bank'     => 'MUFG Bank, Omotesando branch',
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
		<p><?php echo esc_html( $c['company_m'] ); ?></p>
		<h2><?php echo esc_html( $c['company_w_h'] ); ?></h2>
		<ul class="kl-list">
			<li><strong><?php echo esc_html( $c['card1_title'] ); ?></strong> — <?php echo esc_html( $c['card1_body'] ); ?></li>
			<li><strong><?php echo esc_html( $c['card2_title'] ); ?></strong> — <?php echo esc_html( $c['card2_body'] ); ?></li>
			<li><strong><?php echo esc_html( $c['card3_title'] ); ?></strong> — <?php echo esc_html( $c['card3_body'] ); ?></li>
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
		<h2><?php echo esc_html( $c['svc3_h'] ); ?></h2>
		<p><?php echo esc_html( $c['svc3_b'] ); ?></p>
		<h2><?php echo esc_html( $c['svc4_h'] ); ?></h2>
		<p><?php echo esc_html( $c['svc4_b'] ); ?></p>
	</div>
	<?php
	return ob_get_clean();
}

function kocorolab_refresh_profile_html( $c, $lang ) {
	$pub = ( 'en' === $lang ) ? '/en/publications/' : '/hakkou/';
	ob_start();
	?>
	<div class="kl-page">
		<p class="kl-kicker"><?php echo esc_html( $c['profile_role'] ); ?></p>
		<p class="kl-lead"><?php echo esc_html( $c['who_body'] ); ?></p>
		<p><?php echo esc_html( $c['profile_now'] ); ?></p>
		<p><?php echo esc_html( $c['profile_past'] ); ?></p>
		<p><?php echo esc_html( $c['profile_note'] ); ?></p>
		<p><a href="<?php echo esc_url( function_exists( 'home_url' ) ? home_url( $pub ) : $pub ); ?>"><?php echo esc_html( $c['pub_link'] ); ?></a></p>
	</div>
	<?php
	return ob_get_clean();
}
