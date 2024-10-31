<?php

/**
 * Rentware options page
 */

defined('ABSPATH') || exit;

/**
 * Rentware options page class.
 */
class Rentware_Options_Page
{

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		add_action('admin_init', array($this, 'register_settings'));

		add_action('admin_menu', array($this, 'add_options_page'));
		add_action('admin_enqueue_scripts', array($this, 'enqueue_options_page_scripts'));
	}

	/**
	 * Add options page.
	 *
	 * @return void
	 */
	public function add_options_page()
	{
		add_options_page(
			__('Rentware', 'rentware-addon-for-elementor'),
			__('Rentware', 'rentware-addon-for-elementor'),
			'manage_options',
			'rentware-options',
			array($this, 'render_options_page'),
		);
	}

	/**
	 * Enqueue options page scripts.
	 *
	 * @return void
	 */
	public function enqueue_options_page_scripts()
	{
		wp_enqueue_style(
			'rentware-options-page',
			$this->get_assets_dir_url() . 'css/options-page.css',
			[],
			time()
		);
	}

	/**
	 * Get assets directory URL.
	 *
	 * @return string
	 */
	private function get_assets_dir_url()
	{
		return plugin_dir_url(__FILE__) . 'assets/';
	}

	/**
	 * Render options page.
	 *
	 * @return void
	 */
	public function render_options_page()
	{
?>
		<div class="wrap rw-options-page">
			<header class="card rw-options-page__header">
				<img src="<?php echo esc_url($this->get_assets_dir_url() . 'images/logo.svg'); ?>" alt="<?php esc_html_e('Rentware logo', 'rentware-addon-for-elementor'); ?>" height="56">
				<a href="https://rentware.com/en/contact/?utm_source=wordpress-plugin&utm_medium=link&utm_campaign=custom-campaign" class="button">
					<?php esc_html_e('Help', 'rentware-addon-for-elementor'); ?>
				</a>
			</header>
			<form method="post" action="options.php" class="card rw-options-page__form">
				<?php settings_fields('rentware'); ?>
				<h2><?php esc_html_e('1. Connect to your Rentware account', 'rentware-addon-for-elementor'); ?></h2>
				<p>
					<?php esc_html_e('Don\'t have a Rentware account?', 'rentware-addon-for-elementor'); ?>
					<a href="https://rentware.com/en/free-trial/?utm_source=wordpress-plugin&utm_medium=link&utm_campaign=custom-campaign">
						<?php esc_html_e('Start your free trial here.', 'rentware-addon-for-elementor'); ?>
					</a>
				</p>
				<div class="rw-options-page__form__inner">
					<label class="rw-options-page__label">
						<?php esc_html_e('Access Token', 'rentware-addon-for-elementor'); ?>
					</label>
					<div>
						<input type="text" name="rtrElementorAddon_access_token" value="<?php echo esc_attr(get_option('rtrElementorAddon_access_token')); ?>" class="rw-options-page__input" aria-label="<?php esc_html_e('Access token', 'rentware-addon-for-elementor'); ?>">
						<p>
							<?php esc_html_e('Find your Access Token in your Rentware account under shop > widgets', 'rentware-addon-for-elementor'); ?>
						</p>
					</div>
				</div>
				<?php submit_button(__('Update Options', 'rentware-addon-for-elementor'), 'primary', 'submit', false); ?>
			</form>
			<div class="card rw-options-page__info">
				<div>
					<h2><?php esc_html_e('2. Add your products', 'rentware-addon-for-elementor'); ?></h2>
					<p><?php esc_html_e('To get started, simply use the elementor elements under Rentware.', 'rentware-addon-for-elementor'); ?></p>
					<p><?php esc_html_e('Make sure to have exactly one Rentware Checkout element on each Page where you want to use booking widgets and integration of the checkout.', 'rentware-addon-for-elementor'); ?></p>
					<p><?php esc_html_e('For each booking widget you can set different settings like the item id you want to connect or change the view.', 'rentware-addon-for-elementor'); ?></p>
					<img src="<?php echo esc_url($this->get_assets_dir_url() . 'images/preview-1.png'); ?>" alt="<?php esc_html_e('Screenshot of Elementor sidebar', 'rentware-addon-for-elementor'); ?>">
				</div>
				<img src="<?php echo esc_url($this->get_assets_dir_url() . 'images/preview-2.png'); ?>" alt="<?php esc_html_e('Screenshot of Elementor sidebar', 'rentware-addon-for-elementor'); ?>">
			</div>
		</div>
<?php
	}

	/**
	 * Register settings.
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	public function register_settings()
	{
		register_setting('rentware', 'rtrElementorAddon_access_token');
		add_settings_field('rtrElementorAddon_access_token', __('Access token', 'rentware-addon-for-elementor'), '__return_false', 'rentware-options');
	}
}
