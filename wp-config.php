<?php
/**
 * WordPress configuration file
 */

// ** Database settings ** //
define( 'DB_NAME', 'u0949688_wp_tonirovka' );
define( 'DB_USER', 'u0949688_daniil' );
define( 'DB_PASSWORD', ',@V(~lE}=TGz' );
define( 'DB_HOST', '31.31.198.229' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

// ** Authentication keys and salts ** //
define('AUTH_KEY',         'Oq/4-flV{LtCNUx}f~A~9-H{jb):,^5XnLE0F[4~#F-L5+LVP=8pK/ {XDy`#R3o');
define('SECURE_AUTH_KEY',  '&W-]!h?ROYd=nI*s_I$UOA!E;h6;X-KnFL&KH^[47V*!70.[REgm5Ce<t`m.K(:H');
define('LOGGED_IN_KEY',    'AGDg#R$++e)S #H[QjsL81=&Y`m|&&2%]E{7O;|uAL+0E+>YPH8H|]m4?9r4AeOf');
define('NONCE_KEY',        '2UHZRu;cS>5s~ l%t}|(Y+I_HsLLZ@Od<j+lr*ft+ =+iKWy&#hsg5/P#GB0O{B+');
define('AUTH_SALT',        'l31>/J[T55d=cdSguebp+-]xG+pO|0[C12=ozFb7Qyh:Z!*wm%_G0y2~}9<->-Lh');
define('SECURE_AUTH_SALT', 'Q/J=#_}he6c4&N.[SrhEj=2%?xvJNUNhEt_kjb.s.$ScB_8=j86?@N,Vz++gSI;J');
define('LOGGED_IN_SALT',   'Lzx/1Q-<<CLhalG<?{(y}m>pRy]FzNnpcm$ev9,Cv$?51Nf-hoLV$4}_E%i+.l{>');
define('NONCE_SALT',       '0O[>*HLR`_+VNGW_>DwN#(C[Y2|fx{ict?hmDnFt6D{LpCFEH}H0AAq|}rsG*zH-');

// ** Table prefix ** //
$table_prefix = 'wp_';

// ** Debug (выключить на проде) ** //
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_LOG', false );
define( 'WP_DEBUG_DISPLAY', false );

// ** Дополнительные настройки ** //
define( 'WP_MEMORY_LIMIT', '256M' );
define( 'DISALLOW_FILE_EDIT', true ); // Отключает редактор файлов в админке

// Разрешённые домены — сайт работает на обоих + localhost для Docker
$allowed_hosts = [
	'xn--c1ajfmabcc0byi.xn--p1ai',
	'xn--e1aybc.xn--c1ajfmabcc0byi.xn--p1ai',
	'oknaplenka.ru',
	'localhost',
	'127.0.0.1',
];
$host = $_SERVER['HTTP_HOST'] ?? '';
$host_base = preg_replace( '/:\d+$/', '', $host );
$base_url = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http' ) . '://' . $host;
if ( in_array( $host, $allowed_hosts, true ) || in_array( $host_base, $allowed_hosts, true ) ) {
	define( 'WP_HOME',    $base_url );
	define( 'WP_SITEURL', $base_url );
} else {
	define( 'WP_HOME',    'https://xn--c1ajfmabcc0byi.xn--p1ai' );
	define( 'WP_SITEURL', 'https://xn--c1ajfmabcc0byi.xn--p1ai' );
}


/* That's all, stop editing! */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}
require_once ABSPATH . 'wp-settings.php';