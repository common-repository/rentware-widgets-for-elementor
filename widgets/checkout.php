<?php

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

class Rentware_Checkout extends \Elementor\Widget_Base
{

  public function get_script_depends()
  {
    return ['rtr-io.com'];
  }

  public function get_name()
  {
    return 'rtrElementorAddon_checkout';
  }

  public function get_title()
  {
    return esc_html__('Rentware Checkout', 'rentware-addon-for-elementor');
  }

  public function get_icon()
  {
    return 'eicon-cart-medium';
  }

  public function get_categories()
  {
    return ['rentware'];
  }

  public function get_keywords()
  {
    return ['rentware', 'checkout'];
  }

  protected function register_controls()
  {

    // Settings Tab Start

    $description = esc_html__('We recommend to set the access token in the WordPress "Settings" -> "Rentware" page. You can find the access token in the rentware backend. However, if you want to integrate more than one Rentware account into one Site you can override the access token for each page individually here', 'rentware-addon-for-elementor');
    if ((get_option('rtrElementorAddon_access_token'))) {
      $description = esc_html__('You already set an access token in the WordPress "Settings" -> "Rentware" page. If you want to integrate more than one Rentware account into one Site you can override the access token for each page individually here', 'rentware-addon-for-elementor');
    };
    $locale = get_locale();
    $locale = str_replace('_', '-', $locale);

    $this->start_controls_section(
      'section_title',
      [
        'label' => esc_html__('Settings', 'rentware-addon-for-elementor'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'global_access_token',
      [
        'label' => esc_html__(
          'Global Access Token',
          'rentware-addon-for-elementor'
        ),
        'label_block' => true,
        'type' => \Elementor\Controls_Manager::HIDDEN,
        'default' => get_option('rtrElementorAddon_access_token'),
        'placeholder' => esc_html__('W13573b675870ceec4d127c520ce42e2d', 'rentware-addon-for-elementor'),
        'ai' => false,
      ]
    );

    $this->add_control(
      'override_global_settings',
      [
        'label' => esc_html__('Override Global Settings', 'rentware-addon-for-elementor'),
        'description' => $description,
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'rentware-addon-for-elementor'),
        'label_off' => esc_html__('No', 'rentware-addon-for-elementor'),
        'return_value' => 'yes',
        'default' => 'no',
      ]
    );

    $this->add_control(
      'access_token_per_page',
      [
        'label' => esc_html__(
          'Access Token (Override)',
          'rentware-addon-for-elementor'
        ),
        'label_block' => true,
        'description' => esc_html__('Override the access token for this page.', 'rentware-addon-for-elementor'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'dynamic' => [
          'active' => true,
        ],
        'ai' => false,
        'condition' => [
          'override_global_settings' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'locale_per_page',
      [
        'label' => esc_html__('Language', 'rentware-addon-for-elementor'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'placeholder' => esc_html__('de-DE', 'rentware-addon-for-elementor'),
        'default' => $locale,
        'dynamic' => [
          'active' => true,
        ],
        'ai' => false,
        'condition' => [
          'override_global_settings' => 'yes',
        ],
      ]
    );

    $this->end_controls_section();

    // Settings Tab End

  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();
    $access_token = !empty($settings['access_token_per_page']) ? $settings['access_token_per_page'] : get_option('rtrElementorAddon_access_token');
    $locale = !empty($settings['locale']) ? $settings['locale'] : get_locale();

    if (empty($access_token)) {
      return;
    }
?>
    <script>
      window.RTR_ACCESS_TOKEN = '<?php echo esc_html($access_token); ?>'
      window.RTR_LOCALE = '<?php echo esc_html($locale); ?>'
    </script>
    <rtr-checkout></rtr-checkout>

  <?php
  }

  protected function _content_template()
  {
  ?>
    <# if (settings.access_token_per_page || settings.global_access_token) { #>
      <rtr-checkout></rtr-checkout>
      <# } else { #>
        <div class="elementor-alert elementor-alert-warning">
          <?php esc_html_e('Please enter an access token in the settings.', 'rentware-addon-for-elementor'); ?>
        </div>
        <# } #>
          <script>
            window.RTR_ACCESS_TOKEN = '{{{ settings.access_token_per_page }}}'
          </script>
          <# if (settings.locale_per_page) { #>
            <script>
              window.RTR_LOCALE = '{{{ settings.locale_per_page }}}'
            </script>
            <# } else { #>
              <script>
                window.RTR_LOCALE = '<?php echo esc_html(get_locale()); ?>'
              </script>
              <# } #>
            <?php

          }
        }
