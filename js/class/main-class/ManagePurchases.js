import ManageLocalStorage from '../control-class/control-data/ManageLocalStorage';
import ControlPurchases from '../control-class/control-arrays/ControlPurshases';
import Purchase from '../instantiable-class/Purchase';

export default class ManagePurchases {

    static createPurchase = (name, maxSpending) => {
        let id = ManageLocalStorage.getPurchaseId();
        const purchase = new Purchase(id, name, 0, maxSpending, 0);
        ControlPurchases.addPurchase(purchase);
        ManageLocalStorage.setPurchases(ControlPurchases.getPurchases());
        ManageLocalStorage.setPurchaseId(++id);
    }

    static editPurchase = (purchase, name, maxSpending) => {
        purchase.editPurchase(name, maxSpending);
        ManageLocalStorage.setPurchases(ControlPurchases.getPurchases());
    }

    static updateFinalValueAndItemsQuantityAdd = (purchase, quantity, finalValue) => {
        purchase.setItemsQuantityAdd(quantity);
        purchase.setFinalValueAdd(finalValue);
    }

    static updateFinalValueAndItemsQuantityRemove = (purchase, quantity, finalValue) => {
        purchase.setItemsQuantityRemove(quantity);
        purchase.setFinalValueRemove(finalValue);
    }

    static removePurchase = (purchaseId) => ManageLocalStorage.setPurchases(ControlPurchases.removePurchase(purchaseId));
    
}