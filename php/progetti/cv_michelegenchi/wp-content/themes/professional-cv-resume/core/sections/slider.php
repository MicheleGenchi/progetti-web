<?php if ( get_theme_mod('professional_cv_resume_blog_box_enable',false) ) : ?>

<?php $professional_cv_resume_args = array(
  'post_type' => 'post',
  'post_status' => 'publish',
  'category_name' =>  get_theme_mod('professional_cv_resume_blog_slide_category'),
  'posts_per_page' => get_theme_mod('professional_cv_resume_blog_slide_number'),
); ?>

<div class="slider">
  <div class="owl-carousel">
    <?php $professional_cv_resume_arr_posts = new WP_Query( $professional_cv_resume_args );
    if ( $professional_cv_resume_arr_posts->have_posts() ) :
      while ( $professional_cv_resume_arr_posts->have_posts() ) :
        $professional_cv_resume_arr_posts->the_post();
        ?>
        <div class="blog_inner_box wow fadeInRight">
           <?php
            if ( has_post_thumbnail() ) :
              the_post_thumbnail();
            else:
              ?>
              <div class="slider-alternate">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/banner.png'; ?>">
              </div>
              <?php
            endif;
          ?>
          <div class="blog_box pt-3 pt-md-0">
            <?php if ( get_theme_mod('professional_cv_resume_slider_extra_heading') ) : ?>
              <h5><?php echo esc_html(get_theme_mod('professional_cv_resume_slider_extra_heading'));?></h5>
            <?php endif; ?>
            <?php if ( get_theme_mod('professional_cv_resume_title_unable_disable',true) ) : ?>
              <h3 class="my-3"><?php the_title(); ?></a></h3>
            <?php endif; ?>
            <p class="mb-0"><?php echo wp_trim_words( get_the_content(), 20 ); ?></p>
            <?php if ( get_theme_mod('professional_cv_resume_button_unable_disable',true) ) : ?>
              <p class="slider-button mt-4">
                <a class="slide-btn-1" href="<?php echo esc_url(get_permalink($post->ID)); ?>"><?php esc_html_e('My Resume','professional-cv-resume'); ?></a>
                <?php if( get_theme_mod( 'professional_cv_resume_slider_button_2_link' ) != '') { ?>
                <a class="slide-btn-2" target="_blank" href="<?php echo esc_url( get_theme_mod( 'professional_cv_resume_slider_button_2_link','' ) ); ?>"><?php esc_html_e('Project','professional-cv-resume'); ?><i class="fas fa-hand-point-up ms-3"></i></a>
                <?php } ?>
              </p>
            <?php endif; ?>
            <div class="social-links mt-4">
              <?php $professional_cv_resume_settings = get_theme_mod( 'professional_cv_resume_social_links_settings' ); ?>
              <?php if ( is_array($professional_cv_resume_settings) || is_object($professional_cv_resume_settings) ){ ?>
                <span><?php esc_html_e('Follow Me -','professional-cv-resume'); ?></span>
                <?php foreach( $professional_cv_resume_settings as $professional_cv_resume_setting ) { ?>
                  <a href="<?php echo esc_url( $professional_cv_resume_setting['link_url'] ); ?>">
                    <i class="<?php echo esc_attr( $professional_cv_resume_setting['link_text'] ); ?>"></i>
                  </a>
                <?php } ?>
              <?php } ?>
            </div>
          </div>
          <div class="phone-box">
            <?php if ( get_theme_mod('professional_cv_resume_header_phone_text') || get_theme_mod('professional_cv_resume_header_phone_number') ) : ?>
              <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 align-self-center">
                  <i class="fas fa-phone"></i>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 align-self-center">
                  <h6><?php echo esc_html( get_theme_mod('professional_cv_resume_header_phone_text' ) ); ?></h6>
                  <p class="mb-0"><a href="callto:<?php echo esc_html(get_theme_mod('professional_cv_resume_header_phone_number','')); ?>"><?php echo esc_html(get_theme_mod('professional_cv_resume_header_phone_number','')); ?></a></p>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>
      <?php
    endwhile;
    wp_reset_postdata();
    endif; ?>
  </div>
</div>

<?php endif; ?>
