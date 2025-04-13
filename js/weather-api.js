export default async function fetchWeatherForCity(city) {
    try {
      //download geo XYZ
      const geoRes = await fetch(`https://geocoding-api.open-meteo.com/v1/search?name=${encodeURIComponent(city)}&count=1&language=pl&format=json`);
      const geoData = await geoRes.json();
      
      //if failded
      if (!geoData.results || geoData.results.length === 0) {
      return {
        errMsg: "Nie znaleziono podanego miejsca, spróbuj inne.",
        temperature: null,
        CityName: city
      };
      }
      //download weather data for XYZ
      const { latitude, longitude } = geoData.results[0];
      const weatherRes = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${latitude}&longitude=${longitude}&current=temperature_2m,weathercode&timezone=auto`);
      const weatherData = await weatherRes.json();
  
      return {
        errMsg: null,
        temperature: weatherData.current.temperature_2m,
        CityName: city
      };
    } catch (error) {
      return {
        errMsg: "Wystąpił błąd Api, spróbuj ponownie później.",
        temperature: null,
        CityName: city
      };
    }
  }
  