//IMPORTAÇÃO
import Global from './class/GlobalVars.js';
import HTMLComponents from './class/HTMLComponents.js';

//SELEÇÃO DOM
Global.DOMElements.set('namePurchase', document.querySelector('#namePurchase'));
Global.DOMElements.set('finalValue', document.querySelector('#finalValue'));
Global.DOMElements.set('maxSpend', document.querySelector('#maxSpend'));
Global.DOMElements.set('itemsQuantity', document.querySelector('#itemsQuantity'));
Global.DOMElements.set('divItemsPurchase', document.querySelector('#divItemsPurchase'));

const btnAddItem = document.querySelector('#btnAddItem');
const btnSearch = document.querySelector('#button-addon2');
const searchInput = document.querySelector('#searchInput');

//FUNCTIONS
const searchItems = () => {
    let search = searchInput.value.toLowerCase(); 
    let cards = document.querySelectorAll('.card');
    if(cards.length > 0){
        cards.forEach((card) => {
            let nameItem = card.querySelector('.card-title').textContent.toLowerCase(); 
            (nameItem.indexOf(search) !== -1)? card.style.display = '' : card.style.display = 'none';
        });
    } 
}

//EVENTS
window.addEventListener('load', () => Global.updateValues());

searchInput.addEventListener('input', searchItems); 

btnSearch.addEventListener('click', searchItems);

btnAddItem.addEventListener('click', () => {
    let addItemModal = document.createElement('section');
    addItemModal.classList.add('win-floats');
    addItemModal.innerHTML = HTMLComponents.getAddItemModal();
    addItemModal.querySelector('.btnClose').addEventListener('click', () => addItemModal.remove());
    
    document.body.appendChild(addItemModal);
   
    const inputs = addItemModal.querySelectorAll('.form-control');
    const labels = addItemModal.querySelectorAll('.label');
    const radios = addItemModal.querySelectorAll('.form-check-input');
    let selectedRadio = null;

    const changeLabels = (labels, quantity, price) => {
        labels[0].innerHTML = quantity;
        labels[1].innerHTML = price;
    }

    radios.forEach(r => {
        if(r.checked) selectedRadio = r;
        r.addEventListener('click', () => {
            if(r.checked) selectedRadio = r;
            (r.id === 'naoPerecivel')? changeLabels(labels, 'Quantidade (Un.)', 'Preço (por Un.)') : changeLabels(labels, 'Quantidade (Kg)', 'Preço (por Kg)');        
        });
    });

    addItemModal.querySelector('#btnAddItem').addEventListener('click', () => {
        if(Global.validateInputs(inputs)) return;
        Global.addItem(inputs[0].value, selectedRadio.value, Number(inputs[1].value), Number(inputs[2].value));
        Global.updateValues();
        addItemModal.remove();
    });
});