import { validatePassword, validateName, validateEmail, setStatusInput } from  './validateForms';

//Form Edit Name And Email
const formEditNameAndEmail = document.querySelector("#formEditNameAndEmail");
const name = document.querySelector("input[name='name_user']");
const email = document.querySelector("input[name='email_user']");
const spansFormEditNameAndEmail = formEditNameAndEmail.querySelectorAll(".spanFormEditNameAndEmail");
const btnSubmitEdit = formEditNameAndEmail.querySelector('button[type=submit]');
formEditNameAndEmail.addEventListener('submit', (evt) => {
    evt.preventDefault();  
    setStatusInput(validateName(name), name, spansFormEditNameAndEmail[0], true);
    setStatusInput(validateEmail(email), email, spansFormEditNameAndEmail[1], true);
    if (validateName(name) && validateEmail(email))
    {   
        formEditNameAndEmail.submit();
        btnSubmitEdit.disabled = true;
        btnSubmitEdit.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Editando...";
    }
});
name.addEventListener('input', () => setStatusInput(validateName(name), name, spansFormEditNameAndEmail[0], true));
email.addEventListener('input', () => setStatusInput(validateEmail(email), email, spansFormEditNameAndEmail[1], true));

//Form Edit Password
const formEditPassword = document.querySelector("#formEditPassword");
const password = formEditPassword.querySelector("input[name='new_password_user']");
const newPassword = formEditPassword.querySelector("input[name='password_user']");
const spansFormEditPassword = formEditPassword.querySelectorAll(".spanFormEditPassword");
const btnSubmitEditPassword = formEditPassword.querySelector('button[type=submit]');
formEditPassword.addEventListener('submit', (evt) => {
    evt.preventDefault();
    setStatusInput(validatePassword(password), password, spansFormEditPassword[0], true);
    setStatusInput(validatePassword(newPassword), newPassword, spansFormEditPassword[1], true);
    if (validatePassword(password) && validatePassword(newPassword))
    {   
        formEditPassword.submit();
        btnSubmitEditPassword.disabled = true;
        btnSubmitEditPassword.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Editando...";
    }
});
password.addEventListener('input', () => setStatusInput(validatePassword(password), password, spansFormEditPassword[0], true));
newPassword.addEventListener('input', () => setStatusInput(validatePassword(newPassword), newPassword, spansFormEditPassword[1], true));

//Event BTN Delete User
const btnDeleteUser = document.querySelector('#btnDeleteUser');
let intervalo = null;
let segundos = 5;
const atualizarCronometro = () => {
    if (segundos > 0) 
    {
        segundos--;
        btnDeleteUser.innerHTML = `Excluir (${segundos})`;
    }
    if (segundos === 0) 
    {
        clearInterval(intervalo);
        intervalo = null;
        btnDeleteUser.innerHTML = `Excluir`;
        btnDeleteUser.classList.remove('disabled'); 
        btnDeleteUser.addEventListener('click', () => {
            btnDeleteUser.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Excluindo... :(";
        });
    }
}
const iniciar = () => {
    segundos = 5;
    btnDeleteUser.innerHTML = `Excluir (${segundos})`;
    btnDeleteUser.classList.add('disabled');
    if (intervalo === null) 
    {
        intervalo = setInterval(atualizarCronometro, 1000);
    }
}
document.querySelector('#btnModalDeleteUser').addEventListener('click', iniciar);

