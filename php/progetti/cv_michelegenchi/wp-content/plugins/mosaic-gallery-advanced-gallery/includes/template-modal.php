<?php
function migy_enqueue_block_editor_assets() {
    wp_register_script(
        'migy-template-modal-js',
        MIGY_JS_URI . '/modal.js',
        array( 'jquery' ),
        MIGY_VERSION,
        true
    );

    wp_localize_script(
        'migy-template-modal-js',
        'migy_template_modal_js',
        array(
            'admin_ajax'                =>  admin_url( 'admin-ajax.php' ),
            'migy_plugin_assets_url'    => MIGY_PLUGIN_ASSEST,
            'search_icon'               => MIGY_PLUGIN_ASSEST . 'images/search.png',
            'nonce'                     => wp_create_nonce( 'migy_template_modal_nonce_action' )
        )
    );
    wp_enqueue_script( 'migy-template-modal-js' );

    wp_enqueue_style('migy-template-modal-css', MIGY_CSS_URI . '/template-modal.css', array(), MIGY_VERSION);
}

add_action( 'enqueue_block_editor_assets', 'migy_enqueue_block_editor_assets' );