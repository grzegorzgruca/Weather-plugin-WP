document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('city-form');
  const input = document.getElementById('city-input');
  const errorMsg = document.getElementById('error-msg');

  form.addEventListener('submit', async function (e) {
    e.preventDefault();
    //walidacja
    const city = input.value.trim();
    const isValid = /^[A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ\s-]+$/.test(city);

    if (city === '') {
      errorMsg.textContent = 'Pole nie może być puste.';
      return;
    } else if (!isValid) {
      errorMsg.textContent = 'Miasto może zawierać tylko litery i spacje.';
      return;
    } else {
      errorMsg.textContent = '';
    }
    //api
    try {
      const geoRes = await fetch(`https://geocoding-api.open-meteo.com/v1/search?name=${encodeURIComponent(city)}&count=1&language=pl&format=json`);
      const geoData = await geoRes.json();

      if (!geoData.results || geoData.results.length === 0) {
        console.error("Nie znaleziono miasta:", city);
        changeWeatherData({}, false);
        return;
      }
      //lokacja
      const location = geoData.results[0];
      const { latitude, longitude, name, country } = location;
      console.log(`Miasto: ${name}, ${country} — Współrzędne: ${latitude}, ${longitude}`);

      const weatherRes = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${latitude}&longitude=${longitude}&current=temperature_2m,weathercode&timezone=auto`);
      const weatherData = await weatherRes.json();

      const temp = weatherData.current.temperature_2m;
      const code = weatherData.current.weathercode;
      const data = {temperature: temp}
      changeWeatherData(data, true);
    } catch (error) {
      changeWeatherData({}, false);
    }
  });
});

 const changeWeatherData = (changeWeaterDataTemp, state) => {
  const resultBox = document.getElementById("weather-result");
  el = document.getElementsByClassName("temperature_result")[0]
  state ? el.textContent = `Temperatura: ${changeWeaterDataTemp.temperature}°C` : el.textContent = "Nie znaleziono miasta, spróbuj ponownie."
  resultBox.style.display = "block";
};
