<form id="city-form" class="city-form">
  <label for="city-input">Wpisz miasto:</label>
  <input type="text" id="city-input" name="city" placeholder="Np. Warszawa" required />
  <span id="error-msg" class="error-msg"></span>
  <button type="submit">Sprawdź pogodę</button>
</form>

<div id="weather-result" class="weather-result" style="display: none;">
  <p><span class="temperature_result">--</span>°C</p>
</div>
