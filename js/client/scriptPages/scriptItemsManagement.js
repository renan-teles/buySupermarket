//IMPORTS
import HTMLComponents from '../components/HTMLComponents.js';
import ManageLocalStorage from '../../class/control-class/control-data/ManageLocalStorage';
import ManageSessionStorage from '../../class/control-class/control-data/ManageSessionStorage';
import ControlItems from '../../class/control-class/control-arrays/ControlItems';
import ControlPurchases from '../../class/control-class/control-arrays/ControlPurshases';
import ManageItems from '../../class/main-class/ManageItems';
import  { formatCurrency, validateInputs } from './auxiliaryFunctions';
import ManagePurchases from '../../class/main-class/ManagePurchases.js';

//SELECTION DOM
const namePurchase = document.querySelector('#namePurchase');
const finalValue = document.querySelector('#finalValue');
const maxSpend = document.querySelector('#maxSpend');
const itemsQuantity = document.querySelector('#itemsQuantity');
const divItemsPurchase = document.querySelector('#divItemsPurchase');
const btnAddItem = document.querySelector('#btnAddItem');
const btnSearch = document.querySelector('#button-addon2');
const searchInput = document.querySelector('#searchInput');

//FUNCTIONS
const returnItemsCurrentPurchase = () => {
    ControlItems.parseItemsToObj(ManageLocalStorage.getItems());
    return ControlItems.searchItemPurchaseId(Number(ManageSessionStorage.getPurchaseId())) || [];
}

const returnCurrentPurchase = () => {   
    ControlPurchases.parsePurchasesToObj(ManageLocalStorage.getPurchases());
    return ControlPurchases.searchPurchaseId(Number(ManageSessionStorage.getPurchaseId())) || [];
}

const createItem = (inputs, typeItem) => {
    const purchase = returnCurrentPurchase();

    const name = inputs[0].value;
    const type = typeItem;
    const quantity = Number(inputs[1].value);
    const price = Number(inputs[2].value);
    const countItem = countItemQuantity(type, quantity);

    ManageItems.createItem(purchase.getId(), name, type, quantity, price);
    ManagePurchases.updateFinalValueAndItemsQuantityAdd(purchase, countItem, quantity*price);
    ManageLocalStorage.setPurchases(ControlPurchases.updatePurchase(purchase, purchase.getId()));
    updateStatusPurchase();
}

const editItem = (item, inputs) => {
    const purchase = returnCurrentPurchase();

    const name = inputs[0].value;
    const quantity = Number(inputs[1].value);
    const price = Number(inputs[2].value);

    const oldCountItem = countItemQuantity(item.getTipe(), item.getQuantity());

    ManagePurchases.updateFinalValueAndItemsQuantityRemove(purchase, oldCountItem, item.getTotalValue());
    
    ManageItems.editItem(item, name, quantity, price);
    
    const newCountItem = countItemQuantity(item.getTipe(), quantity);

    ManagePurchases.updateFinalValueAndItemsQuantityAdd(purchase, newCountItem, quantity * price);
    ManageLocalStorage.setPurchases(ControlPurchases.updatePurchase(purchase, purchase.getId()));

    updateStatusPurchase();
};

const removeItem = (item) => {
    const purchase = returnCurrentPurchase();
    const countItem = countItemQuantity(item.getTipe(), item.getQuantity());

    ManageItems.removeItem(item.getId());
    ManagePurchases.updateFinalValueAndItemsQuantityRemove(purchase, countItem, item.getTotalValue());
    ManageLocalStorage.setPurchases(ControlPurchases.updatePurchase(purchase, purchase.getId()));
    updateStatusPurchase();
}

const countItemQuantity = (type, quantity) => {
    const typeRules = {
        'Não Perecível': quantity, 
        'Perecível': 1
    };
    return typeRules[type] ?? 1; 
};

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

const updateStatusPurchase = () => {
    const purchase = returnCurrentPurchase();
    namePurchase.innerHTML = `${purchase.getName()} - Items:`;
    itemsQuantity.innerHTML = `Quant. Items: ${purchase.getItemsQuantity()}`;
    let finalValuePurchase = purchase.getFinalValue();
    let maxSpendPurchase = purchase.getMaxSpending() - finalValuePurchase;
  
    editStatusPurchase({finalValuePurchase, maxSpendPurchase, 
        className: (finalValuePurchase > purchase.getMaxSpending()) ? 'text-danger' : 'text-dark', 
        text: (finalValuePurchase > purchase.getMaxSpending()) ? 'Valor a Ser Retirado' : 'Posso Gastar'
    });

    showItems();
}

const editStatusPurchase = ({ finalValuePurchase, maxSpendPurchase, className, text }) => {
    const elements = [finalValue, maxSpend];
    elements.forEach(el => el.setAttribute('class', className));
    finalValue.innerHTML = `Já Gastei: ${formatCurrency(finalValuePurchase)}`;
    maxSpend.innerHTML = `${text}: ${formatCurrency(maxSpendPurchase)}`;
}

const showItems = () => {
    divItemsPurchase.innerHTML = '';
    const items = returnItemsCurrentPurchase();

    if (items.length === 0) {
        divItemsPurchase.innerHTML = '<h5>Você não possui itens nesta compra.</h5>';
        return;
    }

    items.forEach(item => {
        divItemsPurchase.appendChild(createItemCard(item));
    });
}

const createItemCard = (item) => {
    const card = document.createElement('div');
    card.setAttribute('class', 'col d-flex justify-content-center mb-2');
    card.innerHTML = HTMLComponents.getItemCard(item);
    card.querySelector(`#btnEditItem_${item.getId()}`).addEventListener('click', () => openModalEditItem(item));
    card.querySelector(`#btnRemoveItem_${item.getId()}`).addEventListener('click', () => openModalRemoveItem(item));
    return card;
}

const openModalEditItem = (item) => {
    let editModal = document.createElement('section');
    editModal.classList.add('win-floats');
    editModal.innerHTML = HTMLComponents.getEditItemModal(item);
    editModal.querySelector('.btnClose').addEventListener('click', () => editModal.remove());
    document.body.appendChild(editModal);
  
    const inputs = editModal.querySelectorAll('.form-control');
   
    editModal.querySelector('#btnEditItem').addEventListener('click', () => {
        if(validateInputs(inputs)) return;
        editItem(item, inputs);
        editModal.remove();
    });
}

const openModalRemoveItem = (item) => {
    let removeModal = document.createElement('section');
    removeModal.classList.add('win-floats');       
    removeModal.innerHTML = HTMLComponents.getDeleteModal('Remover','Item');
    removeModal.querySelector('.btnClose').addEventListener('click', () => removeModal.remove());
    document.body.appendChild(removeModal);
    
    removeModal.querySelector('#btnDeleteRemove').addEventListener('click', () => {
        removeItem(item);    
        removeModal.remove();
    });
}

//EVENTS
window.addEventListener('load', updateStatusPurchase);
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
    const radios = [...addItemModal.querySelectorAll('.form-check-input')];
    let typeItem = null;

    const changeLabels = (labels, isNonPerishable) => {
        labels[0].innerHTML = isNonPerishable ? 'Quantidade (Un.)' : 'Quantidade (Kg)';
        labels[1].innerHTML = isNonPerishable ? 'Preço (por Un.)' : 'Preço (por Kg)';
    };
    
    typeItem = radios.find(t => t.checked);
    
    radios.forEach(r => {
        r.addEventListener('click', () => {
            typeItem = r;
            changeLabels(labels, r.id === 'naoPerecivel');
        });
    });

    addItemModal.querySelector('#btnAddItem').addEventListener('click', () => {
        if(validateInputs(inputs)) return;
        createItem(inputs, typeItem.value);
        addItemModal.remove();
    });
});