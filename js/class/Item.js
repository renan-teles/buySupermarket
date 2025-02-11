export default class Item {
    constructor(id, purchaseId, name, type, quantity, price){
        this.id = id;
        this.purchaseId = purchaseId;
        this.name = name;
        this.type = type;
        this.quantity = quantity;
        this.price = price;
        this.totalValue = (price * quantity);
    }

    getId = () => this.id;
    
    getPurchaseId = () => this.purchaseId;

    getName = () => this.name;
    
    getType = () => this.type;
    
    getQuantity = () => this.quantity;
    
    getPrice = () => this.price;
    
    getTotalValue = () => this.totalValue;

    setId = (id) => this.id = id;
    
    setPurchaseId = (purchaseId) => this.purchaseId = purchaseId;

    setName = (name) => this.name = name;
    
    setType = (type) => this.type = type;
    
    setQuantity = (quantity) => this.quantity = quantity;
    
    setPrice = (price) => this.price = price;

    setTotalValue = (totalValue) => this.totalValue = totalValue;

    editItem = (name, quantity, price) => {
        this.setName(name);
        this.setQuantity(quantity);
        this.setPrice(price);
        this.setTotalValue(quantity * price);
    }
}
