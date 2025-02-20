//IMPORTS
import HTMLComponents from '../components/HTMLComponents';
import ManageLocalStorage from '../../class/control-class/control-data/ManageLocalStorage';
import ManageSessionStorage from '../../class/control-class/control-data/ManageSessionStorage';
import ControlPurchases from '../../class/control-class/control-arrays/ControlPurshases';
import ManagePurchases from '../../class/main-class/ManagePurchases';
import ControlItems from '../../class/control-class/control-arrays/ControlItems';
import  { validateInputs } from './auxiliaryFunctions';

//SELECTION DOM
const divPurchases = document.querySelector('#divPurchases');
const btnAddPurchase = document.querySelector('#btnAddPurchase');

//FUNCTIONS
const createPurchase = (inputs) => {
    ManagePurchases.createPurchase(inputs[0].value, Number(inputs[1].value));
    showPurchases(ControlPurchases.parsePurchasesToObj(ManageLocalStorage.getPurchases()));
}

const editPurchase = (purchase, inputs) => {
    ManagePurchases.editPurchase(purchase, inputs[0].value, Number(inputs[1].value));
    showPurchases(ControlPurchases.parsePurchasesToObj(ManageLocalStorage.getPurchases()));
}

const removePurchase = (purchase) => {
    ManagePurchases.removePurchase(purchase.getId());
    ControlItems.parseItemsToObj(ManageLocalStorage.getItems());
    ManageLocalStorage.setItems(ControlItems.removeItemsFromPurchaseId(purchase.getId()));
    showPurchases(ControlPurchases.parsePurchasesToObj(ManageLocalStorage.getPurchases()));
}

const showPurchases = (purchases) => {
    divPurchases.innerHTML = '';
    if (purchases.length === 0) {
        divPurchases.innerHTML = '<h5>Você não possui compras.</h5>';
        return;
    }
    purchases.forEach((purchase) => {
        divPurchases.appendChild(createPurchaseCard(purchase));
    });
}

const createPurchaseCard = (purchase) => {
    const card = document.createElement('div');
    card.setAttribute('class', 'col-md-6 col-lg-4 d-flex justify-content-center mb-3');
    card.innerHTML = HTMLComponents.getPurchaseCard(purchase);
    card.querySelector(`#redirect_${purchase.getId()}`).addEventListener('click', () => ManageSessionStorage.setPurchaseId(purchase.getId()));
    card.querySelector(`#btnEditPurchase_${purchase.getId()}`).addEventListener('click', () => openModalEditPurchase(purchase));
    card.querySelector(`#btnDeletePurchase_${purchase.getId()}`).addEventListener('click', () => openModalDeletePurchase(purchase));
    return card;
}

const openModalEditPurchase = (purchase) => {
    let editModal = document.createElement('section');
    editModal.classList.add('win-floats');
    editModal.innerHTML = HTMLComponents.getEditPurchaseModal(purchase);
    editModal.querySelector('.btnClose').addEventListener('click', () => editModal.remove());
    document.body.appendChild(editModal);

    const inputs = editModal.querySelectorAll('.form-control');

    editModal.querySelector('#btnEditPurchase').addEventListener('click', () => {
        if(validateInputs(inputs)) return;
        editPurchase(purchase, inputs)
        editModal.remove();
    });
}

const openModalDeletePurchase = (purchase) => {
    let deleteModal = document.createElement('section');
    deleteModal.classList.add('win-floats');
    deleteModal.innerHTML = HTMLComponents.getDeleteModal('Excluir','Compra');
    deleteModal.querySelector('.btnClose').addEventListener('click', () => deleteModal.remove());
    document.body.appendChild(deleteModal);
 
    deleteModal.querySelector('#btnDeleteRemove').addEventListener('click', () => {
        removePurchase(purchase);
        deleteModal.remove();
    });
}

//EVENTS
window.addEventListener('load', () => showPurchases(ControlPurchases.parsePurchasesToObj(ManageLocalStorage.getPurchases())));

btnAddPurchase.addEventListener('click', () => {
    let createPurchaseModal = document.createElement('section');
    createPurchaseModal.classList.add('win-floats');
    createPurchaseModal.innerHTML = HTMLComponents.getCreatePurchaseModal();
    createPurchaseModal.querySelector('.btnClose').addEventListener('click', () => createPurchaseModal.remove());
    document.body.appendChild(createPurchaseModal);
   
    const inputs = createPurchaseModal.querySelectorAll('.form-control');

    createPurchaseModal.querySelector('#btnAddPurchase').addEventListener('click', () => {
        if(validateInputs(inputs)) return;
        createPurchase(inputs);
        createPurchaseModal.remove();
    });
});