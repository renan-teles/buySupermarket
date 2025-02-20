export default class ManageSessionStorage {
    //purchase ID
    static getPurchaseId = () => JSON.parse(sessionStorage.getItem('purchaseId')) || 1;

    static setPurchaseId = (purchaseId) => sessionStorage.setItem('purchaseId', JSON.stringify(purchaseId));
}