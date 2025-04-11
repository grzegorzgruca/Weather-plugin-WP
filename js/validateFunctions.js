export default function validateCityName(city) {
  if (typeof city !== 'string') return 'Nieprawidłowe dane wejściowe.';

  const obj = {isValid: false, msg: ""};
  const trimmed = city.trim();
  const isValid = /^[A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ\s-]+$/.test(trimmed);

  if (!isValid) {
    obj.isValid = false;
    obj.msg = "Miasto może zawierać tylko litery i spacje."
  }
  else {
    obj.isValid = true;
    obj.msg = trimmed;
  }
  return obj
}
