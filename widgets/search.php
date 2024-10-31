<?php

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

class Rentware_Search extends \Elementor\Widget_Base
{

  public function get_name()
  {
    return 'rtrElementorAddon_search';
  }

  public function get_title()
  {
    return esc_html__('Rentware Search', 'rentware-addon-for-elementor');
  }

  public function get_icon()
  {
    return 'eicon-site-search';
  }

  public function get_categories()
  {
    return ['rentware'];
  }

  public function get_keywords()
  {
    return ['rentware', 'checkout', 'search'];
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
      'show_location',
      [
        'label' => esc_html__('Show location filter', 'rentware-addon-for-elementor'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Show', 'rentware-addon-for-elementor'),
        'label_off' => esc_html__('Hide', 'rentware-addon-for-elementor'),
        'return_value' => 'on',
        'default' => 'on',
      ]
    );

    $this->add_control(
      'locations',
      [
        'label' => esc_html__('Locations', 'rentware-addon-for-elementor'),
        'label_block' => true,
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => '',
        'description' => esc_html__('Enter location IDs separated by comma', 'rentware-addon-for-elementor'),
        'ai' => false,
        'dynamic' => [
          'active' => true,
        ],
      ]
    );

    $this->end_controls_section();

    // Parameters Tab End

    // Results Tab Start

    $this->start_controls_section(
      'results_section',
      [
        'label' => esc_html__('Results', 'rentware-addon-for-elementor'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'view',
      [
        'label' => esc_html__('View', 'rentware-addon-for-elementor'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'default',
        'options' => [
          'default'  => esc_html__('List', 'rentware-addon-for-elementor'),
          'slots' => esc_html__('Slots', 'rentware-addon-for-elementor'),
          'cards' => esc_html__('Cards', 'rentware-addon-for-elementor'),
        ],
      ]
    );

    $this->add_control(
      'show_only_tags',
      [
        'label' => esc_html__('Show only articles with tags', 'rentware-addon-for-elementor'),
        'label_block' => true,
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => '',
        'description' => esc_html__('Enter tags separated by comma', 'rentware-addon-for-elementor'),
        'ai' => false,
      ]
    );

    $this->add_control(
      'search_results',
      [
        'label' => esc_html__('Behavior', 'rentware-addon-for-elementor'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'extended',
        'options' => [
          'extended'  => esc_html__('Extended', 'rentware-addon-for-elementor'),
          'collapsed' => esc_html__('Collapsed', 'rentware-addon-for-elementor'),
          'link-to' => esc_html__('Link to', 'rentware-addon-for-elementor'),
        ],
      ]
    );

    $this->add_control(
      'link_to',
      [
        'label' => esc_html__('Link to', 'rentware-addon-for-elementor'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => '',
        'description' => esc_html__('Enter URL', 'rentware-addon-for-elementor'),
        'condition' => [
          'search_results' => 'link-to',
        ],
      ]
    );

    $this->add_control(
      'results_on_scroll',
      [
        'label' => esc_html__('Load', 'rentware-addon-for-elementor'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => '5',
        'description' => esc_html__('Enter number of results to load on scroll', 'rentware-addon-for-elementor'),
      ]
    );

    $this->add_control(
      'hide_results',
      [
        'label' => esc_html__('Hide results on start', 'rentware-addon-for-elementor'),
        'description' => esc_html__('Only show results when user entered dates', 'rentware-addon-for-elementor'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'rentware-addon-for-elementor'),
        'label_off' => esc_html__('No', 'rentware-addon-for-elementor'),
        'return_value' => 'true',
        'default' => 'false',
      ]
    );

    $this->end_controls_section();

    // Results Tab End

  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();
?>
    <rtr-search show-location="<?php echo esc_attr($settings['show_location']); ?>" locations="<?php echo esc_attr($settings['locations']); ?>" view="<?php echo esc_attr($settings['view']); ?>" show-only-tags="<?php echo esc_attr($settings['show_only_tags']); ?>" search-results="<?php echo esc_attr($settings['search_results']); ?>" link-to="<?php echo esc_attr($settings['link_to']); ?>" results-on-scroll="<?php echo esc_attr($settings['results_on_scroll']); ?>" <?php if ($settings['hide_results'] == 'true') { ?> hide-results="true" <?php } ?>></rtr-search>

  <?php
  }

  // Written as a JS template that generates the preview output in the editor.
  protected function _content_template()
  {
  ?>
    <rtr-search show-location="{{{ settings.show_location }}}" locations="{{{ settings.locations }}}" view="{{{ settings.view }}}" show-only-tags="{{{ settings.show_only_tags }}}" search-results="{{{ settings.search_results }}}" link-to="{{{ settings.link_to }}}" results-on-scroll="{{{ settings.results_on_scroll }}}" <# if (settings.hide_results=='true' ) { #> hide-results="true" <# } #>></rtr-search>

<?php

  }
}
