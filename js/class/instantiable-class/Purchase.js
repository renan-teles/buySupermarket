export default class Purchase {
    constructor(id, name, finalValue, maxSpending, itemsQuantity){
        this.id = id;
        this.name = name;
        this.finalValue = finalValue;
        this.maxSpending = maxSpending;
        this.itemsQuantity = itemsQuantity;
    }

    getId = () => this.id;

    getName = () => this.name;
    
    getFinalValue = () => this.finalValue;

    getMaxSpending = () => this.maxSpending;

    getItemsQuantity = () => this.itemsQuantity;

    setId = (id) => this.id = id;

    setName = (name) => this.name = name;

    setFinalValue = (finalValue) => this.finalValue = finalValue;

    setFinalValueAdd = (finalValue) => this.finalValue += finalValue;

    setFinalValueRemove = (finalValue) => this.finalValue -= finalValue;

    setMaxSpending = (maxSpending) => this.maxSpending = maxSpending;

    setItemsQuantity = (itemsQuantity) => this.itemsQuantity = itemsQuantity;

    setItemsQuantityAdd = (itemsQuantity) => this.itemsQuantity += itemsQuantity;
    
    setItemsQuantityRemove = (itemsQuantity) => this.itemsQuantity -= itemsQuantity;

    editPurchase = (name, maxSpending) => {
        this.setName(name);
        this.setMaxSpending(maxSpending);
    }
}
