<?php
/**
 * Класс для регистрации заявок и настроек в админке
 */
class Okna_Leads {

    private static $instance = null;
    private const BITRIX_WEBHOOK_URL = 'https://metodika.bitrix24.ru/rest/6/38vum9y692tvnuu5/';
    private const BITRIX_SOURCE_ID = 'UC_X3DK6R';
    private const BITRIX_DEPARTMENT_FIELD = 'UF_CRM_1662368942557';
    private const BITRIX_DEPARTMENT_VALUE = '988';
    private const BITRIX_YCLID_FIELD = 'UF_CRM_1685353078';
    private const BITRIX_ASSIGNED_BY_ID = 4456;
    private const BITRIX_NEED_MEASURE_FIELD = 'UF_CRM_1773528405457';
    private const BITRIX_TELEGRAM_FIELD = 'UF_CRM_1773528414802';
    // Заполнить после создания пользовательского поля-файла в Bitrix24.
    private const BITRIX_PHOTO_FIELD = '';

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('init', array($this, 'register_lead_post_type'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('wp_ajax_okna_submit_lead', array($this, 'handle_lead_submission'));
        add_action('wp_ajax_nopriv_okna_submit_lead', array($this, 'handle_lead_submission'));
        add_action('wp_ajax_okna_submit_calc_lead', array($this, 'handle_calc_lead_submission'));
        add_action('wp_ajax_nopriv_okna_submit_calc_lead', array($this, 'handle_calc_lead_submission'));
        add_filter('manage_okna_lead_posts_columns', array($this, 'custom_columns'));
        add_action('manage_okna_lead_posts_custom_column', array($this, 'custom_column_content'), 10, 2);
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
    }

    /**
     * Регистрация типа записи для заявок
     */
    public function register_lead_post_type() {
        register_post_type('okna_lead', array(
            'labels' => array(
                'name' => 'Заявки',
                'singular_name' => 'Заявка',
                'add_new' => 'Добавить заявку',
                'add_new_item' => 'Добавить новую заявку',
                'edit_item' => 'Редактировать заявку',
                'new_item' => 'Новая заявка',
                'view_item' => 'Просмотр заявки',
                'search_items' => 'Поиск заявок',
                'not_found' => 'Заявок не найдено',
                'not_found_in_trash' => 'В корзине заявок не найдено',
                'menu_name' => 'Заявки',
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_icon' => 'dashicons-feedback',
            'capability_type' => 'post',
            'hierarchical' => false,
            'supports' => array('title', 'custom-fields'),
            'has_archive' => false,
            'can_export' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_in_rest' => true,
        ));
    }

    /**
     * Добавление страницы настроек в админке
     */
    public function add_admin_menu() {
        add_submenu_page(
            'edit.php?post_type=okna_lead',
            'Настройки заявок',
            'Настройки',
            'manage_options',
            'okna-leads-settings',
            array($this, 'settings_page_html')
        );
    }

    /**
     * Регистрация настроек
     */
    public function register_settings() {
        register_setting('okna_leads_settings_group', 'okna_leads_email_enabled');
        register_setting('okna_leads_settings_group', 'okna_leads_email_to');
        register_setting('okna_leads_settings_group', 'okna_leads_email_subject');
        register_setting('okna_leads_settings_group', 'okna_leads_telegram_enabled');
        register_setting('okna_leads_settings_group', 'okna_leads_telegram_bot_token');
        register_setting('okna_leads_settings_group', 'okna_leads_telegram_chat_id');
    }

    /**
     * HTML страницы настроек
     */
    public function settings_page_html() {
        ?>
        <div class="wrap">
            <h1>Настройки заявок</h1>
            <form method="post" action="options.php">
                <?php settings_fields('okna_leads_settings_group'); ?>
                <?php do_settings_sections('okna_leads_settings_group'); ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">Отправка на Email</th>
                        <td>
                            <label>
                                <input type="checkbox" name="okna_leads_email_enabled" value="1" <?php checked(get_option('okna_leads_email_enabled'), '1'); ?>>
                                Включить отправку на email
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Email для получения заявок</th>
                        <td>
                            <input type="email" name="okna_leads_email_to" value="<?php echo esc_attr(get_option('okna_leads_email_to')); ?>" class="regular-text" placeholder="example@mail.ru">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Тема письма</th>
                        <td>
                            <input type="text" name="okna_leads_email_subject" value="<?php echo esc_attr(get_option('okna_leads_email_subject', 'Новая заявка с сайта')); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Отправка в Telegram</th>
                        <td>
                            <label>
                                <input type="checkbox" name="okna_leads_telegram_enabled" value="1" <?php checked(get_option('okna_leads_telegram_enabled'), '1'); ?>>
                                Включить отправку в Telegram
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Telegram Bot Token</th>
                        <td>
                            <input type="text" name="okna_leads_telegram_bot_token" value="<?php echo esc_attr(get_option('okna_leads_telegram_bot_token')); ?>" class="regular-text" placeholder="123456789:ABCdefGHIjklMNOpqrsTUVwxyz">
                            <p class="description">Токен бота от @BotFather</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Telegram Chat ID</th>
                        <td>
                            <input type="text" name="okna_leads_telegram_chat_id" value="<?php echo esc_attr(get_option('okna_leads_telegram_chat_id')); ?>" class="regular-text" placeholder="-1001234567890">
                            <p class="description">ID чата или канала (можно узнать через @userinfobot)</p>
                        </td>
                    </tr>
                </table>
                
                <?php submit_button('Сохранить настройки'); ?>
            </form>
        </div>
        <?php
    }

    /**
     * Кастомные колонки в списке заявок
     */
    public function custom_columns($columns) {
        $new_columns = array();
        foreach ($columns as $key => $value) {
            if ($key === 'title') {
                $new_columns[$key] = $value;
                $new_columns['source'] = 'Источник';
                $new_columns['phone'] = 'Телефон';
                $new_columns['name'] = 'Имя';
                $new_columns['total'] = 'Итоговая цена';
                $new_columns['date'] = 'Дата';
            } else {
                $new_columns[$key] = $value;
            }
        }
        return $new_columns;
    }

    /**
     * Содержимое кастомных колонок
     */
    public function custom_column_content($column, $post_id) {
        switch ($column) {
            case 'source':
                $source = get_post_meta($post_id, '_lead_source', true);
                echo esc_html($source ?: '—');
                break;
            case 'name':
                echo esc_html(get_post_meta($post_id, '_lead_name', true));
                break;
            case 'phone':
                echo esc_html(get_post_meta($post_id, '_lead_phone', true));
                break;
            case 'total':
                $total = get_post_meta($post_id, '_lead_total_price', true);
                if ($total) {
                    echo number_format($total, 0, '', ' ') . ' ₽';
                } else {
                    echo '—';
                }
                break;
        }
    }

    /**
     * Добавление мета-боксов для деталей заявки
     */
    public function add_meta_boxes() {
        add_meta_box(
            'okna_lead_details',
            'Детали заявки',
            array($this, 'render_lead_details_meta_box'),
            'okna_lead',
            'normal',
            'high'
        );
    }

    /**
     * Рендер мета-бокса с деталями заявки
     */
    public function render_lead_details_meta_box($post) {
        wp_nonce_field('okna_lead_details_nonce', 'okna_lead_details_nonce');
        
        $source = get_post_meta($post->ID, '_lead_source', true);
        $name = get_post_meta($post->ID, '_lead_name', true);
        $phone = get_post_meta($post->ID, '_lead_phone', true);
        $comment = get_post_meta($post->ID, '_lead_comment', true);
        $need_measure = get_post_meta($post->ID, '_lead_need_measure', true);
        $telegram_pref = get_post_meta($post->ID, '_lead_telegram_pref', true);
        $total_price = get_post_meta($post->ID, '_lead_total_price', true);
        $old_price = get_post_meta($post->ID, '_lead_old_price', true);
        $width = get_post_meta($post->ID, '_lead_width', true);
        $height = get_post_meta($post->ID, '_lead_height', true);
        $quantity = get_post_meta($post->ID, '_lead_quantity', true);
        $category = get_post_meta($post->ID, '_lead_category', true);
        $object = get_post_meta($post->ID, '_lead_object', true);
        $object_price = get_post_meta($post->ID, '_lead_object_price', true);
        $film = get_post_meta($post->ID, '_lead_film', true);
        $film_price = get_post_meta($post->ID, '_lead_film_price', true);
        $services = maybe_unserialize(get_post_meta($post->ID, '_lead_services', true));
        $ip = get_post_meta($post->ID, '_lead_ip', true);
        $user_agent = get_post_meta($post->ID, '_lead_user_agent', true);
        ?>
        <style>
            .okna-lead-details { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
            .okna-lead-detail-row { margin-bottom: 12px; }
            .okna-lead-detail-label { font-weight: 600; color: #666; font-size: 12px; text-transform: uppercase; margin-bottom: 4px; }
            .okna-lead-detail-value { font-size: 14px; color: #23282d; padding: 8px; background: #f9f9f9; border-radius: 4px; }
            .okna-lead-section { margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee; }
            .okna-lead-section-title { font-size: 16px; font-weight: 600; margin-bottom: 12px; color: #23282d; }
            .okna-lead-services-list { list-style: none; padding: 0; margin: 0; }
            .okna-lead-services-list li { padding: 4px 0; border-bottom: 1px solid #eee; }
        </style>
        
        <div class="okna-lead-details">
            <div class="okna-lead-detail-row">
                <div class="okna-lead-detail-label">Источник</div>
                <div class="okna-lead-detail-value"><?php echo esc_html($source ?: '—'); ?></div>
            </div>
            <div class="okna-lead-detail-row">
                <div class="okna-lead-detail-label">Имя</div>
                <div class="okna-lead-detail-value"><?php echo esc_html($name ?: '—'); ?></div>
            </div>
            <div class="okna-lead-detail-row">
                <div class="okna-lead-detail-label">Телефон</div>
                <div class="okna-lead-detail-value"><?php echo esc_html($phone ?: '—'); ?></div>
            </div>
            <?php if ($total_price): ?>
            <div class="okna-lead-detail-row">
                <div class="okna-lead-detail-label">Итоговая цена</div>
                <div class="okna-lead-detail-value"><?php echo number_format($total_price, 0, '', ' ') . ' ₽'; ?></div>
            </div>
            <?php endif; ?>
        </div>
        
        <?php if ($width || $height): ?>
        <div class="okna-lead-section">
            <div class="okna-lead-section-title">📐 Параметры из калькулятора</div>
            <div class="okna-lead-details">
                <div class="okna-lead-detail-row">
                    <div class="okna-lead-detail-label">Размер</div>
                    <div class="okna-lead-detail-value"><?php echo esc_html($width ?: '—') . ' × ' . esc_html($height ?: '—') . ' мм'; ?></div>
                </div>
                <div class="okna-lead-detail-row">
                    <div class="okna-lead-detail-label">Количество</div>
                    <div class="okna-lead-detail-value"><?php echo esc_html($quantity ?: '1'); ?></div>
                </div>
                <div class="okna-lead-detail-row">
                    <div class="okna-lead-detail-label">Категория</div>
                    <div class="okna-lead-detail-value"><?php echo esc_html($category ?: '—'); ?></div>
                </div>
                <div class="okna-lead-detail-row">
                    <div class="okna-lead-detail-label">Объект</div>
                    <div class="okna-lead-detail-value"><?php echo esc_html($object ?: '—'); ?> <?php echo $object_price ? '(+ ' . $object_price . ' ₽)' : ''; ?></div>
                </div>
                <div class="okna-lead-detail-row">
                    <div class="okna-lead-detail-label">Плёнка</div>
                    <div class="okna-lead-detail-value"><?php echo esc_html($film ?: '—'); ?> <?php echo $film_price ? '(+ ' . $film_price . ' ₽)' : ''; ?></div>
                </div>
                <?php if ($old_price): ?>
                <div class="okna-lead-detail-row">
                    <div class="okna-lead-detail-label">Старая цена</div>
                    <div class="okna-lead-detail-value"><?php echo number_format($old_price, 0, '', ' ') . ' ₽'; ?></div>
                </div>
                <?php endif; ?>
            </div>
            
            <?php if (!empty($services) && is_array($services)): ?>
            <div class="okna-lead-detail-row" style="margin-top: 12px;">
                <div class="okna-lead-detail-label">Услуги</div>
                <ul class="okna-lead-services-list">
                    <?php foreach ($services as $service): ?>
                    <li><?php echo esc_html($service); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <?php if ($comment): ?>
        <div class="okna-lead-section">
            <div class="okna-lead-section-title">📝 Комментарий</div>
            <div class="okna-lead-detail-value" style="white-space: pre-wrap;"><?php echo esc_textarea($comment); ?></div>
        </div>
        <?php endif; ?>
        
        <div class="okna-lead-section">
            <div class="okna-lead-section-title">⚙️ Дополнительно</div>
            <div class="okna-lead-details">
                <div class="okna-lead-detail-row">
                    <div class="okna-lead-detail-label">Нужен замер</div>
                    <div class="okna-lead-detail-value"><?php echo $need_measure ? '✓ Да' : '— Нет'; ?></div>
                </div>
                <div class="okna-lead-detail-row">
                    <div class="okna-lead-detail-label">Удобно в Telegram</div>
                    <div class="okna-lead-detail-value"><?php echo $telegram_pref ? '✓ Да' : '— Нет'; ?></div>
                </div>
                <div class="okna-lead-detail-row">
                    <div class="okna-lead-detail-label">IP адрес</div>
                    <div class="okna-lead-detail-value"><?php echo esc_html($ip ?: '—'); ?></div>
                </div>
            </div>
        </div>
        <?php
    }

    private function get_request_field(string $key, string $default = ''): string {
        $value = $_POST[$key] ?? $default;
        return is_string($value) ? sanitize_text_field(wp_unslash($value)) : $default;
    }

    private function collect_attribution_data(): array {
        return array(
            'utm_source'   => $this->get_request_field('utm_source'),
            'utm_medium'   => $this->get_request_field('utm_medium'),
            'utm_campaign' => $this->get_request_field('utm_campaign'),
            'utm_content'  => $this->get_request_field('utm_content'),
            'utm_term'     => $this->get_request_field('utm_term'),
            'yclid'        => $this->get_request_field('yclid'),
        );
    }

    private function upload_lead_photo(string $field_name = 'photo'): array {
        if (empty($_FILES[$field_name]['name'])) {
            return array();
        }

        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';

        $uploaded = wp_handle_upload($_FILES[$field_name], array('test_form' => false));

        if (isset($uploaded['error'])) {
            throw new Exception('Ошибка загрузки файла: ' . $uploaded['error']);
        }

        $uploaded['name'] = sanitize_file_name($_FILES[$field_name]['name']);

        return $uploaded;
    }

    private function save_lead_meta(int $post_id, array $meta): void {
        foreach ($meta as $key => $value) {
            if (is_array($value)) {
                update_post_meta($post_id, $key, maybe_serialize($value));
            } else {
                update_post_meta($post_id, $key, $value);
            }
        }
    }

    private function build_bitrix_comments(array $data): string {
        $lines = array();

        if (!empty($data['source'])) {
            $lines[] = 'Источник формы: ' . $data['source'];
        }

        if (!empty($data['comment'])) {
            $lines[] = 'Комментарий: ' . $data['comment'];
        }

        if (isset($data['need_measure'])) {
            $lines[] = 'Нужен замер: ' . ($data['need_measure'] ? 'Да' : 'Нет');
        }

        if (isset($data['telegram_pref'])) {
            $lines[] = 'Удобно в Telegram: ' . ($data['telegram_pref'] ? 'Да' : 'Нет');
        }

        if (!empty($data['width']) || !empty($data['height'])) {
            $lines[] = '';
            $lines[] = 'Данные калькулятора:';
            $lines[] = 'Размер: ' . ($data['width'] ?? 0) . ' x ' . ($data['height'] ?? 0) . ' мм';
            $lines[] = 'Количество: ' . ($data['quantity'] ?? 1);
            $lines[] = 'Категория: ' . ($data['category'] ?? '—');
            $lines[] = 'Объект: ' . ($data['object'] ?? '—');
            $lines[] = 'Пленка: ' . ($data['film'] ?? '—');

            if (!empty($data['total_price'])) {
                $lines[] = 'Итоговая цена: ' . number_format((int) $data['total_price'], 0, '', ' ') . ' ₽';
            }
        }

        if (!empty($data['photo_url'])) {
            $lines[] = '';
            $lines[] = 'Файл с формы: ' . $data['photo_url'];
        }

        $utmLabels = array(
            'utm_source'   => 'UTM Source',
            'utm_medium'   => 'UTM Medium',
            'utm_campaign' => 'UTM Campaign',
            'utm_content'  => 'UTM Content',
            'utm_term'     => 'UTM Term',
            'yclid'        => 'YCLID',
        );

        $hasAttribution = false;
        foreach ($utmLabels as $key => $label) {
            if (!empty($data[$key])) {
                if (!$hasAttribution) {
                    $lines[] = '';
                    $lines[] = 'Маркетинговые данные:';
                    $hasAttribution = true;
                }
                $lines[] = $label . ': ' . $data[$key];
            }
        }

        return implode("\n", array_filter($lines, static function($line) {
            return $line !== null;
        }));
    }

    // Заполнить кодами UF_CRM_* после того, как менеджер создаст поля калькулятора в Bitrix24.
    private function get_bitrix_calc_field_map(): array {
        return array(
            'width'    => 'UF_CRM_1773579549110',
            'height'   => 'UF_CRM_1773579590361',
            'quantity' => 'UF_CRM_1773579621577',
            'category' => 'UF_CRM_1773579640155',
            'object'   => 'UF_CRM_1773579922894',
            'film'     => 'UF_CRM_1773579941854',
        );
    }

    private function add_bitrix_field(array &$fields, string $field_code, $value): void {
        if ($field_code === '' || $value === null || $value === '') {
            return;
        }

        $fields[$field_code] = $value;
    }

    private function build_bitrix_file_value(array $data): array {
        if (self::BITRIX_PHOTO_FIELD === '') {
            return array();
        }

        $file_path = $data['photo_path'] ?? '';
        if (!$file_path || !file_exists($file_path) || !is_readable($file_path)) {
            return array();
        }

        $contents = file_get_contents($file_path);
        if ($contents === false) {
            return array();
        }

        $filename = $data['photo_name'] ?? basename($file_path);

        return array(
            sanitize_file_name($filename),
            base64_encode($contents),
        );
    }

    private function append_bitrix_custom_fields(array &$fields, array $data): void {
        if (isset($data['need_measure'])) {
            $this->add_bitrix_field($fields, self::BITRIX_NEED_MEASURE_FIELD, $data['need_measure'] ? 'Y' : 'N');
        }

        if (isset($data['telegram_pref'])) {
            $this->add_bitrix_field($fields, self::BITRIX_TELEGRAM_FIELD, $data['telegram_pref'] ? 'Y' : 'N');
        }

        foreach ($this->get_bitrix_calc_field_map() as $data_key => $field_code) {
            if (!array_key_exists($data_key, $data)) {
                continue;
            }

            $value = $data[$data_key];
            if (is_array($value)) {
                $value = implode(', ', array_filter($value));
            }

            $this->add_bitrix_field($fields, $field_code, $value);
        }

        if (!empty($data['total_price'])) {
            $fields['OPPORTUNITY'] = (float) $data['total_price'];
            $fields['CURRENCY_ID'] = 'RUB';
        }

        $bitrix_file = $this->build_bitrix_file_value($data);
        if (!empty($bitrix_file)) {
            $fields[self::BITRIX_PHOTO_FIELD] = $bitrix_file;
        }
    }

    private function send_to_bitrix(int $post_id, array $data): array {
        $fields = array(
            'TITLE' => sprintf('Лид с сайта тонировки: %s', $data['phone'] ?? $post_id),
            'NAME' => $data['name'] ?? 'Клиент',
            'SOURCE_ID' => self::BITRIX_SOURCE_ID,
            self::BITRIX_DEPARTMENT_FIELD => self::BITRIX_DEPARTMENT_VALUE,
            'ASSIGNED_BY_ID' => self::BITRIX_ASSIGNED_BY_ID,
            'PHONE' => array(
                array(
                    'VALUE' => $data['phone'] ?? '',
                    'VALUE_TYPE' => 'WORK',
                ),
            ),
            'COMMENTS' => $this->build_bitrix_comments($data),
        );

        $utmFields = array('utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term');
        foreach ($utmFields as $utmField) {
            if (!empty($data[$utmField])) {
                $fields[strtoupper($utmField)] = $data[$utmField];
            }
        }

        if (!empty($data['yclid'])) {
            $fields[self::BITRIX_YCLID_FIELD] = $data['yclid'];
        }

        $this->append_bitrix_custom_fields($fields, $data);

        $response = wp_remote_post(self::BITRIX_WEBHOOK_URL . 'crm.lead.add.json', array(
            'timeout' => 20,
            'body' => array(
                'fields' => $fields,
                'params' => array('REGISTER_SONET_EVENT' => 'Y'),
            ),
        ));

        if (is_wp_error($response)) {
            update_post_meta($post_id, '_bitrix_error', $response->get_error_message());
            return array('success' => false, 'message' => $response->get_error_message());
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);
        if (!is_array($body) || !empty($body['error'])) {
            $errorMessage = is_array($body) ? ($body['error_description'] ?? $body['error'] ?? 'Неизвестная ошибка Bitrix24') : 'Некорректный ответ Bitrix24';
            update_post_meta($post_id, '_bitrix_error', $errorMessage);
            update_post_meta($post_id, '_bitrix_response', wp_remote_retrieve_body($response));
            return array('success' => false, 'message' => $errorMessage);
        }

        $leadId = isset($body['result']) ? (int) $body['result'] : 0;
        if ($leadId) {
            update_post_meta($post_id, '_bitrix_lead_id', $leadId);
        }
        update_post_meta($post_id, '_bitrix_response', wp_remote_retrieve_body($response));

        return array('success' => true, 'lead_id' => $leadId);
    }

    /**
     * Обработка отправки заявки CTA
     */
    public function handle_lead_submission() {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'okna_lead_nonce')) {
            wp_send_json_error(array('message' => 'Ошибка безопасности'));
        }

        $name = sanitize_text_field($_POST['name'] ?? '');
        $phone = sanitize_text_field($_POST['phone'] ?? '');
        $comment = sanitize_textarea_field($_POST['comment'] ?? '');
        $need_measure = isset($_POST['need_measure']) ? 1 : 0;
        $telegram_pref = isset($_POST['telegram_pref']) ? 1 : 0;
        $privacy = isset($_POST['privacy']) ? 1 : 0;
        $source = $this->get_request_field('source', 'CTA форма');
        $attribution = $this->collect_attribution_data();

        if (empty($name) || empty($phone)) {
            wp_send_json_error(array('message' => 'Заполните имя и телефон'));
        }

        if (!$privacy) {
            wp_send_json_error(array('message' => 'Необходимо согласие с политикой конфиденциальности'));
        }

        $photo = array();
        try {
            $photo = $this->upload_lead_photo('photo');
        } catch (Exception $exception) {
            wp_send_json_error(array('message' => $exception->getMessage()));
        }

        $post_id = wp_insert_post(array(
            'post_type' => 'okna_lead',
            'post_title' => 'Заявка от ' . $name . ' - ' . current_time('mysql'),
            'post_status' => 'publish',
        ));

        if (is_wp_error($post_id)) {
            wp_send_json_error(array('message' => 'Ошибка сохранения заявки'));
        }

        $leadData = array_merge($attribution, array(
            'name' => $name,
            'phone' => $phone,
            'comment' => $comment,
            'need_measure' => $need_measure,
            'telegram_pref' => $telegram_pref,
            'source' => $source,
            'photo_url' => $photo['url'] ?? '',
            'photo_path' => $photo['file'] ?? '',
            'photo_name' => $photo['name'] ?? '',
            'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
        ));

        $this->save_lead_meta($post_id, array(
            '_lead_source' => $source,
            '_lead_name' => $name,
            '_lead_phone' => $phone,
            '_lead_comment' => $comment,
            '_lead_need_measure' => $need_measure,
            '_lead_telegram_pref' => $telegram_pref,
            '_lead_photo_url' => $photo['url'] ?? '',
            '_lead_ip' => $leadData['ip'],
            '_lead_user_agent' => $leadData['user_agent'],
            '_lead_utm_source' => $attribution['utm_source'],
            '_lead_utm_medium' => $attribution['utm_medium'],
            '_lead_utm_campaign' => $attribution['utm_campaign'],
            '_lead_utm_content' => $attribution['utm_content'],
            '_lead_utm_term' => $attribution['utm_term'],
            '_lead_yclid' => $attribution['yclid'],
        ));

        $bitrixResult = $this->send_to_bitrix($post_id, $leadData);

        $this->send_email_notification($post_id, $leadData);
        $this->send_telegram_notification($post_id, $leadData);

        wp_send_json_success(array(
            'message' => 'Заявка успешно отправлена',
            'bitrix' => $bitrixResult,
        ));
    }

    /**
     * Обработка отправки заявки из калькулятора
     */
    public function handle_calc_lead_submission() {
        try {
            if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'okna_lead_nonce')) {
                wp_send_json_error(array('message' => 'Ошибка безопасности'));
                return;
            }

            $phone = sanitize_text_field($_POST['phone'] ?? '');
            $privacy = isset($_POST['privacy']) ? 1 : 0;
            $source = $this->get_request_field('source', 'Калькулятор');
            $attribution = $this->collect_attribution_data();

            $width = absint($_POST['width'] ?? 0);
            $height = absint($_POST['height'] ?? 0);
            $quantity = absint($_POST['quantity'] ?? 1);
            $category = sanitize_text_field($_POST['category'] ?? '');
            $object = sanitize_text_field($_POST['object'] ?? '');
            $film = sanitize_text_field($_POST['film'] ?? '');
            $total_price = absint($_POST['total_price'] ?? 0);

            if (empty($phone)) {
                wp_send_json_error(array('message' => 'Заполните телефон'));
                return;
            }

            if (!$privacy) {
                wp_send_json_error(array('message' => 'Необходимо согласие с политикой конфиденциальности'));
                return;
            }

            $name = 'Клиент калькулятора';

            $post_id = wp_insert_post(array(
                'post_type' => 'okna_lead',
                'post_title' => 'Заявка из калькулятора - ' . $phone . ' - ' . current_time('mysql'),
                'post_status' => 'publish',
            ));

            if (is_wp_error($post_id)) {
                wp_send_json_error(array('message' => 'Ошибка сохранения заявки'));
                return;
            }

            $leadData = array_merge($attribution, array(
                'name' => $name,
                'phone' => $phone,
                'source' => $source,
                'width' => $width,
                'height' => $height,
                'quantity' => $quantity,
                'category' => $category,
                'object' => $object,
                'film' => $film,
                'total_price' => $total_price,
                'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            ));

            $this->save_lead_meta($post_id, array(
                '_lead_source' => $source,
                '_lead_name' => $name,
                '_lead_phone' => $phone,
                '_lead_total_price' => $total_price,
                '_lead_width' => $width,
                '_lead_height' => $height,
                '_lead_quantity' => $quantity,
                '_lead_category' => $category,
                '_lead_object' => $object,
                '_lead_film' => $film,
                '_lead_ip' => $leadData['ip'],
                '_lead_user_agent' => $leadData['user_agent'],
                '_lead_utm_source' => $attribution['utm_source'],
                '_lead_utm_medium' => $attribution['utm_medium'],
                '_lead_utm_campaign' => $attribution['utm_campaign'],
                '_lead_utm_content' => $attribution['utm_content'],
                '_lead_utm_term' => $attribution['utm_term'],
                '_lead_yclid' => $attribution['yclid'],
            ));

            $bitrixResult = $this->send_to_bitrix($post_id, $leadData);

            $this->send_email_notification($post_id, $leadData);
            $this->send_telegram_notification($post_id, $leadData);

            wp_send_json_success(array(
                'message' => 'Заявка успешно отправлена',
                'bitrix' => $bitrixResult,
            ));
            
        } catch (Exception $e) {
            error_log('Okna Leads Error: ' . $e->getMessage());
            wp_send_json_error(array('message' => 'Внутренняя ошибка: ' . $e->getMessage()));
        }
    }

    /**
     * Отправка уведомления на email
     */
    private function send_email_notification($post_id, $data) {
        if (!get_option('okna_leads_email_enabled')) {
            return;
        }

        $email_to = get_option('okna_leads_email_to');
        if (empty($email_to)) {
            return;
        }

        $subject = get_option('okna_leads_email_subject', 'Новая заявка с сайта');
        
        $message = "Новая заявка с сайта\n";
        $message .= "Источник: " . ($data['source'] ?? '—') . "\n\n";
        $message .= "Имя: " . ($data['name'] ?? '—') . "\n";
        $message .= "Телефон: " . ($data['phone'] ?? '—') . "\n";

        // Данные для CTA формы
        if (isset($data['comment'])) {
            $message .= "Комментарий: " . ($data['comment'] ?: '—') . "\n";
            $message .= "Нужен замер: " . (isset($data['need_measure']) && $data['need_measure'] ? 'Да' : 'Нет') . "\n";
            $message .= "Удобно в Telegram: " . (isset($data['telegram_pref']) && $data['telegram_pref'] ? 'Да' : 'Нет') . "\n";
        }

        // Данные для калькулятора
        if (isset($data['width'])) {
            $message .= "\n--- Данные калькулятора ---\n";
            $message .= "Размер: " . ($data['width'] ?? 0) . ' × ' . ($data['height'] ?? 0) . " мм\n";
            $message .= "Количество: " . ($data['quantity'] ?? 1) . "\n";
            $message .= "Категория: " . ($data['category'] ?? '—') . "\n";
            $message .= "Объект: " . ($data['object'] ?? '—') . "\n";
            $message .= "Плёнка: " . ($data['film'] ?? '—') . "\n";
            $message .= "Итоговая цена: " . number_format($data['total_price'] ?? 0, 0, '', ' ') . " ₽\n";
        }

        $message .= "\nСсылка на заявку: " . admin_url('post.php?post=' . $post_id . '&action=edit');

        $headers = array('Content-Type: text/plain; charset=UTF-8');

        wp_mail($email_to, $subject, $message, $headers);
    }

    /**
     * Отправка уведомления в Telegram
     */
    private function send_telegram_notification($post_id, $data) {
        if (!get_option('okna_leads_telegram_enabled')) {
            return;
        }

        $bot_token = get_option('okna_leads_telegram_bot_token');
        $chat_id = get_option('okna_leads_telegram_chat_id');

        if (empty($bot_token) || empty($chat_id)) {
            return;
        }

        $source = $data['source'] ?? '—';
        $source_icon = $source === 'Калькулятор' ? '🧮' : '📝';
        
        $message = "🔔 <b>Новая заявка с сайта</b>\n\n";
        $message .= "{$source_icon} <b>Источник:</b> {$source}\n";
        $message .= "👤 <b>Имя:</b> " . ($data['name'] ?? '—') . "\n";
        $message .= "📞 <b>Телефон:</b> " . ($data['phone'] ?? '—') . "\n";

        // Данные для CTA формы
        if (isset($data['comment'])) {
            $message .= "📝 <b>Комментарий:</b> " . ($data['comment'] ?: '—') . "\n";
            $message .= "📏 <b>Нужен замер:</b> " . (isset($data['need_measure']) && $data['need_measure'] ? 'Да' : 'Нет') . "\n";
            $message .= "✈️ <b>Удобно в Telegram:</b> " . (isset($data['telegram_pref']) && $data['telegram_pref'] ? 'Да' : 'Нет') . "\n";
        }

        // Данные для калькулятора
        if (isset($data['width'])) {
            $message .= "\n<b>--- Данные калькулятора ---</b>\n";
            $message .= "📐 <b>Размер:</b> " . ($data['width'] ?? 0) . ' × ' . ($data['height'] ?? 0) . " мм\n";
            $message .= "🔢 <b>Количество:</b> " . ($data['quantity'] ?? 1) . "\n";
            $message .= "📁 <b>Категория:</b> " . ($data['category'] ?? '—') . "\n";
            $message .= "🏢 <b>Объект:</b> " . ($data['object'] ?? '—') . "\n";
            $message .= "🎬 <b>Плёнка:</b> " . ($data['film'] ?? '—') . "\n";
            
            $message .= "\n💰 <b>Итоговая цена:</b> " . number_format($data['total_price'] ?? 0, 0, '', ' ') . " ₽\n";
        }

        $url = "https://api.telegram.org/bot{$bot_token}/sendMessage";
        
        wp_remote_post($url, array(
            'body' => array(
                'chat_id' => $chat_id,
                'text' => $message,
                'parse_mode' => 'HTML',
            ),
        ));
    }
}

// Инициализация класса
Okna_Leads::get_instance();
