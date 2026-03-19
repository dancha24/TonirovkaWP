<?php

if (!function_exists('okna_flex_sub')) {
    function okna_flex_sub(string $name, $fallback = '')
    {
        $value = get_sub_field($name);
        if ($value !== null && $value !== false && $value !== '') {
            return $value;
        }

        return $fallback;
    }
}

if (!function_exists('okna_flex_sub_rows')) {
    function okna_flex_sub_rows(string $name, array $fallback = []): array
    {
        $rows = get_sub_field($name);
        return is_array($rows) && $rows ? $rows : $fallback;
    }
}

if (!function_exists('okna_flex_sub_image')) {
    function okna_flex_sub_image(string $name, string $fallback_filename = '', string $size = 'large'): string
    {
        $img = get_sub_field($name);

        if (is_array($img) && !empty($img['url'])) {
            return $img['sizes'][$size] ?? $img['url'];
        }

        if (is_string($img) && $img) {
            return $img;
        }

        return $fallback_filename ? get_template_directory_uri() . '/img/' . $fallback_filename : '';
    }
}

if (!function_exists('okna_flex_allow_map')) {
    function okna_flex_allow_map(string $html): string
    {
        return wp_kses($html, [
            'iframe' => [
                'src' => true,
                'width' => true,
                'height' => true,
                'allowfullscreen' => true,
                'referrerpolicy' => true,
                'title' => true,
                'frameborder' => true,
                'style' => true,
            ],
        ]);
    }
}

if (!function_exists('okna_front_why_default_svgs')) {
    function okna_front_why_default_svgs(): array
    {
        return [
            '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M24 0l24 24-24 24L0 24 24 0z" fill="white"/></svg>',
            '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="24" cy="24" r="24" fill="white"/></svg>',
            '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" rx="10" fill="white"/></svg>',
            '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M24 4l6.18 12.52L44 18.54l-10 9.75 2.36 13.71L24 35.77 11.64 42 14 28.29 4 18.54l13.82-2.02L24 4z" fill="white"/></svg>',
            '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 8h32v32H8z" stroke="white" stroke-width="4"/></svg>',
            '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M24 4l20 40H4L24 4z" fill="white"/></svg>',
        ];
    }
}

if (!function_exists('render_block_front_hero')) {
    function render_block_front_hero()
    {
        $benefits_raw = okna_flex_sub('hero_benefits', '');
        $benefits = array_filter(explode("\n", str_replace("\r", '', $benefits_raw)));
        $advantages = okna_flex_sub_rows('hero_advantages');
        ?>
        <section class="hero hero_bg" aria-label="Главный экран">
            <div class="hero__bg" id="hero-bg"
                style="background-image: url('<?php echo esc_url(okna_flex_sub_image('hero_image', 'hero.png')); ?>');">
                <img src="<?php echo esc_url(okna_flex_sub_image('hero_image', 'hero.png')); ?>" alt="" role="presentation"
                    id="hero-bg-img">
            </div>
            <div class="hero__overlay" aria-hidden="true"></div>
            <div class="hero__container container">
                <div class="hero__content">
                    <h1 class="hero__title"><?php echo esc_html(okna_flex_sub('hero_title', 'Главный экран')); ?></h1>
                    <p class="hero__subtitle"><?php echo esc_html(okna_flex_sub('hero_subtitle', '')); ?></p>
                    <?php if ($benefits): ?>
                        <ul class="hero__benefits">
                            <?php foreach ($benefits as $benefit): ?>
                                <li><?php echo esc_html(trim($benefit)); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <a href="#calc"
                        class="hero__cta"><?php echo esc_html(okna_flex_sub('hero_cta_text', 'Оставить заявку')); ?></a>
                </div>
                <?php if ($advantages): ?>
                    <div class="hero__advantages">
                        <?php foreach ($advantages as $adv): ?>
                            <div class="hero__advantage">
                                <div class="hero__advantage-icon" aria-hidden="true"><?php echo esc_html($adv['icon'] ?? ''); ?></div>
                                <div class="hero__advantage-title"><?php echo esc_html($adv['title'] ?? ''); ?></div>
                                <p class="hero__advantage-text"><?php echo esc_html($adv['text'] ?? ''); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}

if (!function_exists('render_block_front_solutions')) {
    function render_block_front_solutions()
    {
        $items = okna_flex_sub_rows('solutions_items');
        ?>
        <section class="solutions" id="services">
            <div class="solutions__container container">
                <h2 class="solutions__title title2"><?php echo esc_html(okna_flex_sub('solutions_title', 'Наши услуги')); ?>
                </h2>
                <?php if ($items): ?>
                    <ul class="solutions__grid">
                        <?php foreach ($items as $item): ?>
                            <li class="solutions__card">
                                <div class="solutions__image-wrapper">
                                    <img src="<?php echo esc_url(is_array($item['image'] ?? null) ? ($item['image']['url'] ?? '') : ''); ?>"
                                        alt="<?php echo esc_attr($item['name'] ?? ''); ?>" class="solutions__image">
                                </div>
                                <div class="solutions__body">
                                    <div class="solutions__header">
                                        <h3 class="solutions__name"><?php echo esc_html($item['name'] ?? ''); ?></h3>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}

if (!function_exists('render_block_front_types')) {
    function render_block_front_types()
    {
        $items = okna_flex_sub_rows('types_items');
        ?>
        <section class="types types_cards">
            <div class="container">
                <div class="types__header">
                    <h2 class="types__title title2"><?php echo esc_html(okna_flex_sub('types_title', 'Типы пленок')); ?></h2>
                    <div class="types-slider-nav">
                        <button type="button" class="types-slider-prev" aria-label="Предыдущий">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
                        </button>
                        <button type="button" class="types-slider-next" aria-label="Следующий">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                        </button>
                    </div>
                </div>
                <div class="types-slider-wrap">
                    <div class="swiper types-slider" id="types-slider" aria-label="Карусель типов пленок">
                        <div class="swiper-wrapper">
                            <?php foreach ($items as $item): ?>
                                <div class="swiper-slide">
                                    <div class="types__card">
                                        <div class="types__card-image-wrap">
                                            <img src="<?php echo esc_url(is_array($item['image'] ?? null) ? ($item['image']['url'] ?? '') : ''); ?>"
                                                alt="<?php echo esc_attr($item['title'] ?? ''); ?>" class="types__card-image">
                                        </div>
                                        <h3 class="types__card-title"><?php echo esc_html($item['title'] ?? ''); ?></h3>
                                        <p class="types__card-desc"><?php echo esc_html($item['desc'] ?? ''); ?></p>
                                        <a href="#calc"
                                            class="button types__card-btn js-calc-modal-open"><?php echo esc_html($item['btn_text'] ?? 'Узнать точную стоимость'); ?></a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}

if (!function_exists('render_block_front_about')) {
    function render_block_front_about()
    {
        $areas = okna_flex_sub_rows('about_areas');
        ?>
        <section class="about" id="about" aria-label="О нас">
            <div class="about__container">
                <div class="about__top">
                    <div class="about__image-wrap">
                        <img src="<?php echo esc_url(okna_flex_sub_image('about_image', 'solutions-03.png')); ?>"
                            alt="О нас" class="about__image">
                    </div>
                    <div class="about__card">
                        <h2 class="about__title"><?php echo esc_html(okna_flex_sub('about_title', 'О нас')); ?></h2>
                        <p class="about__text"><?php echo esc_html(okna_flex_sub('about_text', '')); ?></p>
                        <div class="about__service">
                            <svg class="about__service-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" aria-hidden="true">
                                <path d="M7 17L17 7M17 7h-6M17 7v6" />
                            </svg>
                            <h3 class="about__service-title">
                                <?php echo esc_html(okna_flex_sub('about_service1_title', '')); ?></h3>
                            <p class="about__service-desc"><?php echo esc_html(okna_flex_sub('about_service1_desc', '')); ?>
                            </p>
                        </div>
                        <div class="about__service">
                            <svg class="about__service-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" aria-hidden="true">
                                <path d="M7 17L17 7M17 7h-6M17 7v6" />
                            </svg>
                            <h3 class="about__service-title">
                                <?php echo esc_html(okna_flex_sub('about_service2_title', '')); ?></h3>
                            <p class="about__service-desc"><?php echo esc_html(okna_flex_sub('about_service2_desc', '')); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="about__bottom">
                    <div>
                        <h3 class="about__areas-title"><?php echo esc_html(okna_flex_sub('about_areas_title', '')); ?></h3>
                        <?php if ($areas): ?>
                            <ul class="about__areas-list">
                                <?php foreach ($areas as $row): ?>
                                    <li><?php echo esc_html($row['text'] ?? ''); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <p class="about__intro"><?php echo esc_html(okna_flex_sub('about_intro', '')); ?></p>
                    </div>
                    <div class="about__before-after">
                        <div class="about__before-after-swipe" id="beforeAfterSwipe" role="img"
                            aria-label="Сравнение: до и после">
                            <div class="about__before-after-after"><img
                                    src="<?php echo esc_url(okna_flex_sub_image('about_after_image', '111.png')); ?>"
                                    alt="После"></div>
                            <div class="about__before-after-before" id="beforeAfterBefore"><img
                                    src="<?php echo esc_url(okna_flex_sub_image('about_before_image', '222.png')); ?>"
                                    alt="До"></div>
                            <span class="about__before-after-label _left">До</span>
                            <span class="about__before-after-label _right">После</span>
                            <div class="about__before-after-line" id="beforeAfterLine" aria-label="Перетащите для сравнения">
                                <span class="about__before-after-handle"></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}

if (!function_exists('render_block_front_measure_photo')) {
    function render_block_front_measure_photo()
    {
        ?>
        <section class="measure-photo" id="measure-photo" aria-label="Расчет стоимости по фото">
            <div class="container measure-photo__container">
                <h2 class="measure-photo__title">
                    <?php echo esc_html(okna_flex_sub('measure_title', 'Расчет стоимости по фото')); ?></h2>
                <div class="measure-photo__inner">
                    <div class="measure-photo__left">
                        <div class="measure-photo__image-wrap">
                            <img src="<?php echo esc_url(okna_flex_sub_image('measure_image', 'service_1.png')); ?>"
                                alt="Расчет по фото" class="measure-photo__image">
                        </div>
                    </div>
                    <div class="measure-photo__right">
                        <div class="measure-photo__card">
                            <h3 class="measure-photo__card-title">
                                <?php echo esc_html(okna_flex_sub('measure_card_title', 'Расчет стоимости')); ?></h3>
                            <p class="measure-photo__card-desc">
                                <?php echo esc_html(okna_flex_sub('measure_card_desc', 'Приложите фото для расчета стоимости')); ?>
                            </p>
                            <form class="measure-photo__form" action="#" method="post">
                                <div class="input input_light"><input type="text" class="input__input" name="name"
                                        placeholder="Ваше имя" required></div>
                                <div class="input input_light"><input type="tel" class="input__input" name="phone"
                                        placeholder="+7 (000) 000-00-00" required></div>
                                <div class="measure-photo__upload">
                                    <p class="measure-photo__upload-hint">Нажмите чтобы загрузить файл</p>
                                    <label class="measure-photo__upload-btn">
                                        <input type="file" name="photo" class="measure-photo__file-input"
                                            accept=".jpeg,.jpg,.png,.pdf">
                                        <span class="measure-photo__upload-label">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                                <polyline points="17 8 12 3 7 8" />
                                                <line x1="12" y1="3" x2="12" y2="15" />
                                            </svg>
                                            Загрузить файл
                                        </span>
                                    </label>
                                    <p class="measure-photo__upload-note">Файлы: jpeg, png, pdf до 10 мб.</p>
                                </div>
                                <button type="submit" class="button button_primary measure-photo__submit">Рассчитать
                                    стоимость</button>
                                <div class="cta__checkboxes">
                                    <label class="checkbox"><input type="checkbox" name="need_measure"
                                            class="checkbox__input"><span class="checkbox__text">Нужен замер</span></label>
                                    <label class="checkbox"><input type="checkbox" name="telegram_pref"
                                            class="checkbox__input"><span class="checkbox__text">Удобно в МАХ</span></label>
                                </div>
                                <label class="checkbox measure-photo__agree">
                                    <input type="checkbox" class="checkbox__input" name="privacy" required>
                                    <span class="checkbox__text">Соглашаюсь с <a href="#"
                                            class="measure-photo__privacy-link js-open-privacy">Политикой
                                            конфиденциальности</a></span>
                                </label>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}

if (!function_exists('render_block_front_call_measurer')) {
    function render_block_front_call_measurer()
    {
        $cm_svgs = [
            '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>',
            '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>',
            '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M16 13H8"/><path d="M16 17H8"/><path d="M10 9H8"/></svg>',
            '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>',
        ];
        $list = okna_flex_sub_rows('cm_list');
        $features = okna_flex_sub_rows('cm_features');
        ?>
        <section class="call-measurer" id="call-measurer" aria-label="Вызвать замерщика">
            <div class="container call-measurer__container">
                <div class="call-measurer__inner">
                    <div class="call-measurer__left">
                        <h2 class="call-measurer__title">
                            <?php echo esc_html(okna_flex_sub('cm_title', 'Пригласите специалиста')); ?></h2>
                        <p class="call-measurer__subtitle"><?php echo esc_html(okna_flex_sub('cm_subtitle', '')); ?></p>
                        <p class="call-measurer__intro"><?php echo esc_html(okna_flex_sub('cm_intro', '')); ?></p>
                        <?php if ($list): ?>
                            <ul class="call-measurer__list">
                                <?php foreach ($list as $index => $item): ?>
                                    <li class="call-measurer__item">
                                        <span class="call-measurer__icon"
                                            aria-hidden="true"><?php echo $cm_svgs[$index] ?? $cm_svgs[0]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                                        <span><?php echo esc_html($item['text'] ?? ''); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <div class="call-measurer__right">
                        <div class="call-measurer__card">
                            <div class="call-measurer__card-image-wrap">
                                <img src="<?php echo esc_url(okna_flex_sub_image('cm_card_image', 'service_1.png')); ?>"
                                    alt="Замерщик" class="call-measurer__card-image">
                            </div>
                            <div class="call-measurer__card-body">
                                <h3 class="call-measurer__card-title">
                                    <?php echo esc_html(okna_flex_sub('cm_card_title', '')); ?></h3>
                                <?php if ($features): ?>
                                    <ul class="call-measurer__card-features">
                                        <?php foreach ($features as $feature): ?>
                                            <li><span
                                                    class="call-measurer__card-icon"><?php echo esc_html($feature['icon'] ?? ''); ?></span><?php echo esc_html($feature['text'] ?? ''); ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                                <p class="call-measurer__card-bonus"><?php echo esc_html(okna_flex_sub('cm_bonus', '')); ?>
                                </p>
                                <a href="#cta"
                                    class="button button_primary call-measurer__btn"><?php echo esc_html(okna_flex_sub('cm_btn_text', 'Вызвать замерщика')); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}

if (!function_exists('render_block_front_prices')) {
    function render_block_front_prices()
    {
        $rows = okna_flex_sub_rows('prices_rows');
        ?>
        <div class="prices-calc section-hidden" id="prices">
            <div class="prices-calc__container container">
                <h2 class="prices-calc__title title2"><?php echo esc_html(okna_flex_sub('prices_title', 'Цены')); ?></h2>
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
                                <?php foreach ($rows as $row): ?>
                                    <tr class="prices-calc__row">
                                        <td class="prices-calc__type-cell"><?php echo esc_html($row['type'] ?? ''); ?></td>
                                        <td class="prices-calc__bars-cell">
                                            <div class="prices-calc__bar-container">
                                                <div class="prices-calc__bar"
                                                    data-range="<?php echo esc_attr(intval($row['range'] ?? 0)); ?>"></div>
                                                <span class="prices-calc__percentage">100%</span>
                                            </div>
                                        </td>
                                        <td class="prices-calc__price-cell"><?php echo esc_html($row['price'] ?? ''); ?></td>
                                        <td class="prices-calc__term-cell"><?php echo esc_html($row['term'] ?? ''); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="prices-calc__footer">
                        <?php echo wp_kses_post(okna_flex_sub('prices_footer', '')); ?>
                        <a href="#calc"
                            class="button button_primary button_outline button_arrow js-calc-modal-open"><?php echo esc_html(okna_flex_sub('prices_cta', 'Точный расчет')); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

if (!function_exists('okna_render_front_calculator_inline_script')) {
    function okna_render_front_calculator_inline_script()
    {
        ?>
        <script>
            let currentStep = 1; const totalSteps = 4; let qty = 0; const minSize = 100; let stepAnimationLock = false; let categorySwiper = null; let stepsSwiper = null; const reducedMotionQuery = window.matchMedia("(prefers-reduced-motion: reduce)"); const pricing = { product: 3000, productOld: 8000, services: { srv1: 0, srv2: 122, srv3: 290 } }; renderFooter(); initSizeInputs(); initPricing(); initSwipers(); window.addEventListener("load", initSwipers); function goToStep(step) { if (step < 1 || step > totalSteps || step === currentStep || stepAnimationLock) return; if (currentStep === 1 && step > currentStep && !validateSizeStep()) return; const previousStep = currentStep, previousPanel = document.getElementById("panel-" + previousStep), nextPanel = document.getElementById("panel-" + step), direction = step > previousStep ? "forward" : "backward", leaveClass = "wcp-step-panel--leave-" + direction, enterClass = "wcp-step-panel--enter-" + direction, leaveDuration = reducedMotionQuery.matches ? 0 : 210, enterDuration = reducedMotionQuery.matches ? 0 : 580; stepAnimationLock = true; previousPanel.classList.remove("wcp-step-panel--enter-forward", "wcp-step-panel--enter-backward"); previousPanel.classList.add(leaveClass); updateTabs(step); currentStep = step; renderFooter(); window.setTimeout(() => { previousPanel.classList.remove("wcp-step-panel--active", leaveClass); nextPanel.classList.add("wcp-step-panel--active", enterClass); window.setTimeout(() => { nextPanel.classList.remove(enterClass); stepAnimationLock = false; }, enterDuration); }, leaveDuration); } function updateTabs(step) { for (let i = 1; i <= totalSteps; i++) { const tab = document.getElementById("tab-" + i); tab.classList.remove("wcp-step--active", "wcp-step--done"); const num = tab.querySelector(".wcp-step__num"); if (i < step) { tab.classList.add("wcp-step--done"); } else if (i === step) { tab.classList.add("wcp-step--active"); num.innerHTML = "<span>" + i + "</span>"; } else { num.innerHTML = "<span>" + i + "</span>"; } } if (stepsSwiper) { stepsSwiper.slideTo(Math.max(0, step - 1)); } } function renderFooter() { const fa = document.getElementById("footerActions"); if (!fa) return; fa.innerHTML = ""; if (currentStep === 1) { const btn = mkBtn("primary", 'Выбрать объект для тонировки <span class="ico-arrow-right"></span>', () => goToStep(2)); fa.appendChild(btn); } else if (currentStep === 4) { const back = mkBtn("secondary", '<span class="ico-arrow-left"></span> Назад', () => goToStep(currentStep - 1)); fa.appendChild(back); } else { const back = mkBtn("secondary", '<span class="ico-arrow-left"></span> Назад', () => goToStep(currentStep - 1)); const labels = ["", "", "Выбрать тип пленки", "Подсчет"]; const next = mkBtn("primary", labels[currentStep] + ' <span class="ico-arrow-right"></span>', () => goToStep(currentStep + 1)); fa.appendChild(back); fa.appendChild(next); } } function mkBtn(type, html, cb) { const b = document.createElement("button"); b.className = "wcp-btn wcp-btn--" + type; b.type = "button"; b.innerHTML = html; b.onclick = cb; return b; } function initSwipers() { if (categorySwiper || stepsSwiper) return; if (typeof window.Swiper !== "function") { document.querySelectorAll(".wcp-slider__nav").forEach(b => b.style.display = "none"); return; } document.querySelectorAll(".wcp-slider__nav").forEach(b => b.style.display = ""); categorySwiper = new window.Swiper("#categorySlider", { watchOverflow: true, speed: 500, spaceBetween: 12, slidesPerView: "auto", navigation: { prevEl: ".wcp-categories-prev", nextEl: ".wcp-categories-next" }, breakpoints: { 921: { slidesPerView: 3, allowTouchMove: false } } }); stepsSwiper = new window.Swiper("#stepTabs", { watchOverflow: true, speed: 500, slidesPerView: "auto", navigation: { prevEl: ".wcp-steps-prev", nextEl: ".wcp-steps-next" }, spaceBetween: 8, breakpoints: { 921: { spaceBetween: 20, slidesPerView: 4, allowTouchMove: false } } }); updateTabs(currentStep); } function initSizeInputs() { ["width", "height"].forEach(id => { const input = document.getElementById(id); if (!input) return; input.addEventListener("input", () => { input.value = sanitizeSizeValue(input.value); toggleSizeError(input, !isValidSizeValue(input.value)); }); input.addEventListener("blur", () => { if (!input.value) { toggleSizeError(input, true); return; } if (!isValidSizeValue(input.value)) { input.value = String(minSize); } toggleSizeError(input, false); }); }); } function sanitizeSizeValue(v) { return v.replace(/\D/g, "").slice(0, 5); } function isValidSizeValue(v) { const n = Number(v); return Number.isInteger(n) && n >= minSize; } function toggleSizeError(input, isInvalid) { const f = input.closest(".wcp-field"); if (f) f.classList.toggle("wcp-field--invalid", isInvalid); } function validateSizeStep() { const w = document.getElementById("width"), h = document.getElementById("height"), inputs = [w, h]; let ok = true; inputs.forEach(i => { i.value = sanitizeSizeValue(i.value); const v = isValidSizeValue(i.value); toggleSizeError(i, !v); if (!v) ok = false; }); if (!ok) { const f = inputs.find(i => !isValidSizeValue(i.value)); if (f) f.focus(); } return ok; } function initPricing() { Object.keys(pricing.services).forEach(id => { const cb = document.getElementById(id); if (cb) cb.addEventListener("change", updatePricing); }); updatePricing(); } function updatePricing() { const st = Object.entries(pricing.services).reduce((s, [id, p]) => { const cb = document.getElementById(id); return cb && cb.checked ? s + p : s; }, 0); const total = pricing.product + st, old = pricing.productOld + st; const servicesPrice = document.getElementById("servicesPrice"), productPrice = document.getElementById("productPrice"), totalOldPrice = document.getElementById("totalOldPrice"), totalPrice = document.getElementById("totalPrice"); if (servicesPrice) servicesPrice.textContent = formatPrice(st); if (productPrice) productPrice.textContent = formatPrice(pricing.product); if (totalOldPrice) totalOldPrice.textContent = formatPrice(old); if (totalPrice) totalPrice.innerHTML = formatPriceNumber(total) + " <span>₽</span>"; } function formatPrice(v) { return formatPriceNumber(v) + " ₽"; } function formatPriceNumber(v) { return new Intl.NumberFormat("ru-RU").format(v); } function changeQty(delta) { qty = Math.max(0, qty + delta); const el = document.getElementById("qtyVal"); if (el) el.textContent = qty; } function selectOption(el) { const p = el.parentElement; p.querySelectorAll(".wcp-option").forEach(o => o.classList.remove("wcp-option--selected")); el.classList.add("wcp-option--selected"); } function selectCategory(el) { document.querySelectorAll(".wcp-category").forEach(c => c.classList.remove("wcp-category--active")); el.classList.add("wcp-category--active"); if (categorySwiper) { const slides = Array.from(document.querySelectorAll("#categorySlider .wcp-category")); const i = slides.indexOf(el); if (i >= 0) categorySwiper.slideTo(i); } goToStep(1); }
        </script>
        <?php
    }
}

if (!function_exists('render_block_front_calculator')) {
    function render_block_front_calculator()
    {
        if (function_exists('wca_render_calculator')) {
            echo '<div id="calc" class="window-calc-page">';
            wca_render_calculator();
            echo '</div>';
            okna_render_front_calculator_inline_script();
        }
    }
}

if (!function_exists('render_block_front_cases')) {
    function render_block_front_cases()
    {
        $items = okna_flex_sub_rows('cases_items');
        ?>
        <section class="cases" id="cases">
            <div class="cases__container container">
                <div class="cases__header">
                    <h2 class="cases__title title2"><?php echo esc_html(okna_flex_sub('cases_title', 'Кейсы')); ?></h2>
                    <div class="cases-slider-nav">
                        <button type="button" class="cases-slider-prev" aria-label="Предыдущий">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
                        </button>
                        <button type="button" class="cases-slider-next" aria-label="Следующий">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                        </button>
                    </div>
                </div>
                <div class="cases-slider-wrap">
                    <div class="swiper cases-slider">
                        <div class="swiper-wrapper">
                            <?php foreach ($items as $case): ?>
                                <div class="swiper-slide case" data-case-title="<?php echo esc_attr($case['title'] ?? ''); ?>"
                                    data-case-object="<?php echo esc_attr($case['object'] ?? ''); ?>"
                                    data-case-district="<?php echo esc_attr($case['district'] ?? ''); ?>"
                                    data-case-area="<?php echo esc_attr($case['area'] ?? ''); ?>"
                                    data-case-qty="<?php echo esc_attr($case['qty'] ?? ''); ?>"
                                    data-case-term="<?php echo esc_attr($case['term'] ?? ''); ?>"
                                    data-case-review="<?php echo esc_attr($case['review'] ?? ''); ?>">
                                    <div class="case__images">
                                        <img style="display:block;"
                                            src="<?php echo esc_url(is_array($case['img_after'] ?? null) ? ($case['img_after']['url'] ?? '') : ''); ?>"
                                            alt="После">
                                        <img style="display:none;"
                                            src="<?php echo esc_url(is_array($case['img_before'] ?? null) ? ($case['img_before']['url'] ?? '') : ''); ?>"
                                            alt="До">
                                    </div>
                                    <div class="case__body">
                                        <h3 class="case__title"><?php echo esc_html($case['title'] ?? ''); ?></h3>
                                        <div class="case__stats">
                                            <?php if (!empty($case['object'])): ?>
                                                <div class="case__stat"><span>Объект:</span>
                                                    <strong><?php echo esc_html($case['object']); ?></strong></div><?php endif; ?>
                                            <?php if (!empty($case['district'])): ?>
                                                <div class="case__stat"><span>Район:</span>
                                                    <strong><?php echo esc_html($case['district']); ?></strong></div><?php endif; ?>
                                            <?php if (!empty($case['qty'])): ?>
                                                <div class="case__stat"><span>Кол-во:</span>
                                                    <strong><?php echo esc_html($case['qty']); ?></strong></div><?php endif; ?>
                                            <?php if (!empty($case['area'])): ?>
                                                <div class="case__stat"><span>Площадь:</span>
                                                    <strong><?php echo esc_html($case['area']); ?></strong></div><?php endif; ?>
                                            <?php if (!empty($case['term'])): ?>
                                                <div class="case__stat"><span>Срок:</span>
                                                    <strong><?php echo esc_html($case['term']); ?></strong></div><?php endif; ?>
                                        </div>
                                        <?php if (!empty($case['review'])): ?>
                                            <div class="case__review _dark">
                                                <div class="case__review-header">Отзыв клиента</div>
                                                <p class="case__review-text"><?php echo esc_html($case['review']); ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <button type="button"
                                            class="button button_arrow button_outline button_primary js-case-open">Подробнее</button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}

if (!function_exists('render_block_front_why')) {
    function render_block_front_why()
    {
        $items = okna_flex_sub_rows('why_items');
        $svgs = okna_front_why_default_svgs();
        ?>
        <div class="why">
            <div class="why__container container">
                <h2 class="why__title title2"><?php echo esc_html(okna_flex_sub('why_title', 'Почему мы?')); ?></h2>
                <?php if ($items): ?>
                    <ul class="why__grid">
                        <?php foreach ($items as $index => $item): ?>
                            <li class="why__item">
                                <?php echo !empty($item['svg']) ? $item['svg'] : ($svgs[$index] ?? ''); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                <span><?php echo esc_html($item['text'] ?? ''); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}

if (!function_exists('render_block_front_faq')) {
    function render_block_front_faq()
    {
        $items = okna_flex_sub_rows('faq_items');
        ?>
        <section class="blog faq">
            <div class="blog__container container">
                <h2 class="blog__title title2"><?php echo esc_html(okna_flex_sub('faq_title', 'FAQ')); ?></h2>
                <div class="faq__list">
                    <?php foreach ($items as $item): ?>
                        <details class="faq__item">
                            <summary class="faq__head">
                                <span class="faq__icon" aria-hidden="true"></span>
                                <span class="faq__title"><?php echo esc_html($item['question'] ?? ''); ?></span>
                            </summary>
                            <div class="faq__body-wrap">
                                <div class="faq__body">
                                    <p class="faq__text"><?php echo esc_html($item['answer'] ?? ''); ?></p>
                                </div>
                            </div>
                        </details>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}

if (!function_exists('render_block_front_geo')) {
    function render_block_front_geo()
    {
        $map = okna_flex_sub('geo_map_embed', '');
        ?>
        <section class="geo" id="contacts">
            <div class="container">
                <h2 class="geo__title title2"><?php echo esc_html(okna_flex_sub('geo_title', 'Контакты и карта')); ?></h2>
            </div>
            <div class="geo__wrapper">
                <div class="geo__inner">
                    <div class="geo__card">
                        <ul class="geo__list">
                            <li class="geo__item"><span class="geo__icon" aria-hidden="true"><svg width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg></span><span
                                    class="geo__text"><?php echo esc_html(okna_flex_sub('geo_address', '')); ?></span></li>
                            <li class="geo__item"><span class="geo__icon" aria-hidden="true"><svg width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10" />
                                        <polyline points="12 6 12 12 16 14" />
                                    </svg></span><span
                                    class="geo__text"><?php echo esc_html(okna_flex_sub('geo_hours', '')); ?></span></li>
                            <li class="geo__item"><span class="geo__icon" aria-hidden="true"><svg width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                                    </svg></span><span class="geo__text"><a
                                        href="tel:<?php echo esc_attr(okna_flex_sub('geo_phone', '')); ?>"><?php echo esc_html(okna_flex_sub('geo_phone_display', '')); ?></a></span>
                            </li>
                            <li class="geo__item geo__item_max">
                                <a href="<?php echo esc_url(okna_flex_sub('geo_telegram_url', gs_telegram())); ?>" target="_blank" class="geo__max-link" aria-label="МАХ">
                                    <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 1000 1000" width="48" height="48">
                                        <defs>
                                            <linearGradient id="geo-max-flex-a">
                                                <stop offset="0" stop-color="#4cf" />
                                                <stop offset=".662" stop-color="#53e" />
                                                <stop offset="1" stop-color="#93d" />
                                            </linearGradient>
                                            <linearGradient id="geo-max-flex-c" x1="117.847" x2="1000" y1="760.536" y2="500" gradientUnits="userSpaceOnUse" href="#geo-max-flex-a" />
                                        </defs>
                                        <rect width="1000" height="1000" fill="url(#geo-max-flex-c)" ry="249.681" />
                                        <path fill="#fff" fill-rule="evenodd"
                                            d="M508.211 878.328c-75.007 0-109.864-10.95-170.453-54.75-38.325 49.275-159.686 87.783-164.979 21.9 0-49.456-10.95-91.248-23.36-136.873-14.782-56.21-31.572-118.807-31.572-209.508 0-216.626 177.754-379.597 388.357-379.597 210.785 0 375.947 171.001 375.947 381.604.707 207.346-166.595 376.118-373.94 377.224m3.103-571.585c-102.564-5.292-182.499 65.7-200.201 177.024-14.6 92.162 11.315 204.398 33.397 210.238 10.585 2.555 37.23-18.98 53.837-35.587a189.8 189.8 0 0 0 92.71 33.032c106.273 5.112 197.08-75.794 204.215-181.95 4.154-106.382-77.67-196.486-183.958-202.574Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                        <a href="#cta"
                            class="geo__button button"><?php echo esc_html(okna_flex_sub('geo_call_btn', 'Позвоните мне')); ?><svg
                                width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 24C5.383 24 0 18.617 0 12C0 5.383 5.383 0 12 0C18.617 0 24 5.383 24 12C24 18.617 18.617 24 12 24ZM12 1C5.935 1 1 5.935 1 12C1 18.065 5.935 23 12 23C18.065 23 23 18.065 23 12C23 5.935 18.065 1 12 1Z"
                                    fill="#0096D9" />
                                <path
                                    d="M15.404 18.9786C10.931 18.9786 5 13.0466 5 8.57363C5 7.60963 5.365 6.71462 6.027 6.05262L6.702 5.46363C7.308 4.85263 8.479 4.83062 9.135 5.48662L10.261 6.94563C10.547 7.22463 10.728 7.66063 10.728 8.12563C10.728 8.59063 10.547 9.02663 10.218 9.35463L9.519 10.2376C10.396 12.2596 11.779 13.6466 13.735 14.4626L14.645 13.7376C15.323 13.0826 16.41 13.0876 17.082 13.7586L18.443 14.7986C19.17 15.5196 19.17 16.6226 18.492 17.2996L17.949 17.9246C17.264 18.6126 16.369 18.9766 15.405 18.9766L15.404 18.9786Z"
                                    fill="#0096D9" />
                            </svg></a>
                    </div>
                    <div class="geo__map">
                        <?php echo okna_flex_allow_map($map); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}

if (!function_exists('render_block_front_cta')) {
    function render_block_front_cta()
    {
        ?>
        <section class="cta" id="cta">
            <div class="container">
                <div class="cta__container">
                    <div class="cta__info">
                        <h2 class="cta__title title2">
                            <?php echo esc_html(okna_flex_sub('cta_title', 'Нужен расчет или замер сегодня?')); ?></h2>
                        <p class="cta__subtitle"><?php echo esc_html(okna_flex_sub('cta_subtitle', '')); ?></p>
                        <div class="cta__objects"><img
                                src="<?php echo esc_url(okna_flex_sub_image('cta_image', 'cta.png')); ?>" alt=""
                                class="cta__image"></div>
                    </div>
                    <form class="cta__form" novalidate>
                        <div class="input"><label class="input__label">Имя</label><input type="text" name="name"
                                class="input__input" placeholder="Иван"></div>
                        <div class="input"><label class="input__label">Телефон</label><input type="tel" name="phone"
                                class="input__input" placeholder="+7 (___) ___-__-__"></div>
                        <div class="input"><label class="input__label">Дополнительный комментарий</label><textarea
                                name="comment" class="input__input cta__textarea"></textarea></div>
                        <div class="cta__checkboxes">
                            <label class="checkbox"><input type="checkbox" name="need_measure" class="checkbox__input"><span
                                    class="checkbox__text">Нужен замер</span></label>
                            <label class="checkbox"><input type="checkbox" name="telegram_pref" class="checkbox__input"><span
                                    class="checkbox__text">Удобно в МАХ</span></label>
                        </div>
                        <button type="submit" class="cta__button button button_primary">Отправить заявку</button>
                        <label class="checkbox cta__privacy"><input type="checkbox" name="privacy" class="checkbox__input"
                                required><span class="checkbox__text">Соглашаюсь с <a href="#" class="js-open-privacy">Политикой
                                    конфиденциальности</a></span></label>
                    </form>
                </div>
            </div>
        </section>
        <?php
    }
}
