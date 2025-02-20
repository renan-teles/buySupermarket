export default class ManageLocalStorage {
    //purchases
    static getPurchaseId = () => JSON.parse(localStorage.getItem('purchaseId')) || 1;

    static setPurchaseId = (purchaseId) => localStorage.setItem('purchaseId', JSON.stringify(purchaseId));

    static getPurchases = () => JSON.parse(localStorage.getItem('purchases')) || [];

    static setPurchases = (purchases) => localStorage.setItem('purchases', JSON.stringify(purchases));

    //items
    static getItemId = () => JSON.parse(localStorage.getItem('itemId')) || 1;

    static setItemId = (itemId) => localStorage.setItem('itemId', JSON.stringify(itemId));

    static getItems = () => JSON.parse(localStorage.getItem('items')) || [];

    static setItems = (items) => localStorage.setItem('items', JSON.stringify(items));
}