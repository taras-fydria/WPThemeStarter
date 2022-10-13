<?php

namespace SleepyOwl;

use SleepyOwl\Includes\AddAssets;

function my_custom_autoloader( $class_name ): void {

	$class_name = str_replace( __NAMESPACE__, '', $class_name );
	$class_name = ltrim( $class_name, '\\' );
	$path       = explode( '\\', $class_name );

	foreach ( $path as $key => $path_item ) {

		if ( $key + 1 < count( $path ) ) {
			$path[ $key ] = strtolower( $path_item );
		} else {
			$path[ $key ] = "{$path_item}.php";
		}
	}
	$class_name = implode( DIRECTORY_SEPARATOR, $path );
	$file       = __DIR__ . DIRECTORY_SEPARATOR . $class_name;

	if ( file_exists( $file ) ) {
		require_once $file;
	}
}

// add a new autoloader by passing a callable into spl_autoload_register()
spl_autoload_register( 'SleepyOwl\my_custom_autoloader' );

AddAssets::get_instance();
