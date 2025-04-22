import { validatePassword, validateName, validateEmail, setStatusInput } from './validateForms.js';

const form = document.querySelector('#form');
const name = form.querySelector("input[name='name_user']");
const email = form.querySelector("input[name='email_user']");
const password = form.querySelector("input[name='password_user']");
const spans = [...form.querySelectorAll('.form-text')];
const btnSubmit = form.querySelector("button[type=submit]");
form.addEventListener('submit', (evt) => {
    evt.preventDefault();
    setStatusInput(validateName(name), name, spans[0], true);
    setStatusInput(validateEmail(email), email, spans[1], true);
    setStatusInput(validatePassword(password), password, spans[2], true);
    if (validateName(name) && validateEmail(email) && validatePassword(password))
    {   
        form.submit();
        btnSubmit .disabled = true;
        btnSubmit.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Criando sua conta...";
    }
});
name.addEventListener('input', () => setStatusInput(validateName(name), name, spans[0], true));
email.addEventListener('input', () => setStatusInput(validateEmail(email), email, spans[1], true));
password.addEventListener('input', () =>  setStatusInput(validatePassword(password), password, spans[2], true));