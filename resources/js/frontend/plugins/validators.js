// =============================
// VALIDATORS MODULE
// =============================
const Validators = {

    // CPF
    cpf(cpf) {

        cpf = (cpf || '').replace(/\D/g, '');

        if (cpf.length !== 11) return false;

        if (/^(\d)\1+$/.test(cpf)) return false;

        let sum = 0;

        for (let i = 0; i < 9; i++) {
            sum += parseInt(cpf[i]) * (10 - i);
        }

        let rest = 11 - (sum % 11);
        if (rest >= 10) rest = 0;

        if (rest !== parseInt(cpf[9])) return false;

        sum = 0;

        for (let i = 0; i < 10; i++) {
            sum += parseInt(cpf[i]) * (11 - i);
        }

        rest = 11 - (sum % 11);
        if (rest >= 10) rest = 0;

        return rest === parseInt(cpf[10]);
    },

    // CNPJ
    cnpj(cnpj) {

        cnpj = (cnpj || '').replace(/\D/g, '');

        if (cnpj.length !== 14) return false;

        if (/^(\d)\1+$/.test(cnpj)) return false;

        let size = cnpj.length - 2;
        let numbers = cnpj.substring(0, size);
        let digits = cnpj.substring(size);

        let sum = 0;
        let pos = size - 7;

        for (let i = size; i >= 1; i--) {
            sum += numbers[size - i] * pos--;
            if (pos < 2) pos = 9;
        }

        let result = sum % 11 < 2 ? 0 : 11 - (sum % 11);

        if (result != digits[0]) return false;

        size++;
        numbers = cnpj.substring(0, size);
        sum = 0;
        pos = size - 7;

        for (let i = size; i >= 1; i--) {
            sum += numbers[size - i] * pos--;
            if (pos < 2) pos = 9;
        }

        result = sum % 11 < 2 ? 0 : 11 - (sum % 11);

        return result == digits[1];
    },

    // CPF OU CNPJ (AUTO)
    cpfCnpj(value) {

        const clean = (value || '').replace(/\D/g, '');

        if (clean.length === 11) return this.cpf(clean);
        if (clean.length === 14) return this.cnpj(clean);

        return false;
    },

    // EMAIL
    email(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email || '');
    },

    // NOME COMPLETO
    fullName(name) {

        if (!name) return false;

        const clean = name.trim().replace(/\s+/g, ' ');
        const parts = clean.split(' ');

        return parts.length >= 2;
    },

    // SENHA
    password(password) {

        if (!password) return false;

        const regex = /^(?=.*[A-Za-z])(?=.*\d).{8,}$/;

        return regex.test(password);
    }

};

// EXPORT GLOBAL
window.Validators = Validators;

// (OPCIONAL) EXPORT MODULE
export default Validators;
