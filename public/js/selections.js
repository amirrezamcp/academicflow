document.addEventListener('DOMContentLoaded', function () {

    function bindEvents(row) {
        const select = row.querySelector('.presentation-select');

        select.addEventListener('change', function () {
            const opt = this.selectedOptions[0];

            row.querySelector('.day').value    = opt?.dataset.day || '';
            row.querySelector('.start').value  = opt?.dataset.start || '';
            row.querySelector('.finish').value = opt?.dataset.finish || '';
        });
    }

    document.querySelectorAll('.lesson-row').forEach(bindEvents);

    document.getElementById('add-lesson').addEventListener('click', function () {
        const wrapper = document.getElementById('lessons-wrapper');
        const clone = wrapper.firstElementChild.cloneNode(true);

        clone.querySelector('select').value = '';
        clone.querySelectorAll('input').forEach(i => i.value = '');

        const removeBtn = clone.querySelector('.remove-row');
        removeBtn.classList.remove('hidden');
        removeBtn.addEventListener('click', () => clone.remove());

        bindEvents(clone);

        wrapper.appendChild(clone);
    });

});
