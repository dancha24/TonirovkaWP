<?php

if (!defined('ABSPATH')) {
    exit;
}
?>

<footer class="footer" aria-label="Подвал сайта">
    <div class="container">
        <div class="footer__container">

            <nav class="footer__nav" aria-label="Навигация по сайту">
                <?php
                wp_nav_menu([
                    'menu_class' => 'footer__list',
                    'container' => false,
                    'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'walker' => new Footer_Menu_Walker(),
                ]);
                ?>
                <a href="#" class="footer__logo" aria-label="Наверх">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/logo.png"
                        alt="Окно Тюнинг" class="footer__logo-image">
                </a>
            </nav>

            <ul class="footer__contacts" aria-label="Контакты">
                <li class="footer__contact-item">
                    <span class="footer__contact-icon" aria-hidden="true"><svg width="18" height="18"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg></span>
                    <span class="footer__contact-text" data-strapi="footerAddress"><?php echo gs_address(); ?></span>
                </li>
                <li class="footer__contact-item">
                    <span class="footer__contact-icon" aria-hidden="true"><svg width="18" height="18"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg></span>
                    <span class="footer__contact-text"
                        data-strapi="footerSchedule"><?php echo gs_work_hours(); ?></span>
                </li>
                <li class="footer__contact-item">
                    <span class="footer__contact-icon" aria-hidden="true"><svg width="18" height="18"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                        </svg></span>
                    <a href="tel:<?php echo gs_phone(); ?>" class="footer__contact-text"
                        data-strapi="footerPhoneLink"><?php echo gs_phone(); ?></a>
                </li>
                <li class="footer__contact-item footer__contact-item_max">
                    <a href="<?php echo gs_telegram(); ?>" target="_blank" class="footer__contact-max" aria-label="МАХ"
                        data-strapi="footerTelegramUrl">
                        <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 1000 1000" width="40" height="40">
                            <defs>
                                <linearGradient id="footer-max-a">
                                    <stop offset="0" stop-color="#4cf" />
                                    <stop offset=".662" stop-color="#53e" />
                                    <stop offset="1" stop-color="#93d" />
                                </linearGradient>
                                <linearGradient id="footer-max-c" x1="117.847" x2="1000" y1="760.536" y2="500" gradientUnits="userSpaceOnUse" href="#footer-max-a" />
                            </defs>
                            <rect width="1000" height="1000" fill="url(#footer-max-c)" ry="249.681" />
                            <path fill="#fff" fill-rule="evenodd"
                                d="M508.211 878.328c-75.007 0-109.864-10.95-170.453-54.75-38.325 49.275-159.686 87.783-164.979 21.9 0-49.456-10.95-91.248-23.36-136.873-14.782-56.21-31.572-118.807-31.572-209.508 0-216.626 177.754-379.597 388.357-379.597 210.785 0 375.947 171.001 375.947 381.604.707 207.346-166.595 376.118-373.94 377.224m3.103-571.585c-102.564-5.292-182.499 65.7-200.201 177.024-14.6 92.162 11.315 204.398 33.397 210.238 10.585 2.555 37.23-18.98 53.837-35.587a189.8 189.8 0 0 0 92.71 33.032c106.273 5.112 197.08-75.794 204.215-181.95 4.154-106.382-77.67-196.486-183.958-202.574Z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </li>
            </ul>

        </div>
    </div>
</footer>
</div>
<div id="privacy-modal" class="privacy-modal" aria-hidden="true" role="dialog" aria-labelledby="privacy-modal-title">
    <div class="privacy-modal__box">
        <button type="button" class="privacy-modal__close js-privacy-modal-close" aria-label="Закрыть">×</button>
        <h2 id="privacy-modal-title" class="privacy-modal__title">Политика конфиденциальности и обработки персональных
            данных</h2>
        <div class="privacy-modal__body">
            <h4>1. Общие положения</h4>
            <p>Настоящая политика обработки персональных данных составлена в соответствии с требованиями Федерального
                закона от 27.07.2006 № 152-ФЗ «О персональных данных» и определяет порядок обработки персональных данных
                и меры по обеспечению их безопасности, предпринимаемые владельцем сайта (далее — Оператор).</p>
            <p>Политика применяется ко всей информации, которую Оператор может получить о посетителях веб-сайта.</p>
            <h4>2. Основные понятия</h4>
            <p><strong>Персональные данные</strong> — любая информация, относящаяся к определённому или определяемому
                физическому лицу. <strong>Обработка персональных данных</strong> — любое действие с персональными
                данными (сбор, запись, систематизация, хранение, использование, передача и т.д.).
                <strong>Оператор</strong> — владелец сайта, осуществляющий обработку персональных данных.</p>
            <h4>3. Цели обработки</h4>
            <p>Обработка осуществляется в целях связи с пользователем при направлении заявки с сайта (имя, телефон для
                обратного звонка и расчёта). Правовое основание: согласие субъекта персональных данных. Виды обработки:
                сбор, запись, систематизация, хранение, использование, передача в рамках исполнения заявки.</p>
            <h4>4. Условия обработки</h4>
            <p>Обработка осуществляется с согласия субъекта персональных данных. Согласие даётся путём проставления
                отметки в форме на сайте перед отправкой заявки.</p>
            <h4>5. Безопасность и передача данных</h4>
            <p>Оператор обеспечивает сохранность персональных данных. Персональные данные не передаются третьим лицам,
                за исключением случаев, предусмотренных законодательством РФ или необходимости исполнения заявки.</p>
            <h4>6. Права субъекта персональных данных</h4>
            <p>Субъект имеет право получать информацию об обработке своих данных, требовать уточнения, блокирования или
                уничтожения данных, отозвать согласие, направив обращение Оператору по контактам, указанным на сайте.
            </p>
            <h4>7. Заключительные положения</h4>
            <p>Актуальная версия Политики размещена на сайте. Оператор вправе вносить изменения; новая редакция вступает
                в силу с момента её размещения.</p>
        </div>
    </div>
</div>
<div id="consult-modal" class="consult-modal" aria-hidden="true" role="dialog" aria-labelledby="consult-modal-title">
    <div class="consult-modal__box">
        <button type="button" class="consult-modal__close js-consult-modal-close" aria-label="Закрыть">×</button>
        <h2 id="consult-modal-title" class="consult-modal__title">Заказать звонок</h2>
        <form class="cta__form consult-modal__form" novalidate data-source="Заказать звонок">
            <div class="input">
                <input type="text" name="name" class="input__input" placeholder="Имя" aria-label="Имя">
            </div>
            <div class="input">
                <input type="tel" name="phone" class="input__input" placeholder="+7 (___) ___-__-__" aria-label="Телефон">
            </div>
            <label class="checkbox consult-modal__privacy">
                <input type="checkbox" name="privacy" class="checkbox__input" required>
                <span class="checkbox__text">Соглашаюсь с <a href="#" class="js-open-privacy">Политикой конфиденциальности</a></span>
            </label>
            <button type="submit" class="consult-modal__button button button_primary">Отправить</button>
        </form>
    </div>
</div>
<div id="calc-modal" class="calc-modal" aria-hidden="true" role="dialog" aria-label="Калькулятор">
    <div class="calc-modal__box">
        <button type="button" class="calc-modal__close js-calc-modal-close" aria-label="Закрыть">×</button>
        <div class="calc-modal__body js-calc-modal-body"></div>
    </div>
</div>
<div id="case-modal" class="case-modal" aria-hidden="true" role="dialog" aria-labelledby="case-modal-title">
    <div class="case-modal__box">
        <h2 id="case-modal-title" class="case-modal__title"></h2>
        <div class="case-modal__gallery" aria-label="Фотографии кейса">
            <div class="case-modal__main-wrap">
                <button type="button" class="case-modal__arrow case-modal__arrow_prev js-case-modal-prev"
                    aria-label="Предыдущее фото"></button>
                <img class="case-modal__main js-case-modal-main" src="" alt="" width="480" height="300">
                <button type="button" class="case-modal__arrow case-modal__arrow_next js-case-modal-next"
                    aria-label="Следующее фото"></button>
            </div>
            <div class="case-modal__thumbs js-case-modal-thumbs"></div>
        </div>
        <div class="case-modal__stats"></div>
        <div class="case-modal__review-title">Отзыв клиента</div>
        <p class="case-modal__review-text"></p>
        <button type="button" class="case-modal__close js-case-modal-close">Закрыть</button>
    </div>
</div>
<script>
    (function () {
        document.addEventListener('DOMContentLoaded', function () {
            var modal = document.getElementById('case-modal');
            if (!modal) return;

            var titleEl = modal.querySelector('.case-modal__title');
            var statsEl = modal.querySelector('.case-modal__stats');
            var reviewEl = modal.querySelector('.case-modal__review-text');
            var mainImg = modal.querySelector('.js-case-modal-main');
            var thumbsWrap = modal.querySelector('.js-case-modal-thumbs');
            var btnPrev = modal.querySelector('.js-case-modal-prev');
            var btnNext = modal.querySelector('.js-case-modal-next');
            var galleryImages = [];
            var galleryIndex = 0;

            function setGallerySlide(index) {
                if (!galleryImages.length) return;
                galleryIndex = (index + galleryImages.length) % galleryImages.length;
                if (mainImg) {
                    mainImg.src = galleryImages[galleryIndex].src;
                    mainImg.alt = galleryImages[galleryIndex].alt || '';
                }
                if (thumbsWrap) {
                    thumbsWrap.querySelectorAll('.case-modal__thumb').forEach(function (th, i) {
                        th.classList.toggle('is-active', i === galleryIndex);
                    });
                }
                if (btnPrev) btnPrev.disabled = galleryImages.length <= 1;
                if (btnNext) btnNext.disabled = galleryImages.length <= 1;
            }

            function openModal(card) {
                // Читаем данные прямо из DOM карточки
                var title = card.querySelector('.case__title')?.textContent.trim() || '';
                var stats = card.querySelectorAll('.case__stat strong');
                var obj = stats[0]?.textContent.trim() || '';
                var district = stats[1]?.textContent.trim() || '';
                var qty = stats[2]?.textContent.trim() || '';
                var area = stats[3]?.textContent.trim() || '';
                var term = stats[4]?.textContent.trim() || '';
                var review = card.querySelector('.case__review-text')?.textContent.trim() || '';

                if (titleEl) titleEl.textContent = title;
                if (statsEl) statsEl.innerHTML =
                    '<div>Объект: <strong>' + obj + '</strong></div>' +
                    '<div>Район: <strong>' + district + '</strong></div>' +
                    '<div>Кол-во: <strong>' + qty + '</strong></div>' +
                    '<div>Площадь: <strong>' + area + '</strong></div>' +
                    '<div>Срок: <strong>' + term + '</strong></div>';
                if (reviewEl) reviewEl.textContent = review;

                // Картинки
                galleryImages = [];
                card.querySelectorAll('.case__images img').forEach(function (img) {
                    if (img.src) galleryImages.push({
                        src: img.src,
                        alt: img.alt || ''
                    });
                });

                if (thumbsWrap) {
                    thumbsWrap.innerHTML = '';
                    galleryImages.slice(0, 3).forEach(function (image, i) {
                        var th = document.createElement('button');
                        th.type = 'button';
                        th.className = 'case-modal__thumb' + (i === 0 ? ' is-active' : '');
                        th.setAttribute('aria-label', 'Фото ' + (i + 1));
                        th.dataset.index = i;
                        var inner = document.createElement('img');
                        inner.src = image.src;
                        inner.alt = image.alt;
                        th.appendChild(inner);
                        th.addEventListener('click', function () {
                            setGallerySlide(parseInt(this.dataset.index, 10));
                        });
                        thumbsWrap.appendChild(th);
                    });
                }

                galleryIndex = 0;
                setGallerySlide(0);

                var galleryEl = modal.querySelector('.case-modal__gallery');
                if (galleryEl) galleryEl.style.display = galleryImages.length ? 'block' : 'none';

                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                modal.classList.remove('is-open');
                modal.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            }

            if (btnPrev) btnPrev.addEventListener('click', function () {
                setGallerySlide(galleryIndex - 1);
            });
            if (btnNext) btnNext.addEventListener('click', function () {
                setGallerySlide(galleryIndex + 1);
            });

            document.addEventListener('click', function (e) {
                if (e.target.closest('.js-case-open')) {
                    var card = e.target.closest('.case');
                    if (card) {
                        e.preventDefault();
                        openModal(card);
                    }
                }
                if (e.target.closest('.js-case-modal-close') || e.target === modal) {
                    e.preventDefault();
                    closeModal();
                }
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
            });
        });
    })();
</script>
<script>
    (function () {
        var privacyModal = document.getElementById('privacy-modal');

        function openPrivacyModal() {
            if (privacyModal) {
                privacyModal.classList.add('is-open');
                privacyModal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            }
        }

        function closePrivacyModal() {
            if (privacyModal) {
                privacyModal.classList.remove('is-open');
                privacyModal.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            }
        }
        document.addEventListener('click', function (e) {
            if (e.target.closest('.js-open-privacy')) {
                e.preventDefault();
                e.stopPropagation();
                openPrivacyModal();
            }
            if (privacyModal && privacyModal.classList.contains('is-open') && (e.target.closest('.js-privacy-modal-close') || e.target === privacyModal)) {
                e.preventDefault();
                closePrivacyModal();
            }
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && privacyModal && privacyModal.classList.contains('is-open')) closePrivacyModal();
        });
    })();
</script>
<script>
    (function () {
        var consultModal = document.getElementById('consult-modal');

        function openConsultModal() {
            if (consultModal) {
                consultModal.classList.add('is-open');
                consultModal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeConsultModal() {
            if (consultModal) {
                consultModal.classList.remove('is-open');
                consultModal.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            }
        }
        document.addEventListener('click', function (e) {
            if (e.target.closest('.js-consult-modal-open')) {
                e.preventDefault();
                openConsultModal();
            }
            /* Шапка: на десктопе — модалка, на мобилке — tel: (звонок) */
            if (e.target.closest('.js-header-cta') && window.innerWidth > 480) {
                e.preventDefault();
                openConsultModal();
            }
            if (consultModal && consultModal.classList.contains('is-open') && (e.target.closest('.js-consult-modal-close') || e.target === consultModal)) {
                e.preventDefault();
                closeConsultModal();
            }
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && consultModal && consultModal.classList.contains('is-open')) closeConsultModal();
        });
        window.closeConsultModal = closeConsultModal;
    })();
</script>
<script>
    (function () {
        var calcModal = document.getElementById('calc-modal');
        var calcModalBody = calcModal && calcModal.querySelector('.js-calc-modal-body');
        var calcRestoreParent = null;
        var calcRestoreNext = null;

        function openCalcModal() {
            var calcEl = document.getElementById('calc');
            if (!calcModal || !calcModalBody || !calcEl) return;
            calcRestoreParent = calcEl.parentNode;
            calcRestoreNext = calcEl.nextSibling;
            calcModalBody.appendChild(calcEl);
            calcModal.classList.add('is-open');
            calcModal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeCalcModal() {
            var calcEl = document.getElementById('calc');
            if (!calcModal || !calcModalBody || !calcEl) return;
            if (calcRestoreParent) {
                if (calcRestoreNext) calcRestoreParent.insertBefore(calcEl, calcRestoreNext);
                else calcRestoreParent.appendChild(calcEl);
                calcRestoreParent = null;
                calcRestoreNext = null;
            }
            calcModal.classList.remove('is-open');
            calcModal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        document.addEventListener('click', function (e) {
            if (e.target.closest('.js-calc-modal-open')) {
                e.preventDefault();
                openCalcModal();
            }
            if (calcModal && calcModal.classList.contains('is-open') && (e.target.closest('.js-calc-modal-close') || e.target === calcModal)) {
                e.preventDefault();
                closeCalcModal();
            }
            // Якорь из шапки/футера: если модалка открыта — закрыть, чтобы калькулятор вернулся на страницу и скролл сработал
            var anchor = e.target.closest('a[href="#calc"]');
            if (anchor && !anchor.classList.contains('js-calc-modal-open') && calcModal && calcModal.classList.contains('is-open')) {
                closeCalcModal();
            }
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && calcModal && calcModal.classList.contains('is-open')) closeCalcModal();
        });
    })();
</script>
<script>
    (function () {
        // Калькулятор: обновление шкалы прогресса и подсветка текущего шага
        var calcWrap = document.querySelector('.calc');
        var progressBar = calcWrap && calcWrap.querySelector('.calc__progress');
        var stepLabels = calcWrap && calcWrap.querySelectorAll('.calc__footer .calc__steps .calc__step');
        var contentSteps = calcWrap && calcWrap.querySelectorAll('.calc .calc-step:not(.calc-step_loader)');
        var totalSteps = contentSteps ? contentSteps.length : 8;

        function updateCalcProgress() {
            if (!calcWrap || !contentSteps.length) return;
            var completed = 0;
            for (var i = 0; i < contentSteps.length; i++) {
                if (contentSteps[i].querySelector('[data-next-step]:checked')) completed++;
                else break;
            }
            var current = completed + 1;
            if (current > totalSteps) current = totalSteps;
            var percent = totalSteps > 0 ? (current / totalSteps) * 100 : 0;
            if (progressBar) progressBar.style.width = percent + '%';
            if (stepLabels && stepLabels.length) {
                var activeIndex = Math.min(current - 1, stepLabels.length - 1);
                for (var j = 0; j < stepLabels.length; j++) {
                    stepLabels[j].classList.toggle('calc__step_active', j === activeIndex);
                }
            }
        }

        if (calcWrap) {
            calcWrap.addEventListener('change', function (e) {
                if (e.target.matches('[data-next-step]')) updateCalcProgress();
            });
            calcWrap.addEventListener('input', function (e) {
                if (e.target.matches('[data-next-step]')) updateCalcProgress();
            });
        }
        window.addEventListener('load', updateCalcProgress);
        window.addEventListener('pageshow', updateCalcProgress);
    })();
</script>
<script>
    (function () {
        function initTypesSlider() {
            if (typeof Swiper === 'undefined') return;
            var el = document.getElementById('types-slider');
            if (!el) return;
            if (el.swiper) el.swiper.destroy(true, true);
            new Swiper('#types-slider', {
                loop: true,
                slidesPerView: 'auto',
                spaceBetween: 20,
                grabCursor: true,
                touchRatio: 1,
                simulateTouch: true,
                allowTouchMove: true,
                resistance: false,
                watchSlidesProgress: true,
                navigation: {
                    prevEl: '.types-slider-prev',
                    nextEl: '.types-slider-next'
                },
                breakpoints: {
                    640: {
                        spaceBetween: 20
                    },
                    320: {
                        spaceBetween: 16
                    }
                }
            });
        }

        function initCasesSlider() {
            if (typeof Swiper === 'undefined') return;
            var el = document.querySelector('.cases-slider');
            if (!el) return;
            if (el.swiper) {
                el.swiper.destroy(true, true);
            }
            new Swiper('.cases-slider', {
                loop: true,
                slidesPerView: 'auto',
                spaceBetween: 20,
                grabCursor: true,
                touchRatio: 1,
                allowTouchMove: true,
                resistance: false,
                watchSlidesProgress: true,
                navigation: {
                    prevEl: '.cases-slider-prev',
                    nextEl: '.cases-slider-next'
                },
                breakpoints: {
                    640: {
                        spaceBetween: 20
                    },
                    320: {
                        spaceBetween: 16
                    }
                }
            });
        }
        window.initCasesSlider = initCasesSlider;
        window.initTypesSlider = initTypesSlider;
        window.addEventListener('load', function () {
            initTypesSlider();
            setTimeout(initCasesSlider, 100);
        });
    })();
</script>
<script>
    (function () {
        var container = document.getElementById('beforeAfterSwipe');
        var beforeEl = document.getElementById('beforeAfterBefore');
        var lineEl = document.getElementById('beforeAfterLine');
        if (!container || !beforeEl || !lineEl) return;
        var beforeImg = beforeEl.querySelector('img');

        function setPos(percent) {
            var p = Math.max(5, Math.min(95, percent));
            beforeEl.style.width = p + '%';
            lineEl.style.left = p + '%';
            if (beforeImg) beforeImg.style.width = (100 / p * 100) + '%';
        }

        function onMove(clientX) {
            var rect = container.getBoundingClientRect();
            var p = ((clientX - rect.left) / rect.width) * 100;
            setPos(p);
        }

        function onUp() {
            document.removeEventListener('mousemove', onMouseMove);
            document.removeEventListener('mouseup', onUp);
            document.removeEventListener('touchmove', onTouchMove, {
                passive: false
            });
            document.removeEventListener('touchend', onTouchEnd);
        }

        function onMouseMove(e) {
            e.preventDefault();
            onMove(e.clientX);
        }

        function onTouchMove(e) {
            e.preventDefault();
            if (e.touches.length) onMove(e.touches[0].clientX);
        }

        function onTouchEnd() {
            onUp();
        }
        lineEl.addEventListener('mousedown', function (e) {
            e.preventDefault();
            onMove(e.clientX);
            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onUp);
        });
        lineEl.addEventListener('touchstart', function (e) {
            if (e.touches.length) {
                onMove(e.touches[0].clientX);
                document.addEventListener('touchmove', onTouchMove, {
                    passive: false
                });
                document.addEventListener('touchend', onTouchEnd);
            }
        }, {
            passive: true
        });
        container.addEventListener('click', function (e) {
            if (e.target === lineEl || lineEl.contains(e.target)) return;
            onMove(e.clientX);
        });
        setPos(50);
    })();
</script>

<script>
    (function () {
        var modal = document.getElementById('case-modal');
        var titleEl = modal && modal.querySelector('.case-modal__title');
        var statsEl = modal && modal.querySelector('.case-modal__stats');
        var reviewEl = modal && modal.querySelector('.case-modal__review-text');
        var mainImg = modal && modal.querySelector('.js-case-modal-main');
        var thumbsWrap = modal && modal.querySelector('.js-case-modal-thumbs');
        var btnPrev = modal && modal.querySelector('.js-case-modal-prev');
        var btnNext = modal && modal.querySelector('.js-case-modal-next');
        var galleryImages = [];
        var galleryIndex = 0;

        function setGallerySlide(index) {
            if (galleryImages.length === 0) return;
            galleryIndex = (index + galleryImages.length) % galleryImages.length;
            if (mainImg) {
                mainImg.src = galleryImages[galleryIndex].src;
                mainImg.alt = galleryImages[galleryIndex].alt || '';
            }
            if (thumbsWrap) {
                thumbsWrap.querySelectorAll('.case-modal__thumb').forEach(function (th, i) {
                    th.classList.toggle('is-active', i === galleryIndex);
                });
            }
            if (btnPrev) btnPrev.disabled = galleryImages.length <= 1;
            if (btnNext) btnNext.disabled = galleryImages.length <= 1;
        }

        function openModal(card) {
            if (!modal || !card) return;
            var title = card.getAttribute('data-case-title') || '';
            var obj = card.getAttribute('data-case-object') || '';
            var district = card.getAttribute('data-case-district') || '';
            var area = card.getAttribute('data-case-area') || '';
            var qty = card.getAttribute('data-case-qty') || '';
            var term = card.getAttribute('data-case-term') || '';
            var review = card.getAttribute('data-case-review') || '';
            if (titleEl) titleEl.textContent = title;
            if (statsEl) statsEl.innerHTML = '<div>Объект: <strong>' + obj + '</strong></div><div>Район: <strong>' + district + '</strong></div><div>Кол-во: <strong>' + qty + '</strong></div><div>Площадь: <strong>' + area + '</strong></div><div>Срок: <strong>' + term + '</strong></div>';
            if (reviewEl) reviewEl.textContent = review;

            // Собираем фото из карточки: «До» первым, «После» вторым
            galleryImages = [];
            var imgBefore = card.querySelector('.case__images [data-strapi-field="caseImageBefore"], .case__images .case__img:nth-child(2)');
            var imgAfter = card.querySelector('.case__images [data-strapi-field="caseImageAfter"], .case__images .case__img:first-child');
            if (imgBefore && imgBefore.src) galleryImages.push({
                src: imgBefore.src,
                alt: imgBefore.alt || ''
            });
            if (imgAfter && imgAfter.src) galleryImages.push({
                src: imgAfter.src,
                alt: imgAfter.alt || ''
            });

            // Превью: одна большая фотка и до 3 превью под ней
            if (thumbsWrap) {
                thumbsWrap.innerHTML = '';
                var thumbsCount = Math.min(galleryImages.length, 3);
                for (var i = 0; i < thumbsCount; i++) {
                    var th = document.createElement('button');
                    th.type = 'button';
                    th.className = 'case-modal__thumb' + (i === 0 ? ' is-active' : '');
                    th.setAttribute('aria-label', 'Фото ' + (i + 1));
                    var inner = document.createElement('img');
                    inner.src = galleryImages[i].src;
                    inner.alt = galleryImages[i].alt || '';
                    th.appendChild(inner);
                    th.dataset.index = i;
                    th.addEventListener('click', function () {
                        var idx = parseInt(this.dataset.index, 10);
                        setGallerySlide(idx);
                    });
                    thumbsWrap.appendChild(th);
                }
            }

            galleryIndex = 0;
            setGallerySlide(0);
            modal.querySelector('.case-modal__gallery').style.display = galleryImages.length ? 'block' : 'none';

            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            if (!modal) return;
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        if (btnPrev) btnPrev.addEventListener('click', function () {
            setGallerySlide(galleryIndex - 1);
        });
        if (btnNext) btnNext.addEventListener('click', function () {
            setGallerySlide(galleryIndex + 1);
        });

        document.addEventListener('click', function (e) {
            var btn = e.target.closest('.js-case-open');
            if (btn) {
                var card = btn.closest('.case');
                if (card) {
                    e.preventDefault();
                    openModal(card);
                }
            }
            if (e.target.closest('.js-case-modal-close') || e.target === modal) {
                e.preventDefault();
                closeModal();
            }
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && modal && modal.classList.contains('is-open')) closeModal();
        });
    })();
</script>

<script>
    (function () {
        var privacyModal = document.getElementById('privacy-modal');

        function openPrivacyModal() {
            if (privacyModal) {
                privacyModal.classList.add('is-open');
                privacyModal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            }
        }

        function closePrivacyModal() {
            if (privacyModal) {
                privacyModal.classList.remove('is-open');
                privacyModal.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            }
        }
        document.addEventListener('click', function (e) {
            if (e.target.closest('.js-open-privacy')) {
                e.preventDefault();
                e.stopPropagation();
                openPrivacyModal();
            }
            if (privacyModal && privacyModal.classList.contains('is-open') && (e.target.closest('.js-privacy-modal-close') || e.target === privacyModal)) {
                e.preventDefault();
                closePrivacyModal();
            }
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && privacyModal && privacyModal.classList.contains('is-open')) closePrivacyModal();
        });
    })();
</script>

<script>
    (function () {
        var calcModal = document.getElementById('calc-modal');
        var calcModalBody = calcModal && calcModal.querySelector('.js-calc-modal-body');
        var calcRestoreParent = null;
        var calcRestoreNext = null;

        function openCalcModal() {
            var calcEl = document.getElementById('calc');
            if (!calcModal || !calcModalBody || !calcEl) return;
            calcRestoreParent = calcEl.parentNode;
            calcRestoreNext = calcEl.nextSibling;
            calcModalBody.appendChild(calcEl);
            calcModal.classList.add('is-open');
            calcModal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeCalcModal() {
            var calcEl = document.getElementById('calc');
            if (!calcModal || !calcModalBody || !calcEl) return;
            if (calcRestoreParent) {
                if (calcRestoreNext) calcRestoreParent.insertBefore(calcEl, calcRestoreNext);
                else calcRestoreParent.appendChild(calcEl);
                calcRestoreParent = null;
                calcRestoreNext = null;
            }
            calcModal.classList.remove('is-open');
            calcModal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        document.addEventListener('click', function (e) {
            if (e.target.closest('.js-calc-modal-open')) {
                e.preventDefault();
                openCalcModal();
            }
            if (calcModal && calcModal.classList.contains('is-open') && (e.target.closest('.js-calc-modal-close') || e.target === calcModal)) {
                e.preventDefault();
                closeCalcModal();
            }
            // Якорь из шапки/футера: если модалка открыта — закрыть, чтобы калькулятор вернулся на страницу и скролл сработал
            var anchor = e.target.closest('a[href="#calc"]');
            if (anchor && !anchor.classList.contains('js-calc-modal-open') && calcModal && calcModal.classList.contains('is-open')) {
                closeCalcModal();
            }
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && calcModal && calcModal.classList.contains('is-open')) closeCalcModal();
        });
    })();
</script>

<script>
    (function () {
        // Калькулятор: обновление шкалы прогресса и подсветка текущего шага
        var calcWrap = document.querySelector('.calc');
        var progressBar = calcWrap && calcWrap.querySelector('.calc__progress');
        var stepLabels = calcWrap && calcWrap.querySelectorAll('.calc__footer .calc__steps .calc__step');
        var contentSteps = calcWrap && calcWrap.querySelectorAll('.calc .calc-step:not(.calc-step_loader)');
        var totalSteps = contentSteps ? contentSteps.length : 8;

        function updateCalcProgress() {
            if (!calcWrap || !contentSteps.length) return;
            var completed = 0;
            for (var i = 0; i < contentSteps.length; i++) {
                if (contentSteps[i].querySelector('[data-next-step]:checked')) completed++;
                else break;
            }
            var current = completed + 1;
            if (current > totalSteps) current = totalSteps;
            var percent = totalSteps > 0 ? (current / totalSteps) * 100 : 0;
            if (progressBar) progressBar.style.width = percent + '%';
            if (stepLabels && stepLabels.length) {
                var activeIndex = Math.min(current - 1, stepLabels.length - 1);
                for (var j = 0; j < stepLabels.length; j++) {
                    stepLabels[j].classList.toggle('calc__step_active', j === activeIndex);
                }
            }
        }

        if (calcWrap) {
            calcWrap.addEventListener('change', function (e) {
                if (e.target.matches('[data-next-step]')) updateCalcProgress();
            });
            calcWrap.addEventListener('input', function (e) {
                if (e.target.matches('[data-next-step]')) updateCalcProgress();
            });
        }
        window.addEventListener('load', updateCalcProgress);
        window.addEventListener('pageshow', updateCalcProgress);
    })();
</script>

<script>
    (function () {
        function initTypesSlider() {
            if (typeof Swiper === 'undefined') return;
            var el = document.getElementById('types-slider');
            if (!el) return;
            if (el.swiper) el.swiper.destroy(true, true);
            new Swiper('#types-slider', {
                loop: true,
                slidesPerView: 'auto',
                spaceBetween: 20,
                grabCursor: true,
                touchRatio: 1,
                simulateTouch: true,
                allowTouchMove: true,
                resistance: false,
                watchSlidesProgress: true,
                navigation: {
                    prevEl: '.types-slider-prev',
                    nextEl: '.types-slider-next'
                },
                breakpoints: {
                    640: {
                        spaceBetween: 20
                    },
                    320: {
                        spaceBetween: 16
                    }
                }
            });
        }

        function initCasesSlider() {
            if (typeof Swiper === 'undefined') return;
            var el = document.querySelector('.cases-slider');
            if (!el) return;
            if (el.swiper) {
                el.swiper.destroy(true, true);
            }
            new Swiper('.cases-slider', {
                loop: true,
                slidesPerView: 'auto',
                spaceBetween: 20,
                grabCursor: true,
                touchRatio: 1,
                allowTouchMove: true,
                resistance: false,
                watchSlidesProgress: true,
                navigation: {
                    prevEl: '.cases-slider-prev',
                    nextEl: '.cases-slider-next'
                },
                breakpoints: {
                    640: {
                        spaceBetween: 20
                    },
                    320: {
                        spaceBetween: 16
                    }
                }
            });
        }
        window.initCasesSlider = initCasesSlider;
        window.initTypesSlider = initTypesSlider;
        window.addEventListener('load', function () {
            initTypesSlider();
            setTimeout(initCasesSlider, 100);
        });
    })();
</script>

<script>
    (function () {
        var container = document.getElementById('beforeAfterSwipe');
        var beforeEl = document.getElementById('beforeAfterBefore');
        var lineEl = document.getElementById('beforeAfterLine');
        if (!container || !beforeEl || !lineEl) return;
        var beforeImg = beforeEl.querySelector('img');

        function setPos(percent) {
            var p = Math.max(5, Math.min(95, percent));
            beforeEl.style.width = p + '%';
            lineEl.style.left = p + '%';
            if (beforeImg) beforeImg.style.width = (100 / p * 100) + '%';
        }

        function onMove(clientX) {
            var rect = container.getBoundingClientRect();
            var p = ((clientX - rect.left) / rect.width) * 100;
            setPos(p);
        }

        function onUp() {
            document.removeEventListener('mousemove', onMouseMove);
            document.removeEventListener('mouseup', onUp);
            document.removeEventListener('touchmove', onTouchMove, {
                passive: false
            });
            document.removeEventListener('touchend', onTouchEnd);
        }

        function onMouseMove(e) {
            e.preventDefault();
            onMove(e.clientX);
        }

        function onTouchMove(e) {
            e.preventDefault();
            if (e.touches.length) onMove(e.touches[0].clientX);
        }

        function onTouchEnd() {
            onUp();
        }
        lineEl.addEventListener('mousedown', function (e) {
            e.preventDefault();
            onMove(e.clientX);
            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onUp);
        });
        lineEl.addEventListener('touchstart', function (e) {
            if (e.touches.length) {
                onMove(e.touches[0].clientX);
                document.addEventListener('touchmove', onTouchMove, {
                    passive: false
                });
                document.addEventListener('touchend', onTouchEnd);
            }
        }, {
            passive: true
        });
        container.addEventListener('click', function (e) {
            if (e.target === lineEl || lineEl.contains(e.target)) return;
            onMove(e.clientX);
        });
        setPos(50);
    })();
</script>
<script>
(function () {
    var menu = document.getElementById('menu');
    var menuClose = document.querySelector('.js-menu-close');
    if (menu && menuClose) {
        menuClose.addEventListener('click', function () {
            menu.classList.remove('header__menu_opened');
        });
    }
    if (menu) {
        menu.addEventListener('click', function (e) {
            var link = e.target.closest('.header__link');
            if (link && link.getAttribute('href') && link.getAttribute('href').indexOf('#') === 0) {
                menu.classList.remove('header__menu_opened');
            }
        });
    }
})();
</script>
<?php wp_footer(); ?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (m, e, t, r, i, k, a) {
        m[i] = m[i] || function () { (m[i].a = m[i].a || []).push(arguments) };
        m[i].l = 1 * new Date();
        for (var j = 0; j < document.scripts.length; j++) { if (document.scripts[j].src === r) { return; } }
        k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
    })(window, document, 'script', 'https://mc.yandex.ru/metrika/tag.js?id=106858194', 'ym');

    ym(106858194, 'init', { ssr: true, webvisor: true, clickmap: true, ecommerce: "dataLayer", referrer: document.referrer, url: location.href, accurateTrackBounce: true, trackLinks: true });
</script>
<noscript>
    <div><img src="https://mc.yandex.ru/watch/106858194" style="position:absolute; left:-9999px;" alt="" /></div>
</noscript>
<!-- /Yandex.Metrika counter -->
</body>

</html>