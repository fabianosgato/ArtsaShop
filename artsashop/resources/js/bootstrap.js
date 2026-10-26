
const brl = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' })
export const money = (value) => brl.format(Number(value ?? 0))
