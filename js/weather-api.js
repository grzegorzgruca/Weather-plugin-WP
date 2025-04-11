export default async function fetchWeatherForCity(city) {
    try {
      const geoRes = await fetch(`https://geocoding-api.open-meteo.com/v1/search?name=${encodeURIComponent(city)}&count=1&language=pl&format=json`);
      const geoData = await geoRes.json();
  
      if (!geoData.results || geoData.results.length === 0) {
        return null;
      }
  
      const { latitude, longitude } = geoData.results[0];
  
      const weatherRes = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${latitude}&longitude=${longitude}&current=temperature_2m,weathercode&timezone=auto`);
      const weatherData = await weatherRes.json();
  
      return {
        temperature: weatherData.current.temperature_2m
      };
    } catch (error) {
      return null;
    }
  }
  