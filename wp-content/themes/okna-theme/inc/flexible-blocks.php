<?php
/**
 * ACF Flexible Content — Тестовые блоки
 * Подключается через functions.php
 */

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
    return;
}

if ( ! function_exists( 'okna_flexible_clone_sub_field' ) ) {
    function okna_flexible_clone_sub_field( string $key, string $name, string $label, array $clone ): array {
        return [
            'key'          => $key,
            'label'        => $label,
            'name'         => $name,
            'type'         => 'clone',
            'clone'        => $clone,
            'display'      => 'seamless',
            'layout'       => 'block',
            'prefix_label' => 0,
            'prefix_name'  => 0,
        ];
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// FLEXIBLE CONTENT — Конструктор блоков для любой страницы
// ─────────────────────────────────────────────────────────────────────────────
acf_add_local_field_group( [
    'key'      => 'group_flex_blocks_page_flexible',
    'title'    => '🧱 Конструктор блоков',
    'fields'   => [
        [
            'key'        => 'field_flex_blocks_page_flexible',
            'label'      => 'Блоки страницы',
            'name'       => 'flexible_blocks',
            'type'       => 'flexible_content',
            'layouts'    => [
                // ─── Блок: Hero ─────────────────────────────────────
                [
                    'key'        => 'layout_flex_hero',
                    'name'       => 'hero',
                    'label'      => '🏠 Hero — Главный экран',
                    'display'    => 'block',
                    'sub_fields' => [
                        [
                            'key'           => 'field_flex_hero_bg_image',
                            'label'         => 'Фоновое изображение',
                            'name'          => 'bg_image',
                            'type'          => 'image',
                            'return_format' => 'url',
                            'preview_size'  => 'large',
                        ],
                        [
                            'key'           => 'field_flex_hero_title',
                            'label'         => 'Заголовок H1',
                            'name'          => 'title',
                            'type'          => 'text',
                            'default_value' => 'Установка окон от 750 рублей',
                        ],
                        [
                            'key'           => 'field_flex_hero_subtitle',
                            'label'         => 'Подзаголовок',
                            'name'          => 'subtitle',
                            'type'          => 'text',
                            'default_value' => 'Выезд замерщика за 1 день',
                        ],
                        [
                            'key'           => 'field_flex_hero_benefits',
                            'label'         => 'Преимущества (каждая строка — отдельный пункт)',
                            'name'          => 'benefits',
                            'type'          => 'textarea',
                            'rows'          => 4,
                        ],
                        [
                            'key'           => 'field_flex_hero_cta_text',
                            'label'         => 'Текст кнопки',
                            'name'          => 'cta_text',
                            'type'          => 'text',
                            'default_value' => 'Заказать установку',
                        ],
                        [
                            'key'           => 'field_flex_hero_cta_link',
                            'label'         => 'Ссылка кнопки',
                            'name'          => 'cta_link',
                            'type'          => 'text',
                            'default_value' => '#calc',
                        ],
                    ],
                ],

                [
                    'key'        => 'layout_flex_front_hero',
                    'name'       => 'front_hero',
                    'label'      => 'Главный экран с преимуществами',
                    'display'    => 'block',
                    'sub_fields' => [
                        okna_flexible_clone_sub_field( 'field_flex_clone_front_hero', 'front_hero_fields', 'Содержимое блока', [ 'group_fp_hero' ] ),
                    ],
                ],
                [
                    'key'        => 'layout_flex_front_solutions',
                    'name'       => 'front_solutions',
                    'label'      => 'Наши услуги',
                    'display'    => 'block',
                    'sub_fields' => [
                        okna_flexible_clone_sub_field( 'field_flex_clone_front_solutions', 'front_solutions_fields', 'Содержимое блока', [ 'group_fp_solutions' ] ),
                    ],
                ],
                [
                    'key'        => 'layout_flex_front_types',
                    'name'       => 'front_types',
                    'label'      => 'Типы пленок',
                    'display'    => 'block',
                    'sub_fields' => [
                        okna_flexible_clone_sub_field( 'field_flex_clone_front_types', 'front_types_fields', 'Содержимое блока', [ 'group_fp_types' ] ),
                    ],
                ],
                [
                    'key'        => 'layout_flex_front_about',
                    'name'       => 'front_about',
                    'label'      => 'О компании',
                    'display'    => 'block',
                    'sub_fields' => [
                        okna_flexible_clone_sub_field( 'field_flex_clone_front_about', 'front_about_fields', 'Содержимое блока', [ 'group_fp_about' ] ),
                    ],
                ],
                [
                    'key'        => 'layout_flex_front_measure_photo',
                    'name'       => 'front_measure_photo',
                    'label'      => 'Расчет по фото',
                    'display'    => 'block',
                    'sub_fields' => [
                        okna_flexible_clone_sub_field( 'field_flex_clone_front_measure_photo', 'front_measure_photo_fields', 'Содержимое блока', [ 'group_fp_measure' ] ),
                    ],
                ],
                [
                    'key'        => 'layout_flex_front_call_measurer',
                    'name'       => 'front_call_measurer',
                    'label'      => 'Вызвать замерщика',
                    'display'    => 'block',
                    'sub_fields' => [
                        okna_flexible_clone_sub_field( 'field_flex_clone_front_call_measurer', 'front_call_measurer_fields', 'Содержимое блока', [ 'group_fp_call_measurer' ] ),
                    ],
                ],
                [
                    'key'        => 'layout_flex_front_prices',
                    'name'       => 'front_prices',
                    'label'      => 'Таблица цен',
                    'display'    => 'block',
                    'sub_fields' => [
                        okna_flexible_clone_sub_field( 'field_flex_clone_front_prices', 'front_prices_fields', 'Содержимое блока', [ 'group_fp_prices' ] ),
                    ],
                ],
                [
                    'key'        => 'layout_flex_front_calculator',
                    'name'       => 'front_calculator',
                    'label'      => 'Калькулятор',
                    'display'    => 'block',
                    'sub_fields' => [],
                ],
                [
                    'key'        => 'layout_flex_front_cases',
                    'name'       => 'front_cases',
                    'label'      => 'Кейсы',
                    'display'    => 'block',
                    'sub_fields' => [
                        okna_flexible_clone_sub_field( 'field_flex_clone_front_cases', 'front_cases_fields', 'Содержимое блока', [ 'group_fp_cases' ] ),
                    ],
                ],
                [
                    'key'        => 'layout_flex_front_why',
                    'name'       => 'front_why',
                    'label'      => 'Почему мы',
                    'display'    => 'block',
                    'sub_fields' => [
                        okna_flexible_clone_sub_field( 'field_flex_clone_front_why', 'front_why_fields', 'Содержимое блока', [ 'group_fp_why' ] ),
                    ],
                ],
                [
                    'key'        => 'layout_flex_front_faq',
                    'name'       => 'front_faq',
                    'label'      => 'FAQ',
                    'display'    => 'block',
                    'sub_fields' => [
                        okna_flexible_clone_sub_field( 'field_flex_clone_front_faq', 'front_faq_fields', 'Содержимое блока', [ 'group_fp_faq' ] ),
                    ],
                ],
                [
                    'key'        => 'layout_flex_front_geo',
                    'name'       => 'front_geo',
                    'label'      => 'Контакты и карта',
                    'display'    => 'block',
                    'sub_fields' => [
                        okna_flexible_clone_sub_field( 'field_flex_clone_front_geo', 'front_geo_fields', 'Содержимое блока', [ 'group_fp_geo' ] ),
                    ],
                ],
                [
                    'key'        => 'layout_flex_front_cta',
                    'name'       => 'front_cta',
                    'label'      => 'Финальная форма',
                    'display'    => 'block',
                    'sub_fields' => [
                        okna_flexible_clone_sub_field( 'field_flex_clone_front_cta', 'front_cta_fields', 'Содержимое блока', [ 'group_fp_cta' ] ),
                    ],
                ],
            ],
            'button_label' => 'Добавить блок',
        ],
    ],
    'location' => [
        // Показывать для шаблона page-flexible.php
        [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-flexible.php' ] ],
    ],
    'menu_order' => 0,
] );
