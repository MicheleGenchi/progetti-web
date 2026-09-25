<?php

if ( class_exists("Kirki")){

	// LOGO

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'slider',
		'settings'    => 'professional_cv_resume_logo_resizer',
		'label'       => esc_html__( 'Adjust Your Logo Size ', 'professional-cv-resume' ),
		'section'     => 'title_tagline',
		'default'     => 70,
		'choices'     => [
			'min'  => 10,
			'max'  => 300,
			'step' => 10,
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'professional_cv_resume_enable_logo_text',
		'section'     => 'title_tagline',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Enable / Disable Site Title and Tagline', 'professional-cv-resume' ) . '</h3>',
		'priority'    => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'professional_cv_resume_display_header_title',
		'label'       => esc_html__( 'Site Title Enable / Disable Button', 'professional-cv-resume' ),
		'section'     => 'title_tagline',
		'default'     => '1',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'professional-cv-resume' ),
			'off' => esc_html__( 'Disable', 'professional-cv-resume' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'professional_cv_resume_display_header_text',
		'label'       => esc_html__( 'Tagline Enable / Disable Button', 'professional-cv-resume' ),
		'section'     => 'title_tagline',
		'default'     => false,
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'professional-cv-resume' ),
			'off' => esc_html__( 'Disable', 'professional-cv-resume' ),
		],
	] );

	// FONT STYLE TYPOGRAPHY

	Kirki::add_panel( 'professional_cv_resume_panel_id', array(
	    'priority'    => 10,
	    'title'       => esc_html__( 'Typography', 'professional-cv-resume' ),
	) );

	Kirki::add_section( 'professional_cv_resume_font_style_section', array(
		'title'      => esc_html__( 'Typography Option',  'professional-cv-resume' ),
		'priority'   => 2,
		'capability' => 'edit_theme_options',
	) );

	Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'professional-cv-resume' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( PROFESSIONAL_CV_RESUME_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'professional-cv-resume' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'professional_cv_resume_font_style_section',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. More Font Family Options </p><p>3. Color Pallete Setup </p><p>4. Section Reordering Facility</p><p>5. For More Options kindly Go For Premium Version.</p>', 'professional-cv-resume' ) . '</div>',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'professional_cv_resume_all_headings_typography',
		'section'     => 'professional_cv_resume_font_style_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Heading Of All Sections',  'professional-cv-resume' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'global', array(
		'type'        => 'typography',
		'settings'    => 'professional_cv_resume_all_headings_typography',
		'label'       => esc_html__( 'Heading Typography',  'professional-cv-resume' ),
		'description' => esc_html__( 'Select the typography options for your heading.',  'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_font_style_section',
		'priority'    => 10,
		'default'     => array(
			'font-family'    => '',
			'variant'        => '',
		),
		'output' => array(
			array(
				'element' => array( 'h1','h2','h3','h4','h5','h6', ),
			),
		),
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'professional_cv_resume_body_content_typography',
		'section'     => 'professional_cv_resume_font_style_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Body Content',  'professional-cv-resume' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'global', array(
		'type'        => 'typography',
		'settings'    => 'professional_cv_resume_body_content_typography',
		'label'       => esc_html__( 'Content Typography',  'professional-cv-resume' ),
		'description' => esc_html__( 'Select the typography options for your content.',  'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_font_style_section',
		'priority'    => 10,
		'default'     => array(
			'font-family'    => '',
			'variant'        => '',
		),
		'output' => array(
			array(
				'element' => array( 'body', ),
			),
		),
	) );

		// PANEL
	Kirki::add_panel( 'professional_cv_resume_panel_id_5', array(
	    'priority'    => 10,
	    'title'       => esc_html__( 'Theme Animations', 'professional-cv-resume' ),
	) );

	// ANIMATION SECTION
	Kirki::add_section( 'professional_cv_resume_section_animation', array(
	    'title'          => esc_html__( 'Animations', 'professional-cv-resume' ),
	    'priority'       => 2,
	) );

	Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'professional-cv-resume' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( PROFESSIONAL_CV_RESUME_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'professional-cv-resume' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'professional_cv_resume_section_animation',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. Color Pallete Setup </p><p>3. Section Reordering Facility</p><p>4. For More Options kindly Go For Premium Version.</p>', 'professional-cv-resume' ) . '</div>',
	]);

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'professional_cv_resume_animation_enabled',
		'label'       => esc_html__( 'Turn To Show Animation', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_section_animation',
		'default'     => true,
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'professional-cv-resume' ),
			'off' => esc_html__( 'Disable', 'professional-cv-resume' ),
		],
	] );

	// PANEL
	Kirki::add_panel( 'professional_cv_resume_panel_id_2', array(
	    'priority'    => 10,
	    'title'       => esc_html__( 'Theme Dark Mode', 'professional-cv-resume' ),
	) );

	// DARK MODE SECTION
	Kirki::add_section( 'professional_cv_resume_section_dark_mode', array(
	    'title'          => esc_html__( 'Dark Mode', 'professional-cv-resume' ),
	    'priority'       => 3,
	) );

	Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'professional-cv-resume' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( PROFESSIONAL_CV_RESUME_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'professional-cv-resume' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'professional_cv_resume_section_dark_mode',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. Color Pallete Setup </p><p>3. Section Reordering Facility</p><p>4. For More Options kindly Go For Premium Version.</p>', 'professional-cv-resume' ) . '</div>',
	]);

	Kirki::add_field( 'theme_config_id', [
	    'type'        => 'custom',
	    'settings'    => 'professional_cv_resume_dark_colors',
	    'section'     => 'professional_cv_resume_section_dark_mode',
	    'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Dark Appearance', 'professional-cv-resume' ) . '</h3>',
	    'priority'    => 10,
	]);

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'professional_cv_resume_is_dark_mode_enabled',
		'label'       => esc_html__( 'Turn To Dark Mode', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_section_dark_mode',
		'default'     => false,
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'professional-cv-resume' ),
			'off' => esc_html__( 'Disable', 'professional-cv-resume' ),
		],
	] );


	// PANEL
	Kirki::add_panel( 'professional_cv_resume_panel_id_3', array(
	    'priority'    => 10,
	    'title'       => esc_html__( '404 Settings / No Result', 'professional-cv-resume' ),
	) );

	// 404 SECTION
	Kirki::add_section( 'professional_cv_resume_section_404', array(
		'panel'          => 'professional_cv_resume_panel_id_3',
	    'title'          => esc_html__( '404 Settings', 'professional-cv-resume' ),
	    'priority'       => 3,
	) );

	Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'professional-cv-resume' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( PROFESSIONAL_CV_RESUME_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'professional-cv-resume' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'professional_cv_resume_section_404',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. Color Pallete Setup </p><p>3. Section Reordering Facility</p><p>4. For More Options kindly Go For Premium Version.</p>', 'professional-cv-resume' ) . '</div>',
		'priority'    => 10,
	]);

	Kirki::add_field( 'theme_config_id', [
	    'type'        => 'custom',
	    'settings'    => 'professional_cv_resume_404_heading',
	    'section'     => 'professional_cv_resume_section_404',
	    'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( '404 Heading', 'professional-cv-resume' ) . '</h3>',
	    'priority'    => 10,
	]);

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'professional_cv_resume_404_page_title',
		'section'  => 'professional_cv_resume_section_404',
		'default'  => esc_html__('404 Not Found', 'professional-cv-resume'),
		'priority' => 10,
	] );

		Kirki::add_field( 'theme_config_id', [
	    'type'        => 'custom',
	    'settings'    => 'professional_cv_resume_404_text',
	    'section'     => 'professional_cv_resume_section_404',
	    'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( '404 Content', 'professional-cv-resume' ) . '</h3>',
	    'priority'    => 10,
	]);

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'professional_cv_resume_404_page_content',
		'section'  => 'professional_cv_resume_section_404',
		'default'  => esc_html__('Sorry, no posts matched your criteria.', 'professional-cv-resume'),
		'priority' => 10,
	] );

	// NO Result
	Kirki::add_section( 'professional_cv_resume_no_result', array(
		'panel'          => 'professional_cv_resume_panel_id_3',
	    'title'          => esc_html__( 'No Result Page Settings', 'professional-cv-resume' ),
	    'priority'       => 3,
	) );

	Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'professional-cv-resume' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( PROFESSIONAL_CV_RESUME_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'professional-cv-resume' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'professional_cv_resume_no_result',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. Color Pallete Setup </p><p>3. Section Reordering Facility</p><p>4. For More Options kindly Go For Premium Version.</p>', 'professional-cv-resume' ) . '</div>',
		'priority'    => 10,
	]);

	Kirki::add_field( 'theme_config_id', [
	    'type'        => 'custom',
	    'settings'    => 'professional_cv_resume_not_found_heading',
	    'section'     => 'professional_cv_resume_no_result',
	    'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'No Search Result Heading', 'professional-cv-resume' ) . '</h3>',
	    'priority'    => 10,
	]);

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'professional_cv_resume_no_results_page_title',
		'section'  => 'professional_cv_resume_no_result',
		'default'  => esc_html__('404 Not Found', 'professional-cv-resume'),
		'priority' => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
	    'type'        => 'custom',
	    'settings'    => 'professional_cv_resume_not_found_text',
	    'section'     => 'professional_cv_resume_no_result',
	    'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'No Search Result Content', 'professional-cv-resume' ) . '</h3>',
	    'priority'    => 10,
	]);

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'professional_cv_resume_no_results_page_content',
		'section'  => 'professional_cv_resume_no_result',
		'default'  => esc_html__('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'professional-cv-resume'),
		'priority' => 10,
	] );

	// PANEL

	Kirki::add_panel( 'professional_cv_resume_panel_id', array(
	    'priority'    => 10,
	    'title'       => esc_html__( 'Theme Options', 'professional-cv-resume' ),
	) );

	//COLOR SECTION

	Kirki::add_section( 'professional_cv_resume_section_color', array(
	    'title'          => esc_html__( 'Global Color', 'professional-cv-resume' ),
	    'panel'          => 'professional_cv_resume_panel_id',
	    'priority'       => 160,
	) );

	Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'professional-cv-resume' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( PROFESSIONAL_CV_RESUME_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'professional-cv-resume' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'professional_cv_resume_section_color',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. More Font Family Options </p><p>3. Color Pallete Setup </p><p>4. Section Reordering Facility</p><p>5. For More Options kindly Go For Premium Version.</p>', 'professional-cv-resume' ) . '</div>',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'professional_cv_resume_global_colors',
		'section'     => 'professional_cv_resume_section_color',
		'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Here you can change your theme color on one click.', 'professional-cv-resume' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'color',
		'settings'    => 'professional_cv_resume_first_color',
		'label'       => __( 'Choose Your First Color', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_section_color',
		'default'     => '#47c6c3',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'color',
		'settings'    => 'professional_cv_resume_second_color',
		'label'       => __( 'Choose Your Second Color', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_section_color',
		'default'     => '#222222',
	] );

	// Additional Settings

	Kirki::add_section( 'professional_cv_resume_additional_settings', array(
	    'title'          => esc_html__( 'Additional Settings', 'professional-cv-resume' ),
	    'panel'          => 'professional_cv_resume_panel_id',
	    'priority'       => 160,
	) );

	Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'professional-cv-resume' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( PROFESSIONAL_CV_RESUME_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'professional-cv-resume' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'professional_cv_resume_additional_settings',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. Color Pallete Setup </p><p>3. Section Reordering Facility</p><p>4. For More Options kindly Go For Premium Version.</p>', 'professional-cv-resume' ) . '</div>',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'settings'    => 'professional_cv_resume_scroll_enable_setting',
		'label'       => esc_html__( 'Here you can enable or disable your scroller.', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_additional_settings',
		'default'     => '1',
		'priority'    => 10,
	] );

	new \Kirki\Field\Radio_Buttonset(
	[
		'settings'    => 'professional_cv_resume_scroll_top_position',
		'label'       => esc_html__( 'Alignment for Scroll To Top', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_additional_settings',
		'default'     => 'Right',
		'priority'    => 10,
		'choices'     => [
			'Left'   => esc_html__( 'Left', 'professional-cv-resume' ),
			'Center' => esc_html__( 'Center', 'professional-cv-resume' ),
			'Right'  => esc_html__( 'Right', 'professional-cv-resume' ),
		],
	]
	);

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'dashicons',
		'settings' => 'professional_cv_resume_scroll_top_icon',
		'label'    => esc_html__( 'Select Appropriate Scroll Top Icon', 'professional-cv-resume' ),
		'section'  => 'professional_cv_resume_additional_settings',
		'default'  => 'dashicons dashicons-arrow-up-alt',
		'priority' => 10,
	] );

	new \Kirki\Field\Select(
	[
		'settings'    => 'menu_text_transform_professional_cv_resume',
		'label'       => esc_html__( 'Menus Text Transform', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_additional_settings',
		'default'     => 'CAPITALISE',
		'placeholder' => esc_html__( 'Choose an option', 'professional-cv-resume' ),
		'choices'     => [
			'CAPITALISE' => esc_html__( 'CAPITALISE', 'professional-cv-resume' ),
			'UPPERCASE' => esc_html__( 'UPPERCASE', 'professional-cv-resume' ),
			'LOWERCASE' => esc_html__( 'LOWERCASE', 'professional-cv-resume' ),

		],
	] );

	new \Kirki\Field\Select(
	[
		'settings'    => 'professional_cv_resume_menu_zoom',
		'label'       => esc_html__( 'Menu Transition', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_additional_settings',
		'default' => 'None',
		'placeholder' => esc_html__( 'Choose an option', 'professional-cv-resume' ),
		'choices'     => [
			'None' => __('None','professional-cv-resume'),
            'Zoominn' => __('Zoom Inn','professional-cv-resume'),
            
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'slider',
		'settings'    => 'professional_cv_resume_container_width',
		'label'       => esc_html__( 'Theme Container Width', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_additional_settings',
		'default'     => 100,
		'choices'     => [
			'min'  => 50,
			'max'  => 100,
			'step' => 1,
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'settings'    => 'professional_cv_resume_site_loader',
		'label'       => esc_html__( 'Here you can enable or disable your Site Loader.', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_additional_settings',
		'default'     => false,
		'priority'    => 10,
	] );

		new \Kirki\Field\Select(
	[
		'settings'    => 'professional_cv_resume_preloader_type',
		'label'       => esc_html__( 'Preloader Type', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_additional_settings',
		'default' => 'four-way-loader',
		'placeholder' => esc_html__( 'Choose an option', 'professional-cv-resume' ),
		'choices'     => [
			'four-way-loader' => __('Type 1','professional-cv-resume'),
            'cube-loader' => __('Type 2','professional-cv-resume'),
		],
	] );

	new \Kirki\Field\Select(
	[
		'settings'    => 'professional_cv_resume_page_layout',
		'label'       => esc_html__( 'Page Layout Setting', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_additional_settings',
		'default' => 'Right Sidebar',
		'placeholder' => esc_html__( 'Choose an option', 'professional-cv-resume' ),
		'choices'     => [
			'Left Sidebar' => __('Left Sidebar','professional-cv-resume'),
            'Right Sidebar' => __('Right Sidebar','professional-cv-resume'),
            'One Column' => __('One Column','professional-cv-resume')
		],
	] );


	if ( class_exists("woocommerce")){

	// Woocommerce Settings

	Kirki::add_section( 'professional_cv_resume_woocommerce_settings', array(
		'title'          => esc_html__( 'Woocommerce Settings', 'professional-cv-resume' ),
		'panel'          => 'professional_cv_resume_panel_id',
		'priority'       => 160,
	) );

	Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'professional-cv-resume' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( PROFESSIONAL_CV_RESUME_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'professional-cv-resume' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'professional_cv_resume_woocommerce_settings',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. Color Pallete Setup </p><p>3. Section Reordering Facility</p><p>4. For More Options kindly Go For Premium Version.</p>', 'professional-cv-resume' ) . '</div>',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'settings'    => 'professional_cv_resume_shop_sidebar',
		'label'       => esc_html__( 'Here you can enable or disable shop page sidebar.', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_woocommerce_settings',
		'default'     => '1',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'settings'    => 'professional_cv_resume_product_sidebar',
		'label'       => esc_html__( 'Here you can enable or disable product page sidebar.', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_woocommerce_settings',
		'default'     => '1',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'settings'    => 'professional_cv_resume_related_product_setting',
		'label'       => esc_html__( 'Here you can enable or disable your related products.', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_woocommerce_settings',
		'default'     => true,
		'priority'    => 10,
	] );

	new \Kirki\Field\Number(
	[
		'settings' => 'professional_cv_resume_per_columns',
		'label'    => esc_html__( 'Product Per Row', 'professional-cv-resume' ),
		'section'  => 'professional_cv_resume_woocommerce_settings',
		'default'  => 3,
		'choices'  => [
			'min'  => 1,
			'max'  => 4,
			'step' => 1,
		],
	]
	);

	new \Kirki\Field\Number(
	[
		'settings' => 'professional_cv_resume_product_per_page',
		'label'    => esc_html__( 'Product Per Page', 'professional-cv-resume' ),
		'section'  => 'professional_cv_resume_woocommerce_settings',
		'default'  => 9,
		'choices'  => [
			'min'  => 1,
			'max'  => 15,
			'step' => 1,
		],
	]
	);

	new \Kirki\Field\Number(
	[
		'settings' => 'custom_related_products_number_per_row',
		'label'    => esc_html__( 'Related Product Per Column', 'professional-cv-resume' ),
		'section'  => 'professional_cv_resume_woocommerce_settings',
		'default'  => 3,
		'choices'  => [
			'min'  => 1,
			'max'  => 4,
			'step' => 1,
		],
	]
	);

	new \Kirki\Field\Number(
	[
		'settings' => 'custom_related_products_number',
		'label'    => esc_html__( 'Related Product Per Page', 'professional-cv-resume' ),
		'section'  => 'professional_cv_resume_woocommerce_settings',
		'default'  => 3,
		'choices'  => [
			'min'  => 1,
			'max'  => 10,
			'step' => 1,
		],
	]
	);

	new \Kirki\Field\Select(
	[
		'settings'    => 'professional_cv_resume_shop_page_layout',
		'label'       => esc_html__( 'Shop Page Layout Setting', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_woocommerce_settings',
		'default' => 'Right Sidebar',
		'placeholder' => esc_html__( 'Choose an option', 'professional-cv-resume' ),
		'choices'     => [
			'Left Sidebar' => __('Left Sidebar','professional-cv-resume'),
            'Right Sidebar' => __('Right Sidebar','professional-cv-resume')
		],
	] );

	new \Kirki\Field\Select(
	[
		'settings'    => 'professional_cv_resume_product_page_layout',
		'label'       => esc_html__( 'Product Page Layout Setting', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_woocommerce_settings',
		'default' => 'Right Sidebar',
		'placeholder' => esc_html__( 'Choose an option', 'professional-cv-resume' ),
		'choices'     => [
			'Left Sidebar' => __('Left Sidebar','professional-cv-resume'),
            'Right Sidebar' => __('Right Sidebar','professional-cv-resume')
		],
	] );

	new \Kirki\Field\Radio_Buttonset(
	[
		'settings'    => 'professional_cv_resume_woocommerce_pagination_position',
		'label'       => esc_html__( 'Woocommerce Pagination Alignment', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_woocommerce_settings',
		'default'     => 'Center',
		'priority'    => 10,
		'choices'     => [
			'Left'   => esc_html__( 'Left', 'professional-cv-resume' ),
			'Center' => esc_html__( 'Center', 'professional-cv-resume' ),
			'Right'  => esc_html__( 'Right', 'professional-cv-resume' ),
		],
	]
	);
}

	// POST SECTION

	Kirki::add_section( 'professional_cv_resume_section_post', array(
	    'title'          => esc_html__( 'Post Settings', 'professional-cv-resume' ),
	    'panel'          => 'professional_cv_resume_panel_id',
	    'priority'       => 160,
	) );

	Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'professional-cv-resume' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( PROFESSIONAL_CV_RESUME_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'professional-cv-resume' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'professional_cv_resume_section_post',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. Color Pallete Setup </p><p>3. Section Reordering Facility</p><p>4. For More Options kindly Go For Premium Version.</p>', 'professional-cv-resume' ) . '</div>',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'professional_cv_resume_enable_post_heading',
		'section'     => 'professional_cv_resume_section_post',
		'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Enable / Disable Post Settings.', 'professional-cv-resume' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'professional_cv_resume_blog_admin_enable',
		'label'       => esc_html__( 'Post Author Enable / Disable Button', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_section_post',
		'default'     => '1',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'professional-cv-resume' ),
			'off' => esc_html__( 'Disable', 'professional-cv-resume' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'professional_cv_resume_blog_comment_enable',
		'label'       => esc_html__( 'Post Comment Enable / Disable Button', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_section_post',
		'default'     => '1',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'professional-cv-resume' ),
			'off' => esc_html__( 'Disable', 'professional-cv-resume' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'slider',
		'settings'    => 'professional_cv_resume_post_excerpt_number',
		'label'       => esc_html__( 'Post Content Range', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_section_post',
		'default'     => 10,
		'choices'     => [
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'settings'    => 'professional_cv_resume_pagination_setting',
		'label'       => esc_html__( 'Here you can enable or disable your Pagination.', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_section_post',
		'default'     => true,
		'priority'    => 10,
	] );

	new \Kirki\Field\Sortable(
	[
		'settings' => 'professional_cv_resume_archive_element_sortable',
		'label'    => __( 'Archive Post Page Element Reordering', 'professional-cv-resume' ),
		'description'    => esc_html__( 'This setting is not favorable with post format.', 'professional-cv-resume' ),
		'section'  => 'professional_cv_resume_section_post',
		'default'  => [ 'option1', 'option2', 'option3', 'option4', 'option5' ],
		'choices'  => [
			'option1' => esc_html__( 'Post Image', 'professional-cv-resume' ),
			'option2' => esc_html__( 'Post Meta', 'professional-cv-resume' ),
			'option3' => esc_html__( 'Post Title', 'professional-cv-resume' ),
			'option4' => esc_html__( 'Post Content', 'professional-cv-resume' ),
			'option5' => esc_html__( 'Post Button', 'professional-cv-resume' ),
		],
	]
	);

	new \Kirki\Field\Select(
	[
		'settings'    => 'professional_cv_resume_archive_sidebar_layout',
		'label'       => esc_html__( 'Archive Post Sidebar Layout Setting', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_section_post',
		'default' => 'Right Sidebar',
		'placeholder' => esc_html__( 'Choose an option', 'professional-cv-resume' ),
		'choices'     => [
			'Left Sidebar' => __('Left Sidebar','professional-cv-resume'),
            'Right Sidebar' => __('Right Sidebar','professional-cv-resume'),
            'Three Column' => __('Three Column','professional-cv-resume'),
            'Four Column' => __('Four Column','professional-cv-resume'),
            'Grid Layout Without Sidebar' => __('Grid Layout Without Sidebar','professional-cv-resume'),
            'Grid Layout With Right Sidebar' => __('Grid Layout With Right Sidebar','professional-cv-resume'),
            'Grid Layout With Left Sidebar' => __('Grid Layout With Left Sidebar','professional-cv-resume')
		],
	] );

	new \Kirki\Field\Select(
	[
		'settings'    => 'professional_cv_resume_single_post_sidebar_layout',
		'label'       => esc_html__( 'Single Post Sidebar Layout Setting', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_section_post',
		'default' => 'Right Sidebar',
		'placeholder' => esc_html__( 'Choose an option', 'professional-cv-resume' ),
		'choices'     => [
			'Left Sidebar' => __('Left Sidebar','professional-cv-resume'),
            'Right Sidebar' => __('Right Sidebar','professional-cv-resume'),
		],
	] );

	new \Kirki\Field\Select(
	[
		'settings'    => 'professional_cv_resume_search_sidebar_layout',
		'label'       => esc_html__( 'Search Page Sidebar Layout Setting', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_section_post',
		'default' => 'Right Sidebar',
		'placeholder' => esc_html__( 'Choose an option', 'professional-cv-resume' ),
		'choices'     => [
			'Left Sidebar' => __('Left Sidebar','professional-cv-resume'),
            'Right Sidebar' => __('Right Sidebar','professional-cv-resume'),
            'Three Column' => __('Three Column','professional-cv-resume'),
            'Four Column' => __('Four Column','professional-cv-resume'),
            'Grid Layout Without Sidebar' => __('Grid Layout Without Sidebar','professional-cv-resume'),
            'Grid Layout With Right Sidebar' => __('Grid Layout With Right Sidebar','professional-cv-resume'),
            'Grid Layout With Left Sidebar' => __('Grid Layout With Left Sidebar','professional-cv-resume')
		],
	] );

	// Breadcrumb
	Kirki::add_section( 'professional_cv_resume_bradcrumb', array(
	    'title'          => esc_html__( 'Breadcrumb Settings', 'professional-cv-resume' ),
	    'panel'          => 'professional_cv_resume_panel_id',
	    'priority'       => 160,
	) );

	Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'professional-cv-resume' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( PROFESSIONAL_CV_RESUME_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'professional-cv-resume' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'professional_cv_resume_bradcrumb',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. Color Pallete Setup </p><p>3. Section Reordering Facility</p><p>4. For More Options kindly Go For Premium Version.</p>', 'professional-cv-resume' ) . '</div>',
	] );

	 Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'professional_cv_resume_enable_breadcrumb_heading',
		'section'     => 'professional_cv_resume_bradcrumb',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Enable / Disable Single Page Breadcrumb', 'professional-cv-resume' ) . '</h3>',
		'priority'    => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'professional_cv_resume_breadcrumb_enable',
		'label'       => esc_html__( 'Breadcrumb Enable / Disable', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_bradcrumb',
		'default'     => true,
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'professional-cv-resume' ),
			'off' => esc_html__( 'Disable', 'professional-cv-resume' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
        'type'     => 'text',
        'default'     => '/',
        'settings' => 'professional_cv_resume_breadcrumb_separator' ,
        'label'    => esc_html__( 'Breadcrumb Separator',  'professional-cv-resume' ),
        'section'  => 'professional_cv_resume_bradcrumb',
    ] );

	// SLIDER SECTION

	Kirki::add_section( 'professional_cv_resume_blog_slide_section', array(
        'title'          => esc_html__( ' Slider Settings', 'professional-cv-resume' ),
        'panel'          => 'professional_cv_resume_panel_id',
        'priority'       => 160,
    ) );

    Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'professional-cv-resume' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( PROFESSIONAL_CV_RESUME_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'professional-cv-resume' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'professional_cv_resume_blog_slide_section',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. Color Pallete Setup </p><p>3. Section Reordering Facility</p><p>4. For More Options kindly Go For Premium Version.</p>', 'professional-cv-resume' ) . '</div>',
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'professional_cv_resume_enable_heading',
		'section'     => 'professional_cv_resume_blog_slide_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Enable / Disable Slider', 'professional-cv-resume' ) . '</h3>',
		'priority'    => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'professional_cv_resume_blog_box_enable',
		'label'       => esc_html__( 'Section Enable / Disable', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_blog_slide_section',
		'default'     => false,
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'professional-cv-resume' ),
			'off' => esc_html__( 'Disable', 'professional-cv-resume' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'professional_cv_resume_title_unable_disable',
		'label'       => esc_html__( 'Slide Title Enable / Disable', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_blog_slide_section',
		'default'     => '1',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'professional-cv-resume' ),
			'off' => esc_html__( 'Disable', 'professional-cv-resume' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'professional_cv_resume_button_unable_disable',
		'label'       => esc_html__( 'Slide Button Enable / Disable', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_blog_slide_section',
		'default'     => '1',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'professional-cv-resume' ),
			'off' => esc_html__( 'Disable', 'professional-cv-resume' ),
		],
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'professional_cv_resume_slider_heading',
		'section'     => 'professional_cv_resume_blog_slide_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Slider', 'professional-cv-resume' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
        'type'     => 'text',
        'settings' => 'professional_cv_resume_slider_extra_heading' ,
        'label'    => esc_html__( 'Extra Heading',  'professional-cv-resume' ),
        'section'  => 'professional_cv_resume_blog_slide_section',
    ] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'number',
		'settings'    => 'professional_cv_resume_blog_slide_number',
		'label'       => esc_html__( 'Number of slides to show', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_blog_slide_section',
		'default'     => 0,
		'choices'     => [
			'min'  => 0,
			'max'  => 5,
			'step' => 1,
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'select',
		'settings'    => 'professional_cv_resume_blog_slide_category',
		'label'       => esc_html__( 'Select the category to show slider ( Image Dimension 1600 x 600 )', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_blog_slide_section',
		'default'     => '',
		'placeholder' => esc_html__( 'Select an category...', 'professional-cv-resume' ),
		'priority'    => 10,
		'choices'     => professional_cv_resume_get_categories_select(),
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'url',
		'label'    => esc_html__( 'Slider Button 2 Link', 'professional-cv-resume' ),
		'settings' => 'professional_cv_resume_slider_button_2_link',
		'section'  => 'professional_cv_resume_blog_slide_section',
		'default'  => '',
	] );


	new \Kirki\Field\Select(
	[
		'settings'    => 'professional_cv_resume_slider_content_alignment',
		'label'       => esc_html__( 'Slider Content Alignment', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_blog_slide_section',
		'default'     => 'LEFT-ALIGN',
		'placeholder' => esc_html__( 'Choose an option', 'professional-cv-resume' ),
		'choices'     => [
			'LEFT-ALIGN' => esc_html__( 'LEFT-ALIGN', 'professional-cv-resume' ),
			'CENTER-ALIGN' => esc_html__( 'CENTER-ALIGN', 'professional-cv-resume' ),
			'RIGHT-ALIGN' => esc_html__( 'RIGHT-ALIGN', 'professional-cv-resume' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'professional_cv_resume_header_phone_number_heading',
		'section'     => 'professional_cv_resume_blog_slide_section',
		'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Add Phone Number', 'professional-cv-resume' ) . '</h3>',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'label'    => esc_html__( 'Text', 'professional-cv-resume' ),
		'settings' => 'professional_cv_resume_header_phone_text',
		'section'  => 'professional_cv_resume_blog_slide_section',
		'default'  => '',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'label'    => esc_html__( 'Phone Number', 'professional-cv-resume' ),
		'settings' => 'professional_cv_resume_header_phone_number',
		'section'  => 'professional_cv_resume_blog_slide_section',
		'default'  => '',
		'sanitize_callback' => 'professional_cv_resume_sanitize_phone_number',
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'professional_cv_resume_enable_socail_link',
		'section'     => 'professional_cv_resume_blog_slide_section',
		'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Social Media Link', 'professional-cv-resume' ) . '</h3>',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'repeater',
		'section'     => 'professional_cv_resume_blog_slide_section',
		'row_label' => [
			'type'  => 'field',
			'value' => esc_html__( 'Social Icon', 'professional-cv-resume' ),
			'field' => 'link_text',
		],
		'button_label' => esc_html__('Add New Social Icon', 'professional-cv-resume' ),
		'settings'     => 'professional_cv_resume_social_links_settings',
		'default'      => '',
		'fields' 	   => [
			'link_text' => [
				'type'        => 'text',
				'label'       => esc_html__( 'Icon', 'professional-cv-resume' ),
				'description' => esc_html__( 'Add the fontawesome class ex: "fab fa-facebook-f".', 'professional-cv-resume' ),
				'default'     => '',
			],
			'link_url' => [
				'type'        => 'url',
				'label'       => esc_html__( 'Social Link', 'professional-cv-resume' ),
				'description' => esc_html__( 'Add the social icon url here.', 'professional-cv-resume' ),
				'default'     => '',
			],
		],
		'choices' => [
			'limit' => 5
		],
	] );

	new \Kirki\Field\Select(
	[
		'settings'    => 'professional_cv_resume_slider_opacity_color',
		'label'       => esc_html__( 'Slider Opacity Option', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_blog_slide_section',
		'default'     => '0.5',
		'placeholder' => esc_html__( 'Choose an option', 'professional-cv-resume' ),
		'choices'     => [
			'0' => esc_html__( '0', 'professional-cv-resume' ),
			'0.1' => esc_html__( '0.1', 'professional-cv-resume' ),
			'0.2' => esc_html__( '0.2', 'professional-cv-resume' ),
			'0.3' => esc_html__( '0.3', 'professional-cv-resume' ),
			'0.4' => esc_html__( '0.4', 'professional-cv-resume' ),
			'0.5' => esc_html__( '0.5', 'professional-cv-resume' ),
			'0.6' => esc_html__( '0.6', 'professional-cv-resume' ),
			'0.7' => esc_html__( '0.7', 'professional-cv-resume' ),
			'0.8' => esc_html__( '0.8', 'professional-cv-resume' ),
			'0.9' => esc_html__( '0.9', 'professional-cv-resume' ),
			'unset' => esc_html__( 'Unset', 'professional-cv-resume' ),
			

		],
	] );

	//OUR SERVICES SECTION

	Kirki::add_section( 'professional_cv_resume_what_we_do_section', array(
	    'title'          => esc_html__( 'Our Services Settings', 'professional-cv-resume' ),
	    'panel'          => 'professional_cv_resume_panel_id',
	    'priority'       => 160,
	) );

	Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'professional-cv-resume' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( PROFESSIONAL_CV_RESUME_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'professional-cv-resume' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'professional_cv_resume_what_we_do_section',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. Color Pallete Setup </p><p>3. Section Reordering Facility</p><p>4. For More Options kindly Go For Premium Version.</p>', 'professional-cv-resume' ) . '</div>',
	    'priority'    => 1,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'professional_cv_resume_enable_heading',
		'section'     => 'professional_cv_resume_what_we_do_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Enable / Disable Our Services',  'professional-cv-resume' ) . '</h3>',
		'priority'    => 1,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'professional_cv_resume_what_we_do_section_enable',
		'label'       => esc_html__( 'Section Enable / Disable',  'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_what_we_do_section',
		'default'     => false,
		'priority'    => 2,
		'choices'     => [
			'on'  => esc_html__( 'Enable',  'professional-cv-resume' ),
			'off' => esc_html__( 'Disable',  'professional-cv-resume' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
        'type'     => 'text',
        'settings' => 'professional_cv_resume_what_we_do_short_heading' ,
        'label'    => esc_html__( 'Short Heading',  'professional-cv-resume' ),
        'section'  => 'professional_cv_resume_what_we_do_section',
    ] );

	Kirki::add_field( 'theme_config_id', [
        'type'     => 'text',
        'settings' => 'professional_cv_resume_what_we_do_heading' ,
        'label'    => esc_html__( 'Heading',  'professional-cv-resume' ),
        'section'  => 'professional_cv_resume_what_we_do_section',
    ] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'number',
		'settings'    => 'professional_cv_resume_what_we_do_left_number',
		'label'       => esc_html__( 'Number of post to show', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_what_we_do_section',
		'default'     => 0,
		'choices'     => [
			'min'  => 1,
			'max'  => 10,
			'step' => 1,
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'select',
		'settings'    => 'professional_cv_resume_what_we_do_left_category',
		'label'       => esc_html__( 'Select the category to show post', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_what_we_do_section',
		'default'     => '',
		'placeholder' => esc_html__( 'Select an category...', 'professional-cv-resume' ),
		'priority'    => 10,
		'choices'     => professional_cv_resume_get_categories_select(),
	] );

	// FOOTER SECTION

	Kirki::add_section( 'professional_cv_resume_footer_section', array(
        'title'          => esc_html__( 'Footer Settings', 'professional-cv-resume' ),
        'panel'          => 'professional_cv_resume_panel_id',
        'priority'       => 160,
    ) );

    Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'professional-cv-resume' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( PROFESSIONAL_CV_RESUME_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'professional-cv-resume' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'professional_cv_resume_footer_section',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. Color Pallete Setup </p><p>3. Section Reordering Facility</p><p>4. For More Options kindly Go For Premium Version.</p>', 'professional-cv-resume' ) . '</div>',
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'professional_cv_resume_footer_enable_heading',
		'section'     => 'professional_cv_resume_footer_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Enable / Disable Footer Link', 'professional-cv-resume' ) . '</h3>',
		'priority'    => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'professional_cv_resume_copyright_enable',
		'label'       => esc_html__( 'Section Enable / Disable', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_footer_section',
		'default'     => '1',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'professional-cv-resume' ),
			'off' => esc_html__( 'Disable', 'professional-cv-resume' ),
		],
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'professional_cv_resume_footer_text_heading',
		'section'     => 'professional_cv_resume_footer_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Footer Copyright Text', 'professional-cv-resume' ) . '</h3>',
		'priority'    => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'professional_cv_resume_footer_text',
		'section'  => 'professional_cv_resume_footer_section',
		'default'  => '',
		'priority' => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
	'type'        => 'custom',
	'settings'    => 'professional_cv_resume_footer_text_heading_2',
	'section'     => 'professional_cv_resume_footer_section',
		'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Footer Copyright Alignment', 'professional-cv-resume' ) . '</h3>',
	'priority'    => 10,
	] );

	new \Kirki\Field\Select(
	[
		'settings'    => 'professional_cv_resume_copyright_text_alignment',
		'label'       => esc_html__( 'Copyright text Alignment', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_footer_section',
		'default'     => 'LEFT-ALIGN',
		'placeholder' => esc_html__( 'Choose an option', 'professional-cv-resume' ),
		'choices'     => [
			'LEFT-ALIGN' => esc_html__( 'LEFT-ALIGN', 'professional-cv-resume' ),
			'CENTER-ALIGN' => esc_html__( 'CENTER-ALIGN', 'professional-cv-resume' ),
			'RIGHT-ALIGN' => esc_html__( 'RIGHT-ALIGN', 'professional-cv-resume' ),

		],
	] );

	Kirki::add_field( 'theme_config_id', [
	'type'        => 'custom',
	'settings'    => 'professional_cv_resume_footer_text_heading_1',
	'section'     => 'professional_cv_resume_footer_section',
		'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Footer Copyright Background Color', 'professional-cv-resume' ) . '</h3>',
	'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'color',
		'settings'    => 'professional_cv_resume_copyright_bg',
		'label'       => __( 'Choose Your Copyright Background Color', 'professional-cv-resume' ),
		'section'     => 'professional_cv_resume_footer_section',
		'default'     => '',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'professional_cv_resume_enable_footer_socail_link',
		'section'     => 'professional_cv_resume_footer_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Social Media Link', 'professional-cv-resume' ) . '</h3>',
		'priority'    => 11,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'repeater',
		'section'     => 'professional_cv_resume_footer_section',
		'priority'    => 11,
		'row_label' => [
			'type'  => 'field',
			'value' => esc_html__( 'Footer Social Icon', 'professional-cv-resume' ),
			'field' => 'link_text',
		],
		'button_label' => esc_html__('Add New Social Icon', 'professional-cv-resume' ),
		'settings'     => 'professional_cv_resume_footer_social_links_settings',
		'default'      => '',
		'fields' 	   => [
			'link_text' => [
				'type'        => 'text',
				'label'       => esc_html__( 'Icon', 'professional-cv-resume' ),
				'description' => esc_html__( 'Add the fontawesome class ex: "fab fa-facebook-f".', 'professional-cv-resume' ),
				'default'     => '',
			],
			'link_url' => [
				'type'        => 'url',
				'label'       => esc_html__( 'Social Link', 'professional-cv-resume' ),
				'description' => esc_html__( 'Add the social icon url here.', 'professional-cv-resume' ),
				'default'     => '',
			],
		],
		'choices' => [
			'limit' => 5
		],
	] );
}

/*
 *  Customizer Notifications
 */

$professional_cv_resume_config_customizer = array(
    'recommended_plugins' => array( 
        'kirki' => array(
            'recommended' => true,
            'description' => sprintf( 
                /* translators: %s: plugin name */
                esc_html__( 'If you want to show all the sections of the FrontPage, please install and activate %s plugin', 'professional-cv-resume' ), 
                '<strong>' . esc_html__( 'Kirki Customizer', 'professional-cv-resume' ) . '</strong>'
            ),
        ),
    ),
    'professional_cv_resume_recommended_actions'       => array(),
    'professional_cv_resume_recommended_actions_title' => esc_html__( 'Recommended Actions', 'professional-cv-resume' ),
    'professional_cv_resume_recommended_plugins_title' => esc_html__( 'Recommended Plugin', 'professional-cv-resume' ),
    'professional_cv_resume_install_button_label'      => esc_html__( 'Install and Activate', 'professional-cv-resume' ),
    'professional_cv_resume_activate_button_label'     => esc_html__( 'Activate', 'professional-cv-resume' ),
    'professional_cv_resume_deactivate_button_label'   => esc_html__( 'Deactivate', 'professional-cv-resume' ),
);

Professional_CV_Resume_Customizer_Notify::init( apply_filters( 'professional_cv_resume_customizer_notify_array', $professional_cv_resume_config_customizer ) );