//Functions
export const windowOnScroll = (divSeach, btn) => {
    window.onscroll = () => {
        const offsetTop = divSeach.getBoundingClientRect().top;
        if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) 
        {
          btn.style.display = "block";
        } else {
          btn.style.display = "none";
        }
        divSeach.classList.toggle("margin-on-top", offsetTop <= 0);
    };
    btn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });   
    });
}

export const searchItems = (searchInputValue, classElement1, classElement2) => {
    let search = searchInputValue;
    let elements = document.querySelectorAll(classElement1);
    if(elements.length > 0)
    {
        elements.forEach(el => {
            let nameItem = el.querySelector(classElement2).textContent.toLowerCase(); 
            (nameItem.indexOf(search) !== -1)? el.style.display = '' : el.style.display = 'none';
        });
    } 
}

export const setInputs = (radio, labelPrice, labelQuantity, quantity, price, spanItemQuantityInfo, spanItemQuantityAlert) => {
    const isUnidade = radio.value === '1';
    if(labelPrice && price)
    {
        labelPrice.textContent = isUnidade ? 'Preço por Unidade:' : 'Preço por Kg:';
        price.placeholder = isUnidade ? 'Digite o preço por unidade do item...' : 'Digite o preço por Kg do item...';
    }
    labelQuantity.textContent = isUnidade ? 'Quantidade de Unidades:' : 'Quantidade em Kg:';
    quantity.placeholder = isUnidade ? 'Digite a quantidade de unidades...' : 'Digite a quantidade em Kg...';
    spanItemQuantityInfo.innerText = isUnidade ? 'Un.' : 'Kg';
    spanItemQuantityAlert.innerText = isUnidade ? 'O campo quantidade de unidades é obrigatório!' : 'O campo quantidade em kg é obrigatório!';
}