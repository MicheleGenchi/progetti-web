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

// Risolve problem request ftp access
define('FS_METHOD', 'direct');

// ** Impostazioni database - È possibile ottenere queste informazioni dal proprio fornitore di hosting ** //
/** Il nome del database di WordPress */
define( 'DB_NAME', 'swp1234567-prod' );

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
define( 'AUTH_KEY',         '{vR#L1+ctf;,*T4M0ytjT:Xt4_G^y>~c,]x#9}aPb[mvw0bYJ],;!Zd~,4)u1NfD' );
define( 'SECURE_AUTH_KEY',  'ex&NW)Mi#vc<pqw^KmU5+|]PTqcq!pZE> ?|{icuE*aASwWgCOYu&I2%*;<BUA&s' );
define( 'LOGGED_IN_KEY',    '(l^st`vsIM&.i,uJ%`PfWX6RH,a2Yv_O5_WvEel$abbh4-iA_JWs_#08J./]*~G|' );
define( 'NONCE_KEY',        'fC)QZeM.C?V>TAl8;S?IoWH!:{/!fLHuo>9|>I9Z`+q1L+{AxnsFr~dmU#(:3K{=' );
define( 'AUTH_SALT',        'l x9t]R:}ch;aak.y(Zn=8%6wfY=4~`UD@bWdz7?p&r.NIHgVQgqj9;kjIY0P958' );
define( 'SECURE_AUTH_SALT', ',}(ea$tJ J5.FR<bg#5xff#fzd@8 UG0fl 3Y``?{Jj&|@>`ZCn1PID.d:n|MCFn' );
define( 'LOGGED_IN_SALT',   'l2g!Y$/a+yy{5:pqQJc<Ozf#;T>@msQ#@ovs 4Cf}NH$7ZA4W{tG.>G~zf4Ma1dA' );
define( 'NONCE_SALT',       'epq]Z9s&}HSGC~$Uo^DQ#{.?!f/8P&L=bz|2j1fvozR:@Vg U~N$+_K1KzOW?-rG' );

/**#@-*/

/**
 * Prefisso tabella del database WordPress.
 *
 * È possibile avere installazioni multiple su di un unico database
 * fornendo a ciascuna installazione un prefisso univoco. Solo numeri, lettere e trattini bassi!
 */
$table_prefix = 'wpmlnt_';

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
