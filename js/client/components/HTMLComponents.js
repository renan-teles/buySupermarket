import  { formatCurrency, returnUnitMeasurement } from '../scriptPages/auxiliaryFunctions';

export default class HTMLComponents {
   
    //PURCHASES
    static getPurchaseCard = (purchase) => {
        let purchaseCard = `
        <div class="card">
            <div class="col-12 d-flex justify-content-center mt-3">
                <div class="col-4">
                    <img src="img/kartPurchase.png" class="card-img-top" alt="Carrinho de Compra">
                </div>
            </div>
            <div class="card-body text-center">
                <h5 class="card-title">${purchase.getName()}</h5>
                <div class='mb-3'>
                    <span class="card-text">Gasto Máximo: <strong>${formatCurrency(purchase.getMaxSpending())}</strong></span><br>
                    <span class="card-text">Valor Final: <strong>${formatCurrency(purchase.getFinalValue())}</strong></span><br>
                    <span class="card-text">Quant. Items: <strong>${purchase.getItemsQuantity()}</strong></span><br>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary dropdown-toggle mb-2" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi-basket me-2"></i>Compra
                    </button>
                    <ul class="dropdown-menu text-center">
                        <li><button id='btnEditPurchase_${purchase.getId()}' type="button" class="btn"><i class="bi-eye me-2"></i>Editar Compra</button></li>
                        <li><button id='btnDeletePurchase_${purchase.getId()}' type="button" class="btn text-danger"><i class="bi-trash me-2"></i>Excluir Compra</button></li>
                    </ul>
                </div>
                <a id='redirect_${purchase.getId()}' class="btn btn-success mb-2" href="itemsManagement.html"><i class="bi-bar-chart-steps me-2"></i>Gerir Items</a>
            </div>
        </div>
        `;
        return purchaseCard;
    }

    static getCreatePurchaseModal = () => {
        let createPurchaseModal = `
        <div class="col-11 col-md-7 rounded bg-light p-3 shadow">
            <div class="row">
                <div class="col-10">
                    <h3><i class="bi-plus-circle me-2"></i>Criar Compra</h3>
                </div>
                <div class="col-2 text-end">
                    <button type="button" class="btn-close btnClose" aria-label="Close"></button>
                </div>
            </div>
            <hr>
            <div class="mb-3">
                <label for="txtPurchaseName">Nome</label>
                <input id="txtPurchaseName" required type="text" placeholder="Digite um nome para sua compra..." class="form-control" required>
            </div>
    
            <label for="txtMaxSpending">Gasto Máximo</label>
            <div class="input-group mb-3">
                <input placeholder='Digite o gasto máximo para sua compra...' id="txtMaxSpending" type="number" min='0' class="form-control">
                <span class="input-group-text">R$</span>
            </div>
    
            <div class="mb-1 text-end">
                <button type="button" id='btnAddPurchase' class="btn btn-primary">Criar Compra</button>
            </div>
        </div>`;
        return createPurchaseModal;
    }

    static getEditPurchaseModal = (purchase) => {
        let editPurchaseModal = `
        <div class="col-11 col-md-7 rounded bg-light p-3 shadow">
            <div class="row">
                <div class="col-10">
                    <h3><i class="bi-pencil me-2"></i>Editar Compra</h3>
                </div>
                <div class="col-2 text-end">
                    <button type="button" class="btn-close btnClose" aria-label="Close"></button>
                </div>
            </div>
            <hr>
            <div class="mb-3">
                <label for="txtPurchaseName">Nome</label>
                <input id="txtPurchaseName" required value='${purchase.getName()}' type="text" placeholder="Digite um nome para sua compra..." class="form-control" required>
            </div>
            <label for='txtMaxSpending'>Gasto Máximo</label>
            <div class="input-group mb-3">
                <input id="txtMaxSpending" type="number" value='${purchase.getMaxSpending()}' placeholder="Digite o gasto máximo para sua compra...." min='0' class="form-control">
                <span class="input-group-text">R$</span>
            </div>
            <div class="mb-1 text-end">
                <button type="button" id='btnEditPurchase' class="btn btn-primary">Editar Compra</button>
            </div>
        </div>`;
        return editPurchaseModal;
    }

    //PURCHASES AND ITEMS
    static getDeleteModal = (text1, text2) => {
        let deleteModal= `
        <div class="col-11 col-md-4 rounded bg-light p-3 shadow">
            <div class="row">
                <div class="col-12 text-center">
                    <h3><i class="bi-trash me-2"></i>${text1} ${text2}?</h3>
                </div>
            </div>
            <hr>
            <div class="mb-3 col-12 text-center">
                <button type="button" class="btn btnClose" aria-label="Close">Cancelar</button>
               <button id='btnDeleteRemove' type='button' class='btn btn-danger'>${text1}</button>
            </div>
        </div>`;
        return deleteModal;
    }

    //ITEMS
    static getItemCard = (item) => {
        let itemCard = `
        <div class="card mb-3 p-2" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-3 col-sm-4 d-flex align-items-center">
                    <img src="img/itemsPurchase.png" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-9 col-sm-8">
                    <div class="card-body">
                        <h5 id='itemName' class="card-title">${item.getName()}</h5>
                        <span class="card-text">Tipo: ${item.getTipe()}.</span><br>
                        <span class="card-text">Preço: <strong>${formatCurrency(item.getPrice())}</strong></span><br>
                        <span class="card-text">Quant.: <strong>${item.getQuantity()}${returnUnitMeasurement(item.getTipe())[0]}</strong></span><br>
                        <span class="card-text">Valor Total: <strong>${formatCurrency(item.getTotalValue())}</strong></span>
                    </div>
                </div>
            </div>
            <div class="text-center py-2">    
                <button id='btnRemoveItem_${item.getId()}' class="btn btn-danger">Remover</button>
                <button id='btnEditItem_${item.getId()}' class="btn btn-secondary">Editar</button>
            </div>
        </div>
        `;
        return itemCard;
    }

    static getAddItemModal = () => {
        let addItemModal = `
        <div class="col-11 col-md-7 rounded bg-light p-3 shadow">
            <div class="row">
                <div class="col-10">
                    <h3><i class="bi-plus-circle me-2"></i>Adicionar Item</h3>
                </div>
                <div class="col-2 text-end">
                    <button type="button" class="btn-close btnClose" aria-label="Close"></button>
                </div>
            </div>
            <hr>
            <div class="mb-3">
                <label for="txtItemName">Nome</label>
                <input id="txtItemName" type="text" placeholder="Digite o nome do item..." class="form-control" required>
            </div>

            <div class='mb-3'>
               <div class="form-check">
                    <input class="form-check-input" value='Não Perecível' type="radio" name="itemType" id="naoPerecivel" checked>
                    <label class="form-check-label" for="naoPerecivel">
                        Unidade (Un).
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" value='Perecível' type="radio" name="itemType" id="perecivel" >
                    <label class="form-check-label" for="perecivel">
                        Quilograma (Kg).
                    </label>
                </div>
            </div>

            <div class="mb-3">
                <label class='label' for="txtItemQuantity">Quantidade (Un.)</label>
                <input placeholder='Digite a quantidade...' id="txtItemQuantity" value='1' min='1' type="number" class="form-control" required>
            </div>

            <label class='label' for="txtItemPrice">Preço (por Un.)</label>
            <div class="input-group mb-3">
                <input id='txtItemPrice' placeholder='Digite o preço...' type="number" min='0' class="form-control">
                <span class="input-group-text">R$</span>
            </div>

            <div class="mb-1 text-end">
                <button type="button" id='btnAddItem' class="btn btn-primary">Adicionar Item</button>
            </div>
        </div>`;
        return addItemModal;
    }

    static getEditItemModal = (item) => {       
        let editItemModal = `
        <div class="col-11 col-md-7 rounded bg-light p-3 shadow">
            <div class="row">
                <div class="col-10">
                    <h3><i class="bi-pencil me-2"></i>Editar Item</h3>
                </div>
                <div class="col-2 text-end">
                    <button type="button" class="btn-close btnClose" aria-label="Close"></button>
                </div>
            </div>
            <hr>
            <div class="mb-3">
                <label>Nome</label>
                <input placeholder='Digite o nome do item...' id="txtItemName" type="text" value='${item.getName()}' class="form-control" required>
            </div>

            <div class="mb-3">
                <label class='label'>Quantidade ${returnUnitMeasurement(item.getTipe())[0]}</label>
                <input placeholder='Digite a quantidade de items...' id="txtItemQuantity" type="number" value='${item.getQuantity()}' min='1' class="form-control" required>
            </div>

            <label class='label' for='txtItemPrice'>Preço ${returnUnitMeasurement(item.getTipe())[1]}</label>
            <div class="input-group mb-3">
                <input id='txtItemPrice' placeholder='Digite o preço...' id="txtItemPrice" type="number" value='${item.getPrice()}' min='0' class="form-control">
                <span class="input-group-text">R$</span>
            </div>

            <div class="mb-1 text-end">
                <button type="button" id='btnEditItem' class="btn btn-primary">Salvar</button>
            </div>
        </div>`;
        return editItemModal;
    }

}
