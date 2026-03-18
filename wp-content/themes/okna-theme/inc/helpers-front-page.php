<?php
/**
 * Хелперы для полей главной страницы.
 * Подключается в functions.php вместе с fields-front-page.php.
 */

if ( ! function_exists( 'fp_get' ) ) :
/**
 * Получить ACF-поле страницы с фолбэком на дефолт из схемы.
 *
 * @param string $field_name  имя поля
 * @param mixed  $fallback    значение если ACF не вернул ничего
 * @return mixed
 */
function fp_get( string $field_name, $fallback = '' ) {
    if ( function_exists( 'get_field' ) ) {
        $value = get_field( $field_name );
        if ( $value !== null && $value !== false && $value !== '' ) {
            return $value;
        }
    }
    return $fallback;
}
endif;

if ( ! function_exists( 'fp_field' ) ) :
/**
 * Вывести ACF-поле (echo fp_get).
 */
function fp_field( string $field_name, $fallback = '' ) {
    echo esc_html( fp_get( $field_name, $fallback ) );
}
endif;

if ( ! function_exists( 'fp_field_raw' ) ) :
/**
 * Вывести ACF-поле без экранирования (для HTML/wysiwyg полей).
 */
function fp_field_raw( string $field_name, $fallback = '' ) {
    echo wp_kses_post( fp_get( $field_name, $fallback ) );
}
endif;

if ( ! function_exists( 'fp_image' ) ) :
/**
 * Вернуть URL изображения из ACF image field (array) или фолбэк из /img/.
 *
 * @param string $field_name
 * @param string $fallback_filename  имя файла в /img/ темы
 * @param string $size               'url'|'large'|'medium'|'thumbnail'
 * @return string URL
 */
function fp_image( string $field_name, string $fallback_filename = '', string $size = 'large' ): string {
    $img = fp_get( $field_name );
    if ( is_array( $img ) && ! empty( $img['url'] ) ) {
        return $img['sizes'][ $size ] ?? $img['url'];
    }
    if ( is_string( $img ) && $img ) {
        return $img;
    }
    if ( $fallback_filename ) {
        return esc_url( get_template_directory_uri() . '/img/' . $fallback_filename );
    }
    return '';
}
endif;

if ( ! function_exists( 'fp_repeater' ) ) :
/**
 * Получить строки repeater-поля.
 *
 * @param string $field_name
 * @return array
 */
function fp_repeater( string $field_name ): array {
    if ( function_exists( 'get_field' ) ) {
        $rows = get_field( $field_name );
        if ( is_array( $rows ) && $rows ) {
            return $rows;
        }
    }
    return [];
}
endif;