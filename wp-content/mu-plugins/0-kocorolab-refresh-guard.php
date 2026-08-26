<?php
/**
 * Plugin Name: Kocoro Lab — keep overlay templates out of mu-plugins root
 * Description: If the refresh ZIP is flattened into mu-plugins/, WordPress loads archive-news.php before the overlay and the whole site 500s. Remove those stray copies.
 * Version: 1.6.29
 * Author: Kohei Noda
 */

function kocorolab_refresh_stray_mu_plugin_files() {
	return array(
		'archive-news.php',
		'single-news.php',
		'front-page.php',
		'copy.php',
		'chrome.php',
		'links.php',
		'publications.php',
		'wp-view.php',
		'refresh.css',
		'preview-en.html',
		'preview-ja.html',
		'hero-horizon.jpg',
		'spirit-sky.jpg',
		'society-green.jpg',
		'environment-ocean.jpg',
		'tokyo-tech-job-guidance-2011.pdf',
	);
}

function kocorolab_refresh_remove_stray_mu_plugins( $mu_dir ) {
	$removed = array();
	$mu_dir  = rtrim( (string) $mu_dir, '/\\' );
	foreach ( kocorolab_refresh_stray_mu_plugin_files() as $file ) {
		$path = $mu_dir . '/' . $file;
		if ( ! is_file( $path ) || ! is_readable( $path ) ) {
			continue;
		}
		if ( substr( $file, -4 ) === '.php' ) {
			$src = file_get_contents( $path );
			if ( ! is_string( $src ) || false === strpos( $src, 'kocorolab_refresh_' ) ) {
				continue;
			}
		}
		if ( @unlink( $path ) ) {
			$removed[] = $file;
		}
	}
	return $removed;
}

if ( is_dir( __DIR__ . '/kocorolab-site-refresh' ) ) {
	kocorolab_refresh_remove_stray_mu_plugins( __DIR__ );
}
