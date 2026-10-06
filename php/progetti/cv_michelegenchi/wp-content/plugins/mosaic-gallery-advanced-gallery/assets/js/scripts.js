;(function ($) {
	'use strict';
	jQuery(document).ready(function () {

		jQuery('.migy-img-viewer').each(function () {
			var thisParent = jQuery(this);
			var GalleryId = jQuery(this).attr('gallery_id');
			var parentClass = '.migy-img-viewer-'+GalleryId +'';
			var filterTarget = jQuery('.migy-gallery-item', this);
			var filterbutton = ''+parentClass+' .migy-filter-button';

			// View a list of images
			$('' + parentClass + ' .migy_zoom_gallery').viewer({
				inline: false,
				scalable: false,
				rotatable: false,
				movable: true,
				maxZoomRatio: 3,
			});
			
			jQuery('' + parentClass + ' .migy-filter-gallery-wrapper .migy_gallery_images').mixItUp({

			  	selectors: {
					target: filterTarget,
					filter: filterbutton,
//					sort: '.sort-btn'
			  	},
				animation: {
				  	animateResizeContainer: false,
				  	effects: 'fade scale'
				}

			});

			

		});
	});



	//Wrap media buttons
	jQuery(document).on('click', '.migy-gallery-item', function () {
		jQuery('.viewer-container').each(function () {
			if (jQuery('.toolbar-top-buttons', this).length < 1) {
				jQuery('li.viewer-prev, li.viewer-play, li.viewer-next', this).wrapAll('<div class="toolbar-top-buttons"></div>');
			}
		});

	});

})(jQuery);