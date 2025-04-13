export default function validateCityName(city) {
  if (typeof city !== "string") return "Unexpected input format";
  function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1)
  }
  const validate = { errMsg: "Wystąpił nieoczewkiwany błąd, spróbuj ponownie później." };
  const trimmed = city.trim();
  const isValid = /^[A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ\s-]+$/.test(trimmed);
  //can add more validates
  if (!isValid) {
    validate.errMsg = "Miasto może zawierać tylko litery i spacje.";
  } else {
    validate.errMsg = null
    validate.cityName = capitalizeFirstLetter(trimmed);
    console.log(validate);
    
  }
  return validate
}
