//Validate Functions
export const setStatusInput = (isValid, input, span, showSuccess) => 
{
  span.classList.toggle('d-none', isValid);
  input.classList.toggle('input-error', !isValid);
  if(showSuccess) input.classList.toggle('input-success', isValid);
  return isValid;
}

export const validateEmail = (email) => 
{
  const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  return emailRegex.test(email.value.trim());
}

export const validateName = (name) => 
{
  const nameRegex = /^[a-zA-ZÀ-ÿ\s]+$/;
  return nameRegex.test(name.value.trim()) && name.value.trim().length >= 4;
}

export const validatePassword = (password) => 
{
  return password.value.trim().length >= 7
}

export const validate = (input) => { return input.value.trim(); }

export const validateNumber = (input) => {
  let inputValue = input.value.trim();
  if (inputValue === "") 
  {
    return false;
  }

  inputValue = inputValue.replace(/\./g, '').replace(',', '.');

  const n = Number(inputValue);
  if (isNaN(n) || n <= 0) 
  {
    return false;
  }

  return true;
}

