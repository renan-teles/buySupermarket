import { setStatusInput, validate, validateNumber } from './validateForms.js';
import { windowOnScroll, searchItems, setInputs } from './globalFunctions.js';

//Form Modal Add Item
const formAddItem = document.querySelector('#formAddItem');
const name = formAddItem.querySelector('input[name="name_item"]');
const quantity = formAddItem.querySelector('input[name="quantity_item"]');
const price = formAddItem.querySelector('input[name="price_item"]');
const spanFormAddItem = [...formAddItem.querySelectorAll('.spanFormAddItem')];
const radios = [...formAddItem.querySelectorAll('input[type=radio]')];
const labelPrice = formAddItem.querySelector('#label-price');
const labelQuantity = formAddItem.querySelector('#label-quantity');
const spanItemQuantityInfo = formAddItem.querySelector('#spanItemQuantityInfo');
const spanItemQuantityAlert = formAddItem.querySelector('#spanItemQuantityAlert');
const btnSubmit = formAddItem.querySelector('button[type=submit]');
radios.forEach(radio => {
    radio.addEventListener('click', () => {
        if (radio.checked) 
        {
            setInputs(radio, labelPrice, labelQuantity, quantity, price, spanItemQuantityInfo, spanItemQuantityAlert);
        }
    });
});
document.querySelector('#btnClose').addEventListener('click', () => {
    const inputs = [name, quantity, price];
    for(let i=0; i<inputs.length; i++){
        inputs[i].value = '';
        inputs[i].classList.remove('input-error');
        spanFormAddItem[i].classList.add('d-none');
    }
});
formAddItem.addEventListener('submit', (evt) => {
    evt.preventDefault();
    setStatusInput(validate(name), name, spanFormAddItem[0]);
    setStatusInput(validateNumber(quantity), quantity, spanFormAddItem[1]);
    setStatusInput(validateNumber(price), price, spanFormAddItem[2]);
    name.addEventListener('input', () => setStatusInput(validate(name), name, spanFormAddItem[0]));
    quantity.addEventListener('input', () => setStatusInput(validateNumber(quantity), quantity, spanFormAddItem[1]));
    price.addEventListener('input', () => setStatusInput(validateNumber(price), price, spanFormAddItem[2]));  
    if (validate(name) && validateNumber(quantity) && validateNumber(price)) 
    { 
        formAddItem.submit();
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = "Adicionando...";
        btnSubmit.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Adicionando...";    
    }
});

//Form Modal Edit Item
const formEditItem = document.querySelector('#formEditItem');
const nameEdit = formEditItem.querySelector('input[name="name_item"]');
const quantityEdit = formEditItem.querySelector('input[name="quantity_item"]');
const priceEdit = formEditItem.querySelector('input[name="price_item"]');
const spanFormEditItem = [...formEditItem.querySelectorAll('.spanFormEditItem')];
const radiosEdit = [...formEditItem.querySelectorAll('input[type=radio]')];
const labelPriceEdit = formEditItem.querySelector('#label-edit-price');
const labelQuantityEdit = formEditItem.querySelector('#label-edit-quantity');
const spanItemQuantityInfoEdit = formEditItem.querySelector('#spanItemEditQuantityInfo');
const spanItemQuantityAlertEdit = formEditItem.querySelector('#spanItemEditQuantityAlert');
const btnEditSubmit = formEditItem.querySelector('button[type=submit]');
radiosEdit.forEach(radio => {
    radio.addEventListener('click', () => {
        if (radio.checked) 
        {
            setInputs(radio, labelPriceEdit, labelQuantityEdit, quantityEdit, priceEdit, spanItemQuantityInfoEdit, spanItemQuantityAlertEdit);
        }
    });
});   
formEditItem.addEventListener('submit', (evt) => {
    evt.preventDefault();       
    setStatusInput(validate(nameEdit), nameEdit, spanFormEditItem[0]);
    setStatusInput(validate(quantityEdit), quantityEdit, spanFormEditItem[1]);
    setStatusInput(validate(priceEdit), priceEdit, spanFormEditItem[2]);    
    nameEdit.addEventListener('input', () => setStatusInput(validate(nameEdit), nameEdit, spanFormEditItem[0]));
    quantityEdit.addEventListener('input', () => setStatusInput(validate(quantityEdit), quantityEdit, spanFormEditItem[1]));
    priceEdit.addEventListener('input', () => setStatusInput(validate(priceEdit), priceEdit, spanFormEditItem[2]));
    if (validate(nameEdit) && validate(quantityEdit) && validate(priceEdit)) 
    { 
        formEditItem.submit();
        btnEditSubmit.disabled = true;
        btnEditSubmit.innerHTML = "Salvando...";
        btnEditSubmit.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Salvando...";     
    }
});

//Btn Edit Item Card
const btnModalEditItem = [...document.querySelectorAll('.btnModalEditItem')];
if(btnModalEditItem)
{
    btnModalEditItem.forEach(btn => {
        btn.addEventListener('click', (evt) => {
            const idFull = evt.target.id;
            const card = document.querySelector(`#${idFull}`);
            const inputTypeItem = card.querySelector('#unit_measurement_item'); 
            if (inputTypeItem.value === '1') 
            {
                radiosEdit[0].checked = true;
                setInputs(radiosEdit[0], labelPriceEdit, labelQuantityEdit, quantityEdit, priceEdit, spanItemQuantityInfoEdit, spanItemQuantityAlertEdit);
            }   
            if (inputTypeItem.value === '2') 
            {
                radiosEdit[1].checked = true;
                setInputs(radiosEdit[1], labelPriceEdit, labelQuantityEdit, quantityEdit, priceEdit, spanItemQuantityInfoEdit, spanItemQuantityAlertEdit);
            } 
            const inputs = [nameEdit, quantityEdit, priceEdit];  
            const ids = ['#itemName', '#itemQuantity', '#itemPrice'];
            for(let i=0; i<inputs.length; i++){
                inputs[i].classList.remove('input-error');        
                inputs[i].value = card.querySelector(ids[i]).innerHTML;
                spanFormEditItem[i].classList.add('d-none');
            } 
            formEditItem.querySelector('#itemIdEdit').value = idFull.split("_")[1];
        });
    });
}

//Form Modal Delete Item
const formDeleteItem = document.querySelector('#formDeleteItem');
const btnDeleteSubmit = formDeleteItem.querySelector('button[type=submit]');
formDeleteItem.addEventListener('submit', () => {
    btnDeleteSubmit.disabled = true;
    btnDeleteSubmit.innerHTML = "Removendo...";
    btnDeleteSubmit.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Removendo...";
});

//Btn Delete Item Card
const btnModalDeleteItem = [...document.querySelectorAll('.btnModalDeleteItem')];
if(btnModalDeleteItem)
{
    btnModalDeleteItem.forEach(btn => {
        btn.addEventListener('click', (evt) => {
            const idFull = evt.target.id;
            formDeleteItem.querySelector('#itemIdDelete').value = idFull.split("_")[1];
        });
    });
}

//Search Items
const searchInput = document.querySelector('#searchInput');
searchInput.addEventListener('input', () => searchItems(searchInput.value.toLowerCase(), '.card', '.card-title')); 

//Negative Balance
const balance = document.querySelector('#balance');
let numberBalance = parseFloat(balance.innerText.split("R")[0]);
balance.classList.toggle('text-danger', numberBalance < 0);

//Btn Scroll Top and Sticky DivSeach
windowOnScroll(document.querySelector("#divSearch"), document.querySelector("#btnTop"));
