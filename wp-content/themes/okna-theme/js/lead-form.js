/**
 * Скрипт отправки заявок CTA формы
 */
(function() {
    'use strict';

    // Маска для телефона
    function initPhoneMask(input) {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length === 0) {
                e.target.value = '';
                return;
            }
            
            if (value.length > 11) {
                value = value.slice(0, 11);
            }
            
            let formattedValue = '+' + value;
            
            if (value.length > 1) {
                formattedValue = '+7 (' + value.slice(1, 4);
                if (value.length > 4) {
                    formattedValue += ') ' + value.slice(4, 7);
                }
                if (value.length > 7) {
                    formattedValue += '-' + value.slice(7, 9);
                }
                if (value.length > 9) {
                    formattedValue += '-' + value.slice(9, 11);
                }
            }
            
            e.target.value = formattedValue;
        });
    }

    // Валидация формы
    function validateForm(form) {
        const name = form.querySelector('input[name="name"]');
        const phone = form.querySelector('input[name="phone"]');
        const privacy = form.querySelector('input[name="privacy"]');
        
        let isValid = true;
        let errorMessage = '';
        
        if (!name || !name.value.trim()) {
            if (name) name.classList.add('error');
            isValid = false;
            errorMessage = oknaLead.fill_required_message;
        } else if (name) {
            name.classList.remove('error');
        }
        
        const phoneValue = phone ? phone.value.replace(/\D/g, '') : '';
        if (!phone || phoneValue.length < 11) {
            if (phone) phone.classList.add('error');
            isValid = false;
            errorMessage = oknaLead.fill_required_message;
        } else if (phone) {
            phone.classList.remove('error');
        }
        
        if (!privacy || !privacy.checked) {
            if (privacy) privacy.closest('.checkbox').classList.add('error');
            isValid = false;
            errorMessage = 'Необходимо согласие с политикой конфиденциальности';
        } else if (privacy) {
            privacy.closest('.checkbox').classList.remove('error');
        }
        
        return { isValid: isValid, message: errorMessage };
    }

    function appendAttribution(formData) {
        if (!window.oknaMetrika || typeof window.oknaMetrika.getAttribution !== 'function') {
            return;
        }

        const attribution = window.oknaMetrika.getAttribution();
        ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term', 'yclid'].forEach(function(key) {
            if (attribution[key]) {
                formData.append(key, attribution[key]);
            }
        });
    }

    function getFormSource(form) {
        if (form.dataset.source) {
            return form.dataset.source;
        }
        if (form.classList.contains('measure-photo__form')) {
            return 'Расчет по фото';
        }

        return 'CTA форма';
    }

    // Отправка формы
    function submitForm(form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        
        submitBtn.disabled = true;
        submitBtn.textContent = 'Отправка...';
        
        const formData = new FormData(form);
        formData.append('action', 'okna_submit_lead');
        formData.append('nonce', oknaLead.nonce);
        formData.append('source', getFormSource(form));
        appendAttribution(formData);
        
        fetch(oknaLead.ajax_url, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (window.oknaMetrika && typeof window.oknaMetrika.trackFormSuccess === 'function') {
                    window.oknaMetrika.trackFormSuccess(form);
                }
                showSuccess(form, oknaLead.success_message);
                form.reset();
                if (form.closest('#consult-modal') && typeof window.closeConsultModal === 'function') {
                    setTimeout(window.closeConsultModal, 2000);
                }
            } else {
                showError(form, data.message || oknaLead.error_message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError(form, oknaLead.error_message);
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        });
    }

    // Показ сообщения об успехе
    function showSuccess(form, message) {
        hideMessage(form);
        
        const successDiv = document.createElement('div');
        successDiv.className = 'form-message form-message--success';
        successDiv.textContent = message;
        
        form.appendChild(successDiv);
        
        setTimeout(() => {
            successDiv.remove();
        }, 5000);
    }

    // Показ сообщения об ошибке
    function showError(form, message) {
        hideMessage(form);
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'form-message form-message--error';
        errorDiv.textContent = message;
        
        form.appendChild(errorDiv);
        
        setTimeout(() => {
            errorDiv.remove();
        }, 5000);
    }

    // Скрытие сообщений
    function hideMessage(form) {
        const existingMessage = form.querySelector('.form-message');
        if (existingMessage) {
            existingMessage.remove();
        }
    }

    // Инициализация
    function init() {
        const forms = document.querySelectorAll('.cta__form, .measure-photo__form');
        if (!forms.length) return;

        forms.forEach((form) => {
            const nameInput = form.querySelector('input[type="text"]');
            if (nameInput) nameInput.name = 'name';

            const phoneInput = form.querySelector('input[type="tel"]');
            if (phoneInput) {
                phoneInput.name = 'phone';
                initPhoneMask(phoneInput);
            }

            const commentTextarea = form.querySelector('textarea');
            if (commentTextarea) commentTextarea.name = 'comment';

            const checkboxes = form.querySelectorAll('.checkbox__input');
            checkboxes.forEach((cb) => {
                if (cb.name === 'privacy') return;

                const checkboxText = cb.closest('.checkbox')?.querySelector('.checkbox__text')?.textContent;
                if (checkboxText && checkboxText.includes('Нужен замер')) {
                    cb.name = 'need_measure';
                } else if (checkboxText && checkboxText.includes('Telegram')) {
                    cb.name = 'telegram_pref';
                }
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const validation = validateForm(form);

                if (!validation.isValid) {
                    showError(form, validation.message);
                    return;
                }

                submitForm(form);
            });

            form.querySelectorAll('input, textarea').forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('error');
                    const checkbox = this.closest('.checkbox');
                    if (checkbox) checkbox.classList.remove('error');
                });
            });

            const privacyLink = form.querySelector('.js-open-privacy');
            if (privacyLink) {
                privacyLink.addEventListener('click', function(e) {
                    e.preventDefault();
                });
            }
        });
    }

    // Запуск после загрузки DOM
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
