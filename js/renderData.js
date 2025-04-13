import validateCityName from "./validateFunctions.js";
import fetchWeatherForCity from "./weather-api.js";

document.addEventListener("DOMContentLoaded", function () {
  //submit functions
  const form = document.getElementById("city-form");
  const input = document.getElementById("city-input");

  if (form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      handleCityWeather(input.value, false, 0);
    });
  }
});

export async function handleCityWeather(cityValue, isAdditional, length) {
  //validate input
  const validate = validateCityName(cityValue);

  //if validate correct
  if (validate.errMsg === null) {
    const data = await fetchWeatherForCity(validate.cityName);
    ChangeFrontEnd(data, validate, isAdditional, length);
  }
  else
  {
  //if validate error
    const data = await fetchWeatherForCity(validate.cityName);
    ChangeFrontEnd(data, validate, isAdditional, length);
  }
}

function ChangeFrontEnd(data, validate, isAdditional, length) {

  
  const resultBox = document.getElementById("weather-result");
  const resultAdditionalBox = document.getElementById(
    "weather-result-additional"
  );
  const el = document.getElementsByClassName("temperature_result")[0];


  //didn't get XYZ
  if(validate.errMsg)
  {                                                       //jesli to additionl top niech pokaze error
    //if additional
    if(isAdditional)
    {
      appendAdditionalTemperatureToContainer(data, validate);
    }
    else
    {
      appendMainWeatherResult(data, validate)
    }
  }
  //got XYZ
  else
  {
    //if additional
    if(isAdditional)
    {
      appendAdditionalTemperatureToContainer(data, validate);
    }
    else
    {
      appendMainWeatherResult(data, validate)
    }
  }
  if (resultAdditionalBox.children.length === length && isAdditional) {
    resultAdditionalBox.style.display = "block";
  }
}

function appendAdditionalTemperatureToContainer(data, validate) {
  const container = document.getElementById("weather-result-additional");
  const p = document.createElement("p");
  const span = document.createElement("span");
  span.className = "temperature_result_additional";
   if(validate.errMsg)
  {
    span.textContent = `Błąd: ${validate.errMsg}`
  }
  else if (data.errMsg)
  {
    span.textContent = `Błąd: ${data.errMsg}`
  }
  else
  {
  span.textContent = `Temperatura w ${data.CityName} wynosi: ${data.temperature}°C`;
  }
  p.appendChild(span);
  container.appendChild(p);
}
function appendMainWeatherResult(data, validate) {
  console.log(data);
  const container = document.getElementById("weather-result");
  const span = container.querySelector(".temperature_result");
  if (!span) return
  if(validate.errMsg)
  {
    span.textContent = `Błąd: ${validate.errMsg}`
  }
  else if (data.errMsg)
  {
    span.textContent = `Błąd: ${data.errMsg}`
  }
  else
  {
    span.textContent = `Temperatura w ${data.CityName} wynosi: ${data.temperature}°C`;
  }
  container.style.display = "block";
}
