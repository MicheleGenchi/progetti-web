<?php
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Professional_Cv_Resume_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	*/
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/core/includes/upgrade-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Professional_Cv_Resume_Customize_Section_Pro' );

		// Add the PRO Upgrade section.
		$manager->add_section(
		    new Professional_Cv_Resume_Customize_Section_Pro(
		        $manager,
		        'professional_cv_resume_upgrade_pro',
		        array(
		            'title'         => esc_html__( 'Professional CV Resume PRO', 'professional-cv-resume' ),
		            'pro_text'      => esc_html__( 'CV Resume PRO', 'professional-cv-resume' ),
		            'pro_url'       => esc_url( PROFESSIONAL_CV_RESUME_BUY_NOW ),
		            'demo_text'     => esc_html__( 'Demo', 'professional-cv-resume' ),
		            'demo_url'      => esc_url( PROFESSIONAL_CV_RESUME_DEMO_PRO ),
		            'support_text'  => esc_html__( 'Support', 'professional-cv-resume' ),
		            'support_url'   => esc_url( PROFESSIONAL_CV_RESUME_SUPPORT_FREE ),
		            'bundle_text'   => esc_html__( 'Get All Themes', 'professional-cv-resume' ),
		            'bundle_url'    => esc_url( PROFESSIONAL_CV_RESUME_THEME_BUNDLE ),
		            'lite_doc_text' => esc_html__( 'Lite Doc', 'professional-cv-resume' ),
		            'lite_doc_url'  => esc_url( PROFESSIONAL_CV_RESUME_DOCS_FREE ),
		            'review_text'   => esc_html__( 'Review', 'professional-cv-resume' ),
		            'review_url'    => esc_url( PROFESSIONAL_CV_RESUME_REVIEW_FREE ),
		            'priority'      => 1,
		        )
		    )
		);

	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script(
			'professional-cv-resume-customize-controls',
			trailingslashit( get_template_directory_uri() ) . '/js/customize-controls.js',
			array( 'customize-controls' )
		);

		wp_enqueue_style(
			'professional-cv-resume-customize-controls',
			trailingslashit( get_template_directory_uri() ) . '/css/customize-controls.css'
		);
	}
}

// Doing this customizer thang!
Professional_Cv_Resume_Customize::get_instance();
