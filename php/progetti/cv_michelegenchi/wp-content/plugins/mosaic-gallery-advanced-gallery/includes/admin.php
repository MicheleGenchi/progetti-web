<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit();
}

class MIGY_ADMIN_FUNCTIONS
{

	public function __construct()
	{
		add_action('add_meta_boxes', array($this, 'migy_register_meta_boxes'));
		add_action('save_post', array($this, 'migy_save_meta_box'), 10, 2);
		add_filter('manage_migy_image_gallery_posts_columns', array($this, 'migy_custom_columns'), 10);
		add_action('manage_posts_custom_column', array($this, 'migy_custom_columns_shortcode'), 10, 2);

		
	}

	/**
	 * Register meta box(es).
	 */
	public function migy_register_meta_boxes()
	{
		add_meta_box(
			'migy_gallery_metabox',
			__('Custom Gallery', 'mosaic-image-gallery'),
			array($this, 'migy_gallery_metabox_callback'),
			'migy_image_gallery'
		);
	}

	

	/**
	 * Meta box display callback.
	 *
	 * @param WP_Post $post Current post object.
	 */
	function migy_gallery_metabox_callback($post)
	{
		require_once('meta-fields.php');
	}

	public function prefix_flatten_array($array)
	{
		$flat = array();

		foreach ($array as $sub_array) {
			if (is_array($sub_array)) {
				$flat = array_merge($flat, $this->prefix_flatten_array($sub_array));
			} else {
				$flat[] = $sub_array;
			}
		}

		return $flat;
	}

	public function prefix_sanitize_categories(&$item, $key)
	{
		$item = sanitize_text_field($item);
	}

	/**
	 * Save meta box content.
	 *
	 * @param int $post_id Post ID
	 */
	public function migy_save_meta_box($post_id, $post)
	{
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return;

		if (!isset($_POST['migy_meta_box_noncename']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['migy_meta_box_noncename'])), 'migy_meta_box_nonce'))
			return;

		if (!current_user_can('edit_posts'))
			return;

		//Gallery type
		if (isset($_POST['migy_gallery_type'])) {
			update_post_meta($post_id, 'migy_gallery_type', sanitize_text_field(wp_unslash($_POST['migy_gallery_type'])));
		}

		//Gallery content: image, title, category
		$all_items = array();

		if (isset($_POST['migy_gallery_image_url'])) {

			$gallery_image_urls = array_map('esc_url_raw', wp_unslash($_POST['migy_gallery_image_url']));

			$image_titles = array();
			if (isset($_POST['migy_image_title'])) {
				$image_titles = array_map('sanitize_text_field', wp_unslash($_POST['migy_image_title']));
			}

			$image_descriptions = array();
			if (isset($_POST['migy_image_description'])) {
				$image_descriptions = array_map('sanitize_text_field', wp_unslash($_POST['migy_image_description']));
			}

			$image_alts = array();
			if (isset($_POST['migy_image_alt'])) {
				$image_alts = array_map('sanitize_text_field', wp_unslash($_POST['migy_image_alt']));
			}

			$filter_categories = array();
			if (isset($_POST['migy_filter_category']) && is_array($_POST['migy_filter_category'])) {
				$filter_categories = array_map('intval', wp_unslash($_POST['migy_filter_category']));
			}

			foreach ($gallery_image_urls as $k => $item) {
				if (isset($filter_categories[$k])) {
					$filter_category = array_map('intval', (array) $filter_categories[$k]);
				} else {
					$filter_category = array();
				}

				$all_items[] = array(
					'image_url' => $item,
					'image_title' => isset($image_titles[$k]) ? $image_titles[$k] : '',
					'image_description' => isset($image_descriptions[$k]) ? $image_descriptions[$k] : '',
					'image_alt' => isset($image_alts[$k]) ? $image_alts[$k] : '',
					'filter_category' => $filter_category
				);
			}
		}

		$items_data = apply_filters('migy_update_gallery_items_data', $all_items);

		update_post_meta($post_id, 'migy_gallery_items', $items_data);

		//Save meta fields
		$meta_fields = $this->migy_meta_field_names();

		if (is_array($meta_fields) && !empty($meta_fields)) {
			foreach ($meta_fields as $field_name => $field_type) {
				// if (isset($_POST[$field_name])) {
				// 	update_post_meta($post_id, $field_name, sanitize_text_field(wp_unslash($_POST[$field_name])));
				// }
				if (isset($_POST[$field_name])) {
					update_post_meta($post_id, $field_name, sanitize_text_field(wp_unslash($_POST[$field_name])));
				} else {
					// Remove the meta if checkbox is unchecked
					delete_post_meta($post_id, $field_name);
				}

			}
		}

	}

	/**
	 * Posts column
	 *
	 * Name: Shortcode
	 */
	public function migy_custom_columns($columns)
	{

		$columns['migy_gallery_shortcode'] = esc_html__('Shortcode', 'mosaic-image-gallery');
		unset($columns['date']);
		$columns['date'] = __('Date', 'mosaic-image-gallery');

		return $columns;
	}

	/**
	 * Posts column
	 *
	 * Display gallery shortcode
	 */
	public function migy_custom_columns_shortcode($column_name, $id)
	{
		if ($column_name === 'migy_gallery_shortcode') {
			$shortcode = MIGY_GALLERY_SHORTCODE . ' id="' . $id . '"';
			echo "<input type='text' readonly value='[" . esc_attr($shortcode) . "]'>";
		}
	}

	/**
	 * Meta field names array
	 */
	public function migy_meta_field_names()
	{

		$fields = array(
			'migy_masonry_layout' => 'text',
			'migy_gallery_column' => 'text',
			'migy_gallery_item_space' => 'text',
			'migy_display_image_title' => 'text',
			'migy_display_image_description' => 'text',
			'migy_display_image_alt' => 'text',
			'migy_border_radius' => 'text',
			'migy_image_info_layout' => 'text',
			'migy_filter_buttons_alignment' => 'text',
			'migy_filter_all_button_text' => 'text',
			'migy_filter_button_border_radius' => 'text',
			'migy_filter_button_bg_color' => 'text',
			'migy_filter_button_text_color' => 'text',
			'migy_filter_button_active_bg_color' => 'text',
			'migy_filter_button_active_text_color' => 'text',
			'migy_hover_effect' => 'text',
			'migy_gallery_padding' => 'text',
			'migy_image_radius' => 'text',
			'migy_image_shadow' => 'text',
			'migy_title_color' => 'text',
			'migy_description_color' => 'text',
			'migy_title_font_size' => 'text',
			'migy_description_font_size' => 'text',
			'migy_title_font_family' => 'text',
			'migy_description_font_family' => 'text',
			'migy_title_alignment' => 'text',
			'migy_description_alignment' => 'text',
			'migy_meta_bg_color' => 'text',
			'migy_meta_bg_opacity' => 'text',
		);

		return apply_filters('migy_meta_field_names', $fields);
	}
}
new MIGY_ADMIN_FUNCTIONS();