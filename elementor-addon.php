<?php

/**
 * Plugin Name: Rentware Widgets for Elementor
 * Description: Integrate Rentware seamlessly into your Elementor-powered WordPress site with our Rentware Elementor Addon. Effortlessly create and manage rental listings, booking forms, and availability calendars directly within the Elementor Page Builder.
 * Version:     1.0.3
 * Author:      Rentware.com
 * Author URI:  https://rentware.com/
 * Plugin URI:  https://rentware.com/integrationen/wordpress-elementor-plugin/
 * Text Domain: rentware-addon-for-elementor
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

require_once __DIR__ . '/class-rentware-options-page.php';
new Rentware_Options_Page();

function rtrElementorAddon_register_rtr_for_elementor_widget($widgets_manager)
{

	require_once(__DIR__ . '/widgets/checkout.php');
	require_once(__DIR__ . '/widgets/search.php');
	require_once(__DIR__ . '/widgets/article-booking.php');
	require_once(__DIR__ . '/widgets/article-details.php');

	$widgets_manager->register(new \Rentware_Checkout());
	$widgets_manager->register(new \Rentware_Search());
	$widgets_manager->register(new \Rentware_Article_Booking());
	$widgets_manager->register(new \Rentware_Article_Details());
}
add_action('elementor/widgets/register', 'rtrElementorAddon_register_rtr_for_elementor_widget');

/**
 * Add Rentware as a new category in the Elementor editor after the Basic category.
 */

function rtrElementorAddon_add_elementor_widget_categories($elements_manager)
{

	$categories = [];
	$old_categories = $elements_manager->get_categories();

	foreach ($old_categories as $key => $category) {
		$categories[$key] = $category;
		if ($key == 'basic') {
			$categories['rentware'] =
				[
					'title' => esc_html__('Rentware', 'rentware-addon-for-elementor'),
					'icon' => 'fa fa-plug',
				];
		}
	}

	$set_categories = function ($categories) {
		$this->categories = $categories;
	};

	$set_categories->call($elements_manager, $categories);
}

add_action('elementor/elements/categories_registered', 'rtrElementorAddon_add_elementor_widget_categories');



/**
 * Register Rentware script as module. (wp_register_script_module available since WordPress 6.5)
 * <script
 *  type="module"
 *  src="https://cdn.rtr-io.com/widgets.js"
 * ></script>
 */
function rtrElementorAddon_rtr_widgets_dependencies()
{
	wp_register_script_module(
		'rtr-io.com',
		'https://cdn.rtr-io.com/widgets.js',
	);

	wp_enqueue_script_module('rtr-io.com');
}

add_action('wp_enqueue_scripts', 'rtrElementorAddon_rtr_widgets_dependencies');

/**
 * Add actions links in the plugin list.
 *
 * @param array $actions Actions.
 * @return array
 */
function rtrElementorAddon_add_action_links($actions)
{
	$actions[] = sprintf(
		'<a href="%s">%s</a>',
		menu_page_url('rentware-options', false),
		__('Settings', 'rentware-addon-for-elementor')
	);

	return $actions;
}

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'rtrElementorAddon_add_action_links');

/**
 * Show an admin notice when the access token is missing.
 *
 * @return void
 */
function rtrElementorAddon_show_missing_access_token_notice()
{
	$screen = get_current_screen();

	// If an access token is set, or we are on the options page, don't show the notice.
	if (get_option('rtrElementorAddon_access_token') || 'settings_page_rentware-options' === $screen->id) {
		return;
	}

?>
	<div class="notice notice-error">
		<h3><?php esc_html_e('Rentware - Setup Required', 'rentware-addon-for-elementor'); ?></h3>
		<p>
			<?php
			echo sprintf(
				/* translators: %s: URL to the plugin settings page. */
				wp_kses(__('<b>Rentware</b> needs to be set up. In order to do so, head over to the <a href="%s" title="Go To Plugin Settings">Plugin Settings</a>', 'rentware-addon-for-elementor'), array('a' => array('href' => array(), 'title' => array()), 'b' => array())),
				esc_url(menu_page_url('rentware-options', false))
			);
			?>
		</p>
	</div>
<?php
}

add_action('admin_notices', 'rtrElementorAddon_show_missing_access_token_notice');
