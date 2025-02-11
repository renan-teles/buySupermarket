//IMPORTS
import Global from './class/GlobalVars.js';
import HTMLComponents from './class/HTMLComponents.js';

//SELECTION DOM
Global.DOMElements.set('divPurchases', document.querySelector('#divPurchases'));

const btnAddPurchase = document.querySelector('#btnAddPurchase');

//EVENTS
window.addEventListener('load', () => Global.showPurchases());

btnAddPurchase.addEventListener('click', () => {
    let createPurchaseModal = document.createElement('section');
    createPurchaseModal.classList.add('win-floats');

    createPurchaseModal.innerHTML = HTMLComponents.getCreatePurchaseModal();

    createPurchaseModal.querySelector('.btnClose').addEventListener('click', () => createPurchaseModal.remove());

    document.body.appendChild(createPurchaseModal);
   
    const inputs = createPurchaseModal.querySelectorAll('.form-control');

    createPurchaseModal.querySelector('#btnAddPurchase').addEventListener('click', () => {
        if(Global.validateInputs(inputs)) return;
        Global.createPurchase(inputs[0].value, Number(inputs[1].value));
        Global.showPurchases();
        createPurchaseModal.remove();
    });
});