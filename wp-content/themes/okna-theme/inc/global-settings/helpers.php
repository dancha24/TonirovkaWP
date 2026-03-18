<?php
/**
 * Global Settings — хелперы, шорткоды, REST API, метрика в wp_head.
 *
 * Файл: inc/global-settings/helpers.php
 */

defined( 'ABSPATH' ) || exit;

define( 'GS_OPTION_KEY', 'global_settings_options' );

/* =========================================================
 * HELPERS — вызывай в шаблонах темы
 * ======================================================= */

/**
 * Все настройки одним массивом.
 * $gs = gs_get_options();
 * echo $gs['phone'];
 */
function gs_get_options( bool $force = false ): array {
    static $cache = null;
    if ( $cache === null || $force ) {
        $defaults = [
            'phone'      => '',
            'telegram'   => '',
            'address'    => '',
            'work_hours' => '',
            'metrika'    => '',
        ];
        $cache = wp_parse_args( get_option( GS_OPTION_KEY, [] ), $defaults );
    }
    return $cache;
}

/** Телефон: echo gs_phone(); */
function gs_phone(): string {
    return esc_html( gs_get_options()['phone'] );
}

/** Telegram URL: echo gs_telegram(); */
function gs_telegram(): string {
    return esc_url( gs_get_options()['telegram'] );
}

/** Адрес с переносами строк: echo gs_address(); */
function gs_address(): string {
    return nl2br( esc_html( gs_get_options()['address'] ) );
}

/** Время работы: echo gs_work_hours(); */
function gs_work_hours(): string {
    return esc_html( gs_get_options()['work_hours'] );
}

/**
 * Сырой код метрики (уже прошёл sanitize_textarea_field при сохранении).
 * Используй только в доверенных местах (wp_head / header.php).
 */
function gs_metrika_raw(): string {
    return gs_get_options()['metrika'];
}

/**
 * Выводит код метрики.
 * Автоматически вызывается через wp_head (см. ниже).
 * Можно вызвать и вручную: <?php gs_metrika_output(); ?>
 */
function gs_metrika_output(): void {
    $code = gs_metrika_raw();
    if ( ! empty( $code ) ) {
        echo "\n" . $code . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput
    }
}


add_shortcode( 'gs_phone',      fn() => gs_phone() );
add_shortcode( 'gs_telegram',   fn() => gs_telegram() );
add_shortcode( 'gs_address',    fn() => gs_address() );
add_shortcode( 'gs_work_hours', fn() => gs_work_hours() );

/* =========================================================
 * REST API  GET /wp-json/gs/v1/settings
 * Полезно для headless / React фронта.
 * ======================================================= */

add_action( 'rest_api_init', function () {
    register_rest_route( 'gs/v1', '/settings', [
        'methods'             => 'GET',
        'callback'            => 'gs_rest_get_settings',
        'permission_callback' => '__return_true',
    ] );
} );

function gs_rest_get_settings(): WP_REST_Response {
    $opts = gs_get_options();
    return new WP_REST_Response( [
        'phone'      => gs_phone(),
        'telegram'   => gs_telegram(),
        'address'    => $opts['address'], // raw без nl2br — пусть фронт сам форматирует
        'work_hours' => gs_work_hours(),
        // metrika не отдаём — код счётчика не должен светиться в публичном API
    ], 200 );
}