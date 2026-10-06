<?php 
	if ( ! defined( 'ABSPATH' ) ) exit;
	if($migy_masonry_layout == 'yes'){
		$migy_gallery_item_class = 'migy-masonry-gallery-item';
	} else {
		$migy_gallery_item_class = 'migy-grid-gallery-item';
	}

	$migy_item_meta_class = '';
	if($display_image_description == 'yes' && !empty($image_description)){
		$migy_item_meta_class = 'migy-item-meta-with-description';
	}

	$migy_hover_effect = !empty(get_post_meta($id, 'migy_hover_effect', true)) ? get_post_meta($id, 'migy_hover_effect', true) : 'none';
	$migy_gallery_padding = !empty(get_post_meta($id, 'migy_gallery_padding', true)) ? intval(get_post_meta($id, 'migy_gallery_padding', true)) : 15;

	$migy_meta_bg_color = !empty(get_post_meta($id, 'migy_meta_bg_color', true)) ? get_post_meta($id, 'migy_meta_bg_color', true) : '#000000';
	$migy_meta_bg_opacity = !empty(get_post_meta($id, 'migy_meta_bg_opacity', true)) ? intval(get_post_meta($id, 'migy_meta_bg_opacity', true)) : 51;

	$opacity_decimal = $migy_meta_bg_opacity / 100;
	$hex = ltrim($migy_meta_bg_color, '#');
	if (strlen($hex) == 3) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}
	$r = hexdec(substr($hex, 0, 2));
	$g = hexdec(substr($hex, 2, 2));
	$b = hexdec(substr($hex, 4, 2));
	
	$migy_meta_bg_rgba = "rgba($r, $g, $b, $opacity_decimal)";
?>
<div class="migy-gallery-item <?php echo esc_attr($migy_gallery_item_class); ?> <?php echo esc_attr($filter_categories); ?> migy-hover-<?php echo esc_attr($migy_hover_effect); ?>" style="padding: <?php echo esc_attr($migy_gallery_padding); ?>px;">
	<img src="<?php echo esc_url($image_url) ?>" alt="<?php echo esc_attr($image_alt); ?>">
	<?php if(($display_image_title == 'yes' && !empty($image_title)) || ($display_image_description == 'yes' && !empty($image_description))): ?>
	<div class="migy-item-meta <?php echo esc_attr($migy_item_meta_class); ?>" style="background: <?php echo esc_attr($migy_meta_bg_rgba); ?>;">
		<?php if($display_image_title == 'yes' && !empty($image_title)): ?>
		<h2 class="migy-image-title"><?php echo esc_html($image_title); ?></h2>
		<?php endif; ?>
		
		<?php if($display_image_description == 'yes' && !empty($image_description)): ?>
		<p class="migy-image-description"><?php echo esc_html($image_description); ?></p>
		<?php endif; ?>
	</div>
	<?php endif; ?>
</div>