<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://delay-delo.com/
 * @since      1.0.0
 *
 * @package    Wp_Clear
 * @subpackage Wp_Clear/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap wpclear">

    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

    <h3 class="nav-tab-wrapper">Cleanup</h3>

    <form method="post" name="cleanup_options" action="options.php">

        <?php

        //Load all options
        $options = get_option($this->plugin_name);

        // Cleanup
        $cleanup = $options['cleanup'];
        $emojis_disable = $options['emojis_disable'];
        $remove_xml = $options['remove_xml'];
        $disable_wp_embed = $options['disable_wp_embed'];
        $remove_rest_api = $options['remove_rest_api'];


        ?>

        <?php
        settings_fields( $this->plugin_name );
        do_settings_sections( $this->plugin_name );
        ?>

        <!-- remove some meta and generators from the <head> -->
        <fieldset>
            <legend class="screen-reader-text"><span><?php _e('Clean WordPress head section', $this->plugin_name);?></span></legend>
            <label for="<?php echo $this->plugin_name;?>-cleanup">
                <input type="checkbox" id="<?php echo $this->plugin_name;?>-cleanup" name="<?php echo $this->plugin_name;?>[cleanup]" value="1" <?php checked( $cleanup, 1 ); ?> />
                <span><?php esc_attr_e( 'Clean up the head section', $this->plugin_name ); ?></span>
            </label>
            <div class="note">
                <?php _e('Remove Unnecessary Code from wp_head.
                <ol>
                    <li>WordPress generator meta tag</li>
                    <li>Post Relational Links</li>
                    <li>Post shortlinks</li>
                    <li>Canonical links</li>
                    <li>Post and Comment Feed and Other feeds</li>
                    <li>Resource hints</li>
                </ol>', $this->plugin_name) ?>

            </div>
        </fieldset>

        <hr class="hr">

        <fieldset>
            <legend class="screen-reader-text"><span>Remove XML feeds</span></legend>
            <label for="<?php echo $this->plugin_name;?>-remove_xml">
                <input type="checkbox" id="<?php echo $this->plugin_name;?>-remove_xml" name="<?php echo $this->plugin_name;?>[remove_xml]" value="1" <?php checked( $remove_xml, 1 ); ?> />
                <span><?php esc_attr_e( 'Remove XML feeds', $this->plugin_name ); ?></span>
            </label>
            <div class="note">
                <?php  esc_attr_e( 'Remove rel="alternate" type="application/rss+xml" from < head >' , $this->plugin_name ) ?>
            </div>
        </fieldset>


        <hr class="hr">

        <!-- remove  -->
        <fieldset>
            <legend class="screen-reader-text"><span>Remove emoji</span></legend>
            <label for="<?php echo $this->plugin_name;?>-emojis_disable">
                <input type="checkbox" id="<?php echo $this->plugin_name;?>-emojis_disable" name="<?php echo $this->plugin_name;?>[emojis_disable]" value="1" <?php checked( $emojis_disable, 1 ); ?> />
                <span><?php esc_attr_e( 'Remove emoji', $this->plugin_name ); ?></span>
            </label>
            <div class="note">
                <?php  esc_attr_e('Note: Emoticons will still work and emoji’s will still work in browsers which have built in support for them. This plugin simply removes the extra code bloat used to add support for emoji’s in older browsers.' , $this->plugin_name)  ?>
            </div>
        </fieldset>

        <hr class="hr">



        <hr class="hr">

        <fieldset>
            <legend class="screen-reader-text"><span>Disable wp-embed</span></legend>
            <label for="<?php echo $this->plugin_name;?>-disable_wp_embed">
                <input type="checkbox" id="<?php echo $this->plugin_name;?>-disable_wp_embed" name="<?php echo $this->plugin_name;?>[disable_wp_embed]" value="1" <?php checked( $disable_wp_embed, 1 ); ?> />
                <span><?php esc_attr_e( 'Disable wp-embed', $this->plugin_name ); ?></span>
            </label>
            <div class="note">
                <?php  _e('
                <ol>
                    <li>Prevents others from embedding your site.</li>
                    <li>Prevents you from embedding other non-whitelisted sites.</li>
                    <li>Disables all JavaScript related to the feature.</li>
                    <li>Removes support for the WordPress embed block in the new block editor.</li>
                </ol> ' , $this->plugin_name)  ?>
            </div>
        </fieldset>

        <hr class="hr">

        <fieldset>
            <legend class="screen-reader-text"><span>Removes REST API</span></legend>
            <label for="<?php echo $this->plugin_name;?>-disable_wp_embed">
                <input type="checkbox" id="<?php echo $this->plugin_name;?>-remove_rest_api" name="<?php echo $this->plugin_name;?>[remove_rest_api]" value="1" <?php checked( $remove_rest_api, 1 ); ?> />
                <span><?php esc_attr_e( 'Removes REST API', $this->plugin_name ); ?></span>
            </label>
            <div class="note">
                <?php  _e('Removes all REST API filters and disables the API itself.' , $this->plugin_name)  ?>
            </div>
        </fieldset>

        <hr class="hr">

        <?php submit_button(__('Save all changes', $this->plugin_name), 'primary','submit', TRUE); ?>

    </form>

</div>