<?php
# Database Configuration
define( 'DB_NAME', 'wp_binfantisstg' );
define( 'DB_USER', 'binfantisstg' );
define( 'DB_PASSWORD', '2TBE2pssLcc4TrCnlfXY' );
define( 'DB_HOST', '127.0.0.1:3306' );
define( 'DB_HOST_SLAVE', '127.0.0.1:3306' );
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');
$table_prefix = 'wp_';

# Security Salts, Keys, Etc
define('AUTH_KEY',         '`GW0elM9`vQLpn0V,9FU>YgyW6fI|?kQp)?,WF3+<Z!f0oBnY6+s@+%S$Z/#y.q?');
define('SECURE_AUTH_KEY',  '+R+nGEVz{iY|7pOR#~9|-OtL1Uy>821BF![F`y4@nu[Djj^-i58o4K+$nELLY%yA');
define('LOGGED_IN_KEY',    'qqP5im&h 4VqFE)K@4|3,/M|GSGt&aO7 27royw% pvl1$X3-S&K4s*0!HPwFMrN');
define('NONCE_KEY',        'N~@|P&R}H0Dhp)-IN#`[NFwfwV+1RK~SY+.7RW+E0),YBB_<=9]|, *[F^|X<*Hz');
define('AUTH_SALT',        'Bro^A@fFj#db.Y,QTz(C.+T-fCI~RNpgohg%:6/7Elot|JgAK[vtvy]uYTpaPL62');
define('SECURE_AUTH_SALT', 'T!/Yz5)-D`y%Gd/kTA)3t b8Gj)52gYQa(;.P&q-8B|w;q{IN8;u{Y.|<zlcHAlp');
define('LOGGED_IN_SALT',   'Wa!r=}U.]Gu}hou{/F^L[nG1+tJRcU1(^~*>Q&WZnuLwdpagB1mEbS i~E,dXy d');
define('NONCE_SALT',       'N(of+!TQGz3$>qU?ZYT,t&-R<d#@1k/SsBVEQkKxSi].ljPXM^M-G`GiIj*|+~?p');


# Localized Language Stuff

define( 'WP_CACHE', TRUE );

define( 'WP_AUTO_UPDATE_CORE', false );

define( 'PWP_NAME', 'binfantisstg' );

define( 'FS_METHOD', 'direct' );

define( 'FS_CHMOD_DIR', 0775 );

define( 'FS_CHMOD_FILE', 0664 );

define( 'WPE_APIKEY', '8ff1a56a317e88843271362dbcecac7cc8032bc7' );

define( 'WPE_CLUSTER_ID', '203066' );

define( 'WPE_CLUSTER_TYPE', 'pod' );

define( 'WPE_ISP', true );

define( 'WPE_BPOD', false );

define( 'WPE_RO_FILESYSTEM', false );

define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );

define( 'WPE_SFTP_PORT', 2222 );

define( 'WPE_SFTP_ENDPOINT', '34.139.4.61' );

define( 'WPE_LBMASTER_IP', '' );

define( 'WPE_CDN_DISABLE_ALLOWED', true );

define( 'DISALLOW_FILE_MODS', FALSE );

define( 'DISALLOW_FILE_EDIT', FALSE );

define( 'DISABLE_WP_CRON', false );

define( 'WPE_FORCE_SSL_LOGIN', false );

define( 'FORCE_SSL_LOGIN', false );

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define( 'WPE_EXTERNAL_URL', false );

define( 'WP_POST_REVISIONS', FALSE );

define( 'WPE_WHITELABEL', 'wpengine' );

define( 'WP_TURN_OFF_ADMIN_BAR', false );

define( 'WPE_BETA_TESTER', false );

define( 'WP_DEBUG', true );

umask(0002);

$wpe_cdn_uris=array ( );

$wpe_no_cdn_uris=array ( );

$wpe_content_regexs=array ( );

$wpe_all_domains=array ( 0 => 'binfantisstg.wpengine.com', 1 => 'binfantisstg.wpenginepowered.com', );

$wpe_varnish_servers=array ( 0 => '127.0.0.1', );

$wpe_special_ips=array ( 0 => '34.148.166.239', 1 => 'pod-203066-utility.pod-203066.svc.cluster.local', );

$wpe_netdna_domains=array ( );

$wpe_netdna_domains_secure=array ( );

$wpe_netdna_push_domains=array ( );

$wpe_domain_mappings=array ( );

$memcached_servers=array ( 'default' =>  array ( 0 => 'unix:///tmp/memcached.sock', ), );
define('WPLANG','');

# WP Engine ID


# WP Engine Settings






# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', __DIR__ . '/');
require_once(ABSPATH . 'wp-settings.php');



