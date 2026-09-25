<?php

class Professional_CV_Resume_Customizer_Notify {

	private $config = array(); // Declare $config property
	
	private $professional_cv_resume_recommended_actions;
	
	private $recommended_plugins;
	
	private static $instance;
	
	private $professional_cv_resume_recommended_actions_title;
	
	private $professional_cv_resume_recommended_plugins_title;
	
	private $dismiss_button;
	
	private $professional_cv_resume_install_button_label;
	
	private $professional_cv_resume_activate_button_label;
	
	private $professional_cv_resume_deactivate_button_label;

	
	public static function init( $config ) {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Professional_CV_Resume_Customizer_Notify ) ) {
			self::$instance = new Professional_CV_Resume_Customizer_Notify;
			if ( ! empty( $config ) && is_array( $config ) ) {
				self::$instance->config = $config;
				self::$instance->setup_config();
				self::$instance->setup_actions();
			}
		}

	}

	
	public function setup_config() {

		global $professional_cv_resume_customizer_notify_recommended_plugins;
		global $professional_cv_resume_customizer_notify_professional_cv_resume_recommended_actions;

		global $professional_cv_resume_install_button_label;
		global $professional_cv_resume_activate_button_label;
		global $professional_cv_resume_deactivate_button_label;

		$this->professional_cv_resume_recommended_actions = isset( $this->config['professional_cv_resume_recommended_actions'] ) ? $this->config['professional_cv_resume_recommended_actions'] : array();
		$this->recommended_plugins = isset( $this->config['recommended_plugins'] ) ? $this->config['recommended_plugins'] : array();

		$this->professional_cv_resume_recommended_actions_title = isset( $this->config['professional_cv_resume_recommended_actions_title'] ) ? $this->config['professional_cv_resume_recommended_actions_title'] : '';
		$this->professional_cv_resume_recommended_plugins_title = isset( $this->config['professional_cv_resume_recommended_plugins_title'] ) ? $this->config['professional_cv_resume_recommended_plugins_title'] : '';
		$this->dismiss_button            = isset( $this->config['dismiss_button'] ) ? $this->config['dismiss_button'] : '';

		$professional_cv_resume_customizer_notify_recommended_plugins = array();
		$professional_cv_resume_customizer_notify_professional_cv_resume_recommended_actions = array();

		if ( isset( $this->recommended_plugins ) ) {
			$professional_cv_resume_customizer_notify_recommended_plugins = $this->recommended_plugins;
		}

		if ( isset( $this->professional_cv_resume_recommended_actions ) ) {
			$professional_cv_resume_customizer_notify_professional_cv_resume_recommended_actions = $this->professional_cv_resume_recommended_actions;
		}

		$professional_cv_resume_install_button_label    = isset( $this->config['professional_cv_resume_install_button_label'] ) ? $this->config['professional_cv_resume_install_button_label'] : '';
		$professional_cv_resume_activate_button_label   = isset( $this->config['professional_cv_resume_activate_button_label'] ) ? $this->config['professional_cv_resume_activate_button_label'] : '';
		$professional_cv_resume_deactivate_button_label = isset( $this->config['professional_cv_resume_deactivate_button_label'] ) ? $this->config['professional_cv_resume_deactivate_button_label'] : '';

	}

	
	public function setup_actions() {

		// Register the section
		add_action( 'customize_register', array( $this, 'professional_cv_resume_plugin_notification_customize_register' ) );

		// Enqueue scripts and styles
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'professional_cv_resume_customizer_notify_scripts_for_customizer' ), 0 );

		/* ajax callback for dismissable recommended actions */
		add_action( 'wp_ajax_quality_customizer_notify_dismiss_action', array( $this, 'professional_cv_resume_customizer_notify_dismiss_recommended_action_callback' ) );

		add_action( 'wp_ajax_ti_customizer_notify_dismiss_recommended_plugins', array( $this, 'professional_cv_resume_customizer_notify_dismiss_recommended_plugins_callback' ) );

	}

	
	public function professional_cv_resume_customizer_notify_scripts_for_customizer() {

		wp_enqueue_style( 'professional-cv-resume-customizer-notify-css', get_template_directory_uri() . '/core/includes/customizer-notice/css/professional-cv-resume-customizer-notify.css', array());

		wp_enqueue_style( 'plugin-install' );
		wp_enqueue_script( 'plugin-install' );
		wp_add_inline_script( 'plugin-install', 'var pagenow = "customizer";' );

		wp_enqueue_script( 'updates' );

		wp_enqueue_script( 'professional-cv-resume-customizer-notify-js', get_template_directory_uri() . '/core/includes/customizer-notice/js/professional-cv-resume-customizer-notify.js', array( 'customize-controls' ));
		wp_localize_script(
			'professional-cv-resume-customizer-notify-js', 'professionalcvresumeCustomizercompanionObject', array(
				'ajaxurl'            => admin_url( 'admin-ajax.php' ),
				'template_directory' => get_template_directory_uri(),
				'base_path'          => admin_url(),
				'activating_string'  => __( 'Activating', 'professional-cv-resume' ),
			)
		);

	}

	
	public function professional_cv_resume_plugin_notification_customize_register( $wp_customize ) {

		
		require_once get_template_directory() . '/core/includes/customizer-notice/professional-cv-resume-customizer-notify-section.php';

		$wp_customize->register_section_type( 'Professional_CV_Resume_Customizer_Notify_Section' );

		$wp_customize->add_section(
			new Professional_CV_Resume_Customizer_Notify_Section(
				$wp_customize,
				'professional-cv-resume-customizer-notify-section',
				array(
					'title'          => $this->professional_cv_resume_recommended_actions_title,
					'plugin_text'    => $this->professional_cv_resume_recommended_plugins_title,
					'dismiss_button' => $this->dismiss_button,
					'priority'       => 0,
				)
			)
		);

	}

	
	public function professional_cv_resume_customizer_notify_dismiss_recommended_action_callback() {

		global $professional_cv_resume_customizer_notify_professional_cv_resume_recommended_actions;

		$action_id = ( isset( $_GET['id'] ) ) ? $_GET['id'] : 0;

		echo esc_html( $action_id ); /* this is needed and it's the id of the dismissable required action */ 

		if ( ! empty( $action_id ) ) {
			
			if ( get_option( 'professional_cv_resume_customizer_notify_show' ) ) {

				$professional_cv_resume_customizer_notify_show_professional_cv_resume_recommended_actions = get_option( 'professional_cv_resume_customizer_notify_show' );
				switch ( $_GET['todo'] ) {
					case 'add':
						$professional_cv_resume_customizer_notify_show_professional_cv_resume_recommended_actions[ $action_id ] = true;
						break;
					case 'dismiss':
						$professional_cv_resume_customizer_notify_show_professional_cv_resume_recommended_actions[ $action_id ] = false;
						break;
				}
				update_option( 'professional_cv_resume_customizer_notify_show', $professional_cv_resume_customizer_notify_show_professional_cv_resume_recommended_actions );

				
			} else {
				$professional_cv_resume_customizer_notify_show_professional_cv_resume_recommended_actions = array();
				if ( ! empty( $professional_cv_resume_customizer_notify_professional_cv_resume_recommended_actions ) ) {
					foreach ( $professional_cv_resume_customizer_notify_professional_cv_resume_recommended_actions as $professional_cv_resume_lite_customizer_notify_recommended_action ) {
						if ( $professional_cv_resume_lite_customizer_notify_recommended_action['id'] == $action_id ) {
							$professional_cv_resume_customizer_notify_show_professional_cv_resume_recommended_actions[ $professional_cv_resume_lite_customizer_notify_recommended_action['id'] ] = false;
						} else {
							$professional_cv_resume_customizer_notify_show_professional_cv_resume_recommended_actions[ $professional_cv_resume_lite_customizer_notify_recommended_action['id'] ] = true;
						}
					}
					update_option( 'professional_cv_resume_customizer_notify_show', $professional_cv_resume_customizer_notify_show_professional_cv_resume_recommended_actions );
				}
			}
		}
		die(); 
	}

	
	public function professional_cv_resume_customizer_notify_dismiss_recommended_plugins_callback() {

		$action_id = ( isset( $_GET['id'] ) ) ? $_GET['id'] : 0;

		echo esc_html( $action_id ); /* this is needed and it's the id of the dismissable required action */

		if ( ! empty( $action_id ) ) {

			$professional_cv_resume_lite_customizer_notify_show_recommended_plugins = get_option( 'professional_cv_resume_customizer_notify_show_recommended_plugins' );

			switch ( $_GET['todo'] ) {
				case 'add':
					$professional_cv_resume_lite_customizer_notify_show_recommended_plugins[ $action_id ] = false;
					break;
				case 'dismiss':
					$professional_cv_resume_lite_customizer_notify_show_recommended_plugins[ $action_id ] = true;
					break;
			}
			update_option( 'professional_cv_resume_customizer_notify_show_recommended_plugins', $professional_cv_resume_lite_customizer_notify_show_recommended_plugins );
		}
		die(); 
	}

}
