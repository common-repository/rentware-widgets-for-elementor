<?php

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

class Rentware_Article_Booking extends \Elementor\Widget_Base
{

  public function get_name()
  {
    return 'rtrElementorAddon_article_booking';
  }

  public function get_title()
  {
    return esc_html__('Rentware Article Booking', 'rentware-addon-for-elementor');
  }

  public function get_icon()
  {
    return 'eicon-calendar';
  }

  public function get_categories()
  {
    return ['rentware'];
  }

  public function get_keywords()
  {
    return ['rentware', 'article', 'booking', 'reservation', 'availability', 'calendar'];
  }

  protected function register_controls()
  {

    // Parameters Tab Start

    $this->start_controls_section(
      'settings_section',
      [
        'label' => esc_html__('Parameters', 'rentware-addon-for-elementor'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'article_id',
      [
        'label' => esc_html__('Article ID', 'rentware-addon-for-elementor'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'description' => esc_html__('Enter the article ID of the article you want to display. You can find the article ID in the Rentware backend under https://app.rentware.io/inventory column "reference".', 'rentware-addon-for-elementor'),
        'placeholder' => 'EA9X5A',
        'ai' => false,
        'dynamic' => [
          'active' => true,
        ],
      ]
    );

    $this->add_control(
      'view',
      [
        'label' => esc_html__('View', 'rentware-addon-for-elementor'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'default',
        'options' => [
          'default' => esc_html__('Compressed', 'rentware-addon-for-elementor'),
          'calendar' => esc_html__('Calendar', 'rentware-addon-for-elementor'),
          'slots' => esc_html__('Slots', 'rentware-addon-for-elementor'),
        ],
      ]
    );

    $this->end_controls_section();

    // Parameters Tab End

  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();

    if (empty($settings['article_id'])) {
      return;
    }
?>
    <rtr-article-booking article-id="<?php echo esc_attr($settings['article_id']); ?>" view="<?php echo esc_attr($settings['view']); ?>"></rtr-article-booking>

  <?php
  }

  protected function _content_template()
  {
  ?>
    <# if (settings.article_id) { #>
      <rtr-article-booking article-id="{{ settings.article_id }}" view="{{ settings.view }}"></rtr-article-booking>
      <# } else { #>
        <div class="elementor-alert elementor-alert-warning">
          <?php esc_html_e('Please enter a valid article ID.', 'rentware-addon-for-elementor'); ?>
        </div>
        <rtr-article-booking article-id="{{ settings.article_id }}" view="{{ settings.view }}"></rtr-article-booking>
        <# } #>
      <?php

    }
  }
