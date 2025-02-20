import Purchase from '../../instantiable-class/Purchase';

export default class ControlPurchases {
    static purchases = [];

    static getPurchases = () => ControlPurchases.purchases;

    static setPurchases = (purchases) => ControlPurchases.purchases = purchases;

    static clearPurchases = () => ControlPurchases.purchases = [];

    static addPurchase = (purchase) => ControlPurchases.purchases.push(purchase);

    static removePurchase = (purchaseId) => {
        return ControlPurchases.purchases = ControlPurchases.purchases.filter((p) => p.getId() !== purchaseId);
    }

    static searchPurchaseId = (purchaseId) => {
        return ControlPurchases.purchases.find(p => p.getId() === purchaseId);
    }

    static updatePurchase = (purchase, purchaseId) => {
        ControlPurchases.purchases.forEach(p => {
            if(p.getId() === purchaseId) p = purchase;
        });
        return ControlPurchases.purchases;
    }
    
    static parsePurchasesToObj = (purchases) => {
        let newPurchases = [];
        purchases.forEach(p => {
            newPurchases.push(new Purchase(p.id, p.name, p.finalValue, p.maxSpending, p.itemsQuantity));    
        });
        ControlPurchases.setPurchases(newPurchases);
        return ControlPurchases.getPurchases();
    }
}