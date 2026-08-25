<?php
/**
 * Shared header/footer chrome for the wide landing layout.
 */

if ( ! function_exists( 'kocorolab_refresh_publications_url' ) ) {
	function kocorolab_refresh_publications_url( $lang = null ) {
		return kocorolab_refresh_url( '/publications/', '/en/publications/', $lang );
	}
}

function kocorolab_refresh_nav_key() {
	if ( isset( $GLOBALS['KOCORO_PREVIEW_PAGE'] ) ) {
		return $GLOBALS['KOCORO_PREVIEW_PAGE'];
	}
	if ( function_exists( 'is_front_page' ) && is_front_page() ) {
		return 'home';
	}
	if ( function_exists( 'is_page' ) ) {
		if ( is_page( 'service' ) ) {
			return 'service';
		}
		if ( is_page( array( 'member', 'koheinoda' ) ) ) {
			return 'member';
		}
		if ( is_page( array( 'hakkou', 'publications' ) ) ) {
			return 'publications';
		}
		if ( is_page( 'company' ) ) {
			return 'company';
		}
		if ( is_page( 'contact' ) ) {
			return 'contact';
		}
	}
	if ( function_exists( 'is_post_type_archive' ) && is_post_type_archive( 'news' ) ) {
		return 'news';
	}
	return '';
}

function kocorolab_refresh_lang_switch_url() {
	if ( function_exists( 'kocorolab_preview_lang_href' ) ) {
		return kocorolab_preview_lang_href();
	}
	$root = kocorolab_refresh_root();
	return ( 'en' === kocorolab_refresh_lang() ) ? $root . '/' : $root . '/en/';
}

function kocorolab_refresh_site_header() {
	if ( ! empty( $GLOBALS['KOCORO_HEADER_DONE'] ) ) {
		return;
	}
	$GLOBALS['KOCORO_HEADER_DONE'] = true;
	$en      = ( 'en' === kocorolab_refresh_lang() );
	$current = kocorolab_refresh_nav_key();
	$items   = $en
		? array(
			array( 'home', 'Home', kocorolab_refresh_url( '/', '/en/' ) ),
			array( 'service', 'Services', kocorolab_refresh_url( '/service/', '/en/service/' ) ),
			array( 'news', 'Updates', kocorolab_refresh_url( '/news/', '/news/?lang=en' ) ),
			array( 'publications', 'Publications', kocorolab_refresh_publications_url() ),
			array( 'member', 'Profile', kocorolab_refresh_url( '/member/', '/en/member/' ) ),
			array( 'company', 'Company', kocorolab_refresh_url( '/company/', '/en/company/' ) ),
		)
		: array(
			array( 'home', 'ホーム', kocorolab_refresh_url( '/', '/' ) ),
			array( 'service', 'サービス', kocorolab_refresh_url( '/service/', '/service/' ) ),
			array( 'news', '活動・新着', kocorolab_refresh_url( '/news/', '/news/' ) ),
			array( 'publications', '発表文献', kocorolab_refresh_publications_url() ),
			array( 'member', 'プロフィール', kocorolab_refresh_url( '/member/', '/member/' ) ),
			array( 'company', '会社概要', kocorolab_refresh_url( '/company/', '/company/' ) ),
		);
	$home = $en ? kocorolab_refresh_url( '/', '/en/' ) : kocorolab_refresh_url( '/', '/' );
	$contact = kocorolab_refresh_url( '/contact/', '/en/contact/' );
	?>
<header class="kl-topbar">
	<a class="kl-brand" href="<?php echo esc_url( $home ); ?>">
		<span class="kl-mark" aria-hidden="true">K</span>
		<span class="kl-brand-text">
			<strong><?php echo esc_html( kocorolab_refresh_t( 'brand' ) ); ?></strong>
			<small><?php echo esc_html( kocorolab_refresh_t( 'brand_sub' ) ); ?></small>
		</span>
	</a>
	<nav class="kl-topnav" aria-label="<?php echo $en ? 'Primary' : 'メイン'; ?>">
		<?php foreach ( $items as $item ) : ?>
			<a href="<?php echo esc_url( $item[2] ); ?>"<?php echo ( $current === $item[0] ) ? ' class="is-current"' : ''; ?>><?php echo esc_html( $item[1] ); ?></a>
		<?php endforeach; ?>
	</nav>
	<div class="kl-top-actions">
		<a class="kl-lang" href="<?php echo esc_url( kocorolab_refresh_lang_switch_url() ); ?>"><?php echo $en ? '日本語' : 'English'; ?></a>
		<a class="kl-cta" href="<?php echo esc_url( $contact ); ?>"><?php echo esc_html( kocorolab_refresh_t( 'contact_link' ) ); ?></a>
	</div>
</header>
	<?php
}

function kocorolab_refresh_site_footer() {
	if ( ! empty( $GLOBALS['KOCORO_FOOTER_DONE'] ) ) {
		return;
	}
	$GLOBALS['KOCORO_FOOTER_DONE'] = true;
	$en = ( 'en' === kocorolab_refresh_lang() );
	?>
<footer class="kl-sitefoot">
	<p><?php echo $en ? 'A laboratory for mind, society, and environment.' : '精神・社会・環境を扱う小さな研究所。'; ?></p>
	<p>© 株式会社ココロラボ / Kocoro Laboratory, Inc.</p>
</footer>
	<?php
}
