<?php

// Services Meta Data
function professional_cv_resume_custom_meta_services_rating() {
    add_meta_box( 
    	'bn_meta', __( 'Services Meta Feilds', 'professional-cv-resume' ), 
    	'professional_cv_resume_meta_callback_services_rating', 
    	'post', 
    	'normal', 
    	'high' 
    );
}

/* Hook things in for admin*/
if (is_admin()){
  add_action('admin_menu', 'professional_cv_resume_custom_meta_services_rating');
}

function professional_cv_resume_meta_callback_services_rating( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'professional_cv_resume_meta_nonce_services_rating' );
    $bn_stored_meta = get_post_meta( $post->ID );
    $professional_cv_resume_service_rating = get_post_meta( $post->ID, 'professional_cv_resume_rating', true );
    ?>
    <div id="services_icon_meta">
        <table id="list">
            <tbody id="the-list" data-wp-lists="list:meta">
                <tr id="meta-8">
                    <td class="left">
                        <h3 style="margin:0"><?php esc_html_e( 'Services Rating', 'professional-cv-resume' )?></h3>
                        <input type="text" placeholder="4.9" name="professional_cv_resume_rating" id="professional_cv_resume_rating" value="<?php echo esc_attr($professional_cv_resume_service_rating); ?>" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php
}

/* Saves the custom meta input */
function professional_cv_resume_meta_save_services_rating( $post_id ) {
    if (!isset($_POST['professional_cv_resume_meta_nonce_services_rating']) || !wp_verify_nonce( strip_tags( wp_unslash( $_POST['professional_cv_resume_meta_nonce_services_rating']) ), basename(__FILE__))) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Save Package Amount
    if( isset( $_POST[ 'professional_cv_resume_rating' ] ) ) {
        update_post_meta( $post_id, 'professional_cv_resume_rating', strip_tags( wp_unslash( $_POST[ 'professional_cv_resume_rating' ]) ) );
    }   
}
add_action( 'save_post', 'professional_cv_resume_meta_save_services_rating' );