import Item from './Item';
import Purschase from './Purchase';
import HTMLComponents from './HTMLComponents';
import Purchase from './Purchase';

export default class GlobalVars {
    static purchases = [];
    static items = [];
    static DOMElements = new Map();
    static purschaseId = 1;
    static itemId = 1;
    static currentPurchase = null;
  
    //GENERAL FUNCTIONS
    static updatePurchases = () => {
        const purchaseData = JSON.parse(localStorage.getItem('purchases')) || [];
        GlobalVars.purchases = purchaseData.map((p) => new Purschase(p.id, p.name, p.finalValue, p.maxSpending, p.itemsQuantity));
    }

    static updateItems = () => {
        const itemsData = JSON.parse(localStorage.getItem('items')) || [];
        GlobalVars.items = itemsData.map((i) => new Item(i.id, i.purchaseId, i.name, i.type, i.quantity, i.price));
    }

    static changeCurrentPurchase = (purchaseId) => {
        GlobalVars.currentPurchase = GlobalVars.purchases.find(el => el.getId() === purchaseId) || null;
    }

    static updateValues = () => {
        GlobalVars.updatePurchases();
        GlobalVars.updateItems();
    
        const editStatusPurchase = (finalValuePurchase, maxSpendPurchase, className, text) => {
            GlobalVars.DOMElements.get('finalValue').setAttribute('class', className);
            GlobalVars.DOMElements.get('maxSpend').setAttribute('class', className);
            GlobalVars.DOMElements.get('finalValue').innerHTML = `Já Gastei: ${finalValuePurchase}R$`;
            GlobalVars.DOMElements.get('maxSpend').innerHTML = `${text}: ${maxSpendPurchase}R$`;
        }
    
        let purchase = GlobalVars.purchases.find(el => el.getId() ===  Number(sessionStorage.getItem('purchaseId')));
       
        if(purchase){
            GlobalVars.DOMElements.get('namePurchase').innerHTML = `${purchase.getName()} - Items:`;
            GlobalVars.DOMElements.get('itemsQuantity').innerHTML = `Quant. Items: ${purchase.getItemsQuantity()}`;

            const finalValuePurchase = purchase.getFinalValue();
            const maxSpendPurchase = purchase.getMaxSpending() - purchase.getFinalValue();
            
            (finalValuePurchase > purchase.getMaxSpending())? 
            editStatusPurchase(finalValuePurchase, maxSpendPurchase, 'text-danger', 'Valor a Ser Retirado')
            :
            editStatusPurchase(finalValuePurchase, maxSpendPurchase, 'text-dark', 'Posso Gastar');
        }
        
        GlobalVars.showItems();
    }

    static validateInputs = (inputs) => {
        for (let input of inputs) {
            if (input.value.trim().length == 0 || Number(input.value < 0)) {
                input.focus();
                return true;
            } 
        }
    }

    //FUNCTIONS TO MANAGE ITEMS
    static addItem = (itemName, itemType, itemQuantity, itemPrice) => {
        const itemId = Number(localStorage.getItem('itemId')) || 1;
        GlobalVars.itemId = itemId;
        
        const item = new Item(itemId, Number(sessionStorage.getItem('purchaseId')), itemName, itemType, itemQuantity, itemPrice);
        GlobalVars.items.push(item);

        GlobalVars.changeCurrentPurchase(Number(sessionStorage.getItem('purchaseId')));
        GlobalVars.currentPurchase.finalValue += item.getTotalValue();
        
        let countItems = 0;
        GlobalVars.items.forEach(item => {
            if(item.getPurchaseId() === GlobalVars.currentPurchase.getId()) {
                (item.getType() === 'Perecível')? countItems += 1 : countItems += item.getQuantity();
            } 
        });
        GlobalVars.currentPurchase.setItemsQuantity(countItems);
        
        localStorage.setItem('purchases', JSON.stringify(GlobalVars.purchases));
        localStorage.setItem('itemId', GlobalVars.itemId + 1);
        localStorage.setItem('items', JSON.stringify(GlobalVars.items));
    }

    static changePurchaseItemsQuantity = (item, operacao) => {
       if(operacao === 'sum'){
            (item.getType() === 'Perecível')? 
            GlobalVars.currentPurchase.itemsQuantity += 1
            : 
            GlobalVars.currentPurchase.itemsQuantity += item.getQuantity();
            return;
        }

        (item.getType() === 'Perecível')? 
        GlobalVars.currentPurchase.itemsQuantity -= 1
        : 
        GlobalVars.currentPurchase.itemsQuantity -= item.getQuantity();
    }

    static removeItem = (itemId) => {
        const item = GlobalVars.items.find(el => el.getId() === itemId);
        if (item) {
            GlobalVars.changeCurrentPurchase(Number(sessionStorage.getItem('purchaseId')));
            GlobalVars.currentPurchase.finalValue -= item.getTotalValue();
            GlobalVars.changePurchaseItemsQuantity(item, null);
            
            GlobalVars.items = GlobalVars.items.filter(i => i.getId() !== itemId);

            localStorage.setItem('purchases', JSON.stringify(GlobalVars.purchases));
            localStorage.setItem('items', JSON.stringify(GlobalVars.items));
        }
    }

    static editItem = (item, name, quantity, price) => {
        GlobalVars.changeCurrentPurchase(Number(sessionStorage.getItem('purchaseId')));
       
        GlobalVars.currentPurchase.finalValue -= item.getTotalValue(); 
        GlobalVars.currentPurchase.finalValue += quantity * price;
        GlobalVars.changePurchaseItemsQuantity(item, null);

        item.editItem(name, quantity, price);

        GlobalVars.changePurchaseItemsQuantity(item, 'sum');

        localStorage.setItem('purchases', JSON.stringify(GlobalVars.purchases));
        localStorage.setItem('items', JSON.stringify(GlobalVars.items));
    }

    static showItems = () => {
        GlobalVars.DOMElements.get('divItemsPurchase').innerHTML = '';
        GlobalVars.updatePurchases();
        GlobalVars.updateItems();

        const purchaseItems = GlobalVars.items.filter(i => i.getPurchaseId() === Number(sessionStorage.getItem('purchaseId')));

        if (purchaseItems.length === 0) {
            GlobalVars.DOMElements.get('divItemsPurchase').innerHTML = '<h5>Você não possui itens nesta compra.</h5>';
            return;
        }

        purchaseItems.forEach((item) => {
            GlobalVars.DOMElements.get('divItemsPurchase').appendChild(GlobalVars.createItemCard(item));
        });
    }

    static createItemCard = (item) => {
        const card = document.createElement('div');
        card.setAttribute('class', 'col d-flex justify-content-center mb-2');
        card.innerHTML = HTMLComponents.getItemCard(item);
        card.querySelector(`#btnEditItem_${item.getId()}`).addEventListener('click', () => GlobalVars.openModalEditItem(item));
        card.querySelector(`#btnRemoveItem_${item.getId()}`).addEventListener('click', () => GlobalVars.openModalRemoveItem(item));
        return card;
    }

    static openModalEditItem = (item) => {
        let editModal = document.createElement('section');
        editModal.classList.add('win-floats');
        editModal.innerHTML = HTMLComponents.getEditItemModal(item);
        editModal.querySelector('.btnClose').addEventListener('click', () => editModal.remove());

        document.body.appendChild(editModal);

        const inputs = editModal.querySelectorAll('.form-control');

        editModal.querySelector('#btnEditItem').addEventListener('click', () => {
            if(GlobalVars.validateInputs(inputs)) return;
            GlobalVars.editItem(item, inputs[0].value, Number(inputs[1].value), Number(inputs[2].value));
            GlobalVars.updateValues();
            editModal.remove();
        });
    }

    static openModalRemoveItem = (item) => {
        let removeModal = document.createElement('section');
        removeModal.classList.add('win-floats');       
        removeModal.innerHTML = HTMLComponents.getDeleteModal('Remover','Item');
        removeModal.querySelector('.btnClose').addEventListener('click', () => removeModal.remove());

        document.body.appendChild(removeModal);

        removeModal.querySelector('#btnDeleteRemove').addEventListener('click', () => {
            GlobalVars.removeItem(item.getId());            
            GlobalVars.updateValues();
            removeModal.remove();
        });
    }

    //FUNCTIONS TO MANAGE PURCHASES
    static createPurchase = (purchaseName, maxSpend) => {
        if(GlobalVars.purchases.length >= 5){
            alert('Você só pode ter 5 compras no histórico! Exclua pelo menos uma delas para poder criar uma nova.');
            return;
        }

        const purchaseId = Number(localStorage.getItem('purchaseId')) || 1;
        GlobalVars.purchaseId = purchaseId;
        
        const purchase = new Purchase(purchaseId, purchaseName, 0, maxSpend, 0);
        GlobalVars.purchases.push(purchase);
      
        console.log(GlobalVars.purchases)

        localStorage.setItem('purchaseId', purchaseId + 1);
        localStorage.setItem('purchases', JSON.stringify(GlobalVars.purchases));
    }

    static removePurchase = (purchaseId) => {
        GlobalVars.purchases = GlobalVars.purchases.filter((p) => p.getId() !== purchaseId);
        GlobalVars.items = GlobalVars.items.filter((i) => i.getPurchaseId() !== purchaseId);
        
        localStorage.setItem('purchases', JSON.stringify(GlobalVars.purchases));
        localStorage.setItem('items', JSON.stringify(GlobalVars.items));
    }

    static showPurchases = () => {
        GlobalVars.DOMElements.get('divPurchases').innerHTML = '';
        GlobalVars.updatePurchases();
        GlobalVars.updateItems();

        if (GlobalVars.purchases.length === 0) {
             GlobalVars.DOMElements.get('divPurchases').innerHTML = '<h5>Você não possui compras.</h5>';
            return;
        }
        
        GlobalVars.purchases.forEach((purchase) => {
             GlobalVars.DOMElements.get('divPurchases').appendChild(GlobalVars.createPurchaseCard(purchase));
        });
    }

    static createPurchaseCard = (purchase) => {
        const card = document.createElement('div');
        card.setAttribute('class', 'col-md-6 col-lg-4 d-flex justify-content-center mb-3');
        card.innerHTML = HTMLComponents.getPurchaseCard(purchase);

        card.querySelector(`#redirect_${purchase.getId()}`).addEventListener('click', () => sessionStorage.setItem('purchaseId', purchase.getId()));
        card.querySelector(`#btnEditPurchase_${purchase.getId()}`).addEventListener('click', () => GlobalVars.openModalEditPurchase(purchase));
        card.querySelector(`#btnDeletePurchase_${purchase.getId()}`).addEventListener('click', () => GlobalVars.openModalDeletePurchase(purchase));
        return card;
    }

    static openModalEditPurchase = (purchase) => {
        let editModal = document.createElement('section');
        editModal.classList.add('win-floats');
        editModal.innerHTML = HTMLComponents.getEditPurchaseModal(purchase);
        editModal.querySelector('.btnClose').addEventListener('click', () => editModal.remove());

        document.body.appendChild(editModal);

        const inputs = editModal.querySelectorAll('.form-control');

        editModal.querySelector('#btnEditPurchase').addEventListener('click', () => {
            if(GlobalVars.validateInputs(inputs)) return;
            purchase.editPurchase(inputs[0].value, Number(inputs[1].value));
            localStorage.setItem('purchases', JSON.stringify(GlobalVars.purchases));
            GlobalVars.showPurchases();
            editModal.remove();
        });
    }

    static openModalDeletePurchase = (purchase) => {
        let deleteModal = document.createElement('section');
        deleteModal.classList.add('win-floats');
        deleteModal.innerHTML = HTMLComponents.getDeleteModal('Excluir','Compra');
        deleteModal.querySelector('.btnClose').addEventListener('click', () => deleteModal.remove());
     
        document.body.appendChild(deleteModal);
     
        deleteModal.querySelector('#btnDeleteRemove').addEventListener('click', () => {
            GlobalVars.removePurchase(purchase.getId());
            GlobalVars.purchases.length > 0? GlobalVars.showPurchases() :  GlobalVars.DOMElements.get('divPurchases').innerHTML = `<h5>Você não possui compras.</h5>`;
            deleteModal.remove();
        });
    }
}