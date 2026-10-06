(function ($) {
	"use strict";
	// Tab scripts
	$(document).ready(function () {
		$('.migy-content-and-style-tabs ul li').on('click', function () {
			$('.migy-content-and-style-tabs ul li').removeClass('migy-tab-active');
			$(this).addClass('migy-tab-active');

			if ($(this).hasClass('migy-tab-content')) {
				$('.migy-tab-data-styles').hide();
				$('.migy-tab-data-shortcode').hide();
				$('.migy-tab-data-contents').show();
			}
			if ($(this).hasClass('migy-tab-style')) {
				$('.migy-tab-data-contents').hide();
				$('.migy-tab-data-shortcode').hide();
				$('.migy-tab-data-styles').show();
			}
			if ($(this).hasClass('migy-tab-shortcode')) {
				$('.migy-tab-data-contents').hide();
				$('.migy-tab-data-styles').hide();
				$('.migy-tab-data-shortcode').show();
			}
		});




	});

	// Uploading files
	$(document).on('click', '.migy-gallery-image-upload', function (e) {
		var gallery_image_file_frame;
		e.preventDefault();

		var imageTag = $(this).parents('.migy-field-item').find('.migy-gallery-perview-image');
		var imageUrl = $(this).parents('.migy-image-field-wrapper').find('input.migy-image-url');

		// If the media frame already exists, reopen it.
		if (gallery_image_file_frame) {
			gallery_image_file_frame.open();
			return;
		}

		// Create the media frame.
		gallery_image_file_frame = wp.media.frames.gallery_image_file_frame = wp.media({
			title: jQuery(this).data('uploader_title'),
			button: {
				text: jQuery(this).data('uploader_button_text'),
			},
			multiple: false // Set to true to allow multiple files to be selected
		});

		// When a file is selected, run a callback.
		gallery_image_file_frame.on('select', function () {
			// We set multiple to false so only get one image from the uploader
			var attachment = gallery_image_file_frame.state().get('selection').first().toJSON();

			var url = attachment.url;

			imageUrl.val(url);
			imageTag.attr('src', url);
		});

		// Finally, open the modal
		gallery_image_file_frame.open();
	});

	//Replace category field name
	function migy_replace_filter_category_name_attr() {
		$("#migy-repeatable-fields .migy-field-item").each(function (index) {
			$('.migy_filter_category_field', this).find('.migy-filter-category').attr('name', 'migy_filter_category[' + index + '][]');
		});
	}

	//Fields sortable
	$(document).ready(function () {
		// Make the field sortable
		var migy_repeatable_fields = $('#migy-repeatable-fields');
		if (migy_repeatable_fields.length > 0) {
			migy_repeatable_fields.sortable({
				placeholder: "ui-state-highlight",
				start: function (event, ui) {
					var height = ui.item.height();
					ui.placeholder.height(height);

					migy_replace_filter_category_name_attr();
				},
				stop: function (event, ui) {
					migy_replace_filter_category_name_attr();
				}
			});
		}

		// Add a new field
		$('#migy-add-field').click(function (e) {
			e.preventDefault();
			//$('#uig-repeatable-fields').append($('.uig-field-item-clone').html());
			var original = document.getElementById("migy_field_item_clone");
			var clone = original.cloneNode(true);
			clone.innerHTML = clone.innerHTML.replaceAll("xxx_", "");
			document.getElementById("migy-repeatable-fields").appendChild(clone);
			migy_replace_filter_category_name_attr();
		});

		// Remove a field
		$(document).on('click', '.migy-remove-field', function (e) {
			e.preventDefault();
			$(this).parents('.migy-field-item').remove();
			migy_replace_filter_category_name_attr();
		});
	});

	$(document).on('click', '.toggle-button', function () {
		$(this).toggleClass('arrow-down-style');
		$(this).parents('.migy-field-item').find('.migy-gallery-fields-wrapper').slideToggle();
		$(this).parents('.migy-field-item').toggleClass('pad-bottom-0');
		$(this).parents('.migy-field-item').find('.migy-repeater-action-buttons').toggleClass('border-bottom-0');

	});

	$(document).ready(function () {
		$('.migy_gallery_type').on('change', function () {
			if ($(this).val() == 'filterable_gallery') {
				$('.migy_filter_category_field').removeClass('hidden-if-image-gallery');
				$('.migy_filter_category_field .migy-filter-category').addClass('migy-border-focus');
				setTimeout(function () {
					$('.migy_filter_category_field .migy-filter-category').removeClass('migy-border-focus');
				}, 500);
			} else {
				$('.migy_filter_category_field').addClass('hidden-if-image-gallery');
			}
		});

	});

	/*Copy shortcode*/
	jQuery('.migy_display_shortcode').on('click', function () {

		var copyText = this;

		if (copyText.value != '') {
			copyText.select();
			copyText.setSelectionRange(0, 99999);
			document.execCommand("copy");

			var elem = document.getElementById("migy_shortcode_copied_notice");

			var time = 0;
			var id = setInterval(copyAlert, 10);

			function copyAlert() {
				if (time == 200) {
					clearInterval(id);
					elem.style.display = 'none';
				} else {
					time++;
					elem.style.display = 'block';
				}
			}
		}

	});

	// fetch templates from live
	jQuery(document).ready(function ($) {
		var page = 1;
		var isLoading = false;

		$(window).scroll(function () {
			if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200 && !isLoading) {

				if ($('.migy-templates-wrap').length) {

					loadMoreProducts()
				}
			}
		});

		$('.migy-category-filter').on('click', function (e) {
			e.preventDefault();

			$('.migy-category-filter').removeClass('active');
			$(this).addClass('active');

			var selectedText = $(this).text();
			$('.hover-cont h4').text(selectedText);

			jQuery('.migy-loader').show();
			jQuery('.migy-loader-overlay').show();

			productsAjax('', '', $(this).attr('data-filter'), 'filter');
		});

		$('.migy-sync-btn').on('click', function (e) {
			e.preventDefault();

			$('.migy-category-filter').removeClass('active').first().addClass('active');

			jQuery('.migy-loader').show();
			jQuery('.migy-loader-overlay').show();

			productsAjax('', '', '', 'sync');
		});

		function loadMoreProducts() {
			isLoading = true;
			page++;

			const endCursor = jQuery('[name="migy-end-cursor"]').val();
			const templateSearch = jQuery('[name="migy-templates-search"]').val();
			const collection = jQuery('.migy-category-filter.active').attr('data-filter');

			productsAjax(endCursor, templateSearch, collection, 'load');
		}

		function productsAjax(endCursor, templateSearch, collection, actionValue) {

			$.ajax({
				url: migy_pagination_object.ajaxurl,
				type: 'POST',
				data: {
					action: 'migy_get_filtered_products',
					cursor: endCursor,
					search: templateSearch,
					collection: collection,
					migy_pagination_nonce: migy_pagination_object.nonce
				},
				success: function (response) {

					$('.migy-loader').hide();
					$('.migy-loader-overlay').hide();

					if (response.content) {

						isLoading = false;

						if (actionValue != 'load') {
							$('.migy-wrapper').empty();
						}

						$('.migy-wrapper').append(response.content);

						const hasNextPage = response?.pagination?.hasNextPage;
						const endCursor = response?.pagination?.endCursor;

						$('[name="migy-end-cursor"]').val(endCursor);
						if (!hasNextPage) {
							jQuery('[name="migy-end-cursor"]').val('');
							isLoading = true
						}
					}
				},
				error: function () {

					$('.migy-loader').hide();
					$('.migy-loader-overlay').hide();
				}
			});
		}

		function debounce(func, delay) {
			let timeoutId;
			return function () {
				const context = this;
				const args = arguments;
				clearTimeout(timeoutId);
				timeoutId = setTimeout(() => {
					func.apply(context, args);
				}, delay);
			};
		}

		$('body').on("input", '[name="migy-templates-search"]', debounce(function (event) {

			const templateSearch = $('[name="migy-templates-search"]').val();

			jQuery('.migy-loader').show();
			jQuery('.migy-loader-overlay').show();

			productsAjax('', templateSearch, '', 'search');

		}, 1000));
	});



}(window.jQuery));

const menuHead = document.querySelector('.hover-cont h4');
let menuBox = document.querySelector(".migy-collection-list");

function show() {
	menuBox.style.display = "block";
}

function hide() {
	menuBox.style.display = "none";
}




jQuery(document).ready(function ($) {
	$('#migy-popup-content .migy-popup-dismiss, #migy-popup-content .migy-popup-template-btn').on('click', function () {
		$.ajax({
			url: migy_ajax_object.ajaxurl,
			type: 'POST',
			data: { action: 'migy_get_notice_dismiss' },
			success: function (response) {
				$('#migy-popup-overlay').hide();
				// $('.migy-premium-floating-btn').fadeIn(); 
				$('.migy-premium-floating-btn').fadeIn().attr('style', 'display: inline-block !important; position: fixed; bottom: 20px; right: 20px; z-index: 9999; padding: 10px 15px;');
			}
		});
	});

});