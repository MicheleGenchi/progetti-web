<?php
/**
 * Il file base di configurazione di WordPress.
 *
 * Questo file viene utilizzato, durante l’installazione, dallo script
 * di creazione di wp-config.php. Non è necessario utilizzarlo solo via web
 * puoi copiare questo file in «wp-config.php» e riempire i valori corretti.
 *
 * Questo file definisce le seguenti configurazioni:
 *
 * * Impostazioni del database
 * * Chiavi segrete
 * * Prefisso della tabella
 * * ABSPATH
 *
 * * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Impostazioni database - È possibile ottenere queste informazioni dal proprio fornitore di hosting ** //
/** Il nome del database di WordPress */
define( 'DB_NAME', 'cv_michelegenchi' );

/** Nome utente del database */
define( 'DB_USER', 'root' );

/** Password del database */
define( 'DB_PASSWORD', 'root' );

/** Hostname del database */
define( 'DB_HOST', 'localhost' );

/** Charset del Database da utilizzare nella creazione delle tabelle. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Il tipo di collazione del database. Da non modificare se non si ha idea di cosa sia. */
define( 'DB_COLLATE', '' );

/**#@+
 * Chiavi univoche di autenticazione e di sicurezza.
 *
 * Modificarle con frasi univoche differenti!
 * È possibile generare tali chiavi utilizzando {@link https://api.wordpress.org/secret-key/1.1/salt/ servizio di chiavi-segrete di WordPress.org}
 *
 * È possibile cambiare queste chiavi in qualsiasi momento, per invalidare tutti i cookie esistenti.
 * Ciò forzerà tutti gli utenti a effettuare nuovamente l'accesso.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'hnqT+GXl;AKF0qL R)^@uxK^07{h43[dJcyu.I;3vx`$*OJ>vR:5MOh[QLTV/sXX' );
define( 'SECURE_AUTH_KEY',  '[;9vO>3xWx<2jN32CD3aE~.8c]~tq*h<_/|+nmzCQ0UO4LpZU;5q EHi@{tgJ_]M' );
define( 'LOGGED_IN_KEY',    '6m<8(;z(8|LSH#g[tIQH%J_?o(X;P(xr=dGYU;++@AP sS|a0}qAzc84.pQv_?^o' );
define( 'NONCE_KEY',        '<(m4x3a}%k6kxI6Ydcrl8+VTKeb6@R>/tZV6a&@deW]<sDvc@3b xhND#`@|@ltN' );
define( 'AUTH_SALT',        '7y<Mrp|wnukpbe}]wA>Y&n:hY^qD+.Dsbb?S.$sX`o#D_9H9|p90 N_Fo`3<zd!]' );
define( 'SECURE_AUTH_SALT', ':8|{zj[wh4z;sgj>W<xI^Udl[7/4l$w&}(vA#.JBB9A^!nyU;b?<,,V:9C!hB6(8' );
define( 'LOGGED_IN_SALT',   'p8-wG`fNnO^O@jt,*L>fN)9Mr=f}tIjHsb:m-=9RNzIM&StevipM.DS*=[njvm;t' );
define( 'NONCE_SALT',       '(%YauK_kCkjNIGzS{#80SG_4Sn9SibR*zbc{qVswuxF+=?MNn+)M_9*+)%-=k34|' );

/**#@-*/

/**
 * Prefisso tabella del database WordPress.
 *
 * È possibile avere installazioni multiple su di un unico database
 * fornendo a ciascuna installazione un prefisso univoco. Solo numeri, lettere e trattini bassi!
 */
$table_prefix = 'wp_';

/**
 * Per gli sviluppatori: modalità di debug di WordPress.
 *
 * Modificare questa voce a TRUE per abilitare la visualizzazione degli avvisi durante lo sviluppo
 * È fortemente raccomandato agli svilupaptori di temi e plugin di utilizare
 * WP_DEBUG all’interno dei loro ambienti di sviluppo.
 *
 * Per informazioni sulle altre costanti che possono essere utilizzate per il debug,
 * leggi la documentazione
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Aggiungere qualsiasi valore personalizzato tra questa riga e la riga "Finito, interrompere le modifiche". */



/* Finito, interrompere le modifiche! Buona pubblicazione. */

/** Path assoluto alla directory di WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Imposta le variabili di WordPress ed include i file. */
require_once ABSPATH . 'wp-settings.php';
