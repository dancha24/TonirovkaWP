<?php
/**
 * front-page.php — секция <main>
 * Все тексты, изображения и списки управляются через ACF-поля
 * (зарегистрированы в inc/fields-front-page.php).
 *
 * Дефолтные значения прописаны прямо в вызовах fp_get() / fp_image() —
 * если поле пустое, показывается хардкод из верстки.
 */

// Дефолтные данные — используются как фолбэк если поле ACF пустое
$d = [
    // Hero
    'hero_benefits_default'  => [
        'Бесплатный замер в 3 городах и области:',
        'Акционная скидка на установку',
        'Бесплатную мойку окон',
        'Гарантия на монтаж 10 лет',
    ],
    'hero_advantages_default' => [
        [ 'icon' => '📂', 'title' => 'Бесплатная доставка в пределах города',   'text' => 'Выезд замерщика производится по адресу клиента и компании для точного замера окон, чтобы избежать ошибок при заказе и монтаже' ],
        [ 'icon' => '✓',  'title' => 'Гарантия на монтаж',                       'text' => 'Гарантия на монтаж распространяется на все виды работ до 10 лет' ],
        [ 'icon' => '◑',  'title' => 'Качественная установка окон',              'text' => 'Бесплатная консультация по качественной установке окон' ],
    ],

    // Solutions
    'solutions_default' => [
        [ 'name' => 'Логотип/Балкон',         'img' => 'solutions-01.png' ],
        [ 'name' => 'Перепланировка квартиры', 'img' => 'solutions-02.png' ],
        [ 'name' => 'Москитные сетки',         'img' => 'solutions-03.png' ],
        [ 'name' => 'Отделка откосов',         'img' => 'solutions-04.png' ],
        [ 'name' => 'Фасады',                  'img' => 'solutions-05.png' ],
        [ 'name' => 'Двери',                   'img' => 'solutions-06.png' ],
    ],

    // Types
    'types_default' => [
        [ 'title' => 'Атермальные',          'img' => 'types-1.png', 'desc' => 'Атермальная пленка служит для создания комфортных температур в помещении, в любое время года. В холода сохраняет тепло, а в летнее время защищает комнату от перегрева.' ],
        [ 'title' => 'Зеркальные',           'img' => 'types-3.png', 'desc' => 'Создать благоприятные условия в летнюю жару в помещении поможет солнцезащитная зеркальная пленка. Улучшая вид окон, пленка создаёт щит, поглощающий до 85% тепла и эффективно отражающий солнечный свет.' ],
        [ 'title' => 'Бронирующие',          'img' => 'types-5.png', 'desc' => 'Сделать стекло на окнах прочнее, защитить его от ударов, царапин, повреждений, обезопасить от механического воздействия помогает установка противоударной защитной пленки на стекло.' ],
        [ 'title' => 'Цветные и бронзовые',  'img' => 'types-4.png', 'desc' => 'Цветные тонировочные пленки защитят от ярких солнечных лучей, снизят нагрев помещения, «уберут» блики с компьютерных мониторов и телевизоров, повысят прочностные характеристики стекла.' ],
        [ 'title' => 'Виниловые',            'img' => 'types-2.png', 'desc' => 'Виниловые пленки помогут внести в помещение гармонию, подчеркнуть его привлекательную индивидуальность. Оклейка окон пленкой из винила внесет свежесть и оригинальность, лаконично вливаясь в цветовую гамму ваших стен.' ],
        [ 'title' => 'Матовые и полупрозрачные', 'img' => 'types-6.png', 'desc' => 'Матовые тонированные окна и стеклянные перегородки придают интерьеру определённую изысканность и стиль, создавая внутри него атмосферу комфорта и уюта.' ],
    ],

    // About areas
    'about_areas_default' => [
        'Защита от ультрафиолета — сохранность мебели, отделки и техники от выцветания',
        'Снижение теплового излучения и перегрева помещений',
        'Снижение затрат на кондиционирование и комфортный микроклимат',
        'Скрытие помещения от посторонних глаз при сохранении освещённости',
        'Защитный эффект — стекло не разлетается осколками при повреждении',
    ],

    // Call measurer list
    'cm_list_default' => [
        'Ответим на все интересующие вас вопросы',
        'Произведем полный комплекс замеров на объекте',
        'Предоставим образцы материалов и фотографии',
        'Объясним тонкости и нюансы монтажа',
    ],
    'cm_features_default' => [
        [ 'icon' => '🛡', 'text' => 'Гиппоаллергенные материалы' ],
        [ 'icon' => '◎',  'text' => 'Высокая детализация' ],
        [ 'icon' => '▤',  'text' => 'Варианты пленки' ],
    ],

    // Prices
    'prices_rows_default' => [
        [ 'type' => 'Атермальная',  'range' => 100, 'price' => 'от 500 ₽/м²', 'term' => '2–3 дня' ],
        [ 'type' => 'Зеркальная',   'range' => 24,  'price' => 'от 500 ₽/м²', 'term' => '3–4 недели' ],
        [ 'type' => 'Односторонняя','range' => 32,  'price' => 'от 500 ₽/м²', 'term' => '2 часа' ],
        [ 'type' => 'Матовая',      'range' => 82,  'price' => 'от 500 ₽/м²', 'term' => '2–3 дня' ],
        [ 'type' => 'Декор',        'range' => 43,  'price' => 'от 500 ₽/м²', 'term' => '3–4 недели' ],
        [ 'type' => 'Бронеплёнка',  'range' => 67,  'price' => 'от 500 ₽/м²', 'term' => '2 часа' ],
    ],

    // Cases
    'cases_default' => [
        [ 'title' => 'Тонирование окон',             'img_after' => 'Tonirovanie_okon_posle_2b3cbc90da.png', 'img_before' => 'c1.png', 'object' => 'Окно ПВХ',  'district' => 'Октябрьский', 'qty' => '12 шт.', 'area' => '22 м²',   'term' => '1 день', 'review' => 'Заказывали тонировку во всей квартире. Приехали в удобное время, всё сделали за один день. Окна выглядят аккуратно, без пузырей. Рекомендую.' ],
        [ 'title' => 'Тонировка перегородок в офисе','img_after' => 'Montazh_moskitnyh_setok_posle_775004f142.png', 'img_before' => 'c2.png', 'object' => 'Офис',     'district' => 'Центральный', 'qty' => '10 шт.', 'area' => '35 м²',   'term' => '1 день', 'review' => 'Сделали тонировку стеклянных перегородок в кабинете. Стало намного комфортнее работать — появилось больше приватности, при этом помещение осталось светлым.' ],
        [ 'title' => 'Атермальная плёнка в офис',    'img_after' => 'Atermalnaya_plyonka_v_ofis_posle_caaa32140f.png', 'img_before' => 'c3.png', 'object' => 'Офис',     'district' => 'Центральный', 'qty' => '8 шт.',  'area' => '45 м²',   'term' => '1 день', 'review' => 'Тонировали окна в переговорной — солнце слепило и жара была невыносимая. Поставили атермальную плёнку: в помещении стало комфортно.' ],
        [ 'title' => 'Тонировка окон',               'img_after' => 'Razdvizhnye_setki_na_lodzhiyu_posle_51be047da7.png', 'img_before' => 'c4.png', 'object' => 'Окно ПВХ', 'district' => 'Северный',   'qty' => '4 шт.',  'area' => '17 м²',   'term' => '1 день', 'review' => 'Заказывали тонировку окон в квартире, потому что летом было очень жарко и солнце сильно светило в комнату.' ],
        [ 'title' => 'Зеркальная тонировка витрины', 'img_after' => 'Zerkalnaya_tonirovka_vitriny_posle_1afe04a743.png', 'img_before' => 'c5.png', 'object' => 'Витрина',  'district' => 'Южный',       'qty' => '2 шт.',  'area' => '18 м²',   'term' => '1 день', 'review' => 'Нужна была тонировка витрины магазина — чтобы с улицы не было видно внутрь, а изнутри обзор сохранялся.' ],
        [ 'title' => 'Зеркальный фасад',             'img_after' => 'Plisse_i_tonirovka_v_kottedzhe_posle_611da9159b.png', 'img_before' => 'c6.png', 'object' => 'Коттедж',  'district' => 'Западный',    'qty' => '30+',    'area' => '100+ м²', 'term' => '3 дня',  'review' => 'Установили зеркальную тонировку на фасад офиса — результат превзошёл ожидания.' ],
    ],

    // Why
    'why_items_default' => [
        [ 'text' => 'Бесплатный замер',            'svg_key' => 'why_svg_1' ],
        [ 'text' => 'Монтаж за 1 день',            'svg_key' => 'why_svg_2' ],
        [ 'text' => 'Чисто и без пузырей',         'svg_key' => 'why_svg_3' ],
        [ 'text' => 'Без предоплаты',              'svg_key' => 'why_svg_4' ],
        [ 'text' => 'Сертифицированные материалы', 'svg_key' => 'why_svg_5' ],
        [ 'text' => 'Гарантия 3–5 лет',            'svg_key' => 'why_svg_6' ],
    ],

    // FAQ
    'faq_default' => [
        [ 'q' => 'Затемнение/светопропускание',       'a' => 'Светопропускание (VLT) показывает, сколько процентов видимого света проходит через плёнку. Чем ниже значение — тем темнее плёнка и лучше затемнение. Подбираем пленку под ваши задачи: от лёгкой тонировки до полного затемнения.' ],
        [ 'q' => 'Односторонняя видимость день/ночь', 'a' => 'Зеркальные и односторонние плёнки днём снаружи работают как зеркало (с улицы не видно внутрь), изнутри — прозрачно. Ночью при включённом свете видимость может измениться: с улицы станет заметнее освещение.' ],
        [ 'q' => 'Насколько снижается жара (TSER)',   'a' => 'TSER — доля солнечной энергии, которую плёнка отражает или поглощает. Атермальные и солнцезащитные плёнки снижают нагрев на 30–60% и более в зависимости от типа.' ],
        [ 'q' => 'Можно ли зимой',                    'a' => 'Да. Современные тонировочные плёнки монтируются при температуре от +5 °C (при правильной подготовке — до 0 °C). Зимой работаем с обогревом или в отапливаемых помещениях.' ],
        [ 'q' => 'Срок службы/уход',                  'a' => 'Качественная плёнка служит 10–15 лет и дольше при правильном уходе. Достаточно мыть стекло мягкой губкой и водой без абразивов и агрессивной химии.' ],
        [ 'q' => 'Гарантия',                          'a' => 'Даём гарантию 12 месяцев на работы и материалы. Она распространяется на отслоение, пузыри и дефекты монтажа при соблюдении правил эксплуатации.' ],
        [ 'q' => 'Что влияет на цену',                'a' => 'На итоговую цену влияют: тип и марка плёнки, площадь остекления, сложность доступа (высота, леса), дополнительные работы (демонтаж жалюзи, плёнка на двери).' ],
        [ 'q' => 'Сроки работ',                       'a' => 'Небольшие объекты (квартира, офис) — обычно 1–2 дня. Крупные объекты и нестандартные плёнки — по индивидуальному графику.' ],
    ],
];

// Утилита: получить строки repeater или дефолтный массив
$fp_rows = function( string $field, array $fallback ) use ( $d ): array {
    $rows = fp_repeater( $field );
    return $rows ?: $fallback;
};

// img dir
$img = esc_url( get_template_directory_uri() ) . '/img/';
?>

<main class="main">

    <?php /* ═══════════════════════════════════════════════════════ HERO ══ */ ?>
    <section class="hero hero_bg" aria-label="Главный экран">
        <?php
        $hero_img_url = fp_image( 'hero_image', 'hero.png' );
        ?>
        <div class="hero__bg" id="hero-bg" style="background-image: url('<?php echo esc_url( $hero_img_url ); ?>');">
            <img src="<?php echo esc_url( $hero_img_url ); ?>" alt="" role="presentation" id="hero-bg-img">
        </div>
        <div class="hero__overlay" aria-hidden="true"></div>
        <div class="hero__container container">
            <div class="hero__content">
                <h1 class="hero__title">
                    <?php fp_field( 'hero_title', 'Установка окон от компании от 750 рублей' ); ?>
                </h1>
                <p class="hero__subtitle">
                    <?php fp_field( 'hero_subtitle', 'Выезд замерщика за 1 день' ); ?>
                </p>
                <ul class="hero__benefits">
                    <?php
                    $benefits_raw = fp_get( 'hero_benefits', implode( "\n", $d['hero_benefits_default'] ) );
                    $benefits     = array_filter( explode( "\n", str_replace( "\r", '', $benefits_raw ) ) );
                    foreach ( $benefits as $b ) :
                    ?>
                        <li><?php echo esc_html( trim( $b ) ); ?></li>
                    <?php endforeach; ?>
                </ul>
                <a href="#calc" class="hero__cta">
                    <?php fp_field( 'hero_cta_text', 'Заказать установку' ); ?>
                </a>
            </div>
            <div class="hero__advantages">
                <?php foreach ( $fp_rows( 'hero_advantages', $d['hero_advantages_default'] ) as $adv ) : ?>
                    <div class="hero__advantage">
                        <div class="hero__advantage-icon" aria-hidden="true"><?php echo esc_html( $adv['icon'] ?? '' ); ?></div>
                        <div class="hero__advantage-title"><?php echo esc_html( $adv['title'] ?? '' ); ?></div>
                        <p class="hero__advantage-text"><?php echo esc_html( $adv['text'] ?? '' ); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php /* ══════════════════════════════════════════════════ SOLUTIONS ══ */ ?>
    <section class="solutions" id="services">
        <div class="solutions__container container">
            <h2 class="solutions__title title2">
                <?php fp_field( 'solutions_title', 'Что тонируем' ); ?>
            </h2>
            <ul class="solutions__grid">
                <?php foreach ( $fp_rows( 'solutions_items', $d['solutions_default'] ) as $sol ) :
                    // ACF repeater item или дефолт-массив
                    $sol_name = $sol['name'] ?? '';
                    $sol_img  = '';
                    if ( ! empty( $sol['image']['url'] ) ) {
                        $sol_img = $sol['image']['url'];
                    } elseif ( ! empty( $sol['img'] ) ) {
                        $sol_img = $img . $sol['img'];
                    }
                ?>
                    <li class="solutions__card">
                        <div class="solutions__image-wrapper">
                            <img src="<?php echo esc_url( $sol_img ); ?>"
                                 alt="<?php echo esc_attr( $sol_name ); ?>"
                                 class="solutions__image">
                        </div>
                        <div class="solutions__body">
                            <div class="solutions__header">
                                <h3 class="solutions__name"><?php echo esc_html( $sol_name ); ?></h3>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <?php /* ════════════════════════════════════════════════════════ TYPES ══ */ ?>
    <section class="types types_cards">
        <div class="container">
            <h2 class="types__title title2">
                <?php fp_field( 'types_title', 'Типы пленок' ); ?>
            </h2>
            <div class="types-slider-wrap">
                <div class="swiper types-slider" id="types-slider" aria-label="Карусель типов пленок">
                    <div class="swiper-wrapper">
                        <?php foreach ( $fp_rows( 'types_items', $d['types_default'] ) as $type ) :
                            $t_title = $type['title'] ?? '';
                            $t_desc  = $type['desc']  ?? '';
                            $t_btn   = $type['btn_text'] ?? 'Узнать точную стоимость';
                            $t_img   = '';
                            if ( ! empty( $type['image']['url'] ) ) {
                                $t_img = $type['image']['url'];
                            } elseif ( ! empty( $type['img'] ) ) {
                                $t_img = $img . $type['img'];
                            }
                        ?>
                            <div class="swiper-slide">
                                <div class="types__card">
                                    <div class="types__card-image-wrap">
                                        <img src="<?php echo esc_url( $t_img ); ?>"
                                             alt="<?php echo esc_attr( $t_title ); ?>"
                                             class="types__card-image">
                                    </div>
                                    <h3 class="types__card-title"><?php echo esc_html( $t_title ); ?></h3>
                                    <p class="types__card-desc"><?php echo esc_html( $t_desc ); ?></p>
                                    <a href="#calc" class="button types__card-btn js-calc-modal-open">
                                        <?php echo esc_html( $t_btn ); ?>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php /* ═════════════════════════════════════════════════════════ ABOUT ══ */ ?>
    <section class="about" id="about" aria-label="О нас">
        <div class="about__container">
            <div class="about__top">
                <div class="about__image-wrap">
                    <img src="<?php echo esc_url( fp_image( 'about_image', 'solutions-03.png' ) ); ?>"
                         alt="Офис с перегородками из тонированного стекла"
                         class="about__image">
                </div>
                <div class="about__card">
                    <h2 class="about__title"><?php fp_field( 'about_title', 'О нас' ); ?></h2>
                    <p class="about__text"><?php fp_field( 'about_text', 'Окнотюнинг — тонировка окон в Москве и области.' ); ?></p>
                    <div class="about__service">
                        <svg class="about__service-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M7 17L17 7M17 7h-6M17 7v6" />
                        </svg>
                        <h3 class="about__service-title"><?php fp_field( 'about_service1_title', 'Архитектурное тонирование' ); ?></h3>
                        <p class="about__service-desc"><?php fp_field( 'about_service1_desc', 'Оклейка стекол специальными плёнками для снижения теплопритока, защиты от УФ и декора.' ); ?></p>
                    </div>
                    <div class="about__service">
                        <svg class="about__service-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M7 17L17 7M17 7h-6M17 7v6" />
                        </svg>
                        <h3 class="about__service-title"><?php fp_field( 'about_service2_title', 'Декоративная тонировка' ); ?></h3>
                        <p class="about__service-desc"><?php fp_field( 'about_service2_desc', 'Применяется для декора и зонирования.' ); ?></p>
                    </div>
                </div>
            </div>

            <div class="about__bottom">
                <div>
                    <h3 class="about__areas-title"><?php fp_field( 'about_areas_title', 'Области применения' ); ?></h3>
                    <ul class="about__areas-list">
                        <?php
                        $areas_rows = fp_repeater( 'about_areas' );
                        if ( $areas_rows ) :
                            foreach ( $areas_rows as $row ) :
                        ?>
                                <li><?php echo esc_html( $row['text'] ?? '' ); ?></li>
                        <?php
                            endforeach;
                        else :
                            foreach ( $d['about_areas_default'] as $area ) :
                        ?>
                                <li><?php echo esc_html( $area ); ?></li>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </ul>
                    <p class="about__intro"><?php fp_field( 'about_intro', '' ); ?></p>
                    <a href="#calc" class="about__cta js-calc-modal-open">
                        <?php fp_field( 'about_cta_text', 'Узнать стоимость' ); ?>
                    </a>
                </div>

                <div class="about__before-after">
                    <div class="about__before-after-swipe" id="beforeAfterSwipe"
                         role="img" aria-label="Сравнение: окно до и после тонировки">
                        <div class="about__before-after-after">
                            <img src="<?php echo esc_url( fp_image( 'about_after_image', '111.png' ) ); ?>" alt="После тонировки">
                        </div>
                        <div class="about__before-after-before" id="beforeAfterBefore">
                            <img src="<?php echo esc_url( fp_image( 'about_before_image', '222.png' ) ); ?>" alt="До тонировки">
                        </div>
                        <span class="about__before-after-label _left">До</span>
                        <span class="about__before-after-label _right">После</span>
                        <div class="about__before-after-line" id="beforeAfterLine" aria-label="Перетащите для сравнения">
                            <span class="about__before-after-handle"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php /* ═══════════════════════════════════════════ MEASURE PHOTO ══ */ ?>
    <section class="measure-photo" id="measure-photo" aria-label="Расчёт стоимости по фото">
        <div class="container measure-photo__container">
            <h2 class="measure-photo__title">
                <?php fp_field( 'measure_title', 'Расчет стоимости по фото' ); ?>
            </h2>
            <div class="measure-photo__inner">
                <div class="measure-photo__left">
                    <div class="measure-photo__image-wrap">
                        <img src="<?php echo esc_url( fp_image( 'measure_image', 'service_1.png' ) ); ?>"
                             alt="Специалист с рулеткой для замера"
                             class="measure-photo__image">
                    </div>
                </div>
                <div class="measure-photo__right">
                    <div class="measure-photo__card">
                        <h3 class="measure-photo__card-title">
                            <?php fp_field( 'measure_card_title', 'Расчет стоимости' ); ?>
                        </h3>
                        <p class="measure-photo__card-desc">
                            <?php fp_field( 'measure_card_desc', 'Приложите фото для расчета стоимости' ); ?>
                        </p>
                        <form class="measure-photo__form" action="#" method="post">
                            <div class="input input_light">
                                <input type="text" class="input__input" name="name" placeholder="Ваше Имя" required>
                            </div>
                            <div class="input input_light">
                                <input type="tel" class="input__input" name="phone" placeholder="+7 (000) 000-00-00" required>
                            </div>
                            <div class="measure-photo__upload">
                                <p class="measure-photo__upload-hint">Нажмите чтобы загрузить файл</p>
                                <label class="measure-photo__upload-btn">
                                    <input type="file" name="photo" class="measure-photo__file-input" accept=".jpeg,.jpg,.png,.pdf">
                                    <span class="measure-photo__upload-label">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                                        </svg>
                                        Загрузить файл
                                    </span>
                                </label>
                                <p class="measure-photo__upload-note">Файлы: jpeg, png, pdf до 10 мб.</p>
                            </div>
                            <button type="submit" class="button button_primary measure-photo__submit">Рассчитать стоимость</button>
                            <div class="cta__checkboxes">
                                <label class="checkbox">
                                    <input type="checkbox" name="need_measure" class="checkbox__input">
                                    <span class="checkbox__text">Нужен замер</span>
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox" name="telegram_pref" class="checkbox__input">
                                    <span class="checkbox__text">Удобно в Telegram</span>
                                </label>
                            </div>
                            <label class="checkbox measure-photo__agree">
                                <input type="checkbox" class="checkbox__input" name="privacy" required>
                                <span class="checkbox__text">Соглашаюсь с <a href="#" class="measure-photo__privacy-link js-open-privacy">Политикой конфиденциальности</a></span>
                            </label>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php /* ═══════════════════════════════════════════ CALL MEASURER ══ */ ?>
    <section class="call-measurer" id="call-measurer" aria-label="Вызвать замерщика">
        <div class="container call-measurer__container">
            <div class="call-measurer__inner">
                <div class="call-measurer__left">
                    <h2 class="call-measurer__title"><?php fp_field( 'cm_title', 'Пригласите специалиста' ); ?></h2>
                    <p class="call-measurer__subtitle"><?php fp_field( 'cm_subtitle', 'для точных замеров, выбора материала и цвета пленки' ); ?></p>
                    <p class="call-measurer__intro"><?php fp_field( 'cm_intro', 'Сделаем замеры, поможем выбрать внешний вид и расскажем о процессе монтажа.' ); ?></p>

                    <?php
                    // Иконки для пунктов списка (статичные SVG)
                    $cm_svgs = [
                        '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>',
                        '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>',
                        '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M16 13H8"/><path d="M16 17H8"/><path d="M10 9H8"/></svg>',
                        '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>',
                    ];
                    $cm_list_rows = fp_repeater( 'cm_list' ) ?: $d['cm_list_default'];
                    ?>
                    <ul class="call-measurer__list">
                        <?php foreach ( $cm_list_rows as $idx => $item ) :
                            $item_text = is_array( $item ) ? ( $item['text'] ?? $item ) : $item;
                            $svg = $cm_svgs[ $idx ] ?? $cm_svgs[0];
                        ?>
                            <li class="call-measurer__item">
                                <span class="call-measurer__icon" aria-hidden="true"><?php echo $svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                                <span><?php echo esc_html( $item_text ); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="call-measurer__right">
                    <div class="call-measurer__card">
                        <div class="call-measurer__card-image-wrap">
                            <img src="<?php echo esc_url( fp_image( 'cm_card_image', 'service_1.png' ) ); ?>"
                                 alt="Специалист с рулеткой"
                                 class="call-measurer__card-image">
                        </div>
                        <div class="call-measurer__card-body">
                            <h3 class="call-measurer__card-title"><?php fp_field( 'cm_card_title', 'Образцы пленок с собой' ); ?></h3>
                            <ul class="call-measurer__card-features">
                                <?php foreach ( $fp_rows( 'cm_features', $d['cm_features_default'] ) as $feat ) : ?>
                                    <li>
                                        <span class="call-measurer__card-icon"><?php echo esc_html( $feat['icon'] ?? '' ); ?></span>
                                        <?php echo esc_html( $feat['text'] ?? '' ); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <p class="call-measurer__card-bonus"><?php fp_field( 'cm_bonus', 'Пробная оклейка в подарок!' ); ?></p>
                            <a href="#cta" class="button button_primary call-measurer__btn">
                                <?php fp_field( 'cm_btn_text', 'Вызвать замерщика' ); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php /* ═══════════════════════════════════════════════════ PRICES ══ */ ?>
    <div class="prices-calc section-hidden" id="prices">
        <div class="prices-calc__container container">
            <h2 class="prices-calc__title title2">
                <?php fp_field( 'prices_title', 'Цены' ); ?>
            </h2>
            <div class="prices-calc__wrapper">
                <div class="prices-calc__table-wrapper">
                    <table class="prices-calc__table">
                        <thead>
                            <tr>
                                <th class="prices-calc__head-cell">Тип пленки</th>
                                <th class="prices-calc__head-cell">VLT/UVR/TSER</th>
                                <th class="prices-calc__head-cell">Цена от, ₽/м²</th>
                                <th class="prices-calc__head-cell">Срок монтажа</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( $fp_rows( 'prices_rows', $d['prices_rows_default'] ) as $row ) :
                                $range = intval( $row['range'] ?? 50 );
                            ?>
                                <tr class="prices-calc__row">
                                    <td class="prices-calc__type-cell"><?php echo esc_html( $row['type'] ?? '' ); ?></td>
                                    <td class="prices-calc__bars-cell">
                                        <div class="prices-calc__bar-container">
                                            <div class="prices-calc__bar" data-range="<?php echo esc_attr( $range ); ?>"></div>
                                            <span class="prices-calc__percentage">100%</span>
                                        </div>
                                    </td>
                                    <td class="prices-calc__price-cell"><?php echo esc_html( $row['price'] ?? '' ); ?></td>
                                    <td class="prices-calc__term-cell"><?php echo esc_html( $row['term'] ?? '' ); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="prices-calc__footer">
                    <?php fp_field_raw( 'prices_footer', "Минимальный заказ 5000 ₽<br>Выезд Москва — бесплатно, МО — от 100 ₽/км<br>Доп. работы (жалюзи, высота/доступ) — по смете" ); ?>
                    <a href="#calc" class="button button_primary button_outline button_arrow js-calc-modal-open">
                        <?php fp_field( 'prices_cta', 'Точный расчёт' ); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php /* ═══════════════════════════════════════════════════════ CALC ══ */ ?>
    <div id="calc" class="window-calc-page">
        <?php wca_render_calculator(); ?>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 4;
        let qty = 0;
        const minSize = 100;
        let stepAnimationLock = false;
        let categorySwiper = null;
        let stepsSwiper = null;
        const reducedMotionQuery = window.matchMedia("(prefers-reduced-motion: reduce)");
        const pricing = {
            product: 3000, productOld: 8000,
            services: { srv1: 0, srv2: 122, srv3: 290 }
        };
        renderFooter(); initSizeInputs(); initPricing(); initSwipers();
        window.addEventListener("load", initSwipers);
        function goToStep(step) {
            if (step<1||step>totalSteps||step===currentStep||stepAnimationLock) return;
            if (currentStep===1&&step>currentStep&&!validateSizeStep()) return;
            const previousStep=currentStep, previousPanel=document.getElementById("panel-"+previousStep),
                nextPanel=document.getElementById("panel-"+step),direction=step>previousStep?"forward":"backward",
                leaveClass="wcp-step-panel--leave-"+direction,enterClass="wcp-step-panel--enter-"+direction,
                leaveDuration=reducedMotionQuery.matches?0:210,enterDuration=reducedMotionQuery.matches?0:580;
            stepAnimationLock=true;
            previousPanel.classList.remove("wcp-step-panel--enter-forward","wcp-step-panel--enter-backward");
            previousPanel.classList.add(leaveClass);
            updateTabs(step); currentStep=step; renderFooter();
            window.setTimeout(()=>{
                previousPanel.classList.remove("wcp-step-panel--active",leaveClass);
                nextPanel.classList.add("wcp-step-panel--active",enterClass);
                window.setTimeout(()=>{nextPanel.classList.remove(enterClass);stepAnimationLock=false;},enterDuration);
            },leaveDuration);
        }
        function updateTabs(step) {
            for(let i=1;i<=totalSteps;i++){const tab=document.getElementById("tab-"+i);tab.classList.remove("wcp-step--active","wcp-step--done");const num=tab.querySelector(".wcp-step__num");if(i<step){tab.classList.add("wcp-step--done");}else if(i===step){tab.classList.add("wcp-step--active");num.innerHTML="<span>"+i+"</span>";}else{num.innerHTML="<span>"+i+"</span>";}}
            if(stepsSwiper){stepsSwiper.slideTo(Math.max(0,step-1));}
        }
        function renderFooter(){const fa=document.getElementById("footerActions");fa.innerHTML="";if(currentStep===1){const btn=mkBtn("primary",'Выбрать объект для тонировки <span class="ico-arrow-right"></span>',()=>goToStep(2));fa.appendChild(btn);}else if(currentStep===4){const back=mkBtn("secondary",'<span class="ico-arrow-left"></span> Назад',()=>goToStep(currentStep-1));fa.appendChild(back);}else{const back=mkBtn("secondary",'<span class="ico-arrow-left"></span> Назад',()=>goToStep(currentStep-1));const labels=["","","Выбрать тип пленки","Подсчет"];const next=mkBtn("primary",labels[currentStep]+' <span class="ico-arrow-right"></span>',()=>goToStep(currentStep+1));fa.appendChild(back);fa.appendChild(next);}}
        function mkBtn(type,html,cb){const b=document.createElement("button");b.className="wcp-btn wcp-btn--"+type;b.type="button";b.innerHTML=html;b.onclick=cb;return b;}
        function initSwipers(){if(categorySwiper||stepsSwiper)return;if(typeof window.Swiper!=="function"){document.querySelectorAll(".wcp-slider__nav").forEach(b=>b.style.display="none");return;}document.querySelectorAll(".wcp-slider__nav").forEach(b=>b.style.display="");categorySwiper=new window.Swiper("#categorySlider",{watchOverflow:true,speed:500,spaceBetween:12,slidesPerView:"auto",navigation:{prevEl:".wcp-categories-prev",nextEl:".wcp-categories-next"},breakpoints:{921:{slidesPerView:3,allowTouchMove:false}}});stepsSwiper=new window.Swiper("#stepTabs",{watchOverflow:true,speed:500,slidesPerView:"auto",navigation:{prevEl:".wcp-steps-prev",nextEl:".wcp-steps-next"},spaceBetween:8,breakpoints:{921:{spaceBetween:20,slidesPerView:4,allowTouchMove:false}}});updateTabs(currentStep);}
        function initSizeInputs(){["width","height"].forEach(id=>{const input=document.getElementById(id);if(!input)return;input.addEventListener("input",()=>{input.value=sanitizeSizeValue(input.value);toggleSizeError(input,!isValidSizeValue(input.value));});input.addEventListener("blur",()=>{if(!input.value){toggleSizeError(input,true);return;}if(!isValidSizeValue(input.value)){input.value=String(minSize);}toggleSizeError(input,false);});});}
        function sanitizeSizeValue(v){return v.replace(/\D/g,"").slice(0,5);}
        function isValidSizeValue(v){const n=Number(v);return Number.isInteger(n)&&n>=minSize;}
        function toggleSizeError(input,isInvalid){const f=input.closest(".wcp-field");if(f)f.classList.toggle("wcp-field--invalid",isInvalid);}
        function validateSizeStep(){const w=document.getElementById("width"),h=document.getElementById("height"),inputs=[w,h];let ok=true;inputs.forEach(i=>{i.value=sanitizeSizeValue(i.value);const v=isValidSizeValue(i.value);toggleSizeError(i,!v);if(!v)ok=false;});if(!ok){const f=inputs.find(i=>!isValidSizeValue(i.value));if(f)f.focus();}return ok;}
        function initPricing(){Object.keys(pricing.services).forEach(id=>{const cb=document.getElementById(id);if(cb)cb.addEventListener("change",updatePricing);});updatePricing();}
        function updatePricing(){const st=Object.entries(pricing.services).reduce((s,[id,p])=>{const cb=document.getElementById(id);return cb&&cb.checked?s+p:s;},0);const total=pricing.product+st,old=pricing.productOld+st;document.getElementById("servicesPrice").textContent=formatPrice(st);document.getElementById("productPrice").textContent=formatPrice(pricing.product);document.getElementById("totalOldPrice").textContent=formatPrice(old);document.getElementById("totalPrice").innerHTML=formatPriceNumber(total)+" <span>₽</span>";}
        function formatPrice(v){return formatPriceNumber(v)+" ₽";}
        function formatPriceNumber(v){return new Intl.NumberFormat("ru-RU").format(v);}
        function changeQty(delta){qty=Math.max(0,qty+delta);document.getElementById("qtyVal").textContent=qty;}
        function selectOption(el,group,price){const p=el.parentElement;p.querySelectorAll(".wcp-option").forEach(o=>o.classList.remove("wcp-option--selected"));el.classList.add("wcp-option--selected");}
        function selectCategory(el){document.querySelectorAll(".wcp-category").forEach(c=>c.classList.remove("wcp-category--active"));el.classList.add("wcp-category--active");if(categorySwiper){const slides=Array.from(document.querySelectorAll("#categorySlider .wcp-category"));const i=slides.indexOf(el);if(i>=0)categorySwiper.slideTo(i);}goToStep(1);}
    </script>

    <?php /* ═══════════════════════════════════════════════════════ CASES ══ */ ?>
    <section class="cases" id="cases">
        <div class="cases__container container">
            <h2 class="cases__title title2">
                <?php fp_field( 'cases_title', 'Кейсы' ); ?>
            </h2>
            <div class="cases-slider-wrap">
                <div class="swiper cases-slider">
                    <div class="swiper-wrapper">
                        <?php foreach ( $fp_rows( 'cases_items', $d['cases_default'] ) as $case ) :
                            $c_title    = $case['title']    ?? '';
                            $c_object   = $case['object']   ?? '';
                            $c_district = $case['district'] ?? '';
                            $c_qty      = $case['qty']      ?? '';
                            $c_area     = $case['area']     ?? '';
                            $c_term     = $case['term']     ?? '';
                            $c_review   = $case['review']   ?? '';
                            $c_after    = '';
                            $c_before   = '';
                            if ( ! empty( $case['img_after']['url'] ) ) {
                                $c_after = $case['img_after']['url'];
                            } elseif ( ! empty( $case['img_after'] ) ) {
                                $c_after = $img . $case['img_after'];
                            }
                            if ( ! empty( $case['img_before']['url'] ) ) {
                                $c_before = $case['img_before']['url'];
                            } elseif ( ! empty( $case['img_before'] ) ) {
                                $c_before = $img . $case['img_before'];
                            }
                        ?>
                            <div class="swiper-slide case"
                                 data-case-title="<?php echo esc_attr( $c_title ); ?>"
                                 data-case-object="<?php echo esc_attr( $c_object ); ?>"
                                 data-case-district="<?php echo esc_attr( $c_district ); ?>"
                                 data-case-area="<?php echo esc_attr( $c_area ); ?>"
                                 data-case-qty="<?php echo esc_attr( $c_qty ); ?>"
                                 data-case-term="<?php echo esc_attr( $c_term ); ?>"
                                 data-case-review="<?php echo esc_attr( $c_review ); ?>">
                                <div class="case__images">
                                    <img style="display:block;" src="<?php echo esc_url( $c_after ); ?>" alt="После">
                                    <img style="display:none;" src="<?php echo esc_url( $c_before ); ?>" alt="До">
                                </div>
                                <div class="case__body">
                                    <h3 class="case__title"><?php echo esc_html( $c_title ); ?></h3>
                                    <div class="case__stats">
                                        <?php if ( $c_object )   echo '<div class="case__stat"><span>Объект:</span> <strong>' . esc_html( $c_object ) . '</strong></div>'; ?>
                                        <?php if ( $c_district ) echo '<div class="case__stat"><span>Район:</span> <strong>' . esc_html( $c_district ) . '</strong></div>'; ?>
                                        <?php if ( $c_qty )      echo '<div class="case__stat"><span>Кол-во:</span> <strong>' . esc_html( $c_qty ) . '</strong></div>'; ?>
                                        <?php if ( $c_area )     echo '<div class="case__stat"><span>Площадь:</span> <strong>' . esc_html( $c_area ) . '</strong></div>'; ?>
                                        <?php if ( $c_term )     echo '<div class="case__stat"><span>Срок:</span> <strong>' . esc_html( $c_term ) . '</strong></div>'; ?>
                                    </div>
                                    <?php if ( $c_review ) : ?>
                                        <div class="case__review _dark">
                                            <div class="case__review-header">Отзыв клиента</div>
                                            <p class="case__review-text"><?php echo esc_html( $c_review ); ?></p>
                                        </div>
                                    <?php endif; ?>
                                    <button type="button" class="button button_arrow button_outline button_primary js-case-open">Подробнее</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php /* ═══════════════════════════════════════════════════════ WHY ══ */ ?>
    <?php
    // SVG-иконки для блока "Почему мы" (используются как фолбэк если поле пустое)
    $why_svgs_default = [
        '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#wh1)"><path d="M47.7254 9.5161L43.194 4.98459C43.0181 4.80879 42.7797 4.70996 42.531 4.70996C42.2824 4.70996 42.0439 4.80879 41.868 4.98459L24.9628 21.8898L21.7915 18.7185C19.3798 16.3067 16.1733 14.9786 12.7627 14.9786C9.35198 14.9786 6.14551 16.3067 3.73386 18.7185C-1.24462 23.697 -1.24462 31.7976 3.73386 36.7762C5.87003 38.9122 8.67952 40.2154 11.6798 40.4695L14.2259 43.0156C14.409 43.1987 14.649 43.2903 14.8889 43.2903C15.1288 43.2903 15.3688 43.1987 15.5519 43.0156L30.1572 28.4103C30.5233 28.0442 30.5233 27.4505 30.1572 27.0843L29.4259 26.353L45.6681 10.1108L46.3994 10.8422C46.7656 11.2082 47.3591 11.2084 47.7254 10.8422C48.0916 10.476 48.0916 9.88234 47.7254 9.5161Z" fill="white"/></g><defs><clipPath id="wh1"><rect width="48" height="48" fill="white"/></clipPath></defs></svg>',
        '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M35.8361 37.9984C35.7791 37.5659 35.6841 37.2084 35.5454 36.9057C35.3741 36.5472 35.1852 36.3038 34.9458 36.1282C34.6772 35.9314 34.3719 35.8316 34.0381 35.8316H28.8474V6.61292C28.8474 6.29853 28.7668 6.01821 28.6081 5.78034C28.4316 5.51552 28.1518 5.32975 27.7528 5.21271C27.4766 5.12921 27.0974 5.07266 26.594 5.03986C26.1723 5.01232 25.6262 5 24.823 5C24.2296 5 23.7608 5 23.3873 5.0098C22.9964 5.02004 22.6745 5.04141 22.4344 5.07273C22.1587 5.10717 21.9305 5.15534 21.7368 5.21984C21.5168 5.29814 21.3448 5.38824 21.1975 5.49964L13.4138 10.5395C13.1425 10.7283 12.9405 10.881 12.777 11.0547C12.5611 11.2734 12.4022 11.5347 12.3045 11.8318C12.2065 12.0963 12.1448 12.4099 12.1212 12.7644C12.1011 13.0674 12.0908 13.4574 12.0908 13.9237V35.8316H13.9812C14.3248 35.8316 14.6388 35.9421 14.8913 36.1515C15.1084 36.3252 15.29 36.5684 15.446 36.8947C15.5847 37.2085 15.6798 37.566 15.737 38.0008C15.7868 38.3894 15.81 38.8512 15.81 39.4541C15.81 40.0212 15.7788 40.4942 15.7148 40.8999C15.6413 41.365 15.5442 41.7086 15.4094 41.9808C15.2476 42.3173 15.0564 42.5597 14.8251 42.7213C14.568 42.9037 14.2748 43 13.977 43H34.0435C34.36 43 34.663 42.9037 34.9201 42.7213C35.1629 42.5518 35.3665 42.292 35.5102 41.9688C35.642 41.6987 35.7375 41.3583 35.8098 40.9C35.8738 40.4942 35.905 40.0213 35.905 39.4541C35.905 38.8511 35.8818 38.3893 35.8317 37.9984H35.8361Z" fill="white"/></svg>',
        '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M30.1875 37.5938C34.323 37.5938 37.6875 40.9583 37.6875 45.0938C37.6875 45.6114 38.1073 46.0312 38.625 46.0312C39.1427 46.0312 39.5625 45.6114 39.5625 45.0938C39.5625 40.9583 42.927 37.5938 47.0625 37.5938C47.5802 37.5938 48 37.1739 48 36.6562C48 36.1386 47.5802 35.7188 47.0625 35.7188C42.927 35.7188 39.5625 32.3542 39.5625 28.2188C39.5625 27.7011 39.1427 27.2812 38.625 27.2812C38.1073 27.2812 37.6875 27.7011 37.6875 28.2188C37.6875 32.3542 34.323 35.7188 30.1875 35.7188C29.6698 35.7188 29.25 36.1386 29.25 36.6562C29.25 37.1739 29.6698 37.5938 30.1875 37.5938Z" fill="white"/></svg>',
        '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#wh4)"><path d="M8.0625 24C8.0625 23.4825 7.64246 23.0625 7.125 23.0625C6.60754 23.0625 6.1875 23.4825 6.1875 24C6.1875 24.5175 6.60754 24.9375 7.125 24.9375C7.64246 24.9375 8.0625 24.5175 8.0625 24Z" fill="white"/><path d="M23.9999 6.1875C15.5499 6.1875 8.42347 12.1194 6.62501 20.0654C6.51039 20.5704 6.82716 21.0725 7.33216 21.1868C7.83717 21.3007 8.33924 20.9846 8.4535 20.4796C10.0824 13.2847 16.6204 8.0625 23.9999 8.0625C32.7879 8.0625 39.9374 15.212 39.9374 24C39.9374 32.788 32.7879 39.9375 23.9999 39.9375C16.6204 39.9375 10.0824 34.7153 8.4535 27.5204C8.33924 27.0154 7.8379 26.6986 7.33216 26.8132C6.82716 26.9275 6.51039 27.4296 6.62501 27.9346C8.42494 35.8861 15.5562 41.8125 23.9999 41.8125C33.8217 41.8125 41.8124 33.8218 41.8124 24C41.8124 14.1782 33.8217 6.1875 23.9999 6.1875Z" fill="white"/><path d="M24 0C11.1075 0 0 11.0365 0 24C0 36.9272 11.0735 48 24 48C36.8925 48 48 36.9635 48 24C48 11.0728 36.9265 0 24 0ZM24 46.125C12.2139 46.125 1.875 35.7861 1.875 24C1.875 12.2139 12.2139 1.875 24 1.875C35.7861 1.875 46.125 12.2139 46.125 24C46.125 35.7861 35.7861 46.125 24 46.125Z" fill="white"/></g><defs><clipPath id="wh4"><rect width="48" height="48" fill="white"/></clipPath></defs></svg>',
        '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#wh5)"><path d="M42.0005 8.71875C42.5183 8.71875 42.938 8.29903 42.938 7.78125V2.8125C42.938 1.26169 41.6763 0 40.1255 0H2.81299C1.26218 0 0.000488281 1.26169 0.000488281 2.8125V45.1875C0.000488281 46.7383 1.26218 48 2.81299 48H40.1255C41.6763 48 42.938 46.7383 42.938 45.1875V42.5625C42.938 42.0447 42.5183 41.625 42.0005 41.625C41.4827 41.625 41.063 42.0447 41.063 42.5625V45.1875C41.063 45.7044 40.6424 46.125 40.1255 46.125H2.81299C2.29605 46.125 1.87549 45.7044 1.87549 45.1875V2.8125C1.87549 2.29556 2.29605 1.875 2.81299 1.875H40.1255C40.6424 1.875 41.063 2.29556 41.063 2.8125V7.78125C41.063 8.29903 41.4827 8.71875 42.0005 8.71875Z" fill="white"/></g><defs><clipPath id="wh5"><rect width="48" height="48" fill="white"/></clipPath></defs></svg>',
        '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M24 48C23.9407 48 23.8813 47.9945 23.8228 47.9832C18.1351 46.8893 12.9712 43.8278 9.28235 39.3622C5.59387 34.8966 3.5625 29.2474 3.5625 23.4554V7.04736C3.5625 6.63757 3.82874 6.27502 4.21985 6.15271L23.6902 0.0527344C23.7887 0.0183105 23.8967 0.00219727 24 0H24.0011C24.1073 0 24.2117 0.0183105 24.3102 0.0527344L43.7802 6.15271C44.1713 6.27539 44.4375 6.63757 44.4375 7.04736V23.4554C44.4375 29.2474 42.4061 34.8966 38.7173 39.3622C35.0288 43.8278 29.8649 46.8893 24.1772 47.9832C24.1187 47.9945 24.0593 48 24 48Z" fill="white"/></svg>',
    ];
    $why_rows = fp_repeater( 'why_items' ) ?: $d['why_items_default'];
    ?>
    <div class="why">
        <div class="why__container container">
            <h2 class="why__title title2">
                <?php fp_field( 'why_title', 'Почему мы?' ); ?>
            </h2>
            <ul class="why__grid">
                <?php foreach ( $why_rows as $idx => $item ) :
                    $why_text = is_array( $item ) ? ( $item['text'] ?? '' ) : '';
                    // SVG: из поля ACF или дефолт
                    $why_svg  = ( is_array( $item ) && ! empty( $item['svg'] ) )
                        ? $item['svg']
                        : ( $why_svgs_default[ $idx ] ?? '' );
                ?>
                    <li class="why__item">
                        <?php echo $why_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        <span><?php echo esc_html( $why_text ); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <?php /* ═══════════════════════════════════════════════════════ FAQ ══ */ ?>
    <section class="blog faq">
        <div class="blog__container container">
            <h2 class="blog__title title2">
                <?php fp_field( 'faq_title', 'FAQ' ); ?>
            </h2>
            <div class="faq__list">
                <?php
                $faq_rows = fp_repeater( 'faq_items' );
                if ( $faq_rows ) :
                    foreach ( $faq_rows as $faq ) :
                ?>
                        <details class="faq__item">
                            <summary class="faq__head">
                                <span class="faq__icon" aria-hidden="true"></span>
                                <span class="faq__title"><?php echo esc_html( $faq['question'] ?? '' ); ?></span>
                            </summary>
                            <div class="faq__body-wrap">
                                <div class="faq__body">
                                    <p class="faq__text"><?php echo esc_html( $faq['answer'] ?? '' ); ?></p>
                                </div>
                            </div>
                        </details>
                <?php
                    endforeach;
                else :
                    foreach ( $d['faq_default'] as $faq ) :
                ?>
                        <details class="faq__item">
                            <summary class="faq__head">
                                <span class="faq__icon" aria-hidden="true"></span>
                                <span class="faq__title"><?php echo esc_html( $faq['q'] ); ?></span>
                            </summary>
                            <div class="faq__body-wrap">
                                <div class="faq__body">
                                    <p class="faq__text"><?php echo esc_html( $faq['a'] ); ?></p>
                                </div>
                            </div>
                        </details>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>

    <?php /* ═══════════════════════════════════════════════════════ GEO ══ */ ?>
    <section class="geo" id="contacts">
        <div class="container">
            <h2 class="geo__title title2"><?php fp_field( 'geo_title', 'Контакты и гео' ); ?></h2>
        </div>
        <div class="geo__wrapper">
            <div class="geo__inner">
                <div class="geo__card">
                    <ul class="geo__list">
                        <li class="geo__item">
                            <span class="geo__icon" aria-hidden="true"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></span>
                            <span class="geo__text"><?php fp_field( 'geo_address', 'г. Москва, ул. Никольская, д.29' ); ?></span>
                        </li>
                        <li class="geo__item">
                            <span class="geo__icon" aria-hidden="true"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></span>
                            <span class="geo__text"><?php fp_field( 'geo_hours', 'Ежедневно с 9:00 до 20:00' ); ?></span>
                        </li>
                        <li class="geo__item">
                            <span class="geo__icon" aria-hidden="true"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg></span>
                            <span class="geo__text">
                                <a href="tel:<?php fp_field( 'geo_phone', '89870915171' ); ?>">
                                    <?php fp_field( 'geo_phone_display', '8 (987) 091 51 71' ); ?>
                                </a>
                            </span>
                        </li>
                        <li class="geo__item">
                            <span class="geo__icon" aria-hidden="true"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg></span>
                            <span class="geo__text">
                                <a href="<?php echo esc_url( fp_get( 'geo_telegram_url', 'https://t.me/tg_id' ) ); ?>">
                                    <?php fp_field( 'geo_telegram_label', 'Telegram: @tg_id' ); ?>
                                </a>
                            </span>
                        </li>
                    </ul>

                    <a href="#cta" class="geo__button button">
                        <?php fp_field( 'geo_call_btn', 'Позвоните мне' ); ?>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 24C5.383 24 0 18.617 0 12C0 5.383 5.383 0 12 0C18.617 0 24 5.383 24 12C24 18.617 18.617 24 12 24ZM12 1C5.935 1 1 5.935 1 12C1 18.065 5.935 23 12 23C18.065 23 23 18.065 23 12C23 5.935 18.065 1 12 1Z" fill="#0096D9"/><path d="M15.404 18.9786C10.931 18.9786 5 13.0466 5 8.57363C5 7.60963 5.365 6.71462 6.027 6.05262L6.702 5.46363C7.308 4.85263 8.479 4.83062 9.135 5.48662L10.261 6.94563C10.547 7.22463 10.728 7.66063 10.728 8.12563C10.728 8.59063 10.547 9.02663 10.218 9.35463L9.519 10.2376C10.396 12.2596 11.779 13.6466 13.735 14.4626L14.645 13.7376C15.323 13.0826 16.41 13.0876 17.082 13.7586L18.443 14.7986C19.17 15.5196 19.17 16.6226 18.492 17.2996L17.949 17.9246C17.264 18.6126 16.369 18.9766 15.405 18.9766L15.404 18.9786Z" fill="#0096D9"/></svg>
                    </a>
                </div>
                <div class="geo__map">
                    <?php
                    $map_embed = fp_get( 'geo_map_embed', '' );
                    if ( $map_embed ) {
                        // Разрешаем только iframe
                        echo wp_kses( $map_embed, [
                            'iframe' => [
                                'src'             => true,
                                'width'           => true,
                                'height'          => true,
                                'allowfullscreen' => true,
                                'referrerpolicy'  => true,
                                'title'           => true,
                                'frameborder'     => true,
                                'style'           => true,
                            ],
                        ] );
                    } else {
                        echo '<iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A0fc18ce58211c21b49973611d18a1ba845e075cc79f19d94eabcc019050a5024&amp;source=constructor" width="100%" height="600" allowfullscreen="" referrerpolicy="no-referrer-when-downgrade" title="Яндекс.Карта"></iframe>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <?php /* ════════════════════════════════════════════════════════ CTA ══ */ ?>
    <section class="cta" id="cta">
        <div class="container">
            <div class="cta__container">
                <div class="cta__info">
                    <h2 class="cta__title title2">
                        <?php fp_field( 'cta_title', 'Нужен расчёт или замер сегодня?' ); ?>
                    </h2>
                    <p class="cta__subtitle">
                        <?php fp_field( 'cta_subtitle', 'Приедем в удобное время, предложим 2–3 решения и точную смету.' ); ?>
                    </p>
                    <div class="cta__objects">
                        <img src="<?php echo esc_url( fp_image( 'cta_image', 'cta.png' ) ); ?>"
                             alt="" class="cta__image">
                    </div>
                </div>

                <form class="cta__form" novalidate>
                    <div class="input">
                        <label class="input__label">Имя</label>
                        <input type="text" name="name" class="input__input" placeholder="Иван">
                    </div>
                    <div class="input">
                        <label class="input__label">Телефон</label>
                        <input type="tel" name="phone" class="input__input" placeholder="+7 (___) ___-__-__">
                    </div>
                    <div class="input">
                        <label class="input__label">Дополнительный комментарий</label>
                        <textarea name="comment" class="input__input cta__textarea"></textarea>
                    </div>
                    <div class="cta__checkboxes">
                        <label class="checkbox">
                            <input type="checkbox" name="need_measure" class="checkbox__input">
                            <span class="checkbox__text">Нужен замер</span>
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" name="telegram_pref" class="checkbox__input">
                            <span class="checkbox__text">Удобно в Telegram</span>
                        </label>
                    </div>
                    <button type="submit" class="cta__button button button_primary">Отправить заявку</button>
                    <label class="checkbox cta__privacy">
                        <input type="checkbox" name="privacy" class="checkbox__input" required>
                        <span class="checkbox__text">Соглашаюсь с <a href="#" class="js-open-privacy">Политикой конфиденциальности</a></span>
                    </label>
                </form>
            </div>
        </div>
    </section>

</main>
