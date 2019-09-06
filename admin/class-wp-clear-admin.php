<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://delay-delo.com/
 * @since      1.0.0
 *
 * @package    Wp_Clear
 * @subpackage Wp_Clear/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Clear
 * @subpackage Wp_Clear/admin
 * @author     Alexey Rtishchev <alexmonkwork@gmail.com>
 */
class Wp_Clear_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-clear-admin.css', array(), $this->version, 'all' );

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-clear-admin.js', array( 'jquery' ), $this->version, true );

    }


    /**
     * Add a settings page for this plugin to the Settings menu.
     *
     * @since    1.0.0
     */
    public function add_plugin_admin_menu() {

        add_options_page(
            'WP Clear Options Setup',
            'WP Clear',
            'manage_options',
            $this->plugin_name, array($this, 'display_plugin_setup_page')
        );
    }


    /**
     *  Add plugin action links
     *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
     *
     * @param $links
     * @return array
     * @since    1.0.0
     */
    public function add_action_links( $links ) {

        $settings_link = array(
            '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge(  $settings_link, $links );

    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */

    public function display_plugin_setup_page() {

        include_once( 'partials/wp-clear-admin-display.php' );

    }


    /**
     * Validate options
     *
     * @param $input - get options of options page
     * @return array
     * @since    1.0.0
     */
    public function validate($input) {

        $valid = array();

        $valid['cleanup'] = (isset($input['cleanup']) && !empty($input['cleanup'])) ? 1 : 0;
        $valid['remove_xml'] = (isset($input['remove_xml']) && !empty($input['remove_xml'])) ? 1: 0;
        $valid['emojis_disable'] = (isset($input['emojis_disable']) && !empty($input['emojis_disable'])) ? 1: 0;
        $valid['disable_wp_embed'] = (isset($input['disable_wp_embed']) && !empty($input['disable_wp_embed'])) ? 1: 0;
        $valid['remove_rest_api'] = (isset($input['remove_rest_api']) && !empty($input['remove_rest_api'])) ? 1: 0;

        return $valid;
    }


    /**
     * Update all options
     *
     * @since    1.0.0
     */
    public function options_update() {

        register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));

    }

}
