import { setStatusInput, validate, validateNumber } from './validateForms.js';
import { windowOnScroll, searchItems } from './globalFunctions.js';

//Form Modal Add Purchase
const formAddPurchase = document.querySelector('#formAddPurchase');
const name = formAddPurchase.querySelector('input[name="name_purchase"]');
const maxSpend = formAddPurchase.querySelector('input[name="max_spend_purchase"]');
const spanFormAddPurchase = [...formAddPurchase.querySelectorAll('.spanFormAddPurchase')];
const btnSubmit = formAddPurchase.querySelector('button[type=submit]');
document.querySelector('#btnClose').addEventListener('click', () => {
    const inputs = [name, maxSpend];
    for(let i=0; i<inputs.length; i++){
        inputs[i].value = '';
        inputs[i].classList.remove('input-error');
        spanFormAddPurchase[i].classList.add('d-none');
    }
});
formAddPurchase.addEventListener('submit', (evt) => {
    evt.preventDefault();
    setStatusInput(validate(name), name, spanFormAddPurchase[0]);
    setStatusInput(validateNumber(maxSpend), maxSpend, spanFormAddPurchase[1]);
    name.addEventListener('input', () => setStatusInput(validate(name), name, spanFormAddPurchase[0]));
    maxSpend.addEventListener('input', () => setStatusInput(validateNumber(maxSpend), maxSpend, spanFormAddPurchase[1]));
    if (validate(name) && validateNumber(maxSpend)) 
    { 
        formAddPurchase.submit();
        btnSubmit.disabled = true;
        // btnSubmit.innerHTML = "Criando...";
        btnSubmit.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Criando...";
    }
});

//Form Modal Edit Purchase
const formEditPurchase = document.querySelector('#formEditPurchase');
const nameEdit = formEditPurchase.querySelector('input[name="name_purchase"]');
const maxSpendEdit = formEditPurchase.querySelector('input[name="max_spend_purchase"]');
const spanFormEditPurchase = [...formEditPurchase.querySelectorAll('.spanFormEditPurchase')];
const btnEditSubmit = formEditPurchase.querySelector('button[type=submit]');
formEditPurchase.addEventListener('submit', (evt) => {
    evt.preventDefault();
    setStatusInput(validate(nameEdit), nameEdit, spanFormEditPurchase[0]);
    setStatusInput(validateNumber(maxSpendEdit), maxSpendEdit, spanFormEditPurchase[1]);
    nameEdit.addEventListener('input', () => setStatusInput(validate(nameEdit), nameEdit, spanFormEditPurchase[0]));
    maxSpendEdit.addEventListener('input', () => setStatusInput(validateNumber(maxSpendEdit), maxSpendEdit, spanFormEditPurchase[1]));
    if (validate(nameEdit) && validateNumber(maxSpendEdit)) 
    { 
        formEditPurchase.submit();
        btnEditSubmit.disabled = true;
        // btnEditSubmit.innerHTML = "Salvando...";
        btnEditSubmit.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Salvando...";
    }
});

//Btn Edit Item Card
const btnModalEditPurchase = [...document.querySelectorAll('.btnModalEditPurchase')];
if(btnModalEditPurchase)
{
    btnModalEditPurchase.forEach(btn => {
        btn.addEventListener('click', (evt) => {
            const idFull = evt.target.id;
            const card = document.querySelector(`#${idFull}`);
            const inputs = [nameEdit, maxSpendEdit];
            const ids = ['#purchaseName', '#purchaseMaxSpend'];
            for(let i=0;i<inputs.length; i++){
                inputs[i].classList.remove('input-error');
                inputs[i].value = card.querySelector(ids[i]).innerHTML;
                spanFormEditPurchase[i].classList.add('d-none');
            }
            formEditPurchase.querySelector('#purchaseIdEdit').value = idFull.split("_")[1];
        });
    });
}

//Form Modal Delete Purchase
const formDeletePurchase = document.querySelector('#formDeletePurchase');
const btnDeleteSubmit = formDeletePurchase.querySelector('button[type=submit]');
formDeletePurchase.addEventListener('submit', () => {
    btnDeleteSubmit.disabled = true;
    // btnDeleteSubmit.innerHTML = "Excluindo...";
    btnDeleteSubmit.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Excluindo...";
});

//Btn Delete Item Card
const btnModalDeletePurchase = [...document.querySelectorAll('.btnModalDeletePurchase')];
if(btnModalDeletePurchase)
{
    btnModalDeletePurchase.forEach(btn => {
        btn.addEventListener('click', (evt) => {
            const idFull = evt.target.id;
            formDeletePurchase.querySelector('#purchaseIdDelete').value = idFull.split("_")[1];
        });
    });
}

//Search Items
const searchInput = document.querySelector('#searchInput');
searchInput.addEventListener('input', () => searchItems(searchInput.value.toLowerCase(), '.card', '.card-title')); 

//Btn Scroll Top and Sticky DivSeach
windowOnScroll(document.querySelector("#divSearch"), document.querySelector("#btnTop"));