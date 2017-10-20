<?php
/*
-------------------------------------------------------------------------------
Front-end scripts and styles
-------------------------------------------------------------------------------
*/
add_action( 'wp_enqueue_scripts', function() {

	dwig()->addStyle( '_dex-styles', array(
		'src'     => _DEX_URI . 'assets/css/styles.css',
		'enqueue' => false,
	));

	dwig()->addScript( '_dex-config', array(
		'src'     => _DEX_URI . 'assets/js/config.js',
		'deps'    => array( 'jquery' ),
		'enqueue' => false,
	));

});

/*
-------------------------------------------------------------------------------
Back-end scripts and styles
-------------------------------------------------------------------------------
*/
add_action( 'admin_enqueue_scripts', function() {

	dwig()->addStyle( '_dex-styles-admin', array(
		'src'     => _DEX_URI . 'assets/css/styles-admin.css',
		'enqueue' => false,
	));

	dwig()->addScript( '_dex-config-admin', array(
		'src'     => _DEX_URI . 'assets/js/config-admin.js',
		'deps'    => array( 'jquery' ),
		'enqueue' => false,
	));

});
