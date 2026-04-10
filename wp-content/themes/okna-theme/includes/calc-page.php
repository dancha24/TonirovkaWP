<?php
function wca_defaults(): array
{
    return [
        // Шапка калькулятора
        'page_title'       => 'Калькулятор',
        'page_subtitle'    => 'Пройдите быстрый опрос и узнайте цену',

        // Шаг 1 — размер
        'size_min'         => 100,
        'size_default_w'   => 100,
        'size_default_h'   => 100,
        'size_default_qty' => 1,
        'size_hint'        => 'При указании размера добавьте 2–3 см на монтаж с каждой стороны.',

        // Категории
        'categories' => [
            ['name' => 'Защита от солнца и жары'],
            ['name' => 'Конфиденциальность'],
            ['name' => 'Декор'],
        ],

        // Шаг 2 — объекты
        'objects' => [
            ['name' => 'Квартира/дом',     'price' => 0, 'image' => ''],
            ['name' => 'Офис/перегородки', 'price' => 0, 'image' => ''],
            ['name' => 'Витрина/фасад',    'price' => 0, 'image' => ''],
        ],

        'films' => [
            ['name' => 'Атермальная',               'price' => 2500, 'image' => ''],
            ['name' => 'Зеркальная/односторонняя',  'price' => 1600, 'image' => ''],
            ['name' => 'Матовая/блэкаут',          'price' => 1750, 'image' => ''],
            ['name' => 'Декор',                     'price' => 2800, 'image' => ''],
            ['name' => 'Бронирующая/защитная',      'price' => 1600, 'image' => ''],
        ],

        // Шаг 4 — результат
        'base_price'       => 16000,
        'old_price'        => 16000,
        // Параметры расчетов (задаются в админке)
        'min_order_area_m2'=> 10,      // порог "до X м2" для минимального заказа
        'travel_mkad_rub'  => 2000,   // выезд/доставка внутри МКАД
        'scaffold_rate_rub_per_m2' => 300, // подмащивание: руб/м2
        // Тексты пунктов "подмащивание" (для чекбоксов на шаге 1)
        'scaffold_base_label' => '* работа с использованием средств подмащивания (лестница, стремянка и т.д) - {rate}р/м2',
        'scaffold_height_gt2_label' => '* работа на высоте более 2-х метров с использованием средств подмащивания рассчитываются отдельно',
        // Шаг 1 — подмащивание (набор пунктов в админке)
        // Первый пункт используется как "основная" галочка (id=`wcpScaffold`), остальные зависят от неё.
        'scaffold_items' => [
            [
                'label' => '* работа с использованием средств подмащивания (лестница, стремянка и т.д) - {rate}р/м2',
                'rate' => 300,
                'affects_price' => 1,
            ],
            [
                'label' => '* работа на высоте более 2-х метров с использованием средств подмащивания рассчитываются отдельно',
                'rate' => 0,
                'affects_price' => 0,
            ],
        ],
        'gift_text'        => 'Мытьё окон в подарок',
        'btn_text'         => 'Быстрый заказ',
        'call_hint'        => 'Позвонить через 1 минуту',

        // Дополнительные услуги
        'services' => [
            ['label' => 'Самовывоз', 'hint' => 'сегодня', 'price_text' => '0 ₽',     'checked' => 1],
            ['label' => 'Доставка',  'hint' => 'завтра',  'price_text' => 'от 122 ₽', 'checked' => 0],
            ['label' => 'Монтаж',    'hint' => 'завтра',  'price_text' => 'от 290 ₽', 'checked' => 0],
        ],

        // Подвал
        'footer_note'      => 'Для точного расчета стоимости окна',
        'footer_link_text' => 'пригласите специалиста по замеру',
        'footer_link_url'  => '#',
    ];
}

// ─────────────────────────────────────────────────────────────
// 2. ХЕЛПЕР — получить настройки (дефолты + сохранённые)
// ─────────────────────────────────────────────────────────────
function wca_get(): array
{
    $saved = get_option('wca_settings', []);
    $data = wp_parse_args($saved, wca_defaults());

    // Миграция со старых ключей scaffold_* к новым scaffold_items (если scaffold_items в сохранённых настройках отсутствует).
    if (!is_array($saved) || !array_key_exists('scaffold_items', $saved)) {
        $data['scaffold_items'] = [
            [
                'label' => (string) ($data['scaffold_base_label'] ?? ''),
                'rate' => (int) ($data['scaffold_rate_rub_per_m2'] ?? 0),
                'affects_price' => 1,
            ],
            [
                'label' => (string) ($data['scaffold_height_gt2_label'] ?? ''),
                'rate' => 0,
                'affects_price' => 0,
            ],
        ];
    }

    return $data;
}

// ─────────────────────────────────────────────────────────────
// 3. РЕГИСТРАЦИЯ СТРАНИЦЫ АДМИНКИ
// ─────────────────────────────────────────────────────────────
add_action('admin_menu', function () {
    add_menu_page(
        'Калькулятор',
        'Калькулятор',
        'manage_options',
        'wca-settings',
        'wca_render_page',
        'dashicons-calculator',
        30
    );
});

// ─────────────────────────────────────────────────────────────
// 4. СОХРАНЕНИЕ ФОРМЫ
// ─────────────────────────────────────────────────────────────
add_action('admin_post_wca_save', function () {
    if (! current_user_can('manage_options')) wp_die('Нет доступа');
    check_admin_referer('wca_save');

    $p = $_POST;

    // Скалярные поля
    $data = [
        'page_title'       => sanitize_text_field($p['page_title'] ?? ''),
        'page_subtitle'    => sanitize_text_field($p['page_subtitle'] ?? ''),
        'size_min'         => absint($p['size_min'] ?? 100),
        'size_default_w'   => absint($p['size_default_w'] ?? 100),
        'size_default_h'   => absint($p['size_default_h'] ?? 100),
        'size_default_qty' => absint($p['size_default_qty'] ?? 0),
        'size_hint'        => sanitize_textarea_field($p['size_hint'] ?? ''),
        'base_price'       => absint($p['base_price'] ?? 0),
        'old_price'        => absint($p['old_price'] ?? 0),
        'min_order_area_m2'=> absint($p['min_order_area_m2'] ?? 10),
        'travel_mkad_rub'  => absint($p['travel_mkad_rub'] ?? 2000),
        'scaffold_rate_rub_per_m2' => absint($p['scaffold_rate_rub_per_m2'] ?? 300),
        'scaffold_base_label' => sanitize_text_field($p['scaffold_base_label'] ?? wca_defaults()['scaffold_base_label']),
        'scaffold_height_gt2_label' => sanitize_text_field($p['scaffold_height_gt2_label'] ?? wca_defaults()['scaffold_height_gt2_label']),
        'gift_text'        => sanitize_text_field($p['gift_text'] ?? ''),
        'btn_text'         => sanitize_text_field($p['btn_text'] ?? ''),
        'call_hint'        => sanitize_text_field($p['call_hint'] ?? ''),
        'footer_note'      => sanitize_text_field($p['footer_note'] ?? ''),
        'footer_link_text' => sanitize_text_field($p['footer_link_text'] ?? ''),
        'footer_link_url'  => esc_url_raw($p['footer_link_url'] ?? '#'),
    ];

    // Категории
    $data['categories'] = [];
    foreach ((array) ($p['categories'] ?? []) as $cat) {
        $name = sanitize_text_field($cat['name'] ?? '');
        if ($name !== '') $data['categories'][] = ['name' => $name];
    }

    // Объекты
    $data['objects'] = [];
    foreach ((array) ($p['objects'] ?? []) as $obj) {
        $name = sanitize_text_field($obj['name'] ?? '');
        if ($name !== '') $data['objects'][] = [
            'name'  => $name,
            'price' => absint($obj['price'] ?? 0),
            'image' => esc_url_raw($obj['image'] ?? ''), // ДОБАВИТЬ
        ];
    }

    // Плёнки
    $data['films'] = [];
    foreach ((array) ($p['films'] ?? []) as $film) {
        $name = sanitize_text_field($film['name'] ?? '');
        if ($name !== '') $data['films'][] = [
            'name'  => $name,
            'price' => absint($film['price'] ?? 0),
            'image' => esc_url_raw($film['image'] ?? ''), // ДОБАВИТЬ
        ];
    }

    // Услуги
    $data['services'] = [];
    foreach ((array) ($p['services'] ?? []) as $srv) {
        $label = sanitize_text_field($srv['label'] ?? '');
        if ($label !== '') $data['services'][] = [
            'label'      => $label,
            'hint'       => sanitize_text_field($srv['hint'] ?? ''),
            'price_text' => sanitize_text_field($srv['price_text'] ?? ''),
            'checked'    => isset($srv['checked']) ? 1 : 0,
        ];
    }

    // Подмащивание (шаг 1) — набор пунктов
    $data['scaffold_items'] = [];
    foreach ((array) ($p['scaffold_items'] ?? []) as $it) {
        $label = sanitize_text_field($it['label'] ?? '');
        if ($label === '') continue;
        $rate = absint($it['rate'] ?? 0);
        $affects = absint($it['affects_price'] ?? 0);
        $data['scaffold_items'][] = [
            'label'         => $label,
            'rate'          => $rate,
            'affects_price' => $affects ? 1 : 0,
        ];
    }
    if (empty($data['scaffold_items'])) {
        $data['scaffold_items'] = [
            [
                'label' => (string) ($data['scaffold_base_label'] ?? ''),
                'rate' => (int) ($data['scaffold_rate_rub_per_m2'] ?? 0),
                'affects_price' => 1,
            ],
            [
                'label' => (string) ($data['scaffold_height_gt2_label'] ?? ''),
                'rate' => 0,
                'affects_price' => 0,
            ],
        ];
    }

    update_option('wca_settings', $data);

    wp_redirect(add_query_arg(['page' => 'wca-settings', 'saved' => '1'], admin_url('admin.php')));
    exit;
});

// ─────────────────────────────────────────────────────────────
// 5. СТИЛИ СТРАНИЦЫ АДМИНКИ
// ─────────────────────────────────────────────────────────────
add_action('admin_head', function () {
    if (! isset($_GET['page']) || $_GET['page'] !== 'wca-settings') return;
?>
    <style>
        .wca-wrap {
            max-width: 900px;
        }

        .wca-wrap h1 {
            margin-bottom: 24px;
        }

        .wca-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 24px 28px;
            margin-bottom: 24px;
        }

        .wca-card h2 {
            font-size: 15px;
            font-weight: 600;
            margin: 0 0 16px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            color: #1d2327;
        }

        /* grid полей */
        .wca-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .wca-grid-3 {
            grid-template-columns: 1fr 1fr 1fr;
        }

        .wca-field {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .wca-field label {
            font-size: 12px;
            font-weight: 600;
            color: #50575e;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .wca-field input[type="text"],
        .wca-field input[type="url"],
        .wca-field input[type="number"],
        .wca-field textarea {
            border: 1px solid #c3c4c7;
            border-radius: 4px;
            padding: 7px 10px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
        }

        .wca-field textarea {
            resize: vertical;
            min-height: 60px;
        }

        /* повторяющиеся строки */
        .wca-repeater {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .wca-repeater-row {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f9f9f9;
            border: 1px solid #e5e5e5;
            border-radius: 5px;
            padding: 10px 12px;
        }

        .wca-repeater-row .handle {
            cursor: grab;
            color: #aaa;
            font-size: 18px;
            flex-shrink: 0;
            line-height: 1;
        }

        .wca-repeater-row input[type="text"],
        .wca-repeater-row input[type="number"] {
            border: 1px solid #c3c4c7;
            border-radius: 4px;
            padding: 6px 9px;
            font-size: 14px;
            flex: 1;
            min-width: 0;
        }

        .wca-repeater-row input[type="number"] {
            max-width: 110px;
            flex: 0 0 110px;
        }

        .wca-repeater-row .wca-lbl {
            font-size: 11px;
            color: #888;
            white-space: nowrap;
        }

        .wca-repeater-row input[type="checkbox"] {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .wca-add-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
            color: #2271b1;
            cursor: pointer;
            border: none;
            background: none;
            padding: 4px 0;
            margin-top: 4px;
            text-decoration: underline;
        }

        .wca-remove-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: #cc1818;
            font-size: 18px;
            line-height: 1;
            flex-shrink: 0;
            padding: 0 2px;
        }

        .wca-remove-btn:hover {
            color: #a00;
        }

        .wca-notice-ok {
            background: #d1e7dd;
            border-left: 4px solid #198754;
            padding: 12px 16px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .wca-submit {
            margin-top: 8px;
        }
    </style>

<?php
});

// ─────────────────────────────────────────────────────────────
// 6. РЕНДЕР СТРАНИЦЫ
// ─────────────────────────────────────────────────────────────
function wca_render_page(): void
{
    if (! current_user_can('manage_options')) return;
    $s = wca_get(); // текущие настройки
?>
    <div class="wrap wca-wrap">
        <h1>⚙️ Настройки калькулятора</h1>

        <?php if (isset($_GET['saved'])): ?>
            <div class="wca-notice-ok">✅ Настройки сохранены</div>
        <?php endif; ?>

        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="wca_save">
            <?php wp_nonce_field('wca_save'); ?>

            <!-- ═══════════════════════════════════════════ -->
            <!-- Заголовок                                   -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="wca-card">
                <h2>Заголовок калькулятора</h2>
                <div class="wca-grid">
                    <div class="wca-field">
                        <label>Заголовок</label>
                        <input type="text" name="page_title" value="<?php echo esc_attr($s['page_title']); ?>">
                    </div>
                    <div class="wca-field">
                        <label>Подзаголовок</label>
                        <input type="text" name="page_subtitle" value="<?php echo esc_attr($s['page_subtitle']); ?>">
                    </div>
                </div>
            </div>

            <!-- ═══════════════════════════════════════════ -->
            <!-- Категории                                   -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="wca-card">
                <h2>Категории (вкладки над карточкой)</h2>
                <div class="wca-repeater" id="rep-categories">
                    <?php foreach ($s['categories'] as $i => $cat): ?>
                        <div class="wca-repeater-row">
                            <span class="handle">⠿</span>
                            <span class="wca-lbl">Название</span>
                            <input type="text" name="categories[<?php echo $i; ?>][name]" value="<?php echo esc_attr($cat['name']); ?>">
                            <button type="button" class="wca-remove-btn" onclick="wca_remove(this)">✕</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="wca-add-btn" onclick="wca_add('categories', ['name'], ['Название категории'])">+ Добавить категорию</button>
            </div>

            <!-- ═══════════════════════════════════════════ -->
            <!-- Шаг 1 — размер                             -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="wca-card">
                <h2>Шаг 1 — Размер</h2>
                <div class="wca-grid wca-grid-3">
                    <div class="wca-field">
                        <label>Мин. размер (мм)</label>
                        <input type="number" name="size_min" value="<?php echo esc_attr($s['size_min']); ?>" min="1">
                    </div>
                    <div class="wca-field">
                        <label>Ширина по умолчанию</label>
                        <input type="number" name="size_default_w" value="<?php echo esc_attr($s['size_default_w']); ?>" min="1">
                    </div>
                    <div class="wca-field">
                        <label>Высота по умолчанию</label>
                        <input type="number" name="size_default_h" value="<?php echo esc_attr($s['size_default_h']); ?>" min="1">
                    </div>
                </div>
                <div class="wca-grid" style="margin-top:12px;">
                    <div class="wca-field">
                        <label>Количество по умолчанию</label>
                        <input type="number" name="size_default_qty" value="<?php echo esc_attr($s['size_default_qty']); ?>" min="0">
                    </div>
                    <div class="wca-field">
                        <label>Текст подсказки</label>
                        <textarea name="size_hint"><?php echo esc_textarea($s['size_hint']); ?></textarea>
                    </div>
                </div>
                <div class="wca-grid" style="margin-top:12px;">
                    <div class="wca-field">
                        <label>Подмащивание: пункты (шаг 1)</label>
                        <div class="wca-hint" style="margin-top:-4px; font-size:12px; color:#666;">
                            Первый пункт — основная галочка. Остальные зависят от неё и отключаются, пока она не выбрана.
                        </div>
                    </div>
                </div>
                <div style="margin-top:12px;">
                    <div class="wca-repeater" id="rep-scaffold_items">
                        <?php foreach (($s['scaffold_items'] ?? []) as $i => $it): ?>
                            <div class="wca-repeater-row">
                                <span class="handle">⠿</span>
                                <span class="wca-lbl">Текст пункта (шаблон {rate})</span>
                                <input type="text" name="scaffold_items[<?php echo $i; ?>][label]" value="<?php echo esc_attr($it['label'] ?? ''); ?>">
                                <span class="wca-lbl">Коэффициент ₽/м2</span>
                                <input type="number" name="scaffold_items[<?php echo $i; ?>][rate]" value="<?php echo esc_attr($it['rate'] ?? 0); ?>" min="0">
                                <span class="wca-lbl">Учитывать в цене (0/1)</span>
                                <input type="number" name="scaffold_items[<?php echo $i; ?>][affects_price]" value="<?php echo esc_attr($it['affects_price'] ?? 0); ?>" min="0" max="1" step="1">
                                <button type="button" class="wca-remove-btn" onclick="wca_remove(this)">✕</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="wca-add-btn" onclick="wca_add('scaffold_items', ['label','rate','affects_price'], ['Новый пункт', 0, 0])">+ Добавить пункт</button>
                </div>
            </div>

            <!-- ═══════════════════════════════════════════ -->
            <!-- Шаг 2 — объекты                            -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="wca-card">
                <h2>Шаг 2 — Объекты</h2>
                <div class="wca-repeater" id="rep-objects">
                    <?php foreach ($s['objects'] as $i => $obj): ?>
                        <div class="wca-repeater-row">
                            <span class="handle">⠿</span>

                            <!-- ДОБАВИТЬ превью + кнопку -->
                            <div class="wca-img-pick" style="flex-shrink:0;">
                                <img src="<?php echo esc_url($obj['image'] ?? ''); ?>"
                                    style="width:40px;height:40px;object-fit:cover;border-radius:4px;border:1px solid #ddd;display:<?php echo !empty($obj['image']) ? 'block' : 'none'; ?>;">
                                <input type="hidden" name="objects[<?php echo $i; ?>][image]" value="<?php echo esc_attr($obj['image'] ?? ''); ?>">
                                <button type="button" class="button wca-media-btn" style="margin-top:4px;font-size:11px;">
                                    <?php echo !empty($obj['image']) ? 'Изменить' : 'Выбрать'; ?>
                                </button>
                            </div>

                            <span class="wca-lbl">Название</span>
                            <input type="text" name="objects[<?php echo $i; ?>][name]" value="<?php echo esc_attr($obj['name']); ?>">
                            <span class="wca-lbl">Надбавка ₽</span>
                            <input type="number" name="objects[<?php echo $i; ?>][price]" value="<?php echo esc_attr($obj['price']); ?>" min="0">
                            <button type="button" class="wca-remove-btn" onclick="wca_remove(this)">✕</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="wca-add-btn" onclick="wca_add('objects', ['name','price'], ['Новый объект', 0])">+ Добавить объект</button>



            </div>

            <!-- ═══════════════════════════════════════════ -->
            <!-- Шаг 3 — типы плёнок                        -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="wca-card">
                <h2>Шаг 3 — Типы плёнок</h2>
                <div class="wca-repeater" id="rep-films">
                    <?php foreach ($s['films'] as $i => $film): ?>
                        <div class="wca-repeater-row">
                            <span class="handle">⠿</span>

                            <div class="wca-img-pick" style="flex-shrink:0;">
                                <img src="<?php echo esc_url($film['image'] ?? ''); ?>"
                                    style="width:40px;height:40px;object-fit:cover;border-radius:4px;border:1px solid #ddd;display:<?php echo !empty($film['image']) ? 'block' : 'none'; ?>;">
                                <input type="hidden" name="films[<?php echo $i; ?>][image]" value="<?php echo esc_attr($film['image'] ?? ''); ?>">
                                <button type="button" class="button wca-media-btn" style="margin-top:4px;font-size:11px;">
                                    <?php echo !empty($film['image']) ? 'Изменить' : 'Выбрать'; ?>
                                </button>
                            </div>

                            <span class="wca-lbl">Название</span>
                            <input type="text" name="films[<?php echo $i; ?>][name]" value="<?php echo esc_attr($film['name']); ?>">
                            <span class="wca-lbl">Цена ₽/м2</span>
                            <input type="number" name="films[<?php echo $i; ?>][price]" value="<?php echo esc_attr($film['price']); ?>" min="0">
                            <button type="button" class="wca-remove-btn" onclick="wca_remove(this)">✕</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="wca-add-btn" onclick="wca_add('films', ['name','price'], ['Новый тип', 0])">+ Добавить тип плёнки</button>
            </div>

            <!-- ═══════════════════════════════════════════ -->
            <!-- Шаг 4 — итог и цены                        -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="wca-card">
                <h2>Шаг 4 — Результат и цены</h2>
                <div class="wca-grid wca-grid-3">
                    <div class="wca-field">
                        <label>Базовая цена ₽</label>
                        <input type="number" name="base_price" value="<?php echo esc_attr($s['base_price']); ?>" min="0">
                    </div>
                    <div class="wca-field">
                        <label>Зачёркнутая цена ₽</label>
                        <input type="number" name="old_price" value="<?php echo esc_attr($s['old_price']); ?>" min="0">
                    </div>
                    <div class="wca-field">
                        <label>Текст подарка</label>
                        <input type="text" name="gift_text" value="<?php echo esc_attr($s['gift_text']); ?>">
                    </div>
                </div>
                <div class="wca-grid" style="margin-top:12px;">
                    <div class="wca-field">
                        <label>Текст кнопки</label>
                        <input type="text" name="btn_text" value="<?php echo esc_attr($s['btn_text']); ?>">
                    </div>
                    <div class="wca-field">
                        <label>Подпись под кнопкой</label>
                        <input type="text" name="call_hint" value="<?php echo esc_attr($s['call_hint']); ?>">
                    </div>
                </div>
                <div class="wca-grid" style="margin-top:12px;">
                    <div class="wca-field">
                        <label>Порог минимального заказа (м2)</label>
                        <input type="number" name="min_order_area_m2" value="<?php echo esc_attr($s['min_order_area_m2']); ?>" min="0" step="0.1">
                    </div>
                    <div class="wca-field">
                        <label>Выезд/доставка внутри МКАД ₽</label>
                        <input type="number" name="travel_mkad_rub" value="<?php echo esc_attr($s['travel_mkad_rub']); ?>" min="0">
                    </div>
                </div>
            </div>

            <!-- ═══════════════════════════════════════════ -->
            <!-- Дополнительные услуги                       -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="wca-card">
                <h2>Дополнительные услуги (чекбоксы на шаге 4)</h2>
                <div class="wca-repeater" id="rep-services">
                    <?php foreach ($s['services'] as $i => $srv): ?>
                        <div class="wca-repeater-row">
                            <span class="handle">⠿</span>
                            <span class="wca-lbl">Название</span>
                            <input type="text" name="services[<?php echo $i; ?>][label]" value="<?php echo esc_attr($srv['label']); ?>">
                            <span class="wca-lbl">Подпись</span>
                            <input type="text" name="services[<?php echo $i; ?>][hint]" value="<?php echo esc_attr($srv['hint']); ?>" style="max-width:110px;flex:0 0 110px;">
                            <span class="wca-lbl">Цена</span>
                            <input type="text" name="services[<?php echo $i; ?>][price_text]" value="<?php echo esc_attr($srv['price_text']); ?>" style="max-width:100px;flex:0 0 100px;">
                            <span class="wca-lbl">По умолч.</span>
                            <input type="checkbox" name="services[<?php echo $i; ?>][checked]" value="1" <?php checked($srv['checked']); ?>>
                            <button type="button" class="wca-remove-btn" onclick="wca_remove(this)">✕</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="wca-add-btn" onclick="wca_add_service()">+ Добавить услугу</button>
            </div>

            <!-- ═══════════════════════════════════════════ -->
            <!-- Подвал                                       -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="wca-card">
                <h2>Подвал калькулятора</h2>
                <div class="wca-grid wca-grid-3">
                    <div class="wca-field">
                        <label>Текст примечания</label>
                        <input type="text" name="footer_note" value="<?php echo esc_attr($s['footer_note']); ?>">
                    </div>
                    <div class="wca-field">
                        <label>Текст ссылки</label>
                        <input type="text" name="footer_link_text" value="<?php echo esc_attr($s['footer_link_text']); ?>">
                    </div>
                    <div class="wca-field">
                        <label>URL ссылки</label>
                        <input type="url" name="footer_link_url" value="<?php echo esc_attr($s['footer_link_url']); ?>">
                    </div>
                </div>
            </div>

            <div class="wca-submit">
                <?php submit_button('Сохранить настройки', 'primary large', 'submit', false); ?>
            </div>
        </form>
    </div>

    <script>
        // ── удалить строку ────────────────────────────────────────
        function wca_remove(btn) {
            btn.closest('.wca-repeater-row').remove();
            wca_reindex();
        }

        // ── переиндексировать name-аттрибуты после удаления ───────
        function wca_reindex() {
            document.querySelectorAll('.wca-repeater').forEach(rep => {
                const key = rep.id.replace('rep-', '');
                rep.querySelectorAll('.wca-repeater-row').forEach((row, idx) => {
                    row.querySelectorAll('[name]').forEach(el => {
                        el.name = el.name.replace(/\[\d+\]/, '[' + idx + ']');
                    });
                });
            });
        }

        // ── универсальное добавление строки ───────────────────────
        function wca_add(key, fields, defaults) {
            const rep = document.getElementById('rep-' + key);
            const idx = rep.querySelectorAll('.wca-repeater-row').length;
            const row = document.createElement('div');
            row.className = 'wca-repeater-row';

            let html = '<span class="handle">⠿</span>';
            fields.forEach((f, i) => {
                const type = (f === 'price' || f === 'rate' || f === 'affects_price') ? 'number' : 'text';
                const attrs = (f === 'affects_price') ? ' min="0" max="1" step="1"' : ((f === 'price' || f === 'rate') ? ' min="0"' : '');
                html += `<span class="wca-lbl">${wca_label(key, f)}</span>
                     <input type="${type}" name="${key}[${idx}][${f}]" value="${defaults[i]}"${attrs}>`;
            });
            html += '<button type="button" class="wca-remove-btn" onclick="wca_remove(this)">✕</button>';
            row.innerHTML = html;
            rep.appendChild(row);
        }

        // ── специальный добавщик для услуг (есть чекбокс) ─────────
        function wca_add_service() {
            const rep = document.getElementById('rep-services');
            const idx = rep.querySelectorAll('.wca-repeater-row').length;
            const row = document.createElement('div');
            row.className = 'wca-repeater-row';
            row.innerHTML = `
            <span class="handle">⠿</span>
            <span class="wca-lbl">Название</span>
            <input type="text" name="services[${idx}][label]" value="Новая услуга">
            <span class="wca-lbl">Подпись</span>
            <input type="text" name="services[${idx}][hint]" value="" style="max-width:110px;flex:0 0 110px;">
            <span class="wca-lbl">Цена</span>
            <input type="text" name="services[${idx}][price_text]" value="0 ₽" style="max-width:100px;flex:0 0 100px;">
            <span class="wca-lbl">По умолч.</span>
            <input type="checkbox" name="services[${idx}][checked]" value="1">
            <button type="button" class="wca-remove-btn" onclick="wca_remove(this)">✕</button>`;
            rep.appendChild(row);
        }

        function wca_label(key, f) {
            return {
                name: 'Название',
                price: key === 'films' ? 'Цена ₽/м2' : 'Надбавка ₽',
                rate: 'Коэффициент ₽/м2',
                hint: 'Подпись',
                label: 'Текст пункта',
                affects_price: 'Учитывать в цене (0/1)',
                price_text: 'Цена'
            } [f] || f;
        }
    </script>

    <?php wp_enqueue_media(); // подключаем медиабиблиотеку WP 
    ?>

    <script>
        // Открытие медиабиблиотеки при клике на кнопку
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.wca-media-btn');
            if (!btn) return;

            const wrap = btn.closest('.wca-img-pick');
            const hiddenInput = wrap.querySelector('input[type="hidden"]');
            const preview = wrap.querySelector('img');

            const frame = wp.media({
                title: 'Выберите изображение',
                button: {
                    text: 'Выбрать'
                },
                multiple: false,
                library: {
                    type: 'image'
                }
            });

            frame.on('select', function() {
                const attachment = frame.state().get('selection').first().toJSON();
                hiddenInput.value = attachment.url;
                preview.src = attachment.url;
                preview.style.display = 'block';
                btn.textContent = 'Изменить';
            });

            frame.open();
        });
    </script>
<?php
}

// ─────────────────────────────────────────────────────────────
// 7. ХЕЛПЕР ДЛЯ ШАБЛОНОВ — вывод данных в JS
//    Используйте: wca_js_config() в шаблоне перед скриптами
// ─────────────────────────────────────────────────────────────
function wca_js_config(): void
{
    $s = wca_get();
    echo '<script>window.WCA = ' . wp_json_encode($s) . ';</script>' . "\n";
}

function wca_render_calculator(): void
{
    $s = wca_get();
    $img = get_template_directory_uri() . '/assets/imgs/';
?>
    <div class="window-calc-page">

        <h1 class="window-calc-page__title"><?php echo esc_html($s['page_title']); ?></h1>
        <p class="window-calc-page__subtitle"><?php echo esc_html($s['page_subtitle']); ?></p>

        <!-- CATEGORY TABS -->
        <div class="wcp-slider wcp-slider--categories">
            <button class="wcp-slider__nav wcp-slider__nav--prev wcp-categories-prev" type="button" aria-label="Предыдущая категория"></button>
            <div class="swiper wcp-categories" id="categorySlider">
                <div class="swiper-wrapper">
                    <?php foreach ($s['categories'] as $i => $cat): ?>
                        <div class="swiper-slide">
                            <button class="wcp-category <?php echo $i === 0 ? 'wcp-category--active' : ''; ?>" onclick="selectCategory(this)">
                                <?php echo esc_html($cat['name']); ?>
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <button class="wcp-slider__nav wcp-slider__nav--next wcp-categories-next" type="button" aria-label="Следующая категория"></button>
        </div>

        <!-- CARD -->
        <div class="wcp-card">

            <!-- STEP TABS -->
            <div class="wcp-slider wcp-slider--steps">
                <button class="wcp-slider__nav wcp-slider__nav--prev wcp-steps-prev" type="button" aria-label="Предыдущий шаг"></button>
                <div class="swiper wcp-steps" id="stepTabs">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="wcp-step wcp-step--active" id="tab-1">
                                <div class="wcp-step__num"><span>1</span></div>Размер
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="wcp-step" id="tab-2">
                                <div class="wcp-step__num"><span>2</span></div>Объект
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="wcp-step" id="tab-3">
                                <div class="wcp-step__num"><span>3</span></div>Тип пленки
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="wcp-step" id="tab-4">
                                <div class="wcp-step__num"><span>4</span></div>Подсчет
                            </div>
                        </div>
                    </div>
                </div>
                <button class="wcp-slider__nav wcp-slider__nav--next wcp-steps-next" type="button" aria-label="Следующий шаг"></button>
            </div>

            <!-- ══ STEP 1: SIZE ══ -->
            <div class="wcp-body wcp-step-panel wcp-step-panel--active" id="panel-1">
                <div class="wcp-body__left">
                    <div class="wcp-section-title">Укажите размер объекта</div>
                    <div class="wcp-size-row">
                        <div class="wcp-field" id="widthField">
                            <label>Ширина (мм)</label>
                            <div class="wcp-field__input-wrap">
                                <input type="text" id="width" inputmode="numeric" autocomplete="off"
                                    placeholder="<?php echo esc_attr($s['size_min']); ?>"
                                    value="<?php echo esc_attr($s['size_default_w']); ?>">
                                <span class="wcp-field__unit">мм</span>
                            </div>
                            <div class="wcp-field__error">Минимальный размер <?php echo esc_html($s['size_min']); ?> мм</div>
                        </div>
                        <div class="wcp-size-sep">×</div>
                        <div class="wcp-field" id="heightField">
                            <label>Высота</label>
                            <div class="wcp-field__input-wrap">
                                <input type="text" id="height" inputmode="numeric" autocomplete="off"
                                    placeholder="<?php echo esc_attr($s['size_min']); ?>"
                                    value="<?php echo esc_attr($s['size_default_h']); ?>">
                                <span class="wcp-field__unit">мм</span>
                            </div>
                            <div class="wcp-field__error">Минимальный размер <?php echo esc_html($s['size_min']); ?> мм</div>
                        </div>
                    </div>
                    <div class="wcp-qty">
                        <label>Количество</label>
                        <div class="wcp-qty__control">
                            <button class="wcp-qty__btn" onclick="changeQty(-1)">−</button>
                            <div class="wcp-qty__val" id="qtyVal"><?php echo esc_html($s['size_default_qty']); ?></div>
                            <button class="wcp-qty__btn" onclick="changeQty(1)">+</button>
                        </div>
                    </div>
                    <div class="wcp-area-hint">
                        Итого = <span id="areaM2Val">0</span> м<sup>2</sup>
                    </div>
                    <div class="wcp-hint">
                        <div class="wcp-hint__head">
                            <div class="wcp-hint__icon">i</div>
                            Справка
                        </div>
                        <?php echo esc_html($s['size_hint']); ?>
                    </div>
                    <?php
                    $scaffoldItems = is_array($s['scaffold_items'] ?? null) ? $s['scaffold_items'] : [];
                    $master = $scaffoldItems[0] ?? null;
                    $subs = array_slice($scaffoldItems, 1);
                    ?>
                    <div class="wcp-scaffold">
                        <?php if ($master): ?>
                            <?php
                            $masterRate = (int) ($master['rate'] ?? 0);
                            $masterAffects = (int) ($master['affects_price'] ?? 0);
                            $masterLabel = (string) ($master['label'] ?? '');
                            $masterLabel = str_replace('{rate}', (string) $masterRate, $masterLabel);
                            ?>
                            <label class="wcp-check">
                                <input
                                    type="checkbox"
                                    id="wcpScaffold"
                                    class="wcp-scaffold-item"
                                    data-rate="<?php echo $masterRate; ?>"
                                    data-affects-price="<?php echo $masterAffects; ?>">
                                <span><?php echo esc_html($masterLabel); ?></span>
                            </label>
                        <?php endif; ?>

                        <?php foreach ($subs as $idx => $it): ?>
                            <?php
                            $rate = (int) ($it['rate'] ?? 0);
                            $affects = (int) ($it['affects_price'] ?? 0);
                            $labelTpl = (string) ($it['label'] ?? '');
                            $label = str_replace('{rate}', (string) $rate, $labelTpl);
                            ?>
                            <label class="wcp-check wcp-check--sub">
                                <input
                                    type="checkbox"
                                    class="wcp-scaffold-item wcp-scaffold-item--sub"
                                    id="wcpScaffoldSub<?php echo (int) $idx; ?>"
                                    disabled
                                    data-rate="<?php echo $rate; ?>"
                                    data-affects-price="<?php echo $affects; ?>">
                                <span><?php echo esc_html($label); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="wcp-body__right">
                    <div class="wcp-img-placeholder"><img src="<?php echo esc_url($img . '1.png'); ?>" alt=""></div>
                </div>
            </div>

            <!-- ══ STEP 2: OBJECT ══ -->
            <div class="wcp-body wcp-step-panel" id="panel-2">
                <div class="wcp-body__left">
                    <div class="wcp-section-title">Выберите объект для тонировки</div>
                    <div class="wcp-options" id="objectOptions">
                        <?php foreach ($s['objects'] as $i => $obj): ?>
                            <div class="wcp-option <?php echo $i === 0 ? 'wcp-option--selected' : ''; ?>"
                                data-img="<?php echo esc_url($img . '2-' . ($i + 1) . '.png'); ?>"
                                data-price="<?php echo (int) $obj['price']; ?>"
                                onclick="selectOption(this, 'object', <?php echo (int) $obj['price']; ?>)">
                                <div class="wcp-option__icon" style="border-radius: 50%;">
                                    <img src="<?php echo esc_url($obj['image'] ?: $img . '2-' . ($i + 1) . '.png'); ?>" alt="">
                                </div>
                                <div class="wcp-option__info">
                                    <div class="wcp-option__name"><?php echo esc_html($obj['name']); ?></div>
                                    <div class="wcp-option__price">+ <?php echo esc_html($obj['price']); ?> ₽</div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="wcp-step-note">* работа производится внутри помещения</div>
                </div>
                <div class="wcp-body__right">
                    <div class="wcp-img-placeholder" id="objectMainImg">
                        <img src="<?php echo esc_url($s['objects'][0]['image'] ?: $img . '2-1.png'); ?>" alt="">
                    </div>
                </div>
            </div>

            <!-- ══ STEP 3: FILM TYPE ══ -->
            <div class="wcp-body wcp-step-panel" id="panel-3">
                <div class="wcp-body__left">
                    <div class="wcp-section-title">Выберите тип пленки</div>
                    <div class="wcp-options" id="filmOptions">
                        <?php foreach ($s['films'] as $i => $film): ?>
                            <div class="wcp-option <?php echo $i === 0 ? 'wcp-option--selected' : ''; ?>"
                                data-img="<?php echo esc_url($img . '3-' . ($i + 1) . '.png'); ?>"
                                data-price="<?php echo (int) $film['price']; ?>"
                                onclick="selectOption(this, 'film', <?php echo (int) $film['price']; ?>)">
                                <div class="wcp-option__icon" style="border-radius:50%;">
                                    <img src="<?php echo esc_url($film['image'] ?: $img . '3-' . ($i + 1) . '.png'); ?>" alt="">
                                </div>
                                <div class="wcp-option__info">
                                    <div class="wcp-option__name"><?php echo esc_html($film['name']); ?></div>
                                    <div class="wcp-option__price">+ <?php echo esc_html($film['price']); ?> ₽</div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="wcp-body__right">
                    <div class="wcp-img-placeholder" id="objectMainImg">
                        <img src="<?php echo esc_url($s['films'][0]['image'] ?: $img . '2-1.png'); ?>" alt="">
                    </div>
                </div>
            </div>

            <!-- ══ STEP 4: RESULT ══ -->
            <div class="wcp-body wcp-step-panel" id="panel-4">
                <div class="wcp-body__left" style="min-width:0;">
                    <div class="wcp-result-table">
                        <div class="wcp-result-table__section-head">
                            <span>Цена изделия</span>
                            <span id="productPrice"><?php echo number_format($s['base_price'], 0, '', ' '); ?> ₽</span>
                        </div>
                    </div>

                    <?php
                    $services = is_array($s['services'] ?? null) ? $s['services'] : [];
                    $servicesDefaultSum = 0;
                    foreach ($services as $srv) {
                        $isChecked = !empty($srv['checked']);
                        $priceText = (string) ($srv['price_text'] ?? '');
                        $priceRub = 0;
                        if (preg_match('/(\d[\d\s]*)/', $priceText, $m)) {
                            $priceRub = (int) str_replace(' ', '', $m[1]);
                        }
                        if ($isChecked) $servicesDefaultSum += $priceRub;
                    }
                    ?>
                    <div class="wcp-services">
                        <div class="wcp-services__head">
                            <span>Доп. услуги</span>
                            <span id="servicesPrice"><?php echo number_format((int) $servicesDefaultSum, 0, '', ' '); ?> ₽</span>
                        </div>
                        <?php foreach ($services as $i => $srv): ?>
                            <?php
                            $priceText = (string) ($srv['price_text'] ?? '');
                            $priceRub = 0;
                            if (preg_match('/(\d[\d\s]*)/', $priceText, $m)) {
                                $priceRub = (int) str_replace(' ', '', $m[1]);
                            }
                            $isChecked = !empty($srv['checked']);
                            $label = (string) ($srv['label'] ?? '');
                            $hint = (string) ($srv['hint'] ?? '');
                            ?>
                            <div class="wcp-service-row">
                                <input
                                    type="checkbox"
                                    class="wcp-service-checkbox"
                                    data-price="<?php echo (int) $priceRub; ?>"
                                    <?php checked($isChecked); ?>
                                    aria-label="<?php echo esc_attr($label); ?>">
                                <span class="wcp-service-row__label">
                                    * <?php echo esc_html($label); ?>
                                    <?php if ($hint !== ''): ?>
                                        <br><small><?php echo esc_html($hint); ?></small>
                                    <?php endif; ?>
                                </span>
                                <span class="wcp-service-row__price"><?php echo esc_html($priceText); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="wcp-total">
                        <div>
                            <div class="wcp-total__label">Итоговая цена</div>
                            <div class="wcp-total__old" id="totalOldPrice"><?php echo number_format($s['old_price'], 0, '', ' '); ?> ₽</div>
                            <div class="wcp-total__price" id="totalPrice"><?php echo number_format($s['base_price'], 0, '', ' '); ?> <span>₽</span></div>
                        </div>
                        <div class="wcp-total__gift">
                            <div class="wcp-total__gift-icon"><!-- svg иконка подарка --></div>
                            <div><?php echo esc_html($s['gift_text']); ?></div>
                        </div>
                    </div>

                    <div class="wcp-phone-wrap">
                        <label>Телефон</label>
                        <input type="tel" placeholder="+7 (___) ___-__-__">
                    </div>


                    <button class="wcp-btn wcp-btn--primary wcp-btn--full" onclick="wcp_submit(event)"><?php echo esc_html($s['btn_text']); ?></button>
                    <div class="wcp-btn__call-hint"><?php echo esc_html($s['call_hint']); ?></div>
                </div>
                <div class="wcp-body__right">
                    <div class="wcp-img-placeholder"><img src="<?php echo esc_url($img . '4.png'); ?>" alt=""></div>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="wcp-footer">
                <div class="wcp-footer__note">
                    <?php echo esc_html($s['footer_note']); ?><br>
                    <a href="<?php echo esc_url($s['footer_link_url']); ?>"><?php echo esc_html($s['footer_link_text']); ?></a>
                </div>
                <div class="wcp-footer__actions" id="footerActions"></div>
            </div>

        </div><!-- /wcp-card -->

        <style>
            /* ── Согласие ─────────────────────────────────────────── */
            .wcp-consent {
                margin: 12px 0;
            }

            .wcp-consent__label {
                display: flex;
                align-items: flex-start;
                gap: 8px;
                cursor: pointer;
                padding: 8px 10px;
                border-radius: 6px;
                border: 1px solid transparent;
                transition: border-color .2s, background .2s;
            }

            .wcp-consent__label input[type="checkbox"] {
                margin-top: 2px;
                flex-shrink: 0;
                width: 16px;
                height: 16px;
                accent-color: currentColor;
            }

            .wcp-consent__text {
                font-size: 13px;
                line-height: 1.4;
                color: #555;
            }

            .wcp-consent__text a {
                color: inherit;
                text-decoration: underline;
            }

            .wcp-consent__error {
                display: none;
                font-size: 12px;
                color: #c0392b;
                margin-top: 4px;
                padding-left: 10px;
            }

            /* состояние ошибки */
            .wcp-consent--invalid .wcp-consent__label {
                border-color: #e74c3c;
                background: #fff5f5;
                animation: wcp-shake .3s ease;
            }

            .wcp-consent--invalid .wcp-consent__error {
                display: block;
            }

            @keyframes wcp-shake {

                0%,
                100% {
                    transform: translateX(0);
                }

                25% {
                    transform: translateX(-4px);
                }

                75% {
                    transform: translateX(4px);
                }
            }
        </style>

        <?php wca_js_config(); ?>

        <script>
            // ── Переключение главного изображения (шаги 2 и 3) ────────
            const _wcpImgMap = {
                object: document.getElementById('objectMainImg'),
                film: document.getElementById('filmMainImg'),
            };

            // Патчим selectOption — оригинальная функция вызывается как обычно,
            // мы только добавляем смену картинки справа.
            // Если у вас уже есть своя selectOption — добавьте в неё строки ниже.
            function selectOption(el, type, price) {
                // Снять выделение со всех опций в той же группе
                el.closest('.wcp-options').querySelectorAll('.wcp-option').forEach(o => {
                    o.classList.remove('wcp-option--selected');
                });
                el.classList.add('wcp-option--selected');

                // Обновить главное изображение справа
                const imgSrc = el.dataset.img;
                const placeholder = _wcpImgMap[type];
                if (imgSrc && placeholder) {
                    const imgEl = placeholder.querySelector('img');
                    if (imgEl) {
                        imgEl.src = imgSrc;
                    }
                }

                // Здесь можно добавить логику пересчёта цены (price)
            }

            // переключение изображений
            document.addEventListener('click', function(e) {
                const option = e.target.closest('.wcp-option');
                if (!option) return;

                const panel = option.closest('.wcp-step-panel');
                if (!panel) return;

                // Определяем какой плейсхолдер обновлять
                const placeholder = panel.querySelector('.wcp-img-placeholder img');
                if (!placeholder) return;

                // Берём картинку из иконки выбранной опции
                const optionImg = option.querySelector('.wcp-option__icon img');
                if (!optionImg) return;

                placeholder.src = optionImg.src;


            });


            // Синхронизация дефолтных картинок при загрузке
        </script>
    </div>
<?php
}
