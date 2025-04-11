document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.getElementById('city-list-wrapper');
    const addBtn = document.getElementById('add-city');

    function updateButtons() {
        const removeButtons = wrapper.querySelectorAll('.remove-city');
        removeButtons.forEach(btn => {
            btn.disabled = (wrapper.children.length <= 0);
        });
        addBtn.disabled = (wrapper.children.length >= 4);
    }

    addBtn.addEventListener('click', () => {
        if (wrapper.children.length >= 4) return;
        const div = document.createElement('div');
        div.className = 'city-row';
        div.innerHTML = `<input type="text" name="my_plugin_city_list[]" value="" />
                         <button type="button" class="remove-city">Usuń</button>`;
        wrapper.appendChild(div);
        updateButtons();
    });

    wrapper.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-city')) {
            e.target.parentElement.remove();
            updateButtons();
        }
    });

    updateButtons();
});