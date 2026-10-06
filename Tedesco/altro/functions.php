<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'astra-theme-css' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );

// END ENQUEUE PARENT ACTION

// Registra il tipo di post personalizzato per gli oggetti
add_action('init', 'registra_tipo_post_personalizzato');

function registra_tipo_post_personalizzato() {
    $labels = array(
        'name' => 'Oggetti', // Nome plurale degli oggetti
        'singular_name' => 'Oggetto', // Nome singolare dell'oggetto
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-car', // Icona da visualizzare nel menu
        'supports' => array('title', 'thumbnail'), // Campi supportati per l'oggetto
    );

    register_post_type('prodotti', $args); // Sostituisci 'carica_oggetti' con l'ID univoco del tipo di post
}

// Aggiungi i campi personalizzati agli oggetti
add_action('add_meta_boxes', 'aggiungi_campi_personalizzati');

function aggiungi_campi_personalizzati() {
    add_meta_box(
        'campi_personalizzati',
        'Campi Personalizzati',
        'mostra_campi_personalizzati',
        'prodotti',
        'normal',
        'default'
    );
}
function mostra_campi_personalizzati($post) {
    // Recupera i valori correnti dei campi personalizzati, se presenti
    $prezzoGG = get_post_meta($post->ID, 'prezzoGG', true);
    $prezzoTratta = get_post_meta($post->ID, 'prezzoTratta', true);
    $tipo = get_post_meta($post->ID, 'tipo', true);
    
    // Mostra i campi personalizzati
    ?>
    <table class="form-table">
        <tr>
            <th><label for="prezzoGG">Prezzo GG:</label></th>
            <td><input type="number" name="prezzoGG" id="prezzoGG" value="<?php echo esc_attr($prezzoGG); ?>" /></td>
        </tr>
        <tr>
            <th><label for="prezzoTratta">Prezzo Tratta:</label></th>
            <td><input type="number" name="prezzoTratta" id="prezzoTratta" value="<?php echo esc_attr($prezzoTratta); ?>" /></td>
        </tr>
        <tr>
            <th><label for="tipo">Tipo veicolo:</label></th>
            <td>
            <select name="tipo" id="tipo">
                <?php
                if ($tipo==""){
                    echo '<option value="" disabled selected>Select your option</option>';
                }else{
                    echo '<option value="'.esc_attr($tipo).'" selected>'.esc_attr(tipo).'</option>';
                }
                ?>                
                <option value="pulmino">Pulmino</option>
                <option value="elicottero">Elicottero</option>
                <option value="macchina">Macchina</option>
            </select>
        </tr>
        <!-- Aggiungi altre righe per campi personalizzati aggiuntivi -->
    </table>
    <?php
}

// Salvataggio dei valori dei campi personalizzati
add_action('save_post', 'salva_valori_campi_personalizzati');

function salva_valori_campi_personalizzati($post_id) {
    $campi_personalizzati = array('prezzoGG', 'prezzoTratta');

    foreach ($campi_personalizzati as $campo) {
        if (isset($_POST[$campo])) {
            update_post_meta($post_id, $campo, intval($_POST[$campo]));
        }
    }
    if (isset($_POST['tipo'])) {
        update_post_meta($post_id,'tipo', strval($_POST['tipo']));
    }
    

    // Puoi salvare gli altri campi personalizzati aggiunti precedentemente
}


// Aggiungi colonne personalizzate nella tabella degli oggetti
add_filter('manage_prodotti_posts_columns', 'aggiungi_colonne_personalizzate');

function aggiungi_colonne_personalizzate($columns) {
    $new_columns = array(
        'cb' => $columns['cb'],
        'thumbnail' => 'Thumbnail',
        'title' => $columns['title'],
        'prezzoGG' => 'Prezzo GG',
        'prezzoTratta' => 'Prezzo Tratta',
        'tipo' => 'Tipo',
        'date' => $columns['date'],
    );
    return $new_columns;
}


// Mostra i valori dei campi personalizzati e le miniature
add_action('manage_prodotti_posts_custom_column', 'mostra_valori_colonne_personalizzate', 10, 2);

function mostra_valori_colonne_personalizzate($column, $post_id) {
    switch ($column) {
        case 'thumbnail':
            echo get_the_post_thumbnail($post_id, array(50, 50));
            break;
        case 'prezzoGG':
            echo get_post_meta($post_id, 'prezzoGG', true);
            break;
        case 'prezzoTratta':
            echo get_post_meta($post_id, 'prezzoTratta', true);
            break;
        case 'tipo':
            echo get_post_meta($post_id, 'tipo', true);
            break;
        // Aggiungi altri casi per i campi personalizzati aggiuntivi
    }
}

function mostra_prodotti($atts) {
    $atts = array_change_key_case( (array) $atts, CASE_LOWER );
    $atts = shortcode_atts(array(
        'num_post' => -1,
        'offset' => 0,
        'size' => array(150, 150),
		'type'=>"all"
    ), $atts);
    
    $args = array(
        'post_type' => 'prodotti',
        'posts_per_page' => $atts['num_post'],
        'offset' => $atts['offset'],
    );

    #if ($atts['type']!= 'all'){
    #    $args['meta_key']='tipo';
    #    $args['meta_value']=$atts['type'];
    #}
    
    if( isset($_GET['tipo'])){
        $args['meta_key']='tipo';
        $args['meta_value']=$_GET['tipo'];
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $output = '<ul class="card-list">';
        while ($query->have_posts()) {
            $query->the_post();
            $prezzoGG = get_post_meta(get_the_ID(), 'prezzoGG', true);
            $prezzoTratta = get_post_meta(get_the_ID(), 'prezzoTratta', true);
            $output .= '<li class="card">';
            if (has_post_thumbnail()) {
                $output .= '<div class="card-thumbnail">' . get_the_post_thumbnail(get_the_ID(), $atts['size']) . '</div>';
            }
            $output .= '<div class="card-content">';
            $output .=  get_the_title() ;
            $output .= '<p class="card-price">Prezzo GG: ' . $prezzoGG . '</p>';
            $output .= '<p class="card-price">Prezzo Tratta: ' . $prezzoTratta . '</p>';
            $output .= '</div>';
            $output.='
            <form method="get" action="/prenota">
                <input type="hidden" name="veicolo" value="'.get_the_title().'" />
                <input type="hidden" name="prezzoGG" value="'.$prezzoGG.'" />
                <label for="inizio">Inizio Noleggio:</label>
                <input type="date" name="inizio" value="" min="'.date("Y-m-d",strtotime("now+1 day")).'"><br>
                <label for="fine">Fine Noleggio:</label>
                <input type="date" name="fine" value="" min="'.date("Y-m-d",strtotime("now+1 day")).'"><br>
                <input type="submit" value="Prenota">
            </form>
            ';
            $output .= '</li>';
        }
        $output .= '</ul>';
        wp_reset_postdata();
        return $output;
    }
}
add_shortcode('mostra_prodotti', 'mostra_prodotti');

function custom_login_redirect() {

return 'https://romagoldclub.it';

}

add_filter('login_redirect', 'custom_login_redirect');

