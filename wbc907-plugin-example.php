<?php
/*
Plugin Name: WBC907 Plugin Example
Plugin URI: https://wordpress.org/plugins/health-check/
Description: Example plugin for Reduxframework extensions loading
Version: 1.0
Author: Webcreations907
Author URI: http://webcreations907.com
*/

// Set your ReduxFrameWork Option name below //
$redux_opt_name = "redux_demo";

if ( !function_exists( 'wbc907_example_extension_loader' ) ) {
	function wbc907_example_extension_loader( $ReduxFramework ) {
		$path    = dirname( __FILE__ ) . '/extensions/';
		$folders = scandir( $path, 1 );
		foreach ( $folders as $folder ) {
			if ( $folder === '.' or $folder === '..' or ! is_dir( $path . $folder ) ) {
				continue;
			}
			$extension_class = 'ReduxFramework_Extension_' . $folder;
			if ( ! class_exists( $extension_class ) ) {
				// In case you wanted override your override, hah.
				$class_file = $path . $folder . '/extension_' . $folder . '.php';
				$class_file = apply_filters( 'redux/extension/' . $ReduxFramework->args['opt_name'] . '/' . $folder, $class_file );
				if ( $class_file ) {
					require_once $class_file;
				}
			}
			if ( ! isset( $ReduxFramework->extensions[ $folder ] ) ) {
				$ReduxFramework->extensions[ $folder ] = new $extension_class( $ReduxFramework );
			}
		}
	}
	// Modify {$redux_opt_name} to match your opt_name
	add_action( "redux/extensions/{$redux_opt_name}/before", 'wbc907_example_extension_loader', 0 );
}
?>
