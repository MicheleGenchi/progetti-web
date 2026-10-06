(function($) {
    
    wp.data.subscribe(() => {
        appendSidePanel();
    });

    function appendSidePanel() {
        if ( !$('.migy-side-panel-wrap').length ) {
            $('.components-v-stack.editor-post-panel__section').append(`<div class="migy-side-panel-wrap is-background">
                <div class="migy-side-panel-img">
                    <img src="`+ migy_editor_js.bundle_image +`" />
                </div>
                <div class="migy-side-panel-btn-wrap">
                    <a class="migy-buy-now-btn is-bundle" href="https://www.misbahwp.com/products/wordpress-bundle" target="_blank" >Buy Now</a>
                </div>
            </div>`);
        }
    }

})(jQuery);