<?php
if (!defined('ABSPATH'))
	exit;
?>
<div class="migy-img-viewer migy-img-viewer-<?php echo esc_attr($id); ?>" gallery_id="<?php echo esc_attr($id); ?>">
	<?php
	$migy_gallery_type = !empty(get_post_meta($id, 'migy_gallery_type', true)) ? get_post_meta($id, 'migy_gallery_type', true) : 'image_gallery';
	$gallery_items = !empty(get_post_meta($id, 'migy_gallery_items', true)) ? get_post_meta($id, 'migy_gallery_items', true) : array();
	$migy_masonry_layout = !empty(get_post_meta($id, 'migy_masonry_layout', true)) ? get_post_meta($id, 'migy_masonry_layout', true) : '';
	$migy_gallery_column = !empty(get_post_meta($id, 'migy_gallery_column', true)) ? get_post_meta($id, 'migy_gallery_column', true) : 'three-column';
	$migy_gallery_item_space = !empty(get_post_meta($id, 'migy_gallery_item_space', true)) ? get_post_meta($id, 'migy_gallery_item_space', true) : 'five-px';
	$migy_border_radius = !empty(get_post_meta($id, 'migy_border_radius', true)) ? get_post_meta($id, 'migy_border_radius', true) : '0';
	//new
	$migy_hover_effect = !empty(get_post_meta($id, 'migy_hover_effect', true)) ? get_post_meta($id, 'migy_hover_effect', true) : 'none';



	$filter_wrapper_class = 'migy-image-gallery-wrapper';
	if ($migy_gallery_type == 'filterable_gallery') {
		$filter_wrapper_class = 'migy-filter-gallery-wrapper';
	}
	if ($migy_masonry_layout == 'yes') {
		$migy_gallery_layout = 'migy_masonry_layout';
	} else {
		$migy_gallery_layout = 'migy_grid_layout';
	}
	?>
	<div class="<?php echo esc_attr($filter_wrapper_class); ?>">
		<?php
		if ($migy_gallery_type == 'filterable_gallery') {
			include 'filter-buttons.php';
		}
		?>

		<div id="migy_gallery_images_<?php echo esc_attr($id); ?>"
			class="migy_gallery_images migy_zoom_gallery <?php echo esc_attr($migy_gallery_layout); ?> <?php echo esc_attr($migy_gallery_column); ?> <?php echo esc_attr($migy_gallery_item_space); ?>">
			
			<?php if ($migy_masonry_layout == 'yes'): ?>
			<?php endif; ?>
			<?php
			$display_image_title = !empty(get_post_meta($id, 'migy_display_image_title', true)) ? get_post_meta($id, 'migy_display_image_title', true) : '';
			$display_image_description = !empty(get_post_meta($id, 'migy_display_image_description', true)) ? get_post_meta($id, 'migy_display_image_description', true) : '';

			foreach ($gallery_items as $gallery_item) {
				$image_url = $gallery_item['image_url'];
				$image_title = $gallery_item['image_title'];
				$image_description = $gallery_item['image_description'];
				$image_alt = !empty($gallery_item['image_alt']) ? $gallery_item['image_alt'] : $image_title;
				$filter_categories = '';

				if ($migy_gallery_type == 'filterable_gallery') {
					$category_ids = !empty($gallery_item['filter_category']) ? $gallery_item['filter_category'] : array();

					if (!empty($category_ids)) {

						$slugs = array();
						foreach ($category_ids as $category_id) {
							$term = get_term_by('id', $category_id, 'migy-filter-category');
							if ($term != null) {
								$slugs[] = $term->slug;
							}
						}

						$filter_categories = implode(' ', $slugs);

						if ($image_url) {
							include 'image-loop.php';
						}
					}

				} else {
					if ($image_url) {
						include 'image-loop.php';
					}
				}
			}
			?>
		</div>
	</div>
</div>