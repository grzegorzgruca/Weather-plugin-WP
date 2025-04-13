<?php
require_once plugin_dir_path(__FILE__) . '../settingsRenderer.php';
function my_plugin_city_list_render() {
    $cities = get_option('my_plugin_city_list', []);
    if (!is_array($cities)) {
        $cities = [];
    }
    ?>

    <div id="city-list-wrapper">
        <?php foreach ($cities as $index => $city): ?>
            <div class="city-row">
                <input type="text" name="my_plugin_city_list[]" value="<?php echo esc_attr($city); ?>" />
                <button type="button" class="remove-city">Usuń</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" id="add-city">Add new place</button>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.getElementById('city-list-wrapper');
    const addBtn = document.getElementById('add-city');
    
    // menaging second section form buttons
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
    </script>
    <?php
}