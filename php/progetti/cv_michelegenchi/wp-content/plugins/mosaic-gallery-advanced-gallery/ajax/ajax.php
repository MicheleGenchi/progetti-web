<?php

function migy_get_categories() {

    check_ajax_referer('migy_template_modal_nonce_action', 'nonce');

    $url = MIGY_API_URL . 'getCollections';
    $data = [];
    $args = [
        'method'    => 'POST',
        'body'      => json_encode($data),
        'headers'   => [
            'Content-Type' => 'application/json',
        ]
    ];
    $response = wp_remote_post($url, $args);

    if (is_wp_error($response)) {
        echo json_encode(array(
            'status'    => false,
            'code'      => 100,
            'data'      => array(),
            'msg'       => $response->get_error_message()
        ));
        exit;
    } else {
        $response_body = wp_remote_retrieve_body($response);
        $data = json_decode($response_body, true);

        echo json_encode(array(
            'status'    => true,
            'code'      => 200,
            'data'      => isset($data['data']) ? $data['data'] : array(),
            'msg'       => 'Collections data retrieved!'
        ));
        exit;
    }
}
add_action('wp_ajax_migy_get_categories', 'migy_get_categories');
add_action('wp_ajax_nopriv_migy_get_categories', 'migy_get_categories');

function migy_get_templates() {

    check_ajax_referer('migy_template_modal_nonce_action', 'nonce');

    $url = MIGY_API_URL . 'getFilteredProducts';

    $handle = isset($_POST['handle']) ? sanitize_text_field(wp_unslash($_POST['handle'])) : '';
    $search = isset($_POST['search']) ? sanitize_text_field(wp_unslash($_POST['search'])) : '';
    $cursor = !empty($_POST['cursor']) ? sanitize_text_field(wp_unslash($_POST['cursor'])) : null;

    $data = [
        "collectionHandle" => $handle,
        "productHandle" => $search,
        "paginationParams" => [
            "first" => 9,
            "afterCursor" => $cursor,
            "beforeCursor" => null,
            "reverse" => true
        ]
    ];

    $args = [
        'method'    => 'POST',
        'body'      => json_encode($data),
        'headers'   => [
            'Content-Type' => 'application/json',
        ]
    ];

    $response = wp_remote_post($url, $args);

    if (is_wp_error($response)) {
        echo json_encode(array(
            'status'    => false,
            'code'      => 100,
            'data'      => array(),
            'msg'       => $response->get_error_message()
        ));
        exit;
    } else {

        $response_body = wp_remote_retrieve_body($response);
        $data = json_decode($response_body, true);

        echo json_encode(array(
            'status'    => true,
            'code'      => 200,
            'data'      => isset($data['data']) ? $data['data'] : array(),
            'msg'       => 'Templates data retrieved!'
        ));
        exit;
    }
}
add_action('wp_ajax_migy_get_templates', 'migy_get_templates');
add_action('wp_ajax_nopriv_migy_get_templates', 'migy_get_templates');