<!-- RENDERING HTML BODY PLUGIN -->
<?php
//get defeult database places
$default_cities = get_option('my_plugin_city_list', []);
$placeholder = get_option('my_plugin_city_placeholder', 'Np. Warszawa');
?>
<form id="city-form" class="city-form">
  <script type="module">
  import { handleCityWeather } from "<?php echo plugin_dir_url(__FILE__); ?>../js/renderData.js";
  const cities = <?php echo json_encode($default_cities); ?>;
  const placeholder = <?php echo json_encode($placeholder); ?>;
  
  //call render functions for additional places
  async function processCitiesSequentially(cities) {
    const results = [];
    for (const city of cities) {      
      const result = await handleCityWeather(city, true, cities.length);
    }
  }
  processCitiesSequentially(cities)
  
  //change placeholder
  document.getElementById("city-input").placeholder = placeholder;
  </script>
  
  <label for="city-input">Wpisz miasto:</label>
  <input type="text" id="city-input" name="city" required />
  <span id="error-msg" class="error-msg"></span>
  <button type="submit">Sprawdź pogodę</button>
</form>
<div id="weather-result" class="weather-result" style="display: none">
  <p><span class="temperature_result"></span></p>
</div>
<div id="weather-result-additional" class="weather-result" style="display: none;">
    <p style="font-size: 130%;">Default places:</p>
</div>
