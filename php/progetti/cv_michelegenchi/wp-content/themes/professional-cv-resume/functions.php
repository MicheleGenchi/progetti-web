<?php

/*-----------------------------------------------------------------------------------*/
/* Enqueue script and styles */
/*-----------------------------------------------------------------------------------*/

function professional_cv_resume_enqueue_google_fonts() {

	require_once get_theme_file_path( 'core/includes/wptt-webfont-loader.php' );

	wp_enqueue_style(
		'google-fonts-jost',
		wptt_get_webfont_url( 'https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap' ),
		array(),
		'1.0'
	);
}
add_action( 'wp_enqueue_scripts', 'professional_cv_resume_enqueue_google_fonts' );

if (!function_exists('professional_cv_resume_enqueue_scripts')) {

	function professional_cv_resume_enqueue_scripts() {

		wp_enqueue_style(
			'bootstrap-css',
			get_template_directory_uri() . '/css/bootstrap.css',
			array(),'4.5.0'
		);

		wp_enqueue_style(
			'fontawesome-css',
			get_template_directory_uri() . '/css/fontawesome-all.css',
			array(),'4.5.0'
		);

		wp_enqueue_style(
			'owl.carousel-css',
			get_template_directory_uri() . '/css/owl.carousel.css',
			array(),'2.3.4'
		);

		wp_enqueue_style('professional-cv-resume-style', get_stylesheet_uri(), array() );

		wp_style_add_data('professional-cv-resume-style', 'rtl', 'replace');

		wp_enqueue_style(
			'professional-cv-resume-media-css',
			get_template_directory_uri() . '/css/media.css',
			array(),'2.3.4'
		);

		wp_enqueue_style(
			'professional-cv-resume-woocommerce-css',
			get_template_directory_uri() . '/css/woocommerce.css',
			array(),'2.3.4'
		);

		wp_enqueue_style('dashicons');

		wp_enqueue_script(
			'professional-cv-resume-navigation',
			get_template_directory_uri() . '/js/navigation.js',
			FALSE,
			'1.0',
			TRUE
		);

		wp_enqueue_script(
			'owl.carousel-js',
			get_template_directory_uri() . '/js/owl.carousel.js',
			array('jquery'),
			'2.3.4',
			TRUE
		);

		wp_enqueue_script(
			'professional-cv-resume-script',
			get_template_directory_uri() . '/js/script.js',
			array('jquery'),
			'1.0',
			TRUE
		);

		if ( get_theme_mod( 'professional_cv_resume_animation_enabled', true ) ) {
		        wp_enqueue_script(
		            'professional-cv-resume-wow-script',
		            get_template_directory_uri() . '/js/wow.js',
		            array( 'jquery' ),
		            '1.0',
		            true
		        );

		        wp_enqueue_style(
		            'professional-cv-resume-animate',
		            get_template_directory_uri() . '/css/animate.css',
		            array(),
		            '4.1.1'
		        );
		    }


		if ( is_singular() ) wp_enqueue_script( 'comment-reply' );

		$professional_cv_resume_css = '';

		if ( get_header_image() ) :

			$professional_cv_resume_css .=  '
				#site-navigation,.page-template-frontpage #site-navigation{
					background-image: url('.esc_url(get_header_image()).');
					-webkit-background-size: cover !important;
					-moz-background-size: cover !important;
					-o-background-size: cover !important;
					background-size: cover !important;
				}';

		endif;

		wp_add_inline_style( 'professional-cv-resume-style', $professional_cv_resume_css );

		// Theme Customize CSS.
	require get_template_directory(). '/core/includes/inline.php';
	wp_add_inline_style( 'professional-cv-resume-style',$professional_cv_resume_custom_css );

	}

	add_action( 'wp_enqueue_scripts', 'professional_cv_resume_enqueue_scripts' );
}

/*-----------------------------------------------------------------------------------*/
/* Setup theme */
/*-----------------------------------------------------------------------------------*/

if (!function_exists('professional_cv_resume_after_setup_theme')) {

	function professional_cv_resume_after_setup_theme() {

		load_theme_textdomain( 'professional-cv-resume', get_stylesheet_directory() . '/languages' );
		
		if ( ! isset( $professional_cv_resume_content_width ) ) $professional_cv_resume_content_width = 900;

		register_nav_menus( array(
			'main-menu' => esc_html__( 'Main menu', 'professional-cv-resume' ),
		));

		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'align-wide' );
		add_theme_support('title-tag');
		add_theme_support('automatic-feed-links');
		add_theme_support( 'wp-block-styles' );
		add_theme_support('post-thumbnails');
		add_theme_support( 'custom-background', array(
		  'default-color' => 'f3f3f3'
		));

		add_theme_support( 'custom-logo', array(
			'height'      => 70,
			'width'       => 70,
		) );

		add_theme_support( 'custom-header', array(
			'header-text' => false,
			'width' => 1920,
			'height' => 100
		));

		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		add_theme_support( 'post-formats', array('image','video','gallery','audio',) );

		add_editor_style( array( '/css/editor-style.css' ) );

		add_action( 'wp_ajax_ive-check-plugin-exists', 'check_plugin_exists' );
		add_action( 'wp_ajax_ive_install_and_activate_plugin', 'mep_install_and_activate_plugin' );
	}

	add_action( 'after_setup_theme', 'professional_cv_resume_after_setup_theme', 999 );

}

function mep_install_and_activate_plugin() {

	$post_plugin_details = $_POST['plugin_details'];
	$plugin_text_domain = $post_plugin_details['plugin_text_domain'];
	$plugin_main_file		=	$post_plugin_details['plugin_main_file'];
	$plugin_url					=	$post_plugin_details['plugin_url'];

	$plugin = array(
		'text_domain'	=> $plugin_text_domain,
		'path' 				=> $plugin_url,
		'install' 		=> $plugin_text_domain . '/' . $plugin_main_file
	);

	wp_cache_flush();

	$plugin_path = plugin_basename( trim( $plugin['install'] ) );


	$activate_plugin = activate_plugin( $plugin_path );

	if($activate_plugin) {

		echo $activate_plugin;

	} else {
		echo $activate_plugin;
	}

	$msg = 'installed';

	$response = array( 'status' => true, 'msg' => $msg );
	wp_send_json( $response );
	exit;
}

function check_plugin_exists() {
		$plugin_text_domain = $_POST['plugin_text_domain'];
		$main_plugin_file 	= $_POST['main_plugin_file'];
		$plugin_path = $plugin_text_domain . '/' . $main_plugin_file;

		$get_plugins					= get_plugins();
		$is_plugin_installed	= false;
		$activation_status 		= false;
		if ( isset( $get_plugins[$plugin_path] ) ) {
		$is_plugin_installed = true;

		$activation_status = is_plugin_active( $plugin_path );
		}
		wp_send_json_success(
		array(
		'install_status'  =>	$is_plugin_installed,
			'active_status'		=>	$activation_status,
			'plugin_path'			=>	$plugin_path,
			'plugin_slug'			=>	$plugin_text_domain
		)
		);
}

function professional_cv_resume_template_setup() {

require get_template_directory() .'/core/includes/customizer-notice/professional-cv-resume-customizer-notify.php';
require get_template_directory() .'/core/includes/main.php';
require get_template_directory() .'/core/includes/theme-breadcrumb.php';
require get_template_directory() . '/core/includes/importer/config.php';
require get_template_directory() . '/core/includes/customizer.php';
load_template( trailingslashit( get_template_directory() ) . '/core/includes/class-upgrade-pro.php' );
require get_template_directory() .'/core/includes/meta-data.php';

}
add_action('after_setup_theme', 'professional_cv_resume_template_setup');

/*-----------------------------------------------------------------------------------*/
/* Enqueue theme logo style */
/*-----------------------------------------------------------------------------------*/
function professional_cv_resume_logo_resizer() {

    $professional_cv_resume_theme_logo_size_css = '';
    $professional_cv_resume_logo_resizer = get_theme_mod('professional_cv_resume_logo_resizer');

	$professional_cv_resume_theme_logo_size_css = '
		.custom-logo{
			height: '.esc_attr($professional_cv_resume_logo_resizer).'px !important;
			width: '.esc_attr($professional_cv_resume_logo_resizer).'px !important;
		}
	';
    wp_add_inline_style( 'professional-cv-resume-style',$professional_cv_resume_theme_logo_size_css );

}
add_action( 'wp_enqueue_scripts', 'professional_cv_resume_logo_resizer' );

/*-----------------------------------------------------------------------------------*/
/* Enqueue Global color style */
/*-----------------------------------------------------------------------------------*/
function professional_cv_resume_global_color() {

    $professional_cv_resume_theme_color_css = '';
    $professional_cv_resume_copyright_bg = get_theme_mod('professional_cv_resume_copyright_bg');

	$professional_cv_resume_theme_color_css = '
    	.copyright{
			background: '.esc_attr($professional_cv_resume_copyright_bg).';
		}
	';
    wp_add_inline_style( 'professional-cv-resume-style',$professional_cv_resume_theme_color_css );
    wp_add_inline_style( 'professional-cv-resume-woocommerce-css',$professional_cv_resume_theme_color_css );

}
add_action( 'wp_enqueue_scripts', 'professional_cv_resume_global_color' );


/*-----------------------------------------------------------------------------------*/
/* Get post comments */
/*-----------------------------------------------------------------------------------*/

if (!function_exists('professional_cv_resume_comment')) :
    /**
     * Template for comments and pingbacks.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     */
    function professional_cv_resume_comment($comment, $args, $depth){

        if ('pingback' == $comment->comment_type || 'trackback' == $comment->comment_type) : ?>

            <li id="comment-<?php comment_ID(); ?>" <?php comment_class('media'); ?>>
            <div class="comment-body">
                <?php esc_html_e('Pingback:', 'professional-cv-resume');
                comment_author_link(); ?><?php edit_comment_link(__('Edit', 'professional-cv-resume'), '<span class="edit-link">', '</span>'); ?>
            </div>

        <?php else : ?>

        <li id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body media mb-4">
                <a class="pull-left" href="#">
                    <?php if (0 != $args['avatar_size']) echo get_avatar($comment, $args['avatar_size']); ?>
                </a>
                <div class="media-body">
                    <div class="media-body-wrap card">
                        <div class="card-header">
                            <h5 class="mt-0"><?php /* translators: %s: author */ printf('<cite class="fn">%s</cite>', get_comment_author_link() ); ?></h5>
                            <div class="comment-meta">
                                <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                                    <time datetime="<?php comment_time('c'); ?>">
                                        <?php /* translators: %s: Date */ printf( esc_html__('%1$s at %2$s', 'professional-cv-resume'), esc_html( get_comment_date() ), esc_html( get_comment_time() ) ); ?>
                                    </time>
                                </a>
                                <?php edit_comment_link( __( 'Edit', 'professional-cv-resume' ), '<span class="edit-link">', '</span>' ); ?>
                            </div>
                        </div>

                        <?php if ('0' == $comment->comment_approved) : ?>
                            <p class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'professional-cv-resume'); ?></p>
                        <?php endif; ?>

                        <div class="comment-content card-block">
                            <?php comment_text(); ?>
                        </div>

                        <?php comment_reply_link(
                            array_merge(
                                $args, array(
                                    'add_below' => 'div-comment',
                                    'depth' => $depth,
                                    'max_depth' => $args['max_depth'],
                                    'before' => '<footer class="reply comment-reply card-footer">',
                                    'after' => '</footer><!-- .reply -->'
                                )
                            )
                        ); ?>
                    </div>
                </div>
            </article>

            <?php
        endif;
    }
endif; // ends check for professional_cv_resume_comment()

if (!function_exists('professional_cv_resume_widgets_init')) {

	function professional_cv_resume_widgets_init() {

		register_sidebar(array(

			'name' => esc_html__('Sidebar','professional-cv-resume'),
			'id'   => 'professional-cv-resume-sidebar',
			'description'   => esc_html__('This sidebar will be shown next to the content.', 'professional-cv-resume'),
			'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="title">',
			'after_title'   => '</h4>'

		));

		register_sidebar(array(

			'name' => esc_html__('Sidebar 2','professional-cv-resume'),
			'id'   => 'professional-cv-resume-sidebar-2',
			'description'   => esc_html__('This sidebar will be shown next to the content.', 'professional-cv-resume'),
			'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="title">',
			'after_title'   => '</h4>'

		));

		register_sidebar(array(

			'name' => esc_html__('Sidebar 3','professional-cv-resume'),
			'id'   => 'professional-cv-resume-sidebar-3',
			'description'   => esc_html__('This sidebar will be shown next to the content.', 'professional-cv-resume'),
			'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="title">',
			'after_title'   => '</h4>'

		));

		register_sidebar(array(

			'name' => esc_html__('Footer sidebar','professional-cv-resume'),
			'id'   => 'professional-cv-resume-footer-sidebar',
			'description'   => esc_html__('This sidebar will be shown next at the bottom of your content.', 'professional-cv-resume'),
			'before_widget' => '<div id="%1$s" class="col-lg-3 col-md-3 %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="title">',
			'after_title'   => '</h4>'

		));

	}

	add_action( 'widgets_init', 'professional_cv_resume_widgets_init' );

}

function professional_cv_resume_get_categories_select() {
	$teh_cats = get_categories();
	$results = array();
	$count = count($teh_cats);
	for ($i=0; $i < $count; $i++) {
	if (isset($teh_cats[$i]))
  		$results[$teh_cats[$i]->slug] = $teh_cats[$i]->name;
	else
  		$count++;
	}
	return $results;
}

function professional_cv_resume_sanitize_phone_number( $phone ) {
	return preg_replace( '/[^\d+]/', '', $phone );
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'professional_cv_resume_loop_columns');
if (!function_exists('professional_cv_resume_loop_columns')) {
	function professional_cv_resume_loop_columns() {
		$professional_cv_resume_columns = get_theme_mod( 'professional_cv_resume_per_columns', 3 );
		return $professional_cv_resume_columns;
	}
}

//Change number of products that are displayed per page (shop page)
add_filter( 'loop_shop_per_page', 'professional_cv_resume_per_page', 20 );
function professional_cv_resume_per_page( $professional_cv_resume_cols ) {
  	$professional_cv_resume_cols = get_theme_mod( 'professional_cv_resume_product_per_page', 9 );
	return $professional_cv_resume_cols;
}

// Add filter to modify the number of related products
add_filter( 'woocommerce_output_related_products_args', 'professional_cv_resume_products_args' );
function professional_cv_resume_products_args( $args ) {
    $args['posts_per_page'] = get_theme_mod( 'custom_related_products_number', 6 );
    $args['columns'] = get_theme_mod( 'custom_related_products_number_per_row', 3 );
    return $args;
}

add_action('after_switch_theme', 'professional_cv_resume_setup_options');
function professional_cv_resume_setup_options () {
    update_option('dismissed-get_started', FALSE );
}

//add animation class
if ( class_exists( 'WooCommerce' ) ) { 
	add_filter('post_class', function($professional_cv_resume, $class, $product_id) {
	    if( is_shop() || is_product_category() ){
	        
	        $professional_cv_resume = array_merge(['wow','zoomIn'], $professional_cv_resume);
	    }
	    return $professional_cv_resume;
	},10,3);
}

function get_page_id_by_title($pagename){

    $args = array(
        'post_type' => 'page',
        'posts_per_page' => 1,
        'post_status' => 'publish',
        'title' => $pagename
    );
    $query = new WP_Query( $args );

    $page_id = '1';
    if (isset($query->post->ID)) {
        $page_id = $query->post->ID;
    }

    return $page_id;
}

add_action( 'customize_register', 'professional_cv_resume_remove_setting', 20 );
function professional_cv_resume_remove_setting( $wp_customize ) {
    // Check if the setting or control exists before removing
    if ( $wp_customize->get_setting( 'header_textcolor' ) ) {
        $wp_customize->remove_setting( 'header_textcolor' );
    }

    if ( $wp_customize->get_control( 'header_textcolor' ) ) {
        $wp_customize->remove_control( 'header_textcolor' );
    }
}

// edit link option
if (!function_exists('professional_cv_resume_edit_link')) :

    function professional_cv_resume_edit_link($view = 'default')
    {
        global $post;
            edit_post_link(
                sprintf(
                    wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                        __('Edit <span class="screen-reader-text">%s</span>', 'professional-cv-resume'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    get_the_title()
                ),
                '<span class="edit-link"><i class="fas fa-edit"></i>',
                '</span>'
            );

    }
endif;?>