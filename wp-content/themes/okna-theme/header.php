<?php

if (!defined('ABSPATH')) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>


    <div class="wrapper">
        <header class="header" aria-label="Шапка сайта">
            <div class="container">
                <div class="header__container">
                    <div class="header__logo">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/logo.png"
                            alt="РћРєРЅРѕ РўСЋРЅРёРЅРі" class="header__logo-img">
                    </div>

                    <nav class="header__menu" id="menu" aria-label="Главное меню">
                        <?php
                        wp_nav_menu([
                            'menu_class' => 'header__list',
                            'container' => false,
                            'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                            'walker' => new Header_Menu_Walker(),
                        ]);
                        ?>
                    </nav>
                    <div class="header__actions">
                        <button type="button" class="button header__call-action header__call-action_calc js-consult-modal-open"
                            data-da=".header__actions,480,first" data-strapi="headerCtaText" aria-label="Заказать консультацию">
                            <span data-strapi="headerCtaText">Заказать консультацию</span>
                        </button>
                        <a href="tel:<?php echo gs_phone(); ?>" class="header__phone" data-da="#menu,640,last"
                            data-strapi="headerPhoneLink">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 24C5.383 24 0 18.617 0 12C0 5.383 5.383 0 12 0C18.617 0 24 5.383 24 12C24 18.617 18.617 24 12 24ZM12 1C5.935 1 1 5.935 1 12C1 18.065 5.935 23 12 23C18.065 23 23 18.065 23 12C23 5.935 18.065 1 12 1Z"
                                    fill="#0096D9" />
                                <path
                                    d="M15.404 18.9786C10.931 18.9786 5 13.0466 5 8.57363C5 7.60963 5.365 6.71462 6.027 6.05262L6.702 5.46363C7.308 4.85263 8.479 4.83062 9.135 5.48662L10.261 6.94563C10.547 7.22463 10.728 7.66063 10.728 8.12563C10.728 8.59063 10.547 9.02663 10.218 9.35463L9.519 10.2376C10.396 12.2596 11.779 13.6466 13.735 14.4626L14.645 13.7376C15.323 13.0826 16.41 13.0876 17.082 13.7586L18.443 14.7986C19.17 15.5196 19.17 16.6226 18.492 17.2996L17.949 17.9246C17.264 18.6126 16.369 18.9766 15.405 18.9766L15.404 18.9786ZM7.905 5.97863C7.709 5.97863 7.523 6.05563 7.384 6.19463L6.709 6.78362C6.261 7.23263 6 7.87663 6 8.57363C6 12.7246 11.831 17.9786 15.404 17.9786C16.1 17.9786 16.745 17.7176 17.217 17.2446L17.76 16.6196C18.072 16.3076 18.071 15.8386 17.783 15.5506L16.422 14.5106C16.085 14.1796 15.616 14.1796 15.329 14.4676L13.905 15.6046L13.638 15.5026C11.216 14.5776 9.48 12.8426 8.478 10.3456L8.37 10.0756L9.472 8.68963C9.65 8.50763 9.727 8.32263 9.727 8.12563C9.727 7.92863 9.65 7.74362 9.51 7.60462L8.384 6.14562C8.287 6.05462 8.102 5.97863 7.905 5.97863Z"
                                    fill="#0096D9" />
                            </svg>
                            <span data-strapi="headerPhone"><?php echo gs_phone(); ?></span>
                        </a>
                        <a href="<?php echo gs_telegram(); ?>" target="_blank"
                            class="header__social header__outline-button" aria-label="Написать в Telegram"
                            data-strapi="headerTelegramUrl">
                            <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 1000 1000">
                                <defs>
                                    <linearGradient id="b">
                                        <stop offset="0" stop-color="#00f" />
                                        <stop offset="1" stop-opacity="0" />
                                        <stop offset="1" stop-opacity="0" />
                                    </linearGradient>
                                    <linearGradient id="a">
                                        <stop offset="0" stop-color="#4cf" />
                                        <stop offset=".662" stop-color="#53e" />
                                        <stop offset="1" stop-color="#93d" />
                                    </linearGradient>
                                    <linearGradient id="c" x1="117.847" x2="1000" y1="760.536" y2="500"
                                        gradientUnits="userSpaceOnUse" href="#a" />
                                    <radialGradient id="d" cx="-87.392" cy="1166.116" r="500" fx="-87.392" fy="1166.116"
                                        gradientTransform="rotate(51.356 1551.478 559.3)scale(2.42703433 1)"
                                        gradientUnits="userSpaceOnUse" href="#b" />
                                </defs>
                                <rect width="1000" height="1000" fill="url(#c)" ry="249.681" />
                                <rect width="1000" height="1000" fill="url(#d)" ry="249.681" />
                                <path fill="#fff" fill-rule="evenodd"
                                    d="M508.211 878.328c-75.007 0-109.864-10.95-170.453-54.75-38.325 49.275-159.686 87.783-164.979 21.9 0-49.456-10.95-91.248-23.36-136.873-14.782-56.21-31.572-118.807-31.572-209.508 0-216.626 177.754-379.597 388.357-379.597 210.785 0 375.947 171.001 375.947 381.604.707 207.346-166.595 376.118-373.94 377.224m3.103-571.585c-102.564-5.292-182.499 65.7-200.201 177.024-14.6 92.162 11.315 204.398 33.397 210.238 10.585 2.555 37.23-18.98 53.837-35.587a189.8 189.8 0 0 0 92.71 33.032c106.273 5.112 197.08-75.794 204.215-181.95 4.154-106.382-77.67-196.486-183.958-202.574Z"
                                    clip-rule="evenodd" />
                            </svg>

                        </a>
                        <button type="button" class="header__menu-button header__outline-button" id="menu-button"
                            aria-label="Открыть меню">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M23 11H1C0.447715 11 0 11.4477 0 12C0 12.5523 0.447715 13 1 13H23C23.5523 13 24 12.5523 24 12C24 11.4477 23.5523 11 23 11Z"
                                    fill="#0096D9" />
                                <path
                                    d="M23 4H1C0.447715 4 0 4.44771 0 5C0 5.55228 0.447715 6 1 6H23C23.5523 6 24 5.55228 24 5C24 4.44771 23.5523 4 23 4Z"
                                    fill="#0096D9" />
                                <path
                                    d="M23 18H1C0.447715 18 0 18.4477 0 19C0 19.5523 0.447715 20 1 20H23C23.5523 20 24 19.5523 24 19C24 18.4477 23.5523 18 23 18Z"
                                    fill="#0096D9" />
                            </svg>

                        </button>
                    </div>
                </div>
            </div>
        </header>