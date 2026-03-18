<?php
/**
 * ACF: Поля главной страницы
 * Подключается через functions.php:
 *   require_once get_template_directory() . '/inc/fields-front-page.php';
 *
 * Требуется: ACF Pro (используются Repeater-поля).
 */

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
    return;
}

// ─────────────────────────────────────────────────────────────────────────────
// HERO
// ─────────────────────────────────────────────────────────────────────────────
acf_add_local_field_group( [
    'key'      => 'group_fp_hero',
    'title'    => '🏠 Hero — Главный экран',
    'fields'   => [
        [
            'key'           => 'field_hero_image',
            'label'         => 'Фоновое изображение',
            'name'          => 'hero_image',
            'type'          => 'image',
            'return_format' => 'url',
            'preview_size'  => 'medium',
            'default_value' => '',
        ],
        [
            'key'           => 'field_hero_title',
            'label'         => 'Заголовок H1',
            'name'          => 'hero_title',
            'type'          => 'text',
            'default_value' => 'Установка окон от компании от 750 рублей',
        ],
        [
            'key'           => 'field_hero_subtitle',
            'label'         => 'Подзаголовок',
            'name'          => 'hero_subtitle',
            'type'          => 'text',
            'default_value' => 'Выезд замерщика за 1 день',
        ],
        [
            'key'           => 'field_hero_benefits',
            'label'         => 'Список преимуществ (каждый пункт с новой строки)',
            'name'          => 'hero_benefits',
            'type'          => 'textarea',
            'rows'          => 5,
            'default_value' => "Бесплатный замер в 3 городах и области:\nАкционная скидка на установку\nБесплатную мойку окон\nГарантия на монтаж 10 лет",
            'instructions'  => 'Каждая строка — отдельный &lt;li&gt;',
        ],
        [
            'key'           => 'field_hero_cta_text',
            'label'         => 'Текст кнопки CTA',
            'name'          => 'hero_cta_text',
            'type'          => 'text',
            'default_value' => 'Заказать установку',
        ],
        [
            'key'    => 'field_hero_advantages',
            'label'  => 'Преимущества (3 блока)',
            'name'   => 'hero_advantages',
            'type'   => 'repeater',
            'min'    => 0,
            'max'    => 10,
            'layout' => 'block',
            'button_label' => 'Добавить преимущество',
            'sub_fields'   => [
                [
                    'key'           => 'field_hero_adv_icon',
                    'label'         => 'Иконка (эмодзи или символ)',
                    'name'          => 'icon',
                    'type'          => 'text',
                    'default_value' => '📂',
                ],
                [
                    'key'           => 'field_hero_adv_title',
                    'label'         => 'Заголовок',
                    'name'          => 'title',
                    'type'          => 'text',
                    'default_value' => '',
                ],
                [
                    'key'           => 'field_hero_adv_text',
                    'label'         => 'Описание',
                    'name'          => 'text',
                    'type'          => 'textarea',
                    'rows'          => 3,
                    'default_value' => '',
                ],
            ],
        ],
    ],
    'location' => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    'menu_order' => 10,
] );

// ─────────────────────────────────────────────────────────────────────────────
// SOLUTIONS — Наши услуги
// ─────────────────────────────────────────────────────────────────────────────
acf_add_local_field_group( [
    'key'    => 'group_fp_solutions',
    'title'  => '🔧 Наши услуги',
    'fields' => [
        [
            'key'           => 'field_solutions_title',
            'label'         => 'Заголовок секции',
            'name'          => 'solutions_title',
            'type'          => 'text',
            'default_value' => 'Наши услуги',
        ],
        [
            'key'    => 'field_solutions_items',
            'label'  => 'Карточки услуг',
            'name'   => 'solutions_items',
            'type'   => 'repeater',
            'min'    => 0,
            'max'    => 20,
            'layout' => 'block',
            'button_label' => 'Добавить услугу',
            'sub_fields'   => [
                [
                    'key'           => 'field_sol_image',
                    'label'         => 'Изображение',
                    'name'          => 'image',
                    'type'          => 'image',
                    'return_format' => 'array',
                    'preview_size'  => 'thumbnail',
                ],
                [
                    'key'           => 'field_sol_name',
                    'label'         => 'Название услуги',
                    'name'          => 'name',
                    'type'          => 'text',
                    'default_value' => '',
                ],
            ],
        ],
    ],
    'location'   => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    'menu_order' => 20,
] );

// ─────────────────────────────────────────────────────────────────────────────
// TYPES — Типы плёнок
// ─────────────────────────────────────────────────────────────────────────────
acf_add_local_field_group( [
    'key'    => 'group_fp_types',
    'title'  => '🎞 Типы плёнок',
    'fields' => [
        [
            'key'           => 'field_types_title',
            'label'         => 'Заголовок секции',
            'name'          => 'types_title',
            'type'          => 'text',
            'default_value' => 'Типы пленок',
        ],
        [
            'key'    => 'field_types_items',
            'label'  => 'Карточки плёнок',
            'name'   => 'types_items',
            'type'   => 'repeater',
            'min'    => 0,
            'max'    => 20,
            'layout' => 'block',
            'button_label' => 'Добавить тип',
            'sub_fields'   => [
                [
                    'key'           => 'field_type_image',
                    'label'         => 'Изображение',
                    'name'          => 'image',
                    'type'          => 'image',
                    'return_format' => 'array',
                    'preview_size'  => 'thumbnail',
                ],
                [
                    'key'           => 'field_type_title',
                    'label'         => 'Название',
                    'name'          => 'title',
                    'type'          => 'text',
                    'default_value' => '',
                ],
                [
                    'key'           => 'field_type_desc',
                    'label'         => 'Описание',
                    'name'          => 'desc',
                    'type'          => 'textarea',
                    'rows'          => 4,
                    'default_value' => '',
                ],
                [
                    'key'           => 'field_type_btn',
                    'label'         => 'Текст кнопки',
                    'name'          => 'btn_text',
                    'type'          => 'text',
                    'default_value' => 'Узнать точную стоимость',
                ],
            ],
        ],
    ],
    'location'   => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    'menu_order' => 30,
] );

// ─────────────────────────────────────────────────────────────────────────────
// ABOUT — О нас
// ─────────────────────────────────────────────────────────────────────────────
acf_add_local_field_group( [
    'key'    => 'group_fp_about',
    'title'  => 'ℹ️ О нас',
    'fields' => [
        [
            'key'           => 'field_about_image',
            'label'         => 'Изображение (левая колонка)',
            'name'          => 'about_image',
            'type'          => 'image',
            'return_format' => 'array',
            'preview_size'  => 'medium',
        ],
        [
            'key'           => 'field_about_title',
            'label'         => 'Заголовок',
            'name'          => 'about_title',
            'type'          => 'text',
            'default_value' => 'О нас',
        ],
        [
            'key'           => 'field_about_text',
            'label'         => 'Основной текст',
            'name'          => 'about_text',
            'type'          => 'textarea',
            'rows'          => 4,
            'default_value' => 'Окнотюнинг — тонировка окон в Москве и области. Специализируемся на оклейке стекол плёнками: солнцезащита, декоративная тонировка, бронирование. Работаем с частными и корпоративными заказами. Широкий ассортимент материалов, гарантия на работу, индивидуальный подход к каждому клиенту.',
        ],
        [
            'key'           => 'field_about_srv1_title',
            'label'         => 'Услуга 1 — Заголовок',
            'name'          => 'about_service1_title',
            'type'          => 'text',
            'default_value' => 'Архитектурное тонирование',
        ],
        [
            'key'           => 'field_about_srv1_desc',
            'label'         => 'Услуга 1 — Описание',
            'name'          => 'about_service1_desc',
            'type'          => 'textarea',
            'rows'          => 3,
            'default_value' => 'Оклейка стекол специальными плёнками для снижения теплопритока, защиты от УФ и декора. Подходит для окон, витрин, фасадов и перегородок.',
        ],
        [
            'key'           => 'field_about_srv2_title',
            'label'         => 'Услуга 2 — Заголовок',
            'name'          => 'about_service2_title',
            'type'          => 'text',
            'default_value' => 'Декоративная тонировка',
        ],
        [
            'key'           => 'field_about_srv2_desc',
            'label'         => 'Услуга 2 — Описание',
            'name'          => 'about_service2_desc',
            'type'          => 'textarea',
            'rows'          => 3,
            'default_value' => 'Применяется для декора и зонирования, может затемнять пространство и скрывать интерьер от посторонних глаз. Матовая, зеркальная, цветная плёнка.',
        ],
        [
            'key'           => 'field_about_areas_title',
            'label'         => 'Области применения — Заголовок',
            'name'          => 'about_areas_title',
            'type'          => 'text',
            'default_value' => 'Области применения',
        ],
        [
            'key'    => 'field_about_areas',
            'label'  => 'Области применения (список)',
            'name'   => 'about_areas',
            'type'   => 'repeater',
            'min'    => 0,
            'max'    => 20,
            'layout' => 'table',
            'button_label' => 'Добавить пункт',
            'sub_fields'   => [
                [
                    'key'           => 'field_about_area_text',
                    'label'         => 'Пункт',
                    'name'          => 'text',
                    'type'          => 'text',
                    'default_value' => '',
                ],
            ],
        ],
        [
            'key'           => 'field_about_intro',
            'label'         => 'Текст под списком',
            'name'          => 'about_intro',
            'type'          => 'textarea',
            'rows'          => 3,
            'default_value' => 'Требования к светопропусканию регламентируются нормами (в т.ч. СНиП 23-05). От выбора плёнки зависят инсоляция, прохождение УФ и ИК. Подобрать оптимальный вариант помогут наши специалисты.',
        ],
        [
            'key'           => 'field_about_cta',
            'label'         => 'Текст кнопки CTA',
            'name'          => 'about_cta_text',
            'type'          => 'text',
            'default_value' => 'Узнать стоимость',
        ],
        [
            'key'           => 'field_about_after_image',
            'label'         => 'Изображение "После" (before/after)',
            'name'          => 'about_after_image',
            'type'          => 'image',
            'return_format' => 'array',
            'preview_size'  => 'thumbnail',
        ],
        [
            'key'           => 'field_about_before_image',
            'label'         => 'Изображение "До" (before/after)',
            'name'          => 'about_before_image',
            'type'          => 'image',
            'return_format' => 'array',
            'preview_size'  => 'thumbnail',
        ],
    ],
    'location'   => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    'menu_order' => 40,
] );

// ─────────────────────────────────────────────────────────────────────────────
// MEASURE PHOTO — Расчёт стоимости по фото
// ─────────────────────────────────────────────────────────────────────────────
acf_add_local_field_group( [
    'key'    => 'group_fp_measure',
    'title'  => '📸 Расчёт стоимости по фото',
    'fields' => [
        [
            'key'           => 'field_measure_title',
            'label'         => 'Заголовок секции',
            'name'          => 'measure_title',
            'type'          => 'text',
            'default_value' => 'Расчет стоимости по фото',
        ],
        [
            'key'           => 'field_measure_image',
            'label'         => 'Изображение',
            'name'          => 'measure_image',
            'type'          => 'image',
            'return_format' => 'array',
            'preview_size'  => 'medium',
        ],
        [
            'key'           => 'field_measure_card_title',
            'label'         => 'Заголовок карточки',
            'name'          => 'measure_card_title',
            'type'          => 'text',
            'default_value' => 'Расчет стоимости',
        ],
        [
            'key'           => 'field_measure_card_desc',
            'label'         => 'Описание в карточке',
            'name'          => 'measure_card_desc',
            'type'          => 'text',
            'default_value' => 'Приложите фото для расчета стоимости',
        ],
    ],
    'location'   => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    'menu_order' => 50,
] );

// ─────────────────────────────────────────────────────────────────────────────
// CALL MEASURER — Вызвать замерщика
// ─────────────────────────────────────────────────────────────────────────────
acf_add_local_field_group( [
    'key'    => 'group_fp_call_measurer',
    'title'  => '📐 Вызвать замерщика',
    'fields' => [
        [
            'key'           => 'field_cm_title',
            'label'         => 'Заголовок',
            'name'          => 'cm_title',
            'type'          => 'text',
            'default_value' => 'Пригласите специалиста',
        ],
        [
            'key'           => 'field_cm_subtitle',
            'label'         => 'Подзаголовок',
            'name'          => 'cm_subtitle',
            'type'          => 'text',
            'default_value' => 'для точных замеров, выбора материала и цвета пленки',
        ],
        [
            'key'           => 'field_cm_intro',
            'label'         => 'Вводный текст',
            'name'          => 'cm_intro',
            'type'          => 'textarea',
            'rows'          => 2,
            'default_value' => 'Сделаем замеры, поможем выбрать внешний вид и расскажем о процессе монтажа.',
        ],
        [
            'key'    => 'field_cm_list',
            'label'  => 'Список пунктов',
            'name'   => 'cm_list',
            'type'   => 'repeater',
            'min'    => 0,
            'max'    => 10,
            'layout' => 'table',
            'button_label' => 'Добавить пункт',
            'sub_fields'   => [
                [
                    'key'           => 'field_cm_list_text',
                    'label'         => 'Текст пункта',
                    'name'          => 'text',
                    'type'          => 'text',
                    'default_value' => '',
                ],
            ],
        ],
        [
            'key'           => 'field_cm_card_image',
            'label'         => 'Изображение в карточке',
            'name'          => 'cm_card_image',
            'type'          => 'image',
            'return_format' => 'array',
            'preview_size'  => 'thumbnail',
        ],
        [
            'key'           => 'field_cm_card_title',
            'label'         => 'Заголовок карточки',
            'name'          => 'cm_card_title',
            'type'          => 'text',
            'default_value' => 'Образцы пленок с собой',
        ],
        [
            'key'    => 'field_cm_features',
            'label'  => 'Фичи карточки',
            'name'   => 'cm_features',
            'type'   => 'repeater',
            'min'    => 0,
            'max'    => 10,
            'layout' => 'table',
            'button_label' => 'Добавить фичу',
            'sub_fields'   => [
                [
                    'key'           => 'field_cm_feat_icon',
                    'label'         => 'Иконка',
                    'name'          => 'icon',
                    'type'          => 'text',
                    'default_value' => '🛡',
                ],
                [
                    'key'           => 'field_cm_feat_text',
                    'label'         => 'Текст',
                    'name'          => 'text',
                    'type'          => 'text',
                    'default_value' => '',
                ],
            ],
        ],
        [
            'key'           => 'field_cm_bonus',
            'label'         => 'Бонус (акцентная строка)',
            'name'          => 'cm_bonus',
            'type'          => 'text',
            'default_value' => 'Пробная оклейка в подарок!',
        ],
        [
            'key'           => 'field_cm_btn_text',
            'label'         => 'Текст кнопки',
            'name'          => 'cm_btn_text',
            'type'          => 'text',
            'default_value' => 'Вызвать замерщика',
        ],
    ],
    'location'   => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    'menu_order' => 60,
] );

// ─────────────────────────────────────────────────────────────────────────────
// PRICES — Цены
// ─────────────────────────────────────────────────────────────────────────────
acf_add_local_field_group( [
    'key'    => 'group_fp_prices',
    'title'  => '💰 Цены',
    'fields' => [
        [
            'key'           => 'field_prices_title',
            'label'         => 'Заголовок секции',
            'name'          => 'prices_title',
            'type'          => 'text',
            'default_value' => 'Цены',
        ],
        [
            'key'    => 'field_prices_rows',
            'label'  => 'Строки таблицы',
            'name'   => 'prices_rows',
            'type'   => 'repeater',
            'min'    => 0,
            'max'    => 30,
            'layout' => 'table',
            'button_label' => 'Добавить строку',
            'sub_fields'   => [
                [
                    'key'           => 'field_pr_type',
                    'label'         => 'Тип плёнки',
                    'name'          => 'type',
                    'type'          => 'text',
                    'default_value' => '',
                ],
                [
                    'key'           => 'field_pr_range',
                    'label'         => 'VLT% (ширина бара 0–100)',
                    'name'          => 'range',
                    'type'          => 'number',
                    'min'           => 0,
                    'max'           => 100,
                    'default_value' => 50,
                ],
                [
                    'key'           => 'field_pr_price',
                    'label'         => 'Цена (текст, напр. «от 500 ₽/м²»)',
                    'name'          => 'price',
                    'type'          => 'text',
                    'default_value' => 'от 500 ₽/м²',
                ],
                [
                    'key'           => 'field_pr_term',
                    'label'         => 'Срок монтажа',
                    'name'          => 'term',
                    'type'          => 'text',
                    'default_value' => '1–2 дня',
                ],
            ],
        ],
        [
            'key'           => 'field_prices_footer',
            'label'         => 'Текст под таблицей',
            'name'          => 'prices_footer',
            'type'          => 'wysiwyg',
            'tabs'          => 'all',
            'toolbar'       => 'basic',
            'media_upload'  => 0,
            'default_value' => "Минимальный заказ 5000 ₽\nВыезд Москва — бесплатно, МО — от 100 ₽/км\nДоп. работы (жалюзи, высота/доступ) — по смете",
        ],
        [
            'key'           => 'field_prices_cta',
            'label'         => 'Текст кнопки',
            'name'          => 'prices_cta',
            'type'          => 'text',
            'default_value' => 'Точный расчёт',
        ],
    ],
    'location'   => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    'menu_order' => 70,
] );

// ─────────────────────────────────────────────────────────────────────────────
// CASES — Кейсы
// ─────────────────────────────────────────────────────────────────────────────
acf_add_local_field_group( [
    'key'    => 'group_fp_cases',
    'title'  => '📁 Кейсы',
    'fields' => [
        [
            'key'           => 'field_cases_title',
            'label'         => 'Заголовок секции',
            'name'          => 'cases_title',
            'type'          => 'text',
            'default_value' => 'Кейсы',
        ],
        [
            'key'    => 'field_cases_items',
            'label'  => 'Кейсы',
            'name'   => 'cases_items',
            'type'   => 'repeater',
            'min'    => 0,
            'max'    => 20,
            'layout' => 'block',
            'button_label' => 'Добавить кейс',
            'sub_fields'   => [
                [
                    'key'           => 'field_case_img_after',
                    'label'         => 'Фото «После»',
                    'name'          => 'img_after',
                    'type'          => 'image',
                    'return_format' => 'array',
                    'preview_size'  => 'thumbnail',
                ],
                [
                    'key'           => 'field_case_img_before',
                    'label'         => 'Фото «До»',
                    'name'          => 'img_before',
                    'type'          => 'image',
                    'return_format' => 'array',
                    'preview_size'  => 'thumbnail',
                ],
                [
                    'key'           => 'field_case_title',
                    'label'         => 'Заголовок кейса',
                    'name'          => 'title',
                    'type'          => 'text',
                    'default_value' => '',
                ],
                [
                    'key'           => 'field_case_object',
                    'label'         => 'Объект',
                    'name'          => 'object',
                    'type'          => 'text',
                    'default_value' => '',
                ],
                [
                    'key'           => 'field_case_district',
                    'label'         => 'Район',
                    'name'          => 'district',
                    'type'          => 'text',
                    'default_value' => '',
                ],
                [
                    'key'           => 'field_case_qty',
                    'label'         => 'Кол-во',
                    'name'          => 'qty',
                    'type'          => 'text',
                    'default_value' => '',
                ],
                [
                    'key'           => 'field_case_area',
                    'label'         => 'Площадь',
                    'name'          => 'area',
                    'type'          => 'text',
                    'default_value' => '',
                ],
                [
                    'key'           => 'field_case_term',
                    'label'         => 'Срок',
                    'name'          => 'term',
                    'type'          => 'text',
                    'default_value' => '',
                ],
                [
                    'key'           => 'field_case_review',
                    'label'         => 'Отзыв клиента',
                    'name'          => 'review',
                    'type'          => 'textarea',
                    'rows'          => 3,
                    'default_value' => '',
                ],
            ],
        ],
    ],
    'location'   => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    'menu_order' => 80,
] );

// ─────────────────────────────────────────────────────────────────────────────
// WHY — Почему мы
// ─────────────────────────────────────────────────────────────────────────────
acf_add_local_field_group( [
    'key'    => 'group_fp_why',
    'title'  => '⭐ Почему мы',
    'fields' => [
        [
            'key'           => 'field_why_title',
            'label'         => 'Заголовок секции',
            'name'          => 'why_title',
            'type'          => 'text',
            'default_value' => 'Почему мы?',
        ],
        [
            'key'    => 'field_why_items',
            'label'  => 'Пункты',
            'name'   => 'why_items',
            'type'   => 'repeater',
            'min'    => 0,
            'max'    => 12,
            'layout' => 'table',
            'button_label' => 'Добавить пункт',
            'sub_fields'   => [
                [
                    'key'           => 'field_why_text',
                    'label'         => 'Текст',
                    'name'          => 'text',
                    'type'          => 'text',
                    'default_value' => '',
                ],
                [
                    'key'           => 'field_why_svg',
                    'label'         => 'SVG-иконка (код целиком)',
                    'name'          => 'svg',
                    'type'          => 'textarea',
                    'rows'          => 4,
                    'default_value' => '',
                    'instructions'  => 'Вставьте полный код &lt;svg&gt;...&lt;/svg&gt;',
                ],
            ],
        ],
    ],
    'location'   => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    'menu_order' => 90,
] );

// ─────────────────────────────────────────────────────────────────────────────
// FAQ
// ─────────────────────────────────────────────────────────────────────────────
acf_add_local_field_group( [
    'key'    => 'group_fp_faq',
    'title'  => '❓ FAQ',
    'fields' => [
        [
            'key'           => 'field_faq_title',
            'label'         => 'Заголовок секции',
            'name'          => 'faq_title',
            'type'          => 'text',
            'default_value' => 'FAQ',
        ],
        [
            'key'    => 'field_faq_items',
            'label'  => 'Вопросы и ответы',
            'name'   => 'faq_items',
            'type'   => 'repeater',
            'min'    => 0,
            'max'    => 30,
            'layout' => 'block',
            'button_label' => 'Добавить вопрос',
            'sub_fields'   => [
                [
                    'key'           => 'field_faq_question',
                    'label'         => 'Вопрос',
                    'name'          => 'question',
                    'type'          => 'text',
                    'default_value' => '',
                ],
                [
                    'key'           => 'field_faq_answer',
                    'label'         => 'Ответ',
                    'name'          => 'answer',
                    'type'          => 'textarea',
                    'rows'          => 4,
                    'default_value' => '',
                ],
            ],
        ],
    ],
    'location'   => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    'menu_order' => 100,
] );

// ─────────────────────────────────────────────────────────────────────────────
// GEO / CONTACTS
// ─────────────────────────────────────────────────────────────────────────────
acf_add_local_field_group( [
    'key'    => 'group_fp_geo',
    'title'  => '📍 Контакты и гео',
    'fields' => [
        [
            'key'           => 'field_geo_title',
            'label'         => 'Заголовок секции',
            'name'          => 'geo_title',
            'type'          => 'text',
            'default_value' => 'Контакты и гео',
        ],
        [
            'key'           => 'field_geo_address',
            'label'         => 'Адрес',
            'name'          => 'geo_address',
            'type'          => 'text',
            'default_value' => 'г. Москва, ул. Никольская, д.29',
        ],
        [
            'key'           => 'field_geo_hours',
            'label'         => 'Часы работы',
            'name'          => 'geo_hours',
            'type'          => 'text',
            'default_value' => 'Ежедневно с 9:00 до 20:00',
        ],
        [
            'key'           => 'field_geo_phone',
            'label'         => 'Телефон',
            'name'          => 'geo_phone',
            'type'          => 'text',
            'default_value' => '89870915171',
        ],
        [
            'key'           => 'field_geo_phone_display',
            'label'         => 'Телефон (отображаемый текст)',
            'name'          => 'geo_phone_display',
            'type'          => 'text',
            'default_value' => '8 (987) 091 51 71',
        ],
        [
            'key'           => 'field_geo_telegram_url',
            'label'         => 'Telegram URL',
            'name'          => 'geo_telegram_url',
            'type'          => 'url',
            'default_value' => 'https://t.me/tg_id',
        ],
        [
            'key'           => 'field_geo_telegram_label',
            'label'         => 'Telegram подпись',
            'name'          => 'geo_telegram_label',
            'type'          => 'text',
            'default_value' => 'Telegram: @tg_id',
        ],
        [
            'key'           => 'field_geo_call_btn',
            'label'         => 'Текст кнопки «Позвоните мне»',
            'name'          => 'geo_call_btn',
            'type'          => 'text',
            'default_value' => 'Позвоните мне',
        ],
        [
            'key'           => 'field_geo_map_embed',
            'label'         => 'Код iframe карты (Яндекс/Google)',
            'name'          => 'geo_map_embed',
            'type'          => 'textarea',
            'rows'          => 3,
            'default_value' => '<iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A0fc18ce58211c21b49973611d18a1ba845e075cc79f19d94eabcc019050a5024&amp;source=constructor" width="100%" height="600" allowfullscreen="" referrerpolicy="no-referrer-when-downgrade" title="Яндекс.Карта"></iframe>',
            'instructions'  => 'Вставьте полный код &lt;iframe&gt; из Яндекс.Карт или Google Maps.',
        ],
    ],
    'location'   => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    'menu_order' => 110,
] );

// ─────────────────────────────────────────────────────────────────────────────
// CTA — финальная форма
// ─────────────────────────────────────────────────────────────────────────────
acf_add_local_field_group( [
    'key'    => 'group_fp_cta',
    'title'  => '📬 CTA — Финальная форма',
    'fields' => [
        [
            'key'           => 'field_cta_title',
            'label'         => 'Заголовок',
            'name'          => 'cta_title',
            'type'          => 'text',
            'default_value' => 'Нужен расчёт или замер сегодня?',
        ],
        [
            'key'           => 'field_cta_subtitle',
            'label'         => 'Подзаголовок',
            'name'          => 'cta_subtitle',
            'type'          => 'text',
            'default_value' => 'Приедем в удобное время, предложим 2–3 решения и точную смету.',
        ],
        [
            'key'           => 'field_cta_image',
            'label'         => 'Изображение',
            'name'          => 'cta_image',
            'type'          => 'image',
            'return_format' => 'array',
            'preview_size'  => 'medium',
        ],
    ],
    'location'   => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    'menu_order' => 120,
] );