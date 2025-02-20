//AUXILIARY FUNCTIONS
export const validateInputs = (inputs) => {
    for (let input of inputs) {
        if (input.value.trim().length == 0 || Number(input.value < 0)) {
            input.focus();
            return true;
        } 
    }
}

export const returnUnitMeasurement = (itemType) => {
    const typeRules = {
        'Perecível': ['(Kg)', '(por Kg)'], 
        'Não Perecível': ['(Un.)', '(por Un.)']
    };
    return typeRules[itemType]; 
};

export const formatCurrency = (value) => {
    return value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
};
