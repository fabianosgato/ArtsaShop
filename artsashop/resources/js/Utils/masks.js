export const onlyNumbers = (value) => String(value ?? '').replace(/\D/g, '')

export function maskCEP(value) {
    value = onlyNumbers(value).slice(0, 8)
    return value.replace(/^(\d{5})(\d{1,3})?/, '$1-$2').replace(/-$/, '')
}

export function maskDate(value) {
    value = onlyNumbers(value).slice(0, 8)
    return value
        .replace(/^(\d{2})(\d)/, '$1/$2')
        .replace(/^(\d{2})\/(\d{2})(\d)/, '$1/$2/$3')
        .replace(/\/$/, '')
}

export function maskPhone(value) {
    value = onlyNumbers(value).slice(0, 11)

    if (value.length <= 10) {
        return value
            .replace(/^(\d{2})(\d)/, '($1) $2')
            .replace(/(\d{4})(\d)/, '$1-$2')
    }

    return value
        .replace(/^(\d{2})(\d)/, '($1) $2')
        .replace(/(\d{5})(\d)/, '$1-$2')
}

export function maskCpfCnpj(value) {
    value = onlyNumbers(value).slice(0, 14)

    if (value.length <= 11) {
        return value
            .replace(/(\d{3})(\d)/, '$1.$2')
            .replace(/(\d{3})(\d)/, '$1.$2')
            .replace(/(\d{3})(\d{1,2})$/, '$1-$2')
    }

    return value
        .replace(/^(\d{2})(\d)/, '$1.$2')
        .replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3')
        .replace(/\.(\d{3})(\d)/, '.$1/$2')
        .replace(/(\d{4})(\d)/, '$1-$2')
}

export const masks = {
    cep: maskCEP,
    date: maskDate,
    phone: maskPhone,
    cpfCnpj: maskCpfCnpj,
}
