(function() {
    'use strict';

    const counterId = Number(window.oknaMetrikaConfig && window.oknaMetrikaConfig.counter_id) || 0;
    const attributionStorageKey = 'oknaAttribution';

    function reachGoal(goal) {
        if (!goal || !counterId || typeof window.ym !== 'function') {
            return;
        }

        window.ym(counterId, 'reachGoal', goal);
    }

    function getStoredAttribution() {
        try {
            const raw = window.localStorage.getItem(attributionStorageKey);
            if (!raw) {
                return {};
            }

            const data = JSON.parse(raw);
            return data && typeof data === 'object' ? data : {};
        } catch (error) {
            return {};
        }
    }

    /**
     * ClientID Метрики для сквозной аналитики с Битрикс24 (см. getClientID в справке Метрики).
     * @param {FormData} formData
     * @returns {Promise<void>}
     */
    function withMetrikaClientId(formData) {
        return new Promise(function(resolve) {
            if (!formData || typeof formData.append !== 'function') {
                resolve();
                return;
            }
            if (!counterId || typeof window.ym !== 'function') {
                resolve();
                return;
            }

            var settled = false;
            function done() {
                if (settled) {
                    return;
                }
                settled = true;
                resolve();
            }

            window.setTimeout(done, 2000);

            try {
                window.ym(counterId, 'getClientID', function(clientId) {
                    if (clientId) {
                        formData.append('metrika_client_id', String(clientId));
                    }
                    done();
                });
            } catch (err) {
                done();
            }
        });
    }

    function saveAttribution(data) {
        try {
            window.localStorage.setItem(attributionStorageKey, JSON.stringify(data));
        } catch (error) {
            return;
        }
    }

    function captureAttribution() {
        const params = new URLSearchParams(window.location.search);
        const stored = getStoredAttribution();
        const keys = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term', 'yclid'];
        let hasChanges = false;

        keys.forEach(function(key) {
            const value = params.get(key);
            if (value) {
                stored[key] = value;
                hasChanges = true;
            }
        });

        if (hasChanges) {
            saveAttribution(stored);
        }
    }

    function getTrackableForms() {
        return Array.from(document.querySelectorAll('.measure-photo__form, .cta__form, .window-calc-page'));
    }

    function assignFormGoals() {
        getTrackableForms().forEach(function(formLike, index) {
            formLike.dataset.metrikaFormGoal = 'Form' + (index + 1);
        });
    }

    /** Цель Метрики — только после успешной отправки данных на сервер (вызывается из lead-form / calc-lead-form). */
    function trackFormSuccess(formLike) {
        if (!formLike) {
            return;
        }

        const goal = formLike.dataset.metrikaFormGoal;
        if (goal) {
            reachGoal(goal);
        }
    }

    window.oknaMetrika = {
        reachGoal: reachGoal,
        trackFormSuccess: trackFormSuccess,
        reindexForms: assignFormGoals,
        getAttribution: getStoredAttribution,
        withMetrikaClientId: withMetrikaClientId
    };

    function init() {
        captureAttribution();
        assignFormGoals();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
