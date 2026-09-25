<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

<meta http-equiv="Content-Type" content="<?php echo esc_attr(get_bloginfo('html_type')); ?>; charset=<?php echo esc_attr(get_bloginfo('charset')); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.2, user-scalable=yes" />

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php
	if ( function_exists( 'wp_body_open' ) )
	{
		wp_body_open();
	}else{
		do_action('wp_body_open');
	}
?>

<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'professional-cv-resume' ); ?></a>

<?php if(get_theme_mod('professional_cv_resume_site_loader',false)!= ''){ ?>
    <?php if(get_theme_mod( 'professional_cv_resume_preloader_type','four-way-loader') == 'four-way-loader'){ ?>
	    <div class="cssloader">
	    	<div class="sh1"></div>
	    	<div class="sh2"></div>
	    	<h1 class="lt"><?php esc_html_e( 'loading',  'professional-cv-resume' ); ?></h1>
	    </div>
    <?php }else if(get_theme_mod( 'professional_cv_resume_preloader_type') == 'cube-loader') {?>
		<div class="cssloader">
    		<div class="loader-main ">
				<div class="triangle35b"></div>
				<div class="triangle35b"></div>
				<div class="triangle35b"></div>
			</div>
    	</div>
    <?php }?>
<?php }?>

<header id="site-navigations" class="wow fadeInDown">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-4 col-sm-4 col-8">
				<div class="logo text-center text-md-start">
		    		<div class="logo-image">
		    			<?php the_custom_logo() ; ?>
			    	</div>
			    	<div class="logo-content">
				    	<?php
				    		if ( get_theme_mod('professional_cv_resume_display_header_title', true) == true ) :
					      		echo '<a href="' . esc_url(home_url('/')) . '" title="' . esc_attr(get_bloginfo('name')) . '">';
					      			echo esc_html(get_bloginfo('name'));
					      		echo '</a>';
					      	endif;

					      	if ( get_theme_mod('professional_cv_resume_display_header_text', false) == true ) :
				      			echo '<span>'. esc_html(get_bloginfo('description')) . '</span>';
				      		endif;
			    		?>
					</div>
				</div>
			</div>
			<div class="col-lg-9 col-md-8 col-4 col-sm-8 text-center align-self-center">
				<div class="top-menu-wrapper">
				    <div class="navigation_header">
				        <div class="toggle-nav mobile-menu">
				            <button onclick="professional_cv_resume_openNav()">
				                <span class="dashicons dashicons-menu"></span>
				            </button>
				        </div>
				        <div id="mySidenav" class="nav sidenav">
				            <nav id="site-navigation" class="main-navigation navbar navbar-expand-xl" aria-label="<?php esc_attr_e( 'Top Menu', 'professional-cv-resume' ); ?>">
				                <?php {
				                    wp_nav_menu(
				                        array(
				                            'theme_location' => 'main-menu',
				                            'container_class' => 'navi clearfix navbar-nav',
				                            'menu_class'     => 'menu clearfix',
				                            'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				                            'fallback_cb'    => 'wp_page_menu',
				                        )
				                    );
				                } ?>
				            </nav>
				            <a href="javascript:void(0)" class="closebtn mobile-menu" onclick="professional_cv_resume_closeNav()">
				                <span class="dashicons dashicons-no"></span>
				            </a>
				        </div>
				    </div>
				</div>
			</div>
		</div>
	</div>
</header>
