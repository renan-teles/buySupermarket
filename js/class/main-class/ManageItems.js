import ManageLocalStorage from '../control-class/control-data/ManageLocalStorage';
import ControlItems from '../control-class/control-arrays/ControlItems';
import Item from '../instantiable-class/Item';

export default class ManageItems {

    static createItem = (purchaseId, name, type, quantity, price) => {
        let id = ManageLocalStorage.getItemId();
        const item = new Item(id, purchaseId, name, type, quantity, price);
        ControlItems.addItem(item);
        ManageLocalStorage.setItems(ControlItems.getItems());
        ManageLocalStorage.setItemId(++id);
    }

    static editItem = (item, name, quantity, price) => {
        item.editItem(name, quantity, price);
        ManageLocalStorage.setItems(ControlItems.updateItem(item, item.getId()));
    }

    static removeItem = (itemId) => ManageLocalStorage.setItems(ControlItems.removeItem(itemId));

}