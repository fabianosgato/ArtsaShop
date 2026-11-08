document.addEventListener('DOMContentLoaded', function () {

    function onlyNumbers(value) {
        return value.replace(/\D/g, '');
    }

    function applyMask(element, maskFn) {
        element.addEventListener('input', function () {
            element.value = maskFn(element.value);
        });
    }

    // ===== CEP =====
    function maskCEP(value) {
        value = onlyNumbers(value).slice(0, 8);
        return value.replace(/^(\d{5})(\d{1,3})?/, '$1-$2').replace(/-$/, '');
    }

    // ===== DATA =====
    function maskDate(value) {
        value = onlyNumbers(value).slice(0, 8);
        return value
            .replace(/^(\d{2})(\d)/, '$1/$2')
            .replace(/^(\d{2})\/(\d{2})(\d)/, '$1/$2/$3')
            .replace(/\/$/, '');
    }

    // ===== TELEFONE =====
    function maskPhone(value) {
        value = onlyNumbers(value).slice(0, 11);

        if (value.length <= 10) {
            return value
                .replace(/^(\d{2})(\d)/, '($1) $2')
                .replace(/(\d{4})(\d)/, '$1-$2');
        } else {
            return value
                .replace(/^(\d{2})(\d)/, '($1) $2')
                .replace(/(\d{5})(\d)/, '$1-$2');
        }
    }

    // ===== CPF / CNPJ =====
    function maskCpfCnpj(value) {
        value = onlyNumbers(value).slice(0, 14);

        if (value.length <= 11) {
            // CPF
            return value
                .replace(/(\d{3})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        } else {
            // CNPJ
            return value
                .replace(/^(\d{2})(\d)/, '$1.$2')
                .replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3')
                .replace(/\.(\d{3})(\d)/, '.$1/$2')
                .replace(/(\d{4})(\d)/, '$1-$2');
        }
    }

    // ===== APPLY GLOBAL =====
    document.querySelectorAll('.mask-postcode').forEach(el => applyMask(el, maskCEP));
    document.querySelectorAll('.mask-telefone').forEach(el => applyMask(el, maskPhone));
    document.querySelectorAll('#date_of_birth').forEach(el => applyMask(el, maskDate));
    document.querySelectorAll('#vat_number').forEach(el => applyMask(el, maskCpfCnpj));

});
