<?php require get_template_directory() . '/core/includes/importer/tgm/class-tgm-plugin-activation.php';

function professional_cv_resume_register_recommended_plugins() {
	$plugins = array(
		array(
			'name'             => __( 'Kirki Customizer Framework', 'professional-cv-resume' ),
			'slug'             => 'kirki',
			'required'         => false,
			'force_activation' => false,
		),
		array(
			'name'             => __( 'Mosaic Gallery Advanced Gallery', 'professional-cv-resume' ),
			'slug'             => 'mosaic-gallery-advanced-gallery',
			'required'         => false,
			'force_activation' => false,
		),
	);
	$config = array();
	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'professional_cv_resume_register_recommended_plugins' );