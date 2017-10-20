<?php

class _Dex_Warning {

	protected $page_slug = '_dex_warning';

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'style' ), 999 );
	}

	public function getPluginData( $key ) {
		if ( function_exists( 'get_plugin_data' ) ) {
			$data = get_plugin_data( _DEX_PLUGIN_FILE, false, false );
			return $data[ $key ];
		}

		return false;
	}

	public function renderNotice() {
		$plugin_name = $this->getPluginData( 'Name' );
		$title = ! empty( $plugin_name ) ? $plugin_name : '';

		if ( ! file_exists( plugin_dir_path( __DIR__ ) . 'dwig/dwig.php' ) ) {
			$notice = $this->pluginNotInstalled();
		}
		else {
			$notice = $this->pluginNotActivated();
		}

		echo sprintf( '<div class="page-warning-notice">
			<h1>' . esc_html( $title ) . '</h1>
			%s
			</div>
		', $notice );
	}

	public function register() {
		$plugin_name = esc_html( $this->getPluginData( 'Name' ) );
		$title = ! empty( $plugin_name ) ? $plugin_name : 'DWIG Extension';

		add_menu_page(
			$title,
			$title,
			'manage_options',
			$this->page_slug,
			array( $this, 'renderNotice' ),
			'dashicons-warning',
			60
		);
	}

	public function pluginNotInstalled() {
		return '
			<p>
				This plugin is an extension for another plugin called DWIG. We noticed that you have not installed it yet. In order to be able to use this extension you must install and activate the main plugin first.
			</p>
			<p>
				<a href="http://downloads.wordpress.org/plugin/dwig.latest-stable.zip" class="related-info-button">Download DWIG</a>
				<a href="https://dwig.pro/" target="_blank" class="related-info-button">Official plugin page</a>
				<a href="https://wordpress.org/plugins/dwig" target="_blank" class="related-info-button">DWIG on WordPress.org</a>
			</p>
		';
	}

	public function pluginNotActivated() {
		$activation_url = add_query_arg(
			array(
				'activate_dwig_plugin' => 1,
				'activation_nonce'     => wp_create_nonce( 'activate_dwig_plugin' ),
			),
			admin_url( 'plugins.php' )
		);

		return '
			<p>
				This plugin is an extension for another plugin called DWIG. We detected it on your system as being installed but not activated. In order to be able to use this extension you must activate it first. Go to plugins page or use the following button to activate it.
			</p>
			<p>
				<a href="' . esc_url_raw( $activation_url ) . '" class="related-info-button">Activate DWIG</a>
			</p>
		';
	}

	public function style() {
		if ( is_admin() && isset( $_GET['page'] ) && sanitize_key( $_GET['page'] ) === $this->page_slug ) {
			echo PHP_EOL . '<style>
			#wpcontent,
			.auto-fold #wpcontent {
				padding: 20px!important;
			}
			.page-warning-notice{
				display: block;
				position: relative;
				max-width: 600px;
				margin: 50px auto;
				padding: 50px 80px;
				border-radius: 7px;
				background: #fff;
				border: 0;
				text-align: center;
			}
			.page-warning-notice p{
				font-size: 18px;
				color: #444;
				margin-bottom: 30px;
			}
			.page-warning-notice h3{
				margin-top: 30px;
				font-size: 18px;
			}
			.page-warning-notice h2{
				font-size: 22px;
				margin-bottom: 20px;
			}
			.page-warning-notice h1{
				font-size: 26px;
				margin-top: 20px;
			}

			.page-warning-notice h2,
			.page-warning-notice h1{
				line-height: 1.1;
				margin: 10px 0;
			}

			.page-warning-notice .related-info-button{
				display: inline-block;
				margin: 5px;
				font-size: 14px;
				padding: 7px 14px;
				border: 1px solid #3498DB;
				color: #3498DB;
				border-radius: 3px;
				text-decoration: none;
				transition: all 0.2s;
			}
			.page-warning-notice .related-info-button:hover{
				border-color: transparent;
				color: #fff;
				background: #3498DB;
			}

			@media screen and ( max-width: 500px ){
				.page-warning-notice{
					margin: 30px 10px;
					padding: 25px;
				}
			}

			</style>' . PHP_EOL;
		}
	}

}

new _Dex_Warning();
