<?php

/**
* Get started notice
*/

add_action( 'wp_ajax_professional_cv_resume_dismissed_notice_handler', 'professional_cv_resume_ajax_notice_handler' );

function professional_cv_resume_ajax_notice_handler() {
    if ( isset( $_POST['type'] ) ) {
        $professional_cv_resume_type = sanitize_text_field( wp_unslash( $_POST['type'] ) );
        update_option( 'dismissed-' . $professional_cv_resume_type, TRUE );
    }
}

function professional_cv_resume_deprecated_hook_admin_notice() {
    if ( get_option( 'dismissed-get_started', false ) ) {
        return;
    }
    $professional_cv_resume_current_screen = get_current_screen();
    if (
        $professional_cv_resume_current_screen &&
        $professional_cv_resume_current_screen->id !== 'appearance_page_professional-cv-resume-guide-page' &&
        $professional_cv_resume_current_screen->id !== 'appearance_page_professionalcvresume-wizard'
    ) {
        $professional_cv_resume_comments_theme = wp_get_theme();
        ?>
        <div class="professional-cv-resume-notice-wrapper notice notice-success notice-get-started-class is-dismissible" data-notice="get_started">
            <div class="professional-cv-resume-notice">
                <div class="professional-cv-resume-notice-content">
                    <div class="professional-cv-resume-notice-heading">
                        <h2>
                            <?php esc_html_e( 'Thanks For Installing ', 'professional-cv-resume' ); ?>
                            <?php echo esc_html( $professional_cv_resume_comments_theme ); ?>
                            <?php esc_html_e( ' Theme', 'professional-cv-resume' ); ?>
                        </h2>
                        <p>
                        <?php
                        printf(
                            esc_html__( '%s is now installed and ready to use. We\'ve provided some links to get you started.', 'professional-cv-resume' ),
                            esc_html( $professional_cv_resume_comments_theme )
                        );
                        ?>
                        </p>
                    </div>
                    <div class="diplay-flex-btn">
                        <a class="button button-primary"
                           href="<?php echo esc_url( admin_url( 'themes.php?page=professional-cv-resume-guide-page' ) ); ?>">
                           <?php esc_html_e( 'GET STARTED', 'professional-cv-resume' ); ?>
                        </a>
                        <a class="button button-primary"
                           target="_blank"
                           href="<?php echo esc_url( PROFESSIONAL_CV_RESUME_BUY_NOW ); ?>">
                           <?php esc_html_e( 'GO TO PREMIUM', 'professional-cv-resume' ); ?>
                        </a>
                        <a class="button button-primary import"
                           href="<?php echo esc_url( admin_url( 'themes.php?page=professionalcvresume-wizard' ) ); ?>">
                           <?php esc_html_e( 'ONE CLICK DEMO IMPORTER', 'professional-cv-resume' ); ?>
                        </a>
                    </div>
                </div>
                <div class="professional-cv-resume-notice-img">
                    <a href="<?php echo esc_url( PROFESSIONAL_CV_RESUME_THEME_BUNDLE ); ?>" target="_blank">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/notification.png' ); ?>" alt="<?php esc_attr_e( 'logo', 'professional-cv-resume' ); ?>">
                    </a>
                </div>
            </div>
        </div>
        <?php
    }
}
add_action( 'admin_notices', 'professional_cv_resume_deprecated_hook_admin_notice' );

add_action( 'admin_menu', 'professional_cv_resume_getting_started' );
function professional_cv_resume_getting_started() {
    add_theme_page(
        esc_html__( 'Get Started', 'professional-cv-resume' ),
        esc_html__( 'Get Started', 'professional-cv-resume' ),
        'edit_theme_options',
        'professional-cv-resume-guide-page',
        'professional_cv_resume_test_guide'
    );
}

// After switching theme, reset dismissed notice option
add_action('after_switch_theme', 'professional_cv_resume_after_switch_theme');
function professional_cv_resume_after_switch_theme() {
    update_option('dismissed-get_started', FALSE);
}

function professional_cv_resume_admin_enqueue_scripts() {
	wp_enqueue_style( 'professional-cv-resume-admin-style', esc_url( get_template_directory_uri() ).'/css/main.css' );
	wp_enqueue_script( 'professional-cv-resume-admin-script', get_template_directory_uri() . '/js/professional-cv-resume-admin-script.js', array( 'jquery' ), '', true );
    wp_localize_script( 'professional-cv-resume-admin-script', 'professional_cv_resume_ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
    );
}
add_action( 'admin_enqueue_scripts', 'professional_cv_resume_admin_enqueue_scripts' );

if ( ! defined( 'PROFESSIONAL_CV_RESUME_DOCS_FREE' ) ) {
define('PROFESSIONAL_CV_RESUME_DOCS_FREE',__('https://demo.misbahwp.com/docs/professional-cv-resume-free-docs/','professional-cv-resume'));
}
if ( ! defined( 'PROFESSIONAL_CV_RESUME_DOCS_PRO' ) ) {
define('PROFESSIONAL_CV_RESUME_DOCS_PRO',__('https://demo.misbahwp.com/docs/professional-cv-resume-pro-docs/','professional-cv-resume'));
}
if ( ! defined( 'PROFESSIONAL_CV_RESUME_BUY_NOW' ) ) {
define('PROFESSIONAL_CV_RESUME_BUY_NOW',__('https://www.misbahwp.com/products/resume-cv-WordPress-theme','professional-cv-resume'));
}
if ( ! defined( 'PROFESSIONAL_CV_RESUME_SUPPORT_FREE' ) ) {
define('PROFESSIONAL_CV_RESUME_SUPPORT_FREE',__('https://WordPress.org/support/theme/professional-cv-resume','professional-cv-resume'));
}
if ( ! defined( 'PROFESSIONAL_CV_RESUME_REVIEW_FREE' ) ) {
define('PROFESSIONAL_CV_RESUME_REVIEW_FREE',__('https://WordPress.org/support/theme/professional-cv-resume/reviews/#new-post','professional-cv-resume'));
}
if ( ! defined( 'PROFESSIONAL_CV_RESUME_DEMO_PRO' ) ) {
define('PROFESSIONAL_CV_RESUME_DEMO_PRO',__('https://demo.misbahwp.com/professional-cv-resume/','professional-cv-resume'));
}
if( ! defined( 'PROFESSIONAL_CV_RESUME_THEME_BUNDLE' ) ) {
define('PROFESSIONAL_CV_RESUME_THEME_BUNDLE',__('https://www.misbahwp.com/products/WordPress-bundle','professional-cv-resume'));
}

function professional_cv_resume_test_guide() { 
	$theme = wp_get_theme();?>
	<div class="wrap" id="main-page">
		<div class="demo-import-box">
			<h4><?php echo esc_html__('Import homepage demo in just one click.','professional-cv-resume'); ?></h4>
			<p><?php echo esc_html__('Get started with the WordPress theme installation','professional-cv-resume'); ?></p>
			<a class="button button-primary import" href="themes.php?page=professionalcvresume-wizard"><?php echo esc_html__('ONE CLICK DEMO IMPORTER','professional-cv-resume'); ?></a>
		</div>
		<div id="lefty">
            <div id="lefty-up">
                <div id="description">
                    <h3><?php esc_html_e('Welcome! Thank you for choosing ','professional-cv-resume'); ?><?php echo esc_html( $theme ); ?>  <span><?php esc_html_e('Version: ', 'professional-cv-resume'); ?><?php echo esc_html($theme['Version']);?></span></h3>
                    <div id="description-insidee">
                        <?php
                            $theme = wp_get_theme();
                            echo wp_kses_post( apply_filters( 'misbah_theme_description', esc_html( $theme->get( 'Description' ) ) ) );
                        ?>
                    </div>
                    <div id="admin_links">
                        <h3><?php esc_html_e('Unlock More Features With Premium Version','professional-cv-resume'); ?></h3>
                        <div id="admin_inside_links">
                            <a href="<?php echo esc_url( PROFESSIONAL_CV_RESUME_BUY_NOW ); ?>" target="_blank" class="blue-button-1"><?php esc_html_e( 'Get Premium', 'professional-cv-resume' ) ?></a>
                            <a href="<?php echo esc_url( PROFESSIONAL_CV_RESUME_DEMO_PRO ); ?>" id="customizer" target="_blank"><?php esc_html_e( 'Live Demo', 'professional-cv-resume' ); ?> </a>
                            <a class="blue-button-1" href="<?php echo esc_url( PROFESSIONAL_CV_RESUME_DOCS_PRO ); ?>" target="_blank" class="btn3"><?php esc_html_e( 'Pro Documentation', 'professional-cv-resume' ) ?></a>
                            <a class="blue-button-2" href="<?php echo esc_url( PROFESSIONAL_CV_RESUME_THEME_BUNDLE ); ?>" target="_blank" class="btn4"><?php esc_html_e( 'View All Themes', 'professional-cv-resume' ) ?></a>
                        </div>
                    </div>
                </div>
                <div id="theme-img">
					
                    <img class="img_responsive" style="width: 100%;" src="<?php echo esc_url( $theme->get_screenshot() ); ?>" />
                    <div id="img-btm-box">
                        <h3 class="bundle-box-title"><?php esc_html_e('Get This Premium Theme at Flat 20% OFF','professional-cv-resume'); ?></h3>
                        <div class="bundle-info">
                            <div class="bundle-left">
                                <p class="coupon-text"><?php esc_html_e('Use Coupon Code:','professional-cv-resume'); ?></p>
                                <p class="coupon-code"><?php esc_html_e('HEAT20','professional-cv-resume'); ?></p>
                            </div>
                            <div class="bundle-right">
                                <a class="white-button" href="<?php echo esc_url( PROFESSIONAL_CV_RESUME_BUY_NOW ); ?>" target="_blank"><?php esc_html_e( 'Buy Now $40', 'professional-cv-resume' ) ?><span><?php esc_html_e( '$60', 'professional-cv-resume' ) ?></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="lefty-down">
                <div id="admin_links">
                    <h3><?php esc_html_e('Important Links','professional-cv-resume'); ?></h3>
                    <p id="description-insidee"><?php esc_html_e('Below are some Important Link, Customize your theme, Get Support, and If you are stuck somewhere get help with the documentation','professional-cv-resume'); ?></p>
                    <div id="admin_inside_links">
                        <a href="<?php echo esc_url( PROFESSIONAL_CV_RESUME_DOCS_FREE ); ?>" target="_blank" class="blue-button-1"><?php esc_html_e( 'Professional CV Resume Documentation', 'professional-cv-resume' ) ?></a>
                        <a href="<?php echo esc_url( admin_url('customize.php') ); ?>" id="customizer" target="_blank"><?php esc_html_e( 'Customize Theme', 'professional-cv-resume' ); ?> </a>
                        <a class="blue-button-1" href="<?php echo esc_url( PROFESSIONAL_CV_RESUME_SUPPORT_FREE ); ?>" target="_blank" class="btn3"><?php esc_html_e( 'Get Support', 'professional-cv-resume' ) ?></a>
                        <a class="blue-button-2" href="<?php echo esc_url( PROFESSIONAL_CV_RESUME_REVIEW_FREE ); ?>" target="_blank" class="btn4"><?php esc_html_e( 'Review Theme', 'professional-cv-resume' ) ?></a>
                    </div>
                </div>
            </div>
		</div>

		<div id="righty">
			<div class="postboxx donate">
				<h3 class="hndle bundle"><?php esc_html_e( 'Get All Themes', 'professional-cv-resume' ); ?></h3>
				<div class="insidee theme-bundle">
					<img width="100%" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bundle-image.png' ); ?>" alt="<?php esc_attr_e('logo', 'professional-cv-resume'); ?>">
					<p class="offer"><?php esc_html_e('Get 110+ Perfect WordPress Theme In A Single Package at just $89.','professional-cv-resume'); ?></p>
					<p class="coupon"><?php esc_html_e('Get Our Theme Pack of 110+ WordPress Themes At 20% Off ','professional-cv-resume'); ?><span><?php esc_html_e('"HEAT20"','professional-cv-resume'); ?></span></p>
				<div id="admin_pro_linkss">
					<a class="blue-button-1" href="<?php echo esc_url( PROFESSIONAL_CV_RESUME_THEME_BUNDLE ); ?>" target="_blank"><?php esc_html_e( 'Buy All Themes - $89', 'professional-cv-resume' ) ?></a>
				</div>
				<div class="d-table">
			    <ul class="d-column">
			      <li class="feature"><?php esc_html_e('Features','professional-cv-resume'); ?></li>
			      <li class="free"><?php esc_html_e('Pro','professional-cv-resume'); ?></li>
			      <li class="plus"><?php esc_html_e('Free','professional-cv-resume'); ?></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('24hrs Priority Support','professional-cv-resume'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-yes"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Advance Posttype','professional-cv-resume'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-no"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Section Reordering','professional-cv-resume'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-no"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Enable / Disable Option','professional-cv-resume'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-yes"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Multiple Sections','professional-cv-resume'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-no"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Advance Color Pallete','professional-cv-resume'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-no"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Advance Widgets','professional-cv-resume'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-yes"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Page Templates','professional-cv-resume'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-no"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Advance Typography','professional-cv-resume'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-no"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Section Background Image / Color ','professional-cv-resume'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-no"></span></li>
			    </ul>
	  		</div>
			</div>
		</div>
	</div>
<?php } ?>