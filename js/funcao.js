function formatarValorVirgula(valor) {
    valorSemVirgula = valor.replace(/\./g, '').replace(',', '.');
    valorConvertidoFloat = parseFloat(valorSemVirgula).toFixed(2);
    valorConvertidoNumerico = Number(valorConvertidoFloat);
    return valorConvertidoNumerico;
}

function formatarValorNumero(valor) {
    valorConvertidoFloat = parseFloat(valor).toFixed(2)
    valorConvertidoNumerico = Number(valorConvertidoFloat);
    return valorConvertidoNumerico;
}