import { validatePassword, validateEmail, setStatusInput } from './validateForms.js';

const form = document.querySelector('#form');        
const email = form.querySelector("input[name='email_user']");
const password = form.querySelector("input[name='password_user']");
const spans = [...form.querySelectorAll('.form-text')];
const btnSubmit = form.querySelector('button[type=submit]');
form.addEventListener('submit', (evt) => {
    evt.preventDefault();
    setStatusInput(validateEmail(email), email, spans[0]);
    setStatusInput(validatePassword(password), password, spans[1]);   
    email.addEventListener('input', () => setStatusInput(validateEmail(email), email, spans[0]));
    password.addEventListener('input', () => setStatusInput(validatePassword(password), password, spans[1]));
    if (validateEmail(email) && validatePassword(password))
    {   
        form.submit();
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Entrando com sua conta...";
    }
});
