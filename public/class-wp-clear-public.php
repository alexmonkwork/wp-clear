<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://delay-delo.com/
 * @since      1.0.0
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-clear-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-clear-public.js', array( 'jquery' ), $this->version, true );

	}

	/**
	 * Cleanup head
	 *
	 * @since    1.0.0
	 */
	public function wp_clear_head_all() {

		if($this->wp_clear_options['cleanup']){

			remove_action( 'wp_head', 'rsd_link' );
			remove_action( 'wp_head', 'feed_links_extra', 3 );
			remove_action( 'wp_head', 'feed_links', 2 );
			remove_action( 'wp_head', 'index_rel_link' );
			remove_action( 'wp_head', 'wlwmanifest_link' );
			remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
			remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
			remove_action( 'wp_head', 'rel_canonical', 10, 0 );
			remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
			remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
			remove_action( 'wp_head', 'wp_generator' );
			remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
			remove_action('wp_head', 'adjacent_posts_rel_link');
			remove_action('wp_head', 'wp_resource_hints', 2);

		}
	}


	/**
	 * Disable the emoji's
	 *
	 * @since    1.0.0
	 */
	public function wp_clear_emodji_disable() {

		if($this->wp_clear_options['emojis_disable']){

			remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
			remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
			remove_action( 'wp_print_styles', 'print_emoji_styles' );
			remove_action( 'admin_print_styles', 'print_emoji_styles' );
			remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
			remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
			remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

			remove_action('wp_footer', 'twentyseventeen_include_svg_icons', 9999);


		}
	}


	/**
	 * Filter function used to remove the tinymce emoji plugin.
	 *
	 * @param $plugins
	 *
	 * @return array
	 *
	 * @since    1.0.0
	 */
	public function wp_clear_disable_emojis_tinymce ( $plugins ) {

		remove_filter( 'tiny_mce_plugins', 'disable_emoji_tinymce' );

		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		} else {
			return array();
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
		}

	}

}
