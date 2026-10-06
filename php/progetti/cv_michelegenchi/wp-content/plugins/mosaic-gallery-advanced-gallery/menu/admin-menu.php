<?php
add_action('admin_menu', 'migy_register_admin_menu');
function migy_register_admin_menu() {

    add_submenu_page(
        'edit.php?post_type=migy_image_gallery',
        'New Templates',
        'New Templates',
        'manage_options',
        'migy_templates',
        'migy_dashboard_page'
    );
}

function migy_get_collections() {
    
    $endpoint_url = MIGY_API_URL . 'getCollections';

    $options = [
        'body' => [],
        'headers' => [
            'Content-Type' => 'application/json'
        ]
    ];
    $response = wp_remote_post($endpoint_url, $options);

    if (!is_wp_error($response)) {
        $response_body = wp_remote_retrieve_body($response);
        $response_body = json_decode($response_body);

        if (isset($response_body->data) && !empty($response_body->data)) {

            $collections = $response_body->data;
            usort($collections, function($a, $b) {
                return strcmp($a->title, $b->title);
            });

            return $collections;
        }
        return  [];
    }

    return  [];
}

function migy_get_filtered_products($cursor = '', $search = '', $collection = 'wp-themes') {
    $endpoint_url = MIGY_API_URL . 'getFilteredProducts';

    $remote_post_data = array(
        'collectionHandle' => $collection,
        'productHandle' => $search,
        'paginationParams' => array(
            "first" => 11,
            "afterCursor" => $cursor,
            "beforeCursor" => "",
            "reverse" => true
        )
    );

    $body = wp_json_encode($remote_post_data);

    $options = [
        'body' => $body,
        'headers' => [
            'Content-Type' => 'application/json'
        ]
    ];
    $response = wp_remote_post($endpoint_url, $options);

    if (!is_wp_error($response)) {
        $response_body = wp_remote_retrieve_body($response);
        $response_body = json_decode($response_body);

        if (isset($response_body->data) && !empty($response_body->data)) {
            if (isset($response_body->data->products) && !empty($response_body->data->products)) {
                return  array(
                    'products' => $response_body->data->products,
                    'pagination' => $response_body->data->pageInfo
                );
            }
        }
        return [];
    }
    
    return [];
}

function migy_get_filtered_products_ajax() {
    $cursor = isset($_POST['cursor']) ? sanitize_text_field(wp_unslash($_POST['cursor'])) : '';
    $search = isset($_POST['search']) ? sanitize_text_field(wp_unslash($_POST['search'])) : '';
    $collection = isset($_POST['collection']) ? sanitize_text_field(wp_unslash($_POST['collection'])) : 'wp-themes';
    $collection = $collection == 'all' ? 'wp-themes' : $collection;

    check_ajax_referer('migy_create_pagination_nonce_action', 'migy_pagination_nonce');

    $get_filtered_products = migy_get_filtered_products($cursor, $search, $collection);
    ob_start();
    if (isset($get_filtered_products['products']) && !empty($get_filtered_products['products'])) {
        foreach ( $get_filtered_products['products'] as $product ) {

            $product_obj = $product->node;
                        
            // Skip products with the title "Testing"
            if ($product_obj->title === 'Testing') {
                continue;
            }

            if (isset($product_obj->inCollection) && !$product_obj->inCollection) {
                continue;
            }

            $product_obj = $product->node;

            $demo_url = isset($product->node->metafield) ? $product->node->metafield->value : '';
            $product_url = isset($product->node->onlineStoreUrl) ? $product->node->onlineStoreUrl : '';
            $image_src = isset($product->node->images->edges[0]->node->src) ? $product->node->images->edges[0]->node->src : '';
            $price = isset($product_obj->variants->edges[0]->node->price) ? '$' . $product_obj->variants->edges[0]->node->price : '';
            
            $demo_url = '';$documentation_url = '';
            if (isset($product_obj->metafields->edges)) {
                foreach ($product_obj->metafields->edges as $metafield_edge) {
                    $metafield = $metafield_edge->node;
                    if ($metafield->key === 'custom.live_demo') {
                        $demo_url = $metafield->value;
                    } elseif ($metafield->key === 'custom.view_documentationlink') {
                        $documentation_url = $metafield->value;
                    }
                }
            }
            
            ?>

            <div class="migy-box migy_filter" style="">
                <div class="migy-box-widget">
                    <div class="migy-media"  >
                        <img class="migy-product-img" src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($product_obj->title); ?>">
                        <div class="migy-product-price-wrap" style="background-image:url(<?php echo esc_url(MIGY_PLUGIN_ASSEST. 'images/price-banner.png'); ?>)">
                            <div class="migy-product-banner-wrap">
                                <p class="price-text">SALE PRICE</p>
                                <h2><?php echo esc_html($price); ?></h2>
                            </div>
                        </div>
                    </div>                                   
                    <div class="migy-template-title"><?php echo esc_html($product_obj->title); ?></div>
                    <div class="migy-btn">
                        <a href="<?php echo esc_attr($product_url); ?>" target="_blank" rel="noopener noreferrer" class="btn ins-btn installbtn"><?php echo esc_html('Buy Now'); ?></a>
                        <?php if($demo_url != '') { ?>
                            <a href="<?php echo esc_attr($demo_url); ?>" target="_blank" rel="noopener noreferrer" class="btn pre-btn previewbtn"><?php echo esc_html('Preview'); ?></a>
                        <?php } ?>
                        <?php if($documentation_url != '') { ?>
                            <a href="<?php echo esc_attr($documentation_url); ?>" target="_blank" rel="noopener noreferrer" class="btn pre-btn documentationbtn"><?php echo esc_html('Documentation'); ?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php }
    }
    $output = ob_get_clean();

    $pagination = isset($get_filtered_products['pagination']) ?  $get_filtered_products['pagination'] : [];
    wp_send_json(array(
        'content' => $output,
        'pagination' => $pagination
    ));
}

add_action('wp_ajax_migy_get_filtered_products', 'migy_get_filtered_products_ajax');
add_action('wp_ajax_nopriv_migy_get_filtered_products', 'migy_get_filtered_products_ajax');

function migy_dashboard_page() { ?>
    <div class="wrap migy-templates-wrap">
        <div class="migy-loader" style="display: none;"></div>
        <div class="migy-loader-overlay" style="display: none;"></div>
       
        <!-- new add-->
        <div class="migy-topbar">
            <span class="migy-coupon-text">
                <?php echo esc_html('SUMMER SALE - Get All Themes at Flat 20% OFF - Use Code "HEAT20"'); ?>
            </span>
            <a class="migy-topbar-buy-now" href="<?php echo esc_url(MIGY_MAIN_URL. 'collections/wp-themes'); ?>" target="_blank">
                <?php echo esc_html('Buy Now'); ?>
            </a>
        </div>
        <!-- end -->
        <div class="migy-header">
            <div class="migy-header-logo">
                <img src="<?php echo esc_url(MIGY_PLUGIN_ASSEST. 'images/logo.png'); ?>" alt="<?php echo esc_attr('Mosaic Logo'); ?>">
            </div>
            <div class="migy-header-search">
                <input type="text" name="migy-templates-search" autocomplete="off" placeholder="Search Templates...">
                <span class="dashicons dashicons-search"></span>
            </div>
            <div class="migy-collection-bar">
                <div class="hover-cont" onmouseover="show()" onmouseout="hide()">
                    <h4 ><?php echo esc_html('Collections'); ?></h4>
                    <ul class="migy-collection-list">
                        <li><a class="migy-category-filter active" data-filter="all" href="javascript:void(0)">All</a></li>
                        <?php $collections_arr = migy_get_collections();
                        foreach ( $collections_arr as $key => $collection ) {
                            
                            if ($collection->title == 'Uncategorized' || $collection->title == 'Free' || $collection->title == 'Free Wordpress Themes') {
                                continue;
                            }
                            ?>
                            <li><a href="javascript:void(0)" class="migy-category-filter" data-filter="<?php echo esc_attr($collection->handle); ?>"><?php echo esc_html($collection->title); ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div id="migy-wrap" class="migy-wrap">
            <div class="migy-wrapper">
                <?php $get_filtered_products = migy_get_filtered_products();
                    if (isset($get_filtered_products['products']) && !empty($get_filtered_products['products'])) {
                        foreach ( $get_filtered_products['products'] as $product ) {

                            $product_obj = $product->node;
                            
                            // Skip products with the title "Testing"
                            if ($product_obj->title === 'Testing') {
                                continue;
                            }

                            if (isset($product_obj->inCollection) && !$product_obj->inCollection) {
                                continue;
                            }

                            $product_obj = $product->node;

                            $price = isset($product_obj->variants->edges[0]->node->price) ? '$' . $product_obj->variants->edges[0]->node->price : '';
                            $product_url = isset($product->node->onlineStoreUrl) ? $product->node->onlineStoreUrl : '';
                            $image_src = isset($product->node->images->edges[0]->node->src) ? $product->node->images->edges[0]->node->src : '';
                            
                            $demo_url = '';$documentation_url = '';
                            if (isset($product_obj->metafields->edges)) {
                                foreach ($product_obj->metafields->edges as $metafield_edge) {
                                    $metafield = $metafield_edge->node;
                                    if ($metafield->key === 'custom.live_demo') {
                                        $demo_url = $metafield->value;
                                    } elseif ($metafield->key === 'custom.view_documentationlink') {
                                        $documentation_url = $metafield->value;
                                    }
                                }
                            }

                            ?>

                            <div class="migy-box migy_filter" style="">
                                <div class="migy-box-widget">
                                    <div class="migy-media"  >
                                        <img class="migy-product-img" src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($product_obj->title); ?>">
                                        <div class="migy-product-price-wrap" style="background-image:url(<?php echo esc_url(MIGY_PLUGIN_ASSEST. 'images/price-banner.png'); ?>)">
                                            <div class="migy-product-banner-wrap">
                                                <p class="price-text">SALE PRICE</p>
                                                <h2><?php echo esc_html($price); ?></h2>
                                            </div>
                                        </div>
                                    </div>                                   
                                    <div class="migy-template-title"><?php echo esc_html($product_obj->title); ?></div>
                                    <div class="migy-btn">
                                        <a href="<?php echo esc_attr($product_url); ?>" target="_blank" rel="noopener noreferrer" class="btn ins-btn installbtn"><?php echo esc_html('Buy Now'); ?></a>
                                        <?php if($demo_url != '') { ?>
                                            <a href="<?php echo esc_attr($demo_url); ?>" target="_blank" rel="noopener noreferrer" class="btn pre-btn previewbtn"><?php echo esc_html('Preview'); ?></a>
                                        <?php } ?>
                                        <?php if($documentation_url != '') { ?>
                                            <a href="<?php echo esc_attr($documentation_url); ?>" target="_blank" rel="noopener noreferrer" class="btn pre-btn documentationbtn"><?php echo esc_html('Documentation'); ?></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    }
                ?>
            </div>
            <?php if (isset($get_filtered_products['pagination']->hasNextPage) && $get_filtered_products['pagination']->hasNextPage) { ?>
                <input type="hidden" name="migy-end-cursor" value="<?php echo esc_attr(isset($get_filtered_products['pagination']->endCursor) ? $get_filtered_products['pagination']->endCursor : '') ?>">
            <?php } ?>
        </div>
    </div>
<?php }
