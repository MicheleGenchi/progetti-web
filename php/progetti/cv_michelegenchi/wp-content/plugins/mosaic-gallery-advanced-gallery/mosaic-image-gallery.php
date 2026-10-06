<?php
/*
 * Plugin Name: Mosaic Gallery - Advanced Gallery
 * Description: Mosaic Gallery is an advanced WordPress plugin for creating stunning, responsive mosaic-style galleries with ease, offering customizable layouts and effects.
 * Version: 1.2.1
 * Author: misbahwp
 * Plugin URI: 
 * Text Domain: mosaic-image-gallery
 * License: GPL-2.0+
 */

if (!defined('ABSPATH')) {
    exit();
}
class Mosaic_Image_Gallery
{

    public function __construct()
    {
        define('MIGY_VERSION', '1.2.1');
        define('MIGY_GALLERY_SHORTCODE', 'migy_gallery');
        define('MIGY_PLUGIN_ASSEST', trailingslashit(plugins_url('assets', __FILE__)));
        define('MIGY_CSS_URI', MIGY_PLUGIN_ASSEST . 'css');
        define('MIGY_JS_URI', MIGY_PLUGIN_ASSEST . 'js');
        define('MIGY_API_URL', 'https://license.misbahwp.com/api/general/');
        define('MIGY_MAIN_URL', 'https://www.misbahwp.com/');
        define('MIGY_THEME_BUNDLE_IMAGE_URL', plugin_dir_url(__FILE__) . 'assets/images/get-theme-bundle-img.png');
        define('MIGY_PLUGIN_DIR', plugin_dir_path(__FILE__));
        define('MIGY_PLUGIN_URL', plugin_dir_url(__FILE__));

        add_action('init', array($this, 'mosaic_image_gallery_localization_setup'));

        require_once plugin_dir_path(__FILE__) . 'includes/gallery-functions.php';
        require_once plugin_dir_path(__FILE__) . 'includes/admin.php';
        require_once plugin_dir_path(__FILE__) . 'menu/admin-menu.php';
        require_once plugin_dir_path(__FILE__) . 'ajax/ajax.php';
        require_once plugin_dir_path(__FILE__) . 'includes/template-modal.php';


        add_action('admin_notices', array($this, 'migy_admin_notice_with_html'));
        register_activation_hook(__FILE__, array($this, 'migy_activation_hook'));
        register_deactivation_hook(__FILE__, array($this, 'migy_deactivation_hook'));
        add_action('wp_login', array($this, 'migy_user_login_hook'), 10, 2);
        add_action('wp_logout', array($this, 'migy_user_logout_hook'));
        add_action('admin_footer', array($this, 'migy_custom_popup_html'));
        add_action('admin_enqueue_scripts', array($this, 'migy_admin_styles'));
        add_action('admin_footer', array($this, 'migy_floating_btn'));


    }

    public function mosaic_image_gallery_localization_setup()
    {
        load_plugin_textdomain('mosaic-image-gallery', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }


    public function migy_admin_notice_with_html()
    {
        ?>
        <div class="notice is-dismissible migy">
            <div class="migy-notice-banner-wrap">
                <img src="<?php echo esc_url(MIGY_PLUGIN_ASSEST . '/images/notice-background.png'); ?>" alt="">
                <div class="migy-notice-heading">
                    <h1 class="migy-main-head"><?php echo esc_html('WORDPRESS THEME BUNDLE - 110+ THEMES'); ?></h1>
                    <h4 class="migy-sub-head">
                        <?php echo esc_html('Get Our Theme Pack of 110+ Wordpress Themes'); ?><strong><?php echo esc_html(' AT $89'); ?></strong>
                    </h4>
                    <div class="migy-notice-btn">
                        <a class="migy-buy-btn" target="_blank"
                            href="<?php echo esc_url(MIGY_MAIN_URL . 'products/wordpress-bundle'); ?>"><?php echo esc_html('Shop Now'); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }


    public function migy_activation_hook()
    {
        update_option('migy_show_activation_popup', true);
    }


    public function migy_deactivation_hook()
    {
        delete_option('migy_show_deactivation_popup');
    }


    public function migy_user_login_hook($user_login, $user)
    {
        update_option('migy_show_activation_popup', true);
    }


    public function migy_user_logout_hook()
    {
        delete_option('migy_show_deactivation_popup');
    }


    public function migy_custom_popup_html()
    {

        if (!get_option('migy_show_activation_popup'))
            return;
        if (isset($_GET['page']) && $_GET['page'] === 'migy_templates') {
            return;
        }
        ?>
        <div id="migy-popup-overlay">
            <div id="migy-popup-content">
                <span class="dashicons dashicons-plus-alt2 migy-popup-dismiss"></span>
                <img src="<?php echo esc_url(MIGY_THEME_BUNDLE_IMAGE_URL); ?>" alt="Bundle Image">
                <h2><?php echo esc_html('Upgrade Your Site with Pro Themes—From $48'); ?></h2>
                <div class="migy-popup-wrap">
                    <a href="<?php echo esc_url(admin_url('edit.php?post_type=migy_image_gallery&page=migy_templates')); ?>"
                        class="button button-primary migy-popup-template-btn"><?php echo esc_html('View Premium Templates'); ?></a>
                    <a href="<?php echo esc_url(MIGY_MAIN_URL . 'products/wordpress-bundle'); ?>" target="_blank"
                        class="button button-primary migy-popup-bundle-btn"><?php echo esc_html('Get Theme Bundle'); ?></a>
                </div>
            </div>
        </div>
        <?php
    }


    public function migy_admin_styles()
    {
        if (isset($_GET['page']) && $_GET['page'] === 'migy_templates') {
            return;
        }

        if (!get_option('migy_show_activation_popup')) {
            update_option('migy_show_deactivation_popup', true);
        }

        $dismissed = get_option('migy_show_deactivation_popup');

        wp_register_style('migy-admin-styles', false);
        wp_enqueue_style('migy-admin-styles');

        $css = $dismissed
            ? '.migy-premium-floating-btn { display: inline-block; position: fixed; bottom: 20px; right: 20px; z-index: 9999; padding: 10px 15px; }'
            : '.migy-premium-floating-btn { display: none !important; }';

        wp_add_inline_style('migy-admin-styles', $css);
    }


    public function migy_floating_btn()
    {
        if (is_admin()) {
            $screen = get_current_screen();

            if ($screen && $screen->is_block_editor) {
                return;
            }
        }

        if (isset($_GET['page']) && $_GET['page'] === 'migy_templates') {
            return;
        }
        ?>
        <a href="<?php echo esc_url(admin_url('edit.php?post_type=migy_image_gallery&page=migy_templates')); ?>"
            class="migy-premium-floating-btn button button-primary">
            <?php echo esc_html('View Premium Templates'); ?>
        </a>
        <?php
    }


}

new Mosaic_Image_Gallery();
