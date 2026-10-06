(function($) {
    wp.data.subscribe(() => {
        appendButton();
    });

    function appendButton() {
        if (!$('.migy-templates-btn-wrap').length) {
            var migy_btn = `<div class="migy-templates-btn-wrap"><span>Templates</span></div>`;
            $('.components-accessible-toolbar.edit-post-header-toolbar').append(migy_btn);
        }
    }

    window.onload = function() {

        if (!$('.migy-templates-modal-wrap').length) {
            $('body').append(`
                <div class="templates-modal-wrap-main">
                    <div class="migy templates-modal-wrap">
                        <span class="migy-dismiss-modal">x</span>
                        <div class="migy templates-modal-search">
                            <form  class="templates-modal-form" role="search" method="get">
                                <img class="migy-search-img" src="`+ migy_template_modal_js.search_icon +`">
                                <input type="search" id="migy-template-search" name="search" placeholder="Ecommerce WordPress Theme...">
                            </form>
                        </div>
                        <div class="migy templates-modal-content-wrap">
                            <div class="migy templates-modal-content-categories">
                                <h4>Product categories</h4>
                                <ul class="migy templates-modal-categories">
                                </ul>
                            </div>
                            <div class="migy templates-modal-content-cards-wrap">
                                <div class="migy templates-modal-content-cards"></div>
                                <button class="migy templates-load-more">Load More</button>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        }

        $('body').on('click', '.migy-templates-btn-wrap', function() {
            $('.templates-modal-wrap-main').show();
        })

        $('body').on('click', '.migy-dismiss-modal', function() {
            $('.templates-modal-wrap-main').hide();
        })

        $('body').on('click', '.migy.templates-load-more', function() {

            var active_filter = '';
            if ($('.migy.templates-modal-categories li.active').length) {
                active_filter = $('.migy.templates-modal-categories li.active').attr('data-value');
            }            
            
            migy_get_templates_records( active_filter, '', $(this).attr('data-cursor'), 'basic' );
        })

        $('body').on('click', '.migy.templates-modal-categories li', function() {

            if ($(this).hasClass('active')) {
                $(this).removeClass('active');

                migy_get_templates_records( '', '', '', 'filter' )
            } else {
                $('.migy.templates-modal-categories li').removeClass('active');
                $(this).addClass('active');

                migy_get_templates_records( $(this).attr('data-value'), '', '', 'filter' )
            }
        })

        $('body').on("submit", ".templates-modal-form", function (event) {
            event.preventDefault();
        });

        $('body').on("input", "#migy-template-search", debounce(function (event) {
            event.preventDefault();
            migy_get_templates_records( '', $(this).val(), '', 'search' )
        }, 300));
    }

    migy_get_categories_records();
    migy_get_templates_records();

    function debounce(func, delay) {
        let timeoutId;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                func.apply(context, args);
            }, delay);
        };
    }

    function migy_get_categories_records() {
        $.ajax({
            method: "POST",
            url: migy_template_modal_js.admin_ajax,
            data: {
                action: 'migy_get_categories',
                nonce: migy_template_modal_js.nonce
            }
        }).done(function( data ) {

            const response = JSON.parse(data);
            if ( response.code == 200 ) {
                if (response.data.length) {
                    const categories = response.data;

                    categories.sort((a, b) => a.title.localeCompare(b.title));
                    
                    categories.map((data, index) => {                        
                        $('.migy.templates-modal-categories').append('<li data-value="' + data.handle +'">'+ data.title +'</li>');
                    });
                }                
            }
            
        })
    }

    function migy_get_templates_records( handle = '', search = '', cursor = '', action = 'basic' ) {
        
        const data = {
            handle: handle,
            search: search,
            cursor: cursor,
            action: 'migy_get_templates',
            nonce: migy_template_modal_js.nonce
        }
        
        $.ajax({
            method: "POST",
            url: migy_template_modal_js.admin_ajax,
            data: data
        }).done(function( data ) {

            const response = JSON.parse(data);
            if ( response.code == 200 ) {
                if (response.data.products.length) {
                    const templates_arr = response.data;
                    const products = templates_arr.products;
                    const pagination = templates_arr.pageInfo;
                    
                    $('.migy.templates-load-more').hide();
                    if (pagination.hasNextPage) {
                        $('.migy.templates-load-more').attr('data-cursor', pagination.endCursor);
                        $('.migy.templates-load-more').show();
                    }
                    
                    const cardContainer = $('.migy.templates-modal-content-cards');

                    if (action != 'basic') {
                        cardContainer.empty();                        
                    }

                    products.forEach((data) => {
                        const product = data.node;
                    
                        let demo_url = '';
                        let product_url = product.onlineStoreUrl || '';
                        let image_src = product.images.edges.length > 0 ? product.images.edges[0].node.src : '';
                        let price = product.variants.edges.length > 0 ? `$${product.variants.edges[0].node.price}` : '';
                    
                        if (product.hasOwnProperty('metafields') && product.metafields.edges) {
                            product.metafields.edges.forEach(metafield_edge => {
                                let metafield = metafield_edge.node;
                                if (metafield.key === 'custom.live_demo') {
                                    demo_url = metafield.value;
                                }
                            });
                        }
                    
                        var cardHtml = `
                            <div class="migy-box migy_filter">
                                <div class="migy-box-widget">
                                    <div class="migy-media">
                                        <img class="migy-product-img" src="${image_src}" alt="${product.title}">
                                        <div class="migy-product-price-wrap" style="background-image:url(`+ migy_template_modal_js.migy_plugin_assets_url +`images/price-banner.png)">
                                            <div class="migy-product-banner-wrap">
                                                <p class="price-text">SALE PRICE</p>
                                                <h2>${price}</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="migy-template-title">${product.title}</div>
                                    <div class="migy-btn">
                                        <a href="${product_url}" target="_blank" rel="noopener noreferrer" class="btn ins-btn installbtn">Buy Now</a>`;
                    
                        if (demo_url) {
                            cardHtml += `<a href="${demo_url}" target="_blank" rel="noopener noreferrer" class="btn pre-btn previewbtn">Preview</a>`;
                        }
                    
                        cardHtml += `</div>
                                </div>
                            </div>`;
                    
                        if ( !product.hasOwnProperty('inCollection') || product.inCollection ) {
                            cardContainer.append(cardHtml);                        
                        }
                    });                    
                }
            }
        });
    }

    window.onclick = function(event) {
        var modalWrap = $('.templates-modal-wrap-main');
        var modalButton = $('.migy-templates-btn-wrap');
    
        if (modalWrap.is(':visible') && !modalWrap.is(event.target) && modalWrap.has(event.target).length === 0) {
            if (!modalButton.is(event.target) && modalButton.has(event.target).length === 0) {
                modalWrap.hide();
            }
        }
    };

})(jQuery);