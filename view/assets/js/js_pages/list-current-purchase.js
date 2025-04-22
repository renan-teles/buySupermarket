import { setStatusInput, validate, validateNumber } from './validateForms.js';
import { windowOnScroll, searchItems, setInputs } from './globalFunctions.js';

//Form Modal Add Item
const formAddItemList = document.querySelector('#formAddItemList');
const name = formAddItemList.querySelector('input[name="name_item_list"]');
const quantity = formAddItemList.querySelector('input[name="quantity_item_list"]');
const spanformAddItemList = [...formAddItemList.querySelectorAll('.spanformAddItemList')];
const radios = [...formAddItemList.querySelectorAll('input[type=radio]')];
const labelQuantity = formAddItemList.querySelector('#label-quantity');
const spanItemQuantityInfo = formAddItemList.querySelector('#spanItemListQuantityInfo');
const spanItemQuantityAlert = formAddItemList.querySelector('#spanItemListQuantityAlert');
const btnSubmit = formAddItemList.querySelector('button[type=submit]');
radios.forEach(radio => {
    radio.addEventListener('click', () => {
        if (radio.checked) 
        {
            setInputs(radio, null, labelQuantity, quantity, null, spanItemQuantityInfo, spanItemQuantityAlert);
        }
    });
});
document.querySelector('#btnClose').addEventListener('click', () => {
    const inputs = [name, quantity];
    for(let i=0; i<inputs.length; i++){
        inputs[i].value = '';
        inputs[i].classList.remove('input-error');
        spanformAddItemList[i].classList.add('d-none');
    }
});
formAddItemList.addEventListener('submit', (evt) => {
    evt.preventDefault();
    setStatusInput(validate(name), name, spanformAddItemList[0]);
    setStatusInput(validateNumber(quantity), quantity, spanformAddItemList[1]);
    name.addEventListener('input', () => setStatusInput(validate(name), name, spanformAddItemList[0]));
    quantity.addEventListener('input', () => setStatusInput(validateNumber(quantity), quantity, spanformAddItemList[1]));
    if (validate(name) && validateNumber(quantity)) 
    { 
        formAddItemList.submit();
        btnSubmit.disabled = true;
        // btnSubmit.innerHTML = "Adicionando...";
        btnSubmit.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Adicionando...";    
    }
});

//Form Modal Edit Item
const formEditItemList = document.querySelector('#formEditItemList');
const nameEdit = formEditItemList.querySelector('input[name="name_item_list"]');
const quantityEdit = formEditItemList.querySelector('input[name="quantity_item_list"]');
const spanFormEditItemList = [...formEditItemList.querySelectorAll('.spanFormEditItemList')];
const radiosEdit = [...formEditItemList.querySelectorAll('input[type=radio]')];
const labelQuantityEdit = formEditItemList.querySelector('#label-edit-quantity');
const spanItemListQuantityInfoEdit = formEditItemList.querySelector('#spanItemListEditQuantityInfo');
const spanItemListQuantityAlertEdit = formEditItemList.querySelector('#spanItemListEditQuantityAlert');
const btnEditSubmit = formEditItemList.querySelector('button[type=submit]');
radiosEdit.forEach(radio => {
    radio.addEventListener('click', () => {
        if (radio.checked) 
        {
            setInputs(radio, null, labelQuantityEdit, quantityEdit, null, spanItemListQuantityInfoEdit, spanItemListQuantityAlertEdit);
        }
    });
});   
formEditItemList.addEventListener('submit', (evt) => {
    evt.preventDefault();
    setStatusInput(validate(nameEdit), nameEdit, spanFormEditItemList[0]);
    setStatusInput(validate(quantityEdit), quantityEdit, spanFormEditItemList[1]);     
    nameEdit.addEventListener('input', () => setStatusInput(validate(nameEdit), nameEdit, spanFormEditItemList[0]));
    quantityEdit.addEventListener('input', () => setStatusInput(validate(quantityEdit), quantityEdit, spanFormEditItemList[1]));  
    if (validate(nameEdit) && validate(quantityEdit)) 
    { 
        formEditItemList.submit();
        btnEditSubmit.disabled = true;
        // btnEditSubmit.innerHTML = "Salvando...";
        btnEditSubmit.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Salvando...";    
    }
});

//Btn Edit Item Card
const btnModalEditItemList = [...document.querySelectorAll('.btnModalEditItemList')];
if(btnModalEditItemList)
{
    btnModalEditItemList.forEach(btn => {
        btn.addEventListener('click', (evt) => {
            const idFull = evt.currentTarget.id;
            const tr = document.querySelector(`#${idFull}`);
            const inputTypeItem = tr.querySelector('#unit_measurement_item_list'); 
            if (inputTypeItem.value === '1') 
            {
                radiosEdit[0].checked = true;
                setInputs(radiosEdit[0], null, labelQuantityEdit, quantityEdit, null, spanItemListQuantityInfoEdit, spanItemListQuantityAlertEdit);
            }   
            if (inputTypeItem.value === '2') 
            {
                radiosEdit[1].checked = true;
                setInputs(radiosEdit[1], null, labelQuantityEdit, quantityEdit, null, spanItemListQuantityInfoEdit, spanItemListQuantityAlertEdit);
            } 
            const inputs = [nameEdit, quantityEdit];  
            const ids = ['#itemListName', '#itemListQuantity'];
            for(let i=0; i<inputs.length; i++){
                inputs[i].classList.remove('input-error');        
                inputs[i].value = tr.querySelector(ids[i]).innerHTML;
                spanFormEditItemList[i].classList.add('d-none');
            }
            formEditItemList.querySelector('#itemListIdEdit').value = idFull.split("_")[1];
        });
    });
}

//Form Modal Delete Item
const formDeleteItemList = document.querySelector('#formDeleteItemList');
const btnDeleteSubmit = formDeleteItemList.querySelector('button[type=submit]');
formDeleteItemList.addEventListener('submit', () => {
    btnDeleteSubmit.disabled = true;
    // btnDeleteSubmit.innerHTML = "Removendo...";
    btnDeleteSubmit.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Removendo...";
});

//Btn Delete Item Card
const btnModalDeleteItemList = [...document.querySelectorAll('.btnModalDeleteItemList')];
if(btnModalDeleteItemList)
{
    btnModalDeleteItemList.forEach(btn => {
        btn.addEventListener('click', (evt) => {
            const idFull = evt.currentTarget.id;
            formDeleteItemList.querySelector('#itemListIdDelete').value = idFull.split("_")[1];
        });
    });
}

//Search Items
const searchInput = document.querySelector('#searchInput');
searchInput.addEventListener('input', () => searchItems(searchInput.value.toLowerCase(), '.tr-item', '.tr-title')); 

//Btn Scroll Top and Sticky DivSeach
windowOnScroll(document.querySelector("#divSearch"), document.querySelector("#btnTop"));