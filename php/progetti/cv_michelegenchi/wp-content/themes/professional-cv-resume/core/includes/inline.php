<?php

$professional_cv_resume_custom_css = '';

	/*---------------------------text-transform-------------------*/

	$professional_cv_resume_text_transform = get_theme_mod( 'menu_text_transform_professional_cv_resume','CAPITALISE');
    if($professional_cv_resume_text_transform == 'CAPITALISE'){

		$professional_cv_resume_custom_css .='#main-menu ul li a{';

			$professional_cv_resume_custom_css .='text-transform: capitalize ; font-size: 15px;';

		$professional_cv_resume_custom_css .='}';

	}else if($professional_cv_resume_text_transform == 'UPPERCASE'){

		$professional_cv_resume_custom_css .='#main-menu ul li a{';

			$professional_cv_resume_custom_css .='text-transform: uppercase ; font-size: 15px;';

		$professional_cv_resume_custom_css .='}';

	}else if($professional_cv_resume_text_transform == 'LOWERCASE'){

		$professional_cv_resume_custom_css .='#main-menu ul li a{';

			$professional_cv_resume_custom_css .='text-transform: lowercase ; font-size: 15px;';

		$professional_cv_resume_custom_css .='}';
	}

	/*---------------------------menu-zoom-------------------*/

		$professional_cv_resume_menu_zoom = get_theme_mod( 'professional_cv_resume_menu_zoom','None');

    if($professional_cv_resume_menu_zoom == 'None'){

		$professional_cv_resume_custom_css .='#main-menu ul li a{';

			$professional_cv_resume_custom_css .='';

		$professional_cv_resume_custom_css .='}';

	}else if($professional_cv_resume_menu_zoom == 'Zoominn'){

		$professional_cv_resume_custom_css .='#main-menu ul li a:hover{';

			$professional_cv_resume_custom_css .='transition: all 0.3s ease-in-out !important; transform: scale(1.2) !important; color: var(--first-color);';

		$professional_cv_resume_custom_css .='}';
	}

	/*---------------------------Container Width-------------------*/

$professional_cv_resume_container_width = get_theme_mod('professional_cv_resume_container_width');

		$professional_cv_resume_custom_css .='body, .page-template-frontpage #site-navigation{';

			$professional_cv_resume_custom_css .='width: '.esc_attr($professional_cv_resume_container_width).'%; margin: auto';

		$professional_cv_resume_custom_css .='}';


	/*---------------------------Slider-content-alignment-------------------*/

$professional_cv_resume_slider_content_alignment = get_theme_mod( 'professional_cv_resume_slider_content_alignment','LEFT-ALIGN');

 if($professional_cv_resume_slider_content_alignment == 'LEFT-ALIGN'){

		$professional_cv_resume_custom_css .='.blog_box{';

			$professional_cv_resume_custom_css .='text-align:left;';

		$professional_cv_resume_custom_css .='}';


	}else if($professional_cv_resume_slider_content_alignment == 'CENTER-ALIGN'){

		$professional_cv_resume_custom_css .='.blog_box{';

			$professional_cv_resume_custom_css .='text-align:center; right:30%; left:30%';

		$professional_cv_resume_custom_css .='}';


	}else if($professional_cv_resume_slider_content_alignment == 'RIGHT-ALIGN'){

		$professional_cv_resume_custom_css .='.blog_box{';

			$professional_cv_resume_custom_css .='text-align:right; right:20%; left:50%';

		$professional_cv_resume_custom_css .='}';

	}

	/*---------------------------Copyright Text alignment-------------------*/

$professional_cv_resume_copyright_text_alignment = get_theme_mod( 'professional_cv_resume_copyright_text_alignment','LEFT-ALIGN');

 if($professional_cv_resume_copyright_text_alignment == 'LEFT-ALIGN'){

		$professional_cv_resume_custom_css .='.copy-text p{';

			$professional_cv_resume_custom_css .='text-align:left;';

		$professional_cv_resume_custom_css .='}';


	}else if($professional_cv_resume_copyright_text_alignment == 'CENTER-ALIGN'){

		$professional_cv_resume_custom_css .='.copy-text p{';

			$professional_cv_resume_custom_css .='text-align:center;';

		$professional_cv_resume_custom_css .='}';


	}else if($professional_cv_resume_copyright_text_alignment == 'RIGHT-ALIGN'){

		$professional_cv_resume_custom_css .='.copy-text p{';

			$professional_cv_resume_custom_css .='text-align:right;';

		$professional_cv_resume_custom_css .='}';

	}


/*---------------------------related Product Settings-------------------*/

$professional_cv_resume_related_product_setting = get_theme_mod('professional_cv_resume_related_product_setting',true);

	if($professional_cv_resume_related_product_setting == false){

		$professional_cv_resume_custom_css .='.related.products, .related h2{';

			$professional_cv_resume_custom_css .='display: none;';

		$professional_cv_resume_custom_css .='}';
	}

	/*---------------------------Scroll to Top Alignment Settings-------------------*/

	$professional_cv_resume_scroll_top_position = get_theme_mod( 'professional_cv_resume_scroll_top_position','Right');

	if($professional_cv_resume_scroll_top_position == 'Right'){

		$professional_cv_resume_custom_css .='.scroll-up{';

			$professional_cv_resume_custom_css .='right: 20px;';

		$professional_cv_resume_custom_css .='}';

	}else if($professional_cv_resume_scroll_top_position == 'Left'){

		$professional_cv_resume_custom_css .='.scroll-up{';

			$professional_cv_resume_custom_css .='left: 20px;';

		$professional_cv_resume_custom_css .='}';

	}else if($professional_cv_resume_scroll_top_position == 'Center'){

		$professional_cv_resume_custom_css .='.scroll-up{';

			$professional_cv_resume_custom_css .='right: 50%;left: 50%;';

		$professional_cv_resume_custom_css .='}';
	}

/*---------------------------Pagination Settings-------------------*/


$professional_cv_resume_pagination_setting = get_theme_mod('professional_cv_resume_pagination_setting',true);

	if($professional_cv_resume_pagination_setting == false){

		$professional_cv_resume_custom_css .='.nav-links{';

			$professional_cv_resume_custom_css .='display: none;';

		$professional_cv_resume_custom_css .='}';
	}

	/*--------------------------- Slider Opacity -------------------*/

	$professional_cv_resume_slider_opacity_color = get_theme_mod( 'professional_cv_resume_slider_opacity_color','0.5');

	if($professional_cv_resume_slider_opacity_color == '0'){

		$professional_cv_resume_custom_css .='.blog_inner_box img{';

			$professional_cv_resume_custom_css .='opacity:0';

		$professional_cv_resume_custom_css .='}';

		}else if($professional_cv_resume_slider_opacity_color == '0.1'){

		$professional_cv_resume_custom_css .='.blog_inner_box img{';

			$professional_cv_resume_custom_css .='opacity:0.1';

		$professional_cv_resume_custom_css .='}';

		}else if($professional_cv_resume_slider_opacity_color == '0.2'){

		$professional_cv_resume_custom_css .='.blog_inner_box img{';

			$professional_cv_resume_custom_css .='opacity:0.2';

		$professional_cv_resume_custom_css .='}';

		}else if($professional_cv_resume_slider_opacity_color == '0.3'){

		$professional_cv_resume_custom_css .='.blog_inner_box img{';

			$professional_cv_resume_custom_css .='opacity:0.3';

		$professional_cv_resume_custom_css .='}';

		}else if($professional_cv_resume_slider_opacity_color == '0.4'){

		$professional_cv_resume_custom_css .='.blog_inner_box img{';

			$professional_cv_resume_custom_css .='opacity:0.4';

		$professional_cv_resume_custom_css .='}';

		}else if($professional_cv_resume_slider_opacity_color == '0.5'){

		$professional_cv_resume_custom_css .='.blog_inner_box img{';

			$professional_cv_resume_custom_css .='opacity:0.5';

		$professional_cv_resume_custom_css .='}';

		}else if($professional_cv_resume_slider_opacity_color == '0.6'){

		$professional_cv_resume_custom_css .='.blog_inner_box img{';

			$professional_cv_resume_custom_css .='opacity:0.6';

		$professional_cv_resume_custom_css .='}';

		}else if($professional_cv_resume_slider_opacity_color == '0.7'){

		$professional_cv_resume_custom_css .='.blog_inner_box img{';

			$professional_cv_resume_custom_css .='opacity:0.7';

		$professional_cv_resume_custom_css .='}';

		}else if($professional_cv_resume_slider_opacity_color == '0.8'){

		$professional_cv_resume_custom_css .='.blog_inner_box img{';

			$professional_cv_resume_custom_css .='opacity:0.8';

		$professional_cv_resume_custom_css .='}';

		}else if($professional_cv_resume_slider_opacity_color == '0.9'){

		$professional_cv_resume_custom_css .='.blog_inner_box img{';

			$professional_cv_resume_custom_css .='opacity:0.9';

		$professional_cv_resume_custom_css .='}';

		}else if($professional_cv_resume_slider_opacity_color == 'unset'){

		$professional_cv_resume_custom_css .='.blog_inner_box img{';

			$professional_cv_resume_custom_css .='opacity:unset';

		$professional_cv_resume_custom_css .='}';

		}

/*---------------------------woocommerce pagination alignment settings-------------------*/

	$professional_cv_resume_woocommerce_pagination_position = get_theme_mod( 'professional_cv_resume_woocommerce_pagination_position','Center');

	if($professional_cv_resume_woocommerce_pagination_position == 'Left'){

		$professional_cv_resume_custom_css .='.woocommerce nav.woocommerce-pagination{';

			$professional_cv_resume_custom_css .='text-align: left;';

		$professional_cv_resume_custom_css .='}';

	}else if($professional_cv_resume_woocommerce_pagination_position == 'Center'){

		$professional_cv_resume_custom_css .='.woocommerce nav.woocommerce-pagination{';

			$professional_cv_resume_custom_css .='text-align: center;';

		$professional_cv_resume_custom_css .='}';

	}else if($professional_cv_resume_woocommerce_pagination_position == 'Right'){

		$professional_cv_resume_custom_css .='.woocommerce nav.woocommerce-pagination{';

			$professional_cv_resume_custom_css .='text-align: right;';

		$professional_cv_resume_custom_css .='}';
	}

/*---------------------------Global Color-------------------*/

$professional_cv_resume_first_color = get_theme_mod('professional_cv_resume_first_color');
$professional_cv_resume_second_color = get_theme_mod('professional_cv_resume_second_color');

/*--- First Global Color ---*/

if ($professional_cv_resume_first_color) {
  $professional_cv_resume_custom_css .= ':root {';
  $professional_cv_resume_custom_css .= '--first-color: ' . esc_attr($professional_cv_resume_first_color) . ' !important;';
  $professional_cv_resume_custom_css .= '} ';
}

/*--- Second Global Color ---*/

if ($professional_cv_resume_second_color) {
  $professional_cv_resume_custom_css .= ':root {';
  $professional_cv_resume_custom_css .= '--second-color: ' . esc_attr($professional_cv_resume_second_color) . ' !important;';
  $professional_cv_resume_custom_css .= '} ';
}


/*-----------------------------------------------------------------------------------*/
/* Dark Mode */
/*-----------------------------------------------------------------------------------*/

function professional_cv_resume_body_class( $professional_cv_resume_classes ) {
    $professional_cv_resume_dark_mode_enabled = get_theme_mod( 'professional_cv_resume_is_dark_mode_enabled', false );

    if ( $professional_cv_resume_dark_mode_enabled ) {
        $professional_cv_resume_classes[] = 'dark-mode';
    }

    return $professional_cv_resume_classes;
}
add_filter( 'body_class', 'professional_cv_resume_body_class' );