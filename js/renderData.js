import validateCityName from './validateFunctions.js';
import fetchWeatherForCity from './weather-api.js';


document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('city-form');
  const input = document.getElementById('city-input');
  
  //can add more validates
  form.addEventListener('submit', async function (e) {
    e.preventDefault();
    const resultObj = validateCityName(input.value)
    if (resultObj.isValid === true) {
      const data = await fetchWeatherForCity(resultObj.msg)
      ChangeFrontEnd(data, true)
    }
    else {
      ChangeFrontEnd(null, false)
    }
  });
});

function ChangeFrontEnd(data, isValid) {
  const resultBox = document.getElementById("weather-result");
  const el = document.getElementsByClassName("temperature_result")[0];

  if (isValid && data != null) {
    el.textContent = `Temperatura: ${data.temperature}°C`;
  } else {
    el.textContent = data || "Nie znaleziono miasta, spróbuj ponownie.";
  }
  resultBox.style.display = "block";
}