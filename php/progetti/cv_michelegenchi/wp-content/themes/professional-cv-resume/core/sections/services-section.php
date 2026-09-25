<?php if ( get_theme_mod('professional_cv_resume_what_we_do_section_enable',false) ) : ?>

<?php $professional_cv_resume_left_args = array(
  'post_type' => 'post',
  'post_status' => 'publish',
  'category_name' =>  get_theme_mod('professional_cv_resume_what_we_do_left_category'),
  'posts_per_page' => get_theme_mod('professional_cv_resume_what_we_do_left_number'),
); ?>

	<div id="our_services" class="py-5">
		<div class="container">
			<?php if ( get_theme_mod('professional_cv_resume_what_we_do_short_heading') ) : ?>
    		<h6 class="text-center wow fadeInDown"><?php echo esc_html(get_theme_mod('professional_cv_resume_what_we_do_short_heading'));?></h6>
    	<?php endif; ?>
			<?php if ( get_theme_mod('professional_cv_resume_what_we_do_heading') ) : ?>
    		<h2 class="text-center mb-5 wow fadeInDown"><?php echo esc_html(get_theme_mod('professional_cv_resume_what_we_do_heading'));?></h2>
    	<?php endif; ?>
			<div class="row">
				<?php $professional_cv_resume_arr_posts = new WP_Query( $professional_cv_resume_left_args );
			    if ( $professional_cv_resume_arr_posts->have_posts() ) :
			      while ( $professional_cv_resume_arr_posts->have_posts() ) :
			        $professional_cv_resume_arr_posts->the_post();
			        global $post; ?>
			        <div class="col-lg-3 col-md-4 col-sm-4">
								<div class="services-box mb-4 wow zoomIn">
									<?php
				            if ( has_post_thumbnail() ) :
				              the_post_thumbnail();
				            else:
				              ?>
				              <div class="services-box">
				                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/banner.png'; ?>">
				              </div>
				              <?php
				            endif;
				          ?>
				          <div class="box-inner">
										<h3 class="mb-3"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
										<?php if( get_post_meta($post->ID, 'professional_cv_resume_rating', true) ) {?>
											<p class="mb-0"><span class="me-3"><?php echo esc_html(get_post_meta($post->ID,'professional_cv_resume_rating',true)); ?></span><?php esc_html_e('Rating Overview','professional-cv-resume'); ?></p>
			    					<?php }?>
			    				</div>
								</div>
							</div>
			    <?php
			    endwhile;
			    wp_reset_postdata();
			    endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>
