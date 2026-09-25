<?php get_header(); ?>

<div id="content">
	<div class="container">
		<div class="not-found py-5 text-center">
			<h1><?php echo esc_html(get_theme_mod('professional_cv_resume_404_page_title',__('404 Not Found','professional-cv-resume')));?></h1>
			<p class="text-404"><?php echo esc_html(get_theme_mod('professional_cv_resume_404_page_content',__('Sorry, no posts matched your criteria.','professional-cv-resume')));?></p>
			<?php get_search_form(); ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>