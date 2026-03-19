<?php

if (! defined('ABSPATH')) {
    exit;
}

add_theme_support( 'menus' );

require_once get_template_directory() . '/inc/global-settings/helpers.php';
 
// Страница настроек в админке (меню + admin bar + форма)
// Грузим только в админке — на фронте этот файл не нужен
if ( is_admin() ) {
    require_once get_template_directory() . '/inc/global-settings/admin-page.php';
}
 

// functions.php

function create_default_menus() {

    // === HEADER MENU ===
    $header_menu_name = 'Главное меню (шапка)';
    $header_location  = 'header-menu';

    if ( ! wp_get_nav_menu_object( $header_menu_name ) ) {
        $header_menu_id = wp_create_nav_menu( $header_menu_name );

        $header_items = [
            [ 'title' => 'Услуги',      'url' => '#services'  ],
            [ 'title' => 'Цены',        'url' => '#prices',   'classes' => 'js-hide-if-no-prices section-hidden' ],
            [ 'title' => 'Калькулятор', 'url' => '#calc'      ],
            [ 'title' => 'Кейсы',       'url' => '#cases'     ],
            [ 'title' => 'Контакты',    'url' => '#contacts'  ],
        ];

        foreach ( $header_items as $item ) {
            wp_update_nav_menu_item( $header_menu_id, 0, [
                'menu-item-title'   => $item['title'],
                'menu-item-url'     => $item['url'],
                'menu-item-classes' => $item['classes'] ?? '',
                'menu-item-status'  => 'publish',
                'menu-item-type'    => 'custom',
            ]);
        }

        // Привязываем к локации
        $locations = get_theme_mod( 'nav_menu_locations', [] );
        $locations[ $header_location ] = $header_menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );
    }

    // === FOOTER MENU ===
    $footer_menu_name = 'Меню в подвале';
    $footer_location  = 'footer-menu';

    if ( ! wp_get_nav_menu_object( $footer_menu_name ) ) {
        $footer_menu_id = wp_create_nav_menu( $footer_menu_name );

        $footer_items = [
            [ 'title' => 'Сетки',       'url' => '#nets'      ],
            [ 'title' => 'Тонировка',   'url' => '#tinting'   ],
            [ 'title' => 'Цены',        'url' => '#prices',   'classes' => 'js-hide-if-no-prices section-hidden' ],
            [ 'title' => 'Калькулятор', 'url' => '#calc'      ],
            [ 'title' => 'Кейсы',       'url' => '#cases'     ],
            [ 'title' => 'Контакты',    'url' => '#contacts'  ],
        ];

        foreach ( $footer_items as $item ) {
            wp_update_nav_menu_item( $footer_menu_id, 0, [
                'menu-item-title'   => $item['title'],
                'menu-item-url'     => $item['url'],
                'menu-item-classes' => $item['classes'] ?? '',
                'menu-item-status'  => 'publish',
                'menu-item-type'    => 'custom',
            ]);
        }

        $locations = get_theme_mod( 'nav_menu_locations', [] );
        $locations[ $footer_location ] = $footer_menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );
    }
}
add_action( 'after_setup_theme', 'create_default_menus' );

// Добавляем пункт "Заказать звонок" в мобильное меню (то же окно, что кнопка в шапке)
add_filter( 'wp_nav_menu_items', function ( $items, $args ) {
    if ( isset( $args->menu_class ) && $args->menu_class === 'header__list' ) {
        $items .= '<li class="header__item header__item_call"><a href="#" class="header__link js-consult-modal-open" role="button">Заказать звонок</a></li>';
    }
    return $items;
}, 10, 2 );
// Подключение класса заявок
require_once get_template_directory() . '/includes/class-okna-leads.php';
require_once get_template_directory() . '/includes/calc-page.php';

require_once get_template_directory() . '/inc/helpers-front-page.php';
 
// ─── 2. ACF-поля главной страницы ────────────────────────────────────────────
add_action( 'acf/init', function () {
    require_once get_template_directory() . '/inc/fields-front-page.php';
    
    // Тестовые Flexible Content блоки
    require_once get_template_directory() . '/inc/flexible-blocks.php';
} );


function okna_theme_setup(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
}
add_action('after_setup_theme', 'okna_theme_setup');

function okna_theme_enqueue_assets(): void
{
    $theme = wp_get_theme();
    $version = $theme->get('Version') ?: '1.0.0';
    $theme_uri = get_template_directory_uri();

    wp_enqueue_style(
        'okna-theme-fonts',
        'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap',
        [],
        null
    );

    wp_enqueue_style(
        'okna-theme-swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        [],
        null
    );

    wp_enqueue_style(
        'okna-theme-main',
        $theme_uri . '/css/main.css',
        ['okna-theme-fonts', 'okna-theme-swiper'],
        $version
    );

    wp_enqueue_style(
        'update-css',
        $theme_uri . '/css/update.css',
        [],
        $version
    );

    wp_enqueue_script(
        'okna-theme-swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        [],
        null,
        true
    );

    wp_enqueue_script(
        'okna-theme-main',
        $theme_uri . '/js/main.js',
        ['okna-theme-swiper'],
        $version,
        true
    );
    wp_enqueue_script(
        'app-js',
        $theme_uri . '/js/app.js',
        ['okna-theme-swiper'],
        $version,
        true
    );

    wp_enqueue_script(
        'okna-cta-form',
        $theme_uri . '/js/lead-form.js',
        [],
        $version,
        true
    );

    // Скрипт для отправки заявок калькулятора
    wp_enqueue_script(
        'okna-calc-lead-form',
        $theme_uri . '/js/calc-lead-form.js',
        [],
        $version,
        true
    );

    wp_enqueue_script(
        'okna-metrika-goals',
        $theme_uri . '/js/metrika-goals.js',
        [],
        $version,
        true
    );

    $lead_form_data = array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('okna_lead_nonce'),
        'success_message' => 'Заявка успешно отправлена! Мы свяжемся с вами в ближайшее время.',
        'error_message' => 'Ошибка отправки. Пожалуйста, попробуйте ещё раз.',
        'fill_required_message' => 'Заполните обязательные поля',
    );

    wp_localize_script('okna-cta-form', 'oknaLead', $lead_form_data);
    wp_localize_script('okna-calc-lead-form', 'oknaLead', $lead_form_data);
    wp_localize_script('okna-metrika-goals', 'oknaMetrikaConfig', array(
        'counter_id' => 106858194,
    ));
}
add_action('wp_enqueue_scripts', 'okna_theme_enqueue_assets');

class Footer_Menu_Walker extends Walker_Nav_Menu {

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes = 'footer__item';

        $custom_classes = implode( ' ', array_filter( (array) $item->classes ) ); // ← (array)
        if ( $custom_classes ) {
            $classes .= ' ' . $custom_classes;
        }

        $output .= '<li class="' . esc_attr( $classes ) . '">';
        $output .= '<a href="' . esc_url( $item->url ) . '" class="footer__link">';
        $output .= esc_html( $item->title );
        $output .= '</a>';
    }

    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= '</li>';
    }
}


class Header_Menu_Walker extends Walker_Nav_Menu {

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes = 'header__item';

        $custom_classes = implode( ' ', array_filter( (array) $item->classes ) ); // ← (array)
        if ( $custom_classes ) {
            $classes .= ' ' . $custom_classes;
        }

        $output .= '<li class="' . esc_attr( $classes ) . '">';
        $output .= '<a href="' . esc_url( $item->url ) . '" class="header__link">';
        $output .= esc_html( $item->title );
        $output .= '</a>';
    }

    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= '</li>';
    }
}
