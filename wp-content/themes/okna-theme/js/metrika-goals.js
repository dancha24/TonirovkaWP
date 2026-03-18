(function() {
    'use strict';

    const counterId = Number(window.oknaMetrikaConfig && window.oknaMetrikaConfig.counter_id) || 0;
    const firedGoals = new Set();
    const attributionStorageKey = 'oknaAttribution';
    const scrollGoals = [
        { percent: 25, goal: 'scr25' },
        { percent: 50, goal: 'scr50' },
        { percent: 75, goal: 'scr75' },
        { percent: 100, goal: 'scr100' }
    ];

    function reachGoal(goal) {
        if (!goal || !counterId || typeof window.ym !== 'function') {
            return;
        }

        window.ym(counterId, 'reachGoal', goal);
    }

    function reachGoalOnce(goal) {
        if (firedGoals.has(goal)) {
            return;
        }

        firedGoals.add(goal);
        reachGoal(goal);
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

    function trackFormSuccess(formLike) {
        if (!formLike) {
            return;
        }

        const goal = formLike.dataset.metrikaFormGoal;
        if (goal) {
            reachGoal(goal);
        }
    }

    function bindNativeForms() {
        document.addEventListener('submit', function(event) {
            const form = event.target;

            if (!(form instanceof HTMLFormElement)) {
                return;
            }

            if (!form.matches('.measure-photo__form')) {
                return;
            }

            if (typeof form.checkValidity === 'function' && !form.checkValidity()) {
                return;
            }

            trackFormSuccess(form);
        });
    }

    function bindPhoneClicks() {
        document.addEventListener('click', function(event) {
            const phoneLink = event.target.closest('a[href^="tel:"]');
            if (!phoneLink) {
                return;
            }

            reachGoal('clickphone');
        });
    }

    function bindTimeGoals() {
        window.setTimeout(function() { reachGoalOnce('30sec'); }, 30000);
        window.setTimeout(function() { reachGoalOnce('60sec'); }, 60000);
        window.setTimeout(function() { reachGoalOnce('120sec'); }, 120000);
    }

    function bindScrollGoals() {
        function handleScroll() {
            const doc = document.documentElement;
            const scrollTop = window.pageYOffset || doc.scrollTop || 0;
            const viewportHeight = window.innerHeight || doc.clientHeight || 0;
            const maxScroll = Math.max(doc.scrollHeight - viewportHeight, 0);
            const scrollPercent = maxScroll > 0
                ? ((scrollTop + viewportHeight) / doc.scrollHeight) * 100
                : 100;

            scrollGoals.forEach(function(item) {
                if (scrollPercent >= item.percent) {
                    reachGoalOnce(item.goal);
                }
            });
        }

        window.addEventListener('scroll', handleScroll, { passive: true });
        window.addEventListener('resize', handleScroll);
        handleScroll();
    }

    window.oknaMetrika = {
        reachGoal: reachGoal,
        trackFormSuccess: trackFormSuccess,
        reindexForms: assignFormGoals,
        getAttribution: getStoredAttribution
    };

    function init() {
        captureAttribution();
        assignFormGoals();
        bindNativeForms();
        bindPhoneClicks();
        bindTimeGoals();
        bindScrollGoals();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
