<?php
if (!defined('ABSPATH'))
	exit;

$filter_button_bg_color = !empty(get_post_meta($id, 'migy_filter_button_bg_color', true)) ? get_post_meta($id, 'migy_filter_button_bg_color', true) : '#f5f5f5';
$filter_button_text_color = !empty(get_post_meta($id, 'migy_filter_button_text_color', true)) ? get_post_meta($id, 'migy_filter_button_text_color', true) : '#222';

$filter_button_bg_active_color = !empty(get_post_meta($id, 'migy_filter_button_active_bg_color', true)) ? get_post_meta($id, 'migy_filter_button_active_bg_color', true) : '#f56616';
$filter_button_text_active_color = !empty(get_post_meta($id, 'migy_filter_button_active_text_color', true)) ? get_post_meta($id, 'migy_filter_button_active_text_color', true) : '#fff';

?>
<div class="migy-filter-buttons" data-isotope-key="filter">
	<?php
	echo '<button class="migy-filter-button active" data-filter="all">' . esc_html__('All', 'mosaic-image-gallery') . '</button>';


	$filter_category_ids = array();
	foreach ($gallery_items as $gallery_item) {

		$filter_categories = '';

		$category_ids = !empty($gallery_item['filter_category']) ? $gallery_item['filter_category'] : array();

		if (!empty($category_ids)) {

			foreach ($category_ids as $category_id) {
				$filter_category_ids[] = $category_id;
			}
		}
	}

	$filter_category_ids = array_unique($filter_category_ids);

	foreach ($filter_category_ids as $filter_category_id) {
		$term = get_term_by('id', $filter_category_id, 'migy-filter-category');
		if ($term != null) {
			echo '<button class="migy-filter-button" data-rel="' . esc_attr($term->slug) . '" data-filter=".' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</button>';
		}
	}
	?>
</div>