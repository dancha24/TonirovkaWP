<?php
/**
 * Шаблон вывода ACF Flexible Content блоков
 * Использование: include get_template_directory() . '/template-parts/render-flexible-blocks.php';
 */

if ( ! function_exists( 'render_flexible_blocks' ) ) :

function render_flexible_blocks( $field_name = 'flexible_blocks' ) {
    if ( ! function_exists( 'have_rows' ) || ! have_rows( $field_name ) ) {
        return;
    }

    while ( have_rows( $field_name ) ) : the_row();
        $layout = get_row_layout();

        switch ( $layout ) {
            case 'hero':
                // Получаем все подполя блока Hero
                $data = [
                    'bg_image'   => get_sub_field( 'bg_image' ),
                    'title'      => get_sub_field( 'title' ),
                    'subtitle'   => get_sub_field( 'subtitle' ),
                    'benefits'   => get_sub_field( 'benefits' ),
                    'cta_text'   => get_sub_field( 'cta_text' ),
                    'cta_link'   => get_sub_field( 'cta_link' ),
                ];
                render_block_hero( $data );
                break;

            case 'advantages':
                $data = [
                    'adv_items' => get_sub_field( 'adv_items' ),
                ];
                render_block_advantages( $data );
                break;

            case 'text_image':
                $data = [
                    'image'          => get_sub_field( 'image' ),
                    'title'          => get_sub_field( 'title' ),
                    'content'        => get_sub_field( 'content' ),
                    'image_position' => get_sub_field( 'image_position' ),
                ];
                render_block_text_image( $data );
                break;

            case 'cta':
                $data = [
                    'bg_color'    => get_sub_field( 'bg_color' ),
                    'title'       => get_sub_field( 'title' ),
                    'text'        => get_sub_field( 'text' ),
                    'button_text' => get_sub_field( 'button_text' ),
                    'button_link' => get_sub_field( 'button_link' ),
                ];
                render_block_cta( $data );
                break;

            case 'front_hero':
                render_block_front_hero();
                break;

            case 'front_solutions':
                render_block_front_solutions();
                break;

            case 'front_types':
                render_block_front_types();
                break;

            case 'front_about':
                render_block_front_about();
                break;

            case 'front_measure_photo':
                render_block_front_measure_photo();
                break;

            case 'front_call_measurer':
                render_block_front_call_measurer();
                break;

            case 'front_prices':
                render_block_front_prices();
                break;

            case 'front_calculator':
                render_block_front_calculator();
                break;

            case 'front_cases':
                render_block_front_cases();
                break;

            case 'front_why':
                render_block_front_why();
                break;

            case 'front_faq':
                render_block_front_faq();
                break;

            case 'front_geo':
                render_block_front_geo();
                break;

            case 'front_cta':
                render_block_front_cta();
                break;

            default:
                do_action( 'render_flexible_block_' . $layout );
                break;
        }

    endwhile;
}

endif;

require_once get_template_directory() . '/template-parts/render-flexible-front-blocks.php';


// ──────────────────────────────────────────────────────────────────────
// Блок: Hero
// ──────────────────────────────────────────────────────────────────────
if ( ! function_exists( 'render_block_hero' ) ) :
function render_block_hero( $data ) {
    $bg_image   = $data['bg_image'] ?? '';
    $title      = $data['title'] ?? '';
    $subtitle   = $data['subtitle'] ?? '';
    $benefits   = $data['benefits'] ?? '';
    $cta_text   = $data['cta_text'] ?? '';
    $cta_link   = $data['cta_link'] ?? '#calc';

    $bg_url = is_array( $bg_image ) ? $bg_image['url'] : $bg_image;
    ?>
    <section class="hero hero_bg" aria-label="Главный экран">
        <div class="hero__bg" style="background-image: url('<?php echo esc_url( $bg_url ); ?>');">
            <?php if ( $bg_url ) : ?>
                <img src="<?php echo esc_url( $bg_url ); ?>" alt="" role="presentation">
            <?php endif; ?>
        </div>
        <div class="hero__overlay" aria-hidden="true"></div>
        <div class="hero__container container">
            <div class="hero__content">
                <?php if ( $title ) : ?>
                    <h1 class="hero__title"><?php echo esc_html( $title ); ?></h1>
                <?php endif; ?>

                <?php if ( $subtitle ) : ?>
                    <p class="hero__subtitle"><?php echo esc_html( $subtitle ); ?></p>
                <?php endif; ?>

                <?php if ( $benefits ) : ?>
                    <ul class="hero__benefits">
                        <?php
                        $benefits_array = array_filter( explode( "\n", $benefits ) );
                        foreach ( $benefits_array as $benefit ) :
                        ?>
                            <li><?php echo esc_html( trim( $benefit ) ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if ( $cta_text ) : ?>
                    <a href="<?php echo esc_url( $cta_link ); ?>" class="hero__cta">
                        <?php echo esc_html( $cta_text ); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php
}
endif;


// ──────────────────────────────────────────────────────────────────────
// Блок: Преимущества
// ──────────────────────────────────────────────────────────────────────
if ( ! function_exists( 'render_block_advantages' ) ) :
function render_block_advantages( $data ) {
    $adv_items = $data['adv_items'] ?? [];
    ?>
    <section class="hero__advantages-section" aria-label="Преимущества">
        <div class="container">
            <div class="hero__advantages">
                <?php if ( $adv_items ) : ?>
                    <?php foreach ( $adv_items as $item ) : ?>
                        <div class="hero__advantage">
                            <?php if ( ! empty( $item['icon'] ) ) : ?>
                                <div class="hero__advantage-icon" aria-hidden="true"><?php echo esc_html( $item['icon'] ); ?></div>
                            <?php endif; ?>

                            <?php if ( ! empty( $item['title'] ) ) : ?>
                                <div class="hero__advantage-title"><?php echo esc_html( $item['title'] ); ?></div>
                            <?php endif; ?>

                            <?php if ( ! empty( $item['text'] ) ) : ?>
                                <p class="hero__advantage-text"><?php echo esc_html( $item['text'] ); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php
}
endif;


// ──────────────────────────────────────────────────────────────────────
// Блок: Текст + Картинка
// ──────────────────────────────────────────────────────────────────────
if ( ! function_exists( 'render_block_text_image' ) ) :
function render_block_text_image( $data ) {
    $image    = $data['image'] ?? '';
    $title    = $data['title'] ?? '';
    $content  = $data['content'] ?? '';
    $position = $data['image_position'] ?? 'left';

    $image_url = is_array( $image ) ? $image['url'] : $image;
    $image_alt = is_array( $image ) ? $image['alt'] : '';
    ?>
    <section class="text-image-block" aria-label="<?php echo esc_attr( $title ?: 'Текст и изображение' ); ?>">
        <div class="container">
            <div class="text-image-block__inner text-image-block__inner--<?php echo esc_attr( $position ); ?>">
                <?php if ( $image_url ) : ?>
                    <div class="text-image-block__image-wrap">
                        <img src="<?php echo esc_url( $image_url ); ?>"
                             alt="<?php echo esc_attr( $image_alt ); ?>"
                             class="text-image-block__image">
                    </div>
                <?php endif; ?>

                <div class="text-image-block__content">
                    <?php if ( $title ) : ?>
                        <h2 class="text-image-block__title"><?php echo esc_html( $title ); ?></h2>
                    <?php endif; ?>

                    <?php if ( $content ) : ?>
                        <div class="text-image-block__text">
                            <?php echo wp_kses_post( $content ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}
endif;


// ──────────────────────────────────────────────────────────────────────
// Блок: CTA (Призыв к действию)
// ──────────────────────────────────────────────────────────────────────
if ( ! function_exists( 'render_block_cta' ) ) :
function render_block_cta( $data ) {
    $bg_color     = $data['bg_color'] ?? '#0096D9';
    $title        = $data['title'] ?? '';
    $text         = $data['text'] ?? '';
    $button_text  = $data['button_text'] ?? '';
    $button_link  = $data['button_link'] ?? '#calc';
    ?>
    <section class="cta-block" aria-label="<?php echo esc_attr( $title ?: 'Призыв к действию' ); ?>"
             style="background-color: <?php echo esc_attr( $bg_color ); ?>;">
        <div class="container">
            <div class="cta-block__inner">
                <?php if ( $title ) : ?>
                    <h2 class="cta-block__title"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <?php if ( $text ) : ?>
                    <p class="cta-block__text"><?php echo esc_html( $text ); ?></p>
                <?php endif; ?>

                <?php if ( $button_text ) : ?>
                    <a href="<?php echo esc_url( $button_link ); ?>" class="button cta-block__button">
                        <?php echo esc_html( $button_text ); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php
}
endif;
