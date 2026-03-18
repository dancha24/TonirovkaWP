/**
 * Скрипт отправки заявок из калькулятора
 */
(function () {
  "use strict";

  // Маска для телефона
  function initPhoneMask(input) {
    input.addEventListener("input", function (e) {
      let value = e.target.value.replace(/\D/g, "");

      if (value.length === 0) {
        e.target.value = "";
        return;
      }

      if (value.length > 11) {
        value = value.slice(0, 11);
      }

      let formattedValue = "+" + value;

      if (value.length > 1) {
        formattedValue = "+7 (" + value.slice(1, 4);
        if (value.length > 4) {
          formattedValue += ") " + value.slice(4, 7);
        }
        if (value.length > 7) {
          formattedValue += "-" + value.slice(7, 9);
        }
        if (value.length > 9) {
          formattedValue += "-" + value.slice(9, 11);
        }
      }

      e.target.value = formattedValue;
    });
  }

  // Показ сообщения
  function showMessage(container, message, type) {
    hideMessage(container);

    const msgDiv = document.createElement("div");
    msgDiv.className = "form-message form-message--" + type;
    msgDiv.textContent = message;
    msgDiv.style.cssText =
      "padding: 12px 16px; border-radius: 8px; margin-top: 16px; font-size: 14px; line-height: 1.5; animation: formMessageSlideIn 0.3s ease;";

    if (type === "success") {
      msgDiv.style.backgroundColor = "#d4edda";
      msgDiv.style.color = "#155724";
      msgDiv.style.border = "1px solid #c3e6cb";
    } else {
      msgDiv.style.backgroundColor = "#f8d7da";
      msgDiv.style.color = "#721c24";
      msgDiv.style.border = "1px solid #f5c6cb";
    }

    container.appendChild(msgDiv);

    setTimeout(() => {
      msgDiv.remove();
    }, 5000);
  }

  // Скрытие сообщений
  function hideMessage(container) {
    const existingMessage = container.querySelector(".form-message");
    if (existingMessage) {
      existingMessage.remove();
    }
  }

  // Получение выбранных услуг
  function appendAttribution(formData) {
    if (
      !window.oknaMetrika ||
      typeof window.oknaMetrika.getAttribution !== "function"
    ) {
      return;
    }

    const attribution = window.oknaMetrika.getAttribution();
    [
      "utm_source",
      "utm_medium",
      "utm_campaign",
      "utm_content",
      "utm_term",
      "yclid",
    ].forEach(function (key) {
      if (attribution[key]) {
        formData.append(key, attribution[key]);
      }
    });
  }

  // Инициализация
  function init() {
    const calcContainer = document.querySelector(".window-calc-page");

    if (!calcContainer) {
      return;
    }

    // Находим кнопку отправки
    const submitBtn = calcContainer.querySelector(".wcp-btn--primary");
    const phoneInput = calcContainer.querySelector(
      '.wcp-phone-wrap input[type="tel"]',
    );

    if (!submitBtn || !phoneInput) {
      return;
    }

    // Инициализация маски телефона
    initPhoneMask(phoneInput);

    // Добавляем чекбокс согласия
    const phoneWrap = calcContainer.querySelector(".wcp-phone-wrap");
    if (phoneWrap && !phoneWrap.querySelector(".wcp-privacy")) {
      const privacyHtml = document.createElement("div");
      privacyHtml.className = "wcp-privacy";
      privacyHtml.style.cssText =
        "margin-top: 12px; font-size: 12px; color: #666;";
      privacyHtml.innerHTML = `
                <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
                    <input checked type="checkbox" name="privacy" required style="margin-top: 2px; flex-shrink: 0;">
                    <span>Соглашаюсь с <a href="#" class="js-open-privacy" style="color: #0096D9; text-decoration: underline;">Политикой конфиденциальности</a></span>
                </label>
            `;
      phoneWrap.appendChild(privacyHtml);

      const privacyCheckboxEl = privacyHtml.querySelector(
        'input[name="privacy"]',
      );
      privacyCheckboxEl.addEventListener("change", function () {
        if (this.checked) {
          privacyHtml.style.outline = "";
          privacyHtml.style.borderRadius = "";
          privacyHtml.style.backgroundColor = "";
        }
      });
    }

    // Отправка формы
    submitBtn.addEventListener("click", function (e) {
      e.preventDefault();

      const privacyCheckbox = calcContainer.querySelector(
        'input[name="privacy"]',
      );

      // Валидация
      const phoneValue = phoneInput.value.replace(/\D/g, "");
      if (phoneValue.length < 11) {
        showMessage(
          calcContainer,
          "Заполните корректный номер телефона",
          "error",
        );
        phoneInput.focus();
        return;
      }

      if (!privacyCheckbox || !privacyCheckbox.checked) {
        showMessage(
          calcContainer,
          "Необходимо согласие с политикой конфиденциальности",
          "error",
        );

        const privacyWrap = calcContainer.querySelector(".wcp-privacy");
        if (privacyWrap) {
          privacyWrap.style.outline = "2px solid #e74c3c";
          privacyWrap.style.borderRadius = "4px";
          privacyWrap.style.backgroundColor = "#fff5f5";
          privacyWrap.scrollIntoView({ behavior: "smooth", block: "center" });
        }
        return;
      }

      // Сбор данных из калькулятора
      const widthInput = calcContainer.querySelector("#width");
      const heightInput = calcContainer.querySelector("#height");
      const qtyVal = calcContainer.querySelector("#qtyVal");

      // Получаем выбранную категорию
      const activeCategory = calcContainer.querySelector(
        ".wcp-category--active, .wcp-option--selected",
      );
      const category = activeCategory ? activeCategory.textContent.trim() : "";

      // Получаем выбранный объект
      const selectedObject = calcContainer.querySelector(
        "#objectOptions .wcp-option--selected",
      );
      const objectName = selectedObject
        ? selectedObject.querySelector(".wcp-option__name")?.textContent.trim()
        : "";

      // Получаем выбранную плёнку
      const selectedFilm = calcContainer.querySelector(
        "#filmOptions .wcp-option--selected",
      );
      const filmName = selectedFilm
        ? selectedFilm.querySelector(".wcp-option__name")?.textContent.trim()
        : "";

      // Получаем услуги

      // Получаем цены
      const totalPriceEl = calcContainer.querySelector("#totalPrice");
      const totalPrice = totalPriceEl
        ? parseInt(totalPriceEl.textContent.replace(/\D/g, ""))
        : 0;

      // Блокируем кнопку
      const originalText = submitBtn.textContent;
      submitBtn.disabled = true;
      submitBtn.textContent = "Отправка...";

      const formData = new FormData();
      formData.append("action", "okna_submit_calc_lead");
      formData.append("nonce", oknaLead.nonce);
      formData.append("source", "Калькулятор");
      formData.append("phone", phoneInput.value);
      formData.append("privacy", privacyCheckbox && privacyCheckbox.checked ? 1 : 0);
      formData.append("width", widthInput ? widthInput.value : 0);
      formData.append("height", heightInput ? heightInput.value : 0);
      formData.append("quantity", qtyVal ? qtyVal.textContent : 1);
      formData.append("category", category);
      formData.append("object", objectName);
      formData.append("film", filmName);
      formData.append("total_price", totalPrice);
      appendAttribution(formData);

      fetch(oknaLead.ajax_url, {
        method: "POST",
        body: formData,
        credentials: "same-origin",
      })
        .then((response) => {
          // Проверяем, JSON ли приходит в ответе
          const contentType = response.headers.get("content-type");
          if (contentType && contentType.includes("application/json")) {
            return response.json();
          } else {
            return response.text().then((text) => {
              throw new Error(
                "Сервер вернул ошибку: " + text.substring(0, 200),
              );
            });
          }
        })
        .then((data) => {
          if (data.success) {
            if (
              window.oknaMetrika &&
              typeof window.oknaMetrika.trackFormSuccess === "function"
            ) {
              window.oknaMetrika.trackFormSuccess(calcContainer);
            }
            showMessage(calcContainer, oknaLead.success_message, "success");
            setTimeout(() => {
              hideMessage(calcContainer);
            }, 3000);
          } else {
            showMessage(
              calcContainer,
              data.message || oknaLead.error_message,
              "error",
            );
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          showMessage(calcContainer, "Ошибка: " + error.message, "error");
        })
        .finally(() => {
          submitBtn.disabled = false;
          submitBtn.textContent = originalText;
        });
    });

    // Открытие политики
    const privacyLink = calcContainer.querySelector(".js-open-privacy");
    if (privacyLink) {
      privacyLink.addEventListener("click", function (e) {
        e.preventDefault();
        alert("Политика конфиденциальности (здесь должно быть модальное окно)");
      });
    }
  }

  // Запуск после загрузки DOM
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
