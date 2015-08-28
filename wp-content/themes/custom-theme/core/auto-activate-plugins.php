<?php

// example on admin init, control about register_activation_hook()
//add_action( 'admin_init', 'fb_activate_plugins' );
add_action("after_switch_theme", "fb_activate_plugins", 10 ,  2);
// the exmple function
function fb_activate_plugins() {
    if ( ! current_user_can('activate_plugins') )
        wp_die(__('You do not have sufficient permissions to activate plugins for this site.'));
    $plugins = FALSE;
    $plugins = get_option('active_plugins'); // get active plugins

    if ( $plugins !== false ) {

        // plugins to active
        $pugins_to_active = array(
            //"hello.php", // Hello Dolly
            //"adminimize/adminimize.php", // Adminimize
            //"akismet/akismet.php", // Akismet
            "all-in-one-seo-pack/all_in_one_seo_pack.php",
            "all-in-one-wp-migration/all-in-one-wp-migration.php",
            "codepress-admin-columns/codepress-admin-columns.php",
            "contact-form-7/wp-contact-form-7.php",
            "contact-form-7-to-database-extension/contact-form-7-db.php",
            "export-featured-images/export-featured-images.php",
            "meta-box/meta-box.php",
            "post-types-order/post-types-order.php",
            "taxonomy-terms-order/taxonomy-terms-order.php",
            "tinymce-advanced/tinymce-advanced.php",
            //"updraftplus",
            //"wordpress-importer",
            "wp-email-login/email-login.php",
            "wp-mail-smtp/wp_mail_smtp.php",
            "wp-pace/pace.php",
        );

        foreach ( $pugins_to_active as $plugin ) {
            if ( ! in_array( $plugin, $plugins ) ) {
                array_push( $plugins, $plugin );
                update_option( 'active_plugins', $plugins );
            }
        }

    } // end if $plugins
}
