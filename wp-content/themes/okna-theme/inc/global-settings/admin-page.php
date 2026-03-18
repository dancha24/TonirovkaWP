<?php
/**
 * Global Settings — страница настроек в админке.
 * Регистрирует меню, кнопку в wp_admin_bar и рендерит форму.
 *
 * Файл: inc/global-settings/admin-page.php
 */

defined( 'ABSPATH' ) || exit;

/* =========================================================
 * ADMIN MENU — пункт в боковом меню
 * ======================================================= */

add_action( 'admin_menu', function () {
    add_menu_page(
        'Глобальные параметры',   // <title> страницы
        'Глобальные параметры',   // текст пункта меню
        'manage_options',
        'global-settings',
        'gs_render_settings_page',
        'dashicons-admin-settings',
        3                          // позиция: сразу под Dashboard
    );
} );

/* =========================================================
 * ADMIN BAR — ссылка в верхней панели (только для авторизованных)
 * ======================================================= */

add_action( 'admin_bar_menu', function ( WP_Admin_Bar $bar ) {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    $bar->add_node( [
        'id'    => 'global-settings-bar',
        'title' => '<span class="ab-icon dashicons dashicons-admin-settings" style="top:2px"></span> Глобальные параметры',
        'href'  => admin_url( 'admin.php?page=global-settings' ),
        'meta'  => [ 'title' => 'Глобальные параметры' ],
    ] );
}, 100 );

/* =========================================================
 * ADMIN ASSETS — подключаем CSS только на нашей странице
 * ======================================================= */

add_action( 'admin_enqueue_scripts', function ( string $hook ) {
    if ( $hook !== 'toplevel_page_global-settings' ) {
        return;
    }
    wp_enqueue_style(
        'gs-admin',
        get_template_directory_uri() . '/inc/global-settings/admin.css',
        [],
        '1.0.0'
    );
} );

/* =========================================================
 * SETTINGS PAGE — рендер формы
 * ======================================================= */

function gs_render_settings_page(): void {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // Сохранение
    if ( isset( $_POST['gs_nonce'] ) && wp_verify_nonce( $_POST['gs_nonce'], 'gs_save_settings' ) ) {
        update_option( GS_OPTION_KEY, [
            'phone'      => sanitize_text_field( $_POST['gs_phone'] ?? '' ),
            'telegram'   => esc_url_raw( $_POST['gs_telegram'] ?? '' ),
            'address'    => sanitize_textarea_field( $_POST['gs_address'] ?? '' ),
            'work_hours' => sanitize_text_field( $_POST['gs_work_hours'] ?? '' ),
            'metrika'    => sanitize_textarea_field( $_POST['gs_metrika'] ?? '' ),
        ] );
        gs_get_options( true ); // сбрасываем static-кэш, чтобы форма показала свежие данные
        echo '<div class="notice notice-success is-dismissible"><p>✅ Настройки сохранены.</p></div>';
    }

    $opts = gs_get_options();
    ?>
    <div class="wrap gs-wrap">

        <h1 class="gs-page-title">
            <span class="dashicons dashicons-admin-settings"></span>
            Глобальные параметры
        </h1>

        <div class="gs-layout">

            <!-- ======== ФОРМА ======== -->
            <div class="gs-card gs-main-card">
                <form method="post" action="">
                    <?php wp_nonce_field( 'gs_save_settings', 'gs_nonce' ); ?>

                    <!-- Телефон -->
                    <div class="gs-field-group">
                        <label for="gs_phone" class="gs-label">
                            <span class="dashicons dashicons-phone"></span> Телефон
                        </label>
                        <input type="text" id="gs_phone" name="gs_phone" class="gs-input"
                               value="<?php echo esc_attr( $opts['phone'] ); ?>"
                               placeholder="+7 (000) 000-00-00">
                    </div>

                    <!-- Telegram -->
                    <div class="gs-field-group">
                        <label for="gs_telegram" class="gs-label">
                            <span class="dashicons dashicons-share"></span> Telegram ссылка
                        </label>
                        <input type="url" id="gs_telegram" name="gs_telegram" class="gs-input"
                               value="<?php echo esc_attr( $opts['telegram'] ); ?>"
                               placeholder="https://t.me/username">
                    </div>

                    <!-- Адрес -->
                    <div class="gs-field-group">
                        <label for="gs_address" class="gs-label">
                            <span class="dashicons dashicons-location"></span> Адрес
                        </label>
                        <textarea id="gs_address" name="gs_address"
                                  class="gs-input gs-textarea" rows="3"
                                  placeholder="г. Москва, ул. Примерная, д. 1"
                        ><?php echo esc_textarea( $opts['address'] ); ?></textarea>
                    </div>

                    <!-- Время работы -->
                    <div class="gs-field-group">
                        <label for="gs_work_hours" class="gs-label">
                            <span class="dashicons dashicons-clock"></span> Время работы
                        </label>
                        <input type="text" id="gs_work_hours" name="gs_work_hours" class="gs-input"
                               value="<?php echo esc_attr( $opts['work_hours'] ); ?>"
                               placeholder="Пн–Пт: 9:00–18:00">
                    </div>

                    <!-- Метрика -->
                   <?php 
                   
                   /*
                    <div class="gs-field-group gs-field-group--metrika">
                        <label for="gs_metrika" class="gs-label">
                            <span class="dashicons dashicons-chart-bar"></span> Метрика
                            <span class="gs-label-hint">Яндекс.Метрика / Google Analytics / GTM</span>
                        </label>
                        <textarea id="gs_metrika" name="gs_metrika"
                                  class="gs-input gs-textarea gs-textarea--code"
                                  rows="7" spellcheck="false"
                                  placeholder="<!-- вставь код счётчика -->"
                        ><?php echo esc_textarea( $opts['metrika'] ); ?></textarea>
                        <p class="gs-field-hint">
                            Вызови <code>gs_metrika_output()</code> вручную в <code>footer.php</code> перед <code>&lt;/body&gt;</code>.
                        </p>
                    </div>
                   
                   */
                   ?>

                    <div class="gs-actions">
                        <button type="submit" class="gs-btn gs-btn-primary">
                            <span class="dashicons dashicons-saved"></span>
                            Сохранить настройки
                        </button>
                    </div>

                </form>
            </div>

            <!-- ======== САЙДБАР ======== -->
            <div class="gs-sidebar">

                <div class="gs-card gs-shortcut-card">
                    <h3 class="gs-card-title">Быстрый доступ</h3>

                    <a href="<?php echo admin_url( 'nav-menus.php' ); ?>" target="_blank"
                       class="gs-btn gs-btn-secondary gs-full">
                        <span class="dashicons dashicons-menu"></span> Редактировать меню
                    </a>

                    <a href="<?php echo admin_url( 'customize.php' ); ?>" target="_blank"
                       class="gs-btn gs-btn-secondary gs-full">
                        <span class="dashicons dashicons-admin-customizer"></span> Замена иконки / Настроить
                    </a>

                    <a href="<?php echo admin_url( 'admin.php?page=wca-settings' ); ?>"
                       class="gs-btn gs-btn-secondary gs-full">
                        <span class="dashicons dashicons-calculator"></span> Калькулятор (WCA)
                    </a>
                </div>

                <!-- <div class="gs-card gs-usage-card">
                    <h3 class="gs-card-title">Использование на фронте</h3>

                    <p class="gs-hint">PHP:</p>
                    <code class="gs-code">&lt;?php echo gs_phone(); ?&gt;</code>
                    <code class="gs-code">&lt;?php echo gs_telegram(); ?&gt;</code>
                    <code class="gs-code">&lt;?php echo gs_address(); ?&gt;</code>
                    <code class="gs-code">&lt;?php echo gs_work_hours(); ?&gt;</code>
                    <code class="gs-code">&lt;?php gs_metrika_output(); ?&gt;</code>

                    <p class="gs-hint" style="margin-top:12px">Shortcode:</p>
                    <code class="gs-code">[gs_phone]</code>
                    <code class="gs-code">[gs_telegram]</code>
                    <code class="gs-code">[gs_address]</code>
                    <code class="gs-code">[gs_work_hours]</code>

                    <p class="gs-hint" style="margin-top:12px">Метрика:</p>
                    <code class="gs-code">wp_head → авто ✓</code>
                </div> -->

            </div>

        </div><!-- /gs-layout -->
    </div>
    <?php
}