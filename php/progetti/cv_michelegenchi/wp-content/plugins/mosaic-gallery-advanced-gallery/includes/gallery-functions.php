<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit();
}

class MIGY_Gallery_Functions {
	
	public function __construct(){
        
        add_action( 'init', array($this, 'init_plugin') );
        add_shortcode(MIGY_GALLERY_SHORTCODE, array($this, 'mosaic_image_gallery_scode'));
        add_action( 'init', array($this, 'migy_register_taxonomy') );
		add_action('wp_enqueue_scripts', array($this,'mosaic_image_gallery_scripts'));
        add_action('enqueue_block_editor_assets', array($this,'mosaic_image_gallery_editor_scripts'));
		add_action('admin_enqueue_scripts', array($this,'admin_scripts'));
        add_action('wp_ajax_migy_get_notice_dismiss', [$this, 'migy_get_notice_dismiss']);
    }
	
	//Initializes the plugin
    public function init_plugin(){
        
		//Register post type
        register_post_type('migy_image_gallery', array(
            'labels'=>array(
                'name'=>'Mosaic Gallery',
                'all_items'=> __( 'All Galleries', 'mosaic-image-gallery' ),
                'add_new'=> __( 'Add Gallery', 'mosaic-image-gallery' ),
                'add_new_item' => __( 'Add new Gallery', 'mosaic-image-gallery' ),
                'edit_item'  => __( 'Edit Gallery', 'mosaic-image-gallery' ),
                'view_items' => __( 'View Galleries', 'mosaic-image-gallery' ),
                'not_found' => __( 'No gallery found', 'mosaic-image-gallery' ),
                'not_found_in_trash' => __( 'No gallery found in trash', 'mosaic-image-gallery' )
            ),
            'public'=>true,
            'menu_icon'=>'dashicons-images-alt2',
            'supports'=>array('title')
        ));
        
    }
     public function migy_get_notice_dismiss() {

            delete_option( 'migy_show_activation_popup' );
            update_option('migy_show_deactivation_popup', true);

            wp_send_json_success([
                "code" => 200,
                "msg" => "Activation popup preference saved successfully."
            ]);
    }
	
	//Register taxonomy
	public function migy_register_taxonomy() {
        $taxonomy = 'migy-filter-category';
		$args = array(
            'label'        => __( 'Filter category', 'mosaic-image-gallery' ),
            'public'       => true,
            'rewrite'      => false,
            'hierarchical' => true
        );

        register_taxonomy( $taxonomy, 'migy_image_gallery', $args );
    }

    public function mosaic_image_gallery_editor_scripts() {

        wp_enqueue_style('migy-editor-css', MIGY_CSS_URI . '/editor.css', array(), MIGY_VERSION);

        wp_register_script(
            'migy-editor-js',
            MIGY_JS_URI . '/editor.js',
            array( 'jquery' ),
            MIGY_VERSION,
            true
        );

        $localize_arr = array(
            'bundle_image'      =>  MIGY_PLUGIN_ASSEST . '/images/bundle-image.png'
        );
    
        wp_localize_script(
            'migy-editor-js',
            'migy_editor_js',
            $localize_arr
        );
        wp_enqueue_script( 'migy-editor-js' );
    }
    
	//Enqueue scripts
    public function mosaic_image_gallery_scripts() {
        if (!$this->migy_gallery_assets_required()) {
            return;
        }

        // Define the version number
        $version = MIGY_VERSION; // Assuming MIGY_VERSION is defined elsewhere in your codebase

        // CSS style
        wp_enqueue_style('migy-viewercss', MIGY_CSS_URI.'/viewer.css', array(), $version);
        wp_enqueue_style('migy-styles', MIGY_CSS_URI.'/styles.css', array(), $version);

        wp_enqueue_script('masonry');

        // JS script
        wp_enqueue_script('migy-viewerjs', MIGY_JS_URI.'/viewer.js', array('jquery'), $version, true);
        wp_enqueue_script('migy-mixitup', MIGY_JS_URI.'/mixitup.min.js', array('jquery'), $version, true);
        wp_enqueue_script('migy-scripts', MIGY_JS_URI.'/scripts.js', array('jquery'), $version, true);
    }

    //Whether the current request needs the gallery front-end assets
    private function migy_gallery_assets_required() {
        global $post;

        $required = ($post instanceof WP_Post) && has_shortcode($post->post_content, MIGY_GALLERY_SHORTCODE);

        // Sites that place the shortcode in a widget/template outside post_content can force-enable via this filter.
        return apply_filters('migy_load_gallery_assets', $required, $post);
    }
	
	//Enqueue admin scripts
    public function admin_scripts($hook){

        if ( $hook == 'migy_image_gallery_page_migy_templates' ) {
            wp_enqueue_style('migy-admin-menu-page', MIGY_PLUGIN_ASSEST.'admin/css/admin-templates.css', array(), MIGY_VERSION);    
        }
        //CSS style
        wp_enqueue_style('migy-admin-styles', MIGY_PLUGIN_ASSEST.'admin/css/admin-style.css', array(), MIGY_VERSION);
        wp_enqueue_script('migy-admin-scripts', MIGY_PLUGIN_ASSEST.'admin/js/admin-scripts.js', array('jquery'), MIGY_VERSION, true);

        //JS script
		global $post_type;
		if( 'migy_image_gallery' == $post_type) {
			if(function_exists('wp_enqueue_media')) {
				wp_enqueue_media();
			}
			else {
				wp_enqueue_script('media-upload');
				wp_enqueue_script('thickbox');
				wp_enqueue_style('thickbox');
			}
		}

        wp_localize_script('migy-admin-scripts', 'migy_pagination_object', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('migy_create_pagination_nonce_action')
        ));

        wp_localize_script('migy-admin-scripts', 'migy_ajax_object', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
        ));
    }
	
    //Gallery shortcode
    public function mosaic_image_gallery_scode($imigy_attr, $imigy_content){
        $scode_atts = shortcode_atts(array(
                'id'=>''
        ),$imigy_attr);
        
        extract($scode_atts);

        $filter_button_bg_color = !empty(get_post_meta($id, 'migy_filter_button_bg_color', true)) ? get_post_meta($id, 'migy_filter_button_bg_color', true) : '#f5f5f5';
        $filter_button_text_color = !empty(get_post_meta($id, 'migy_filter_button_text_color', true)) ? get_post_meta($id, 'migy_filter_button_text_color', true) : '#222';

        $filter_button_bg_active_color = !empty(get_post_meta($id, 'migy_filter_button_active_bg_color', true)) ? get_post_meta($id, 'migy_filter_button_active_bg_color', true) : '#f56616';
        $filter_button_text_active_color = !empty(get_post_meta($id, 'migy_filter_button_active_text_color', true)) ? get_post_meta($id, 'migy_filter_button_active_text_color', true) : '#fff';

        $filter_buttons_alignment = !empty(get_post_meta($id, 'migy_filter_buttons_alignment', true)) ? get_post_meta($id, 'migy_filter_buttons_alignment', true) : 'left';
        $filter_buttons_alignment_map = array(
            'left'   => 'flex-start',
            'center' => 'center',
            'right'  => 'flex-end',
        );
        $filter_buttons_justify = isset($filter_buttons_alignment_map[$filter_buttons_alignment]) ? $filter_buttons_alignment_map[$filter_buttons_alignment] : 'flex-start';

        $image_radius = !empty(get_post_meta($id, 'migy_image_radius', true)) ? get_post_meta($id, 'migy_image_radius', true) : '0';
        $image_radius =  $image_radius .'px';

        $image_shadow = !empty(get_post_meta($id, 'migy_image_shadow', true)) ? get_post_meta($id, 'migy_image_shadow', true) : 'none';
        $shadow_presets = [
            'none'          => 'none',
            'shadow-soft'   => '0 2px 6px rgba(0,0,0)',
            'shadow-medium' => '0 4px 10px rgba(0,0,0)',
            'shadow-strong' => '0 6px 16px rgba(0,0,0)'
        ];
        
        $shadow_value = $shadow_presets[$image_shadow] ?? 'none';

        $title_color = !empty(get_post_meta($id, 'migy_title_color', true)) ? get_post_meta($id, 'migy_title_color', true) : '#FFFFFF';
        $description_color = !empty(get_post_meta($id, 'migy_description_color', true)) ? get_post_meta($id, 'migy_description_color', true) : '#FFFFFF';

        $title_font_size = !empty(get_post_meta($id, 'migy_title_font_size', true)) ? get_post_meta($id, 'migy_title_font_size', true) : '17';
        $description_font_size = !empty(get_post_meta($id, 'migy_description_font_size', true)) ? get_post_meta($id, 'migy_description_font_size', true) : '14';
        
        $title_font_family = !empty(get_post_meta($id, 'migy_title_font_family', true)) ? get_post_meta($id, 'migy_title_font_family', true) : 'Arial, Helvetica, sans-serif';
        $description_font_family = !empty(get_post_meta($id, 'migy_description_font_family', true)) ? get_post_meta($id, 'migy_description_font_family', true) : 'Georgia, serif';

        $title_alignment = !empty(get_post_meta($id, 'migy_title_alignment', true)) ? get_post_meta($id, 'migy_title_alignment', true) : 'left';

        $description_alignment = !empty(get_post_meta($id, 'migy_description_alignment', true)) ? get_post_meta($id, 'migy_description_alignment', true) : 'left';
        

        $custom_css = "";
        $custom_css .= ".migy-img-viewer-" . $id . " .migy-filter-buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: " . $filter_buttons_justify . ";
        }";

        $custom_css .= ".migy-img-viewer-" . $id . " .migy-filter-buttons button.migy-filter-button {
            background-color: " . $filter_button_bg_color . ";
            border: 1px solid " . $filter_button_bg_color . ";
            color: " . $filter_button_text_color . ";
        }";

        $custom_css .= ".migy-img-viewer-" . $id . " .migy-filter-buttons button.migy-filter-button.active,
        .migy-img-viewer-" . $id . " .migy-filter-buttons button.migy-filter-button:hover {
            background-color: " . $filter_button_bg_active_color . ";
            color: " . $filter_button_text_active_color . ";
            border: 1px solid " . $filter_button_bg_active_color . ";
        }";

        $custom_css .= ".migy-img-viewer-" . $id . " .migy-gallery-item img {
            border-radius: " . $image_radius . ";
        }";

        $custom_css .= ".migy-img-viewer-" . $id . " .migy-gallery-item {
            box-shadow: " . $shadow_value . ";
        }";

        // Add title and description color styles
        $custom_css .= ".migy-img-viewer-" . $id . " .migy-image-title {
            color: " . $title_color . " !important;
            font-size: " . $title_font_size . "px !important;
            font-family: " . $title_font_family . " !important;
            text-align: " . $title_alignment . " !important;
        }";

        $custom_css .= ".migy-img-viewer-" . $id . " .migy-image-description {
            color: " . $description_color . " !important;
            font-size: " . $description_font_size . "px !important;
            font-family: " . $description_font_family . " !important;
            text-align: " . $description_alignment . " !important;
        }";

        wp_enqueue_style('migy-custom-styles', MIGY_CSS_URI.'/custom-styles.css', array(), MIGY_VERSION);
        wp_add_inline_style('migy-custom-styles', $custom_css);

        ob_start();

        include MIGY_PLUGIN_DIR. 'templates/gallery.php';

    	return ob_get_clean();
    }
}

new MIGY_Gallery_Functions();
