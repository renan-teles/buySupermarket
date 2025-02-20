import Item from '../../instantiable-class/Item';

export default class ControlItems {
    static items = [];

    static getItems = () => ControlItems.items;

    static setItems = (items) => ControlItems.items = items; 

    static clearItems = () => ControlItems.items = [];

    static addItem = (item) => ControlItems.items.push(item);

    static removeItem = (itemId) => {
        return ControlItems.items = ControlItems.items.filter((i) => i.getId() !== itemId);
    } 
 
    static removeItemsFromPurchaseId = (purchaseId) => {
        return ControlItems.items = ControlItems.items.filter((i) => i.getPurchaseId() !== purchaseId);
    }

    static searchItemId = (itemId) => {
        return ControlItems.items.find((i) => i.getId() === itemId);
    }
    
    static searchItemPurchaseId = (purchaseId) => {
        return ControlItems.items.filter(i => i.getPurchaseId() === purchaseId);
    }

    static updateItem = (item, itemId) => {
        ControlItems.items.forEach(i => {
            if(i.getId() === itemId) i = item;
        });
        return ControlItems.items;
    }

    static parseItemsToObj = (items) => {
        let newItems = [];
        items.forEach(i => {
            newItems.push(new Item(i.id, i.purchaseId, i.name, i.tipe, i.quantity, i.price));    
        });
        ControlItems.setItems(newItems);
        return ControlItems.getItems();
    }
}