<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://delay-delo.com/
 * @since      2.0.0
 *
 * @package    Wp_Clear
 * @subpackage Wp_Clear/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Clear
 * @subpackage Wp_Clear/public
 * @author     Alexey Rtishchev <alexmonkwork@gmail.com>
 */
class Wp_Clear_Public {

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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

        $this->wp_clear_options = get_option($this->plugin_name);

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        //	wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-clear-public.css', array(), $this->version, 'all' );

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        //	wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-clear-public.js', array( 'jquery' ), $this->version, true );

    }


    /**
     * Cleanup head
     *
     * @since   2.0.0
     */
    public function wp_clear_head_all() {

        if($this->wp_clear_options['cleanup']){

            // Remove or set up DNS prefetch links
            remove_action( 'wp_head', 'wp_resource_hints', 2 );

            // Remove info about WordPress version from <head>
            remove_action('wp_head', 'wp_generator');

            // Remove XML-RPC link from <head>
            add_filter('xmlrpc_enabled', function (): bool {
                return false;
            });
            remove_action('wp_head', 'rsd_link');

            // Remove Windows Live Writer manifest
            remove_action('wp_head', 'wlwmanifest_link');

            // Remove  shortlink
            remove_action('wp_head', 'wp_shortlink_wp_head');

            //Remove  canonical
            remove_action('wp_head','rel_canonical');

            // Remove PREV and NEXT links
            remove_action('wp_head', 'adjacent_posts_rel_link');

        }
    }


    /**
     *  Remove XML feeds
     *
     * @since   2.0.0
     */
    public function  wp_clear_remove_xml() {

        if($this->wp_clear_options['wp_clear_remove_xml']){

            // Disable RSS feeds by redirecting their URLs to homepage
            foreach (['do_feed_rss2', 'do_feed_rss2_comments'] as $feedAction) {
                add_action($feedAction, function (): void {
                    // Redirect permanently to homepage
                    wp_redirect(home_url(), 301);
                    exit;
                }, 1);
            }

            //Remove the feed links from <head>
            remove_action('wp_head', 'feed_links', 2);
            remove_action( 'wp_head', 'rsd_link' );
            remove_action( 'wp_head', 'feed_links_extra', 3 );
            remove_action( 'wp_head', 'index_rel_link' );
        }

    }


    /**
     * Disable the emoji's Remove emoji script and styles from <head>
     *
     * @since    2.0.0
     */
    public function wp_clear_emodji_disable() {

        if($this->wp_clear_options['emojis_disable']){

            remove_action('wp_head', 'print_emoji_detection_script', 7);
            remove_action('wp_print_styles', 'print_emoji_styles');

        }
    }


    /**
     * Clean up head
     *
     * @since    1.0.0
     */
    public function wp_clear_remove_x_pingback($headers) {

        if(!empty($this->wp_clear_options['cleanup'])){
            unset($headers['X-Pingback']);
            return $headers;
        }
    }


    /**
     * Disable wp-embed
     *
     * @since    1.0.0
     */
    public function wp_clear_deregister_wp_embed(){

        if($this->wp_clear_options['disable_wp_embed']) {

            wp_dequeue_script( 'wp-embed' );
            remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
            remove_action( 'wp_head', 'wp_oembed_add_host_js' );
            remove_action('rest_api_init', 'wp_oembed_register_route');
            remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
        }
    }


    /**
     * Removes all REST API filters and disables the API itself.
     *
     *@since    2.0.0
     */

    public function wp_clear_remove_rest_api() {

        add_filter('rest_authentication_errors', function ($access) {
            if (!current_user_can('administrator')) {
                return new WP_Error('rest_cannot_access', 'Only authenticated users can access the REST API.', ['status' => rest_authorization_required_code()]);
            }
            return $access;
        });

        remove_action('wp_head', 'rest_output_link_wp_head');

    }

}
