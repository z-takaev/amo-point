(function () {
    'use strict';

    function updateVisibility() {
        const filter = document.querySelector('select[name="type_val"]');

        if (!filter) {
            return;
        }

        const selectedType = filter.value.trim();

        document.querySelectorAll('[name]').forEach((field) => {
            if (field === filter) {
                return;
            }

            const wrapper = field.closest('p');

            if (!wrapper) {
                return;
            }

            wrapper.hidden = selectedType !== '' && !field.name.includes(selectedType);
        });
    }

    function init() {
        const filter = document.querySelector('select[name="type_val"]');

        if (!filter) {
            return;
        }

        updateVisibility();
        filter.addEventListener('change', updateVisibility);
    }

    document.addEventListener('DOMContentLoaded', init, { once: true });
})();
