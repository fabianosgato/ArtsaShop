document.addEventListener('alpine:init', () => {

    Alpine.data('productGallery', (images) => ({

        images: images,
        activeIndex: 0,
        lightboxOpen: false,

        lensVisible: false,
        lensX: 0,
        lensY: 0,
        backgroundStyle: '',

        startX: 0,
        currentTranslate: 0,

        get activeImage() {
            return this.images[this.activeIndex]
        },

        next() {
            if (this.activeIndex < this.images.length - 1) {
                this.activeIndex++
            }
        },

        prev() {
            if (this.activeIndex > 0) {
                this.activeIndex--
            }
        },

        setImage(index) {
            this.activeIndex = index
        },

        // ===== ZOOM LENTE =====
        showLens() {
            this.lensVisible = true
        },

        hideLens() {
            this.lensVisible = false
        },

        openLightbox() {
            this.lightboxOpen = true
            document.body.classList.add('overflow-hidden')
        },

        closeLightbox() {
            this.lightboxOpen = false
            document.body.classList.remove('overflow-hidden')
        },

        moveLens(event) {
            const rect = event.target.getBoundingClientRect()
            const x = event.clientX - rect.left
            const y = event.clientY - rect.top

            const percentX = (x / rect.width) * 100
            const percentY = (y / rect.height) * 100

            this.lensX = x - 75
            this.lensY = y - 75

            this.backgroundStyle = `
                background-image: url('${this.activeImage.full}');
                background-repeat: no-repeat;
                background-size: 300%;
                background-position: ${percentX}% ${percentY}%;
            `
        },

        // ===== SWIPE =====
        touchStart(event) {
            this.startX = event.touches[0].clientX
        },

        touchEnd(event) {
            let endX = event.changedTouches[0].clientX
            let diff = this.startX - endX

            if (diff > 50) this.next()
            if (diff < -50) this.prev()
        }
    }))

    // Sugestão de busca
    Alpine.data('searchBox', () => ({

        open: false,
        query: '',
        products: [],
        total: 0,
        resultsUrl: '',
        loading: false,

        async search() {

            // NÃO altera o valor digitado pelo usuário
            const searchQuery = this.query.trim();

            // Fecha dropdown se tiver menos de 3 caracteres
            if (searchQuery.length < 3) {

                this.products = [];
                this.total = 0;
                this.resultsUrl = '';
                this.open = false;

                return;

            }

            this.loading = true;

            try {

                const response = await fetch(
                    `/catalogsearch/suggestions?q=${encodeURIComponent(searchQuery)}`
                );

                const data = await response.json();

                this.products = data.products || [];
                this.total = data.total || 0;
                this.resultsUrl = data.url || '';

                this.open = this.products.length > 0;

            } catch (error) {

                console.error('Erro ao buscar sugestões', error);

                this.products = [];
                this.total = 0;
                this.resultsUrl = '';
                this.open = false;

            } finally {

                this.loading = false;

            }

        }

    }));

})


document.addEventListener('click', function (event) {

    if (!event.target.classList.contains('toggle-password')) return;

    const wrapper = event.target.closest('.relative');
    const input = wrapper.querySelector('.password-field');

    if (!input) return;

    if (input.type === 'password') {
        input.type = 'text';
        event.target.textContent = '🙈';
    } else {
        input.type = 'password';
        event.target.textContent = '👁';
    }

});

// Auto preechimento de CEP
document.addEventListener('DOMContentLoaded', function () {

    function getFields(scope) {
        return {
            street: document.querySelector(`.street[data-scope="${scope}"]`),
            neighborhood: document.querySelector(`.neighborhood[data-scope="${scope}"]`),
            city: document.querySelector(`.city[data-scope="${scope}"]`),
            region: document.querySelector(`.region[data-scope="${scope}"]`)
        };
    }

    function clearFields(fields) {
        if (!fields) return;
        if (fields.street) fields.street.value = '';
        if (fields.neighborhood) fields.neighborhood.value = '';
        if (fields.city) fields.city.value = '';
        if (fields.region) fields.region.value = '';
    }

    function setLoading(fields, state) {
        if (!fields) return;

        if (fields.region) fields.region.disabled = state;

        if (state) {
            if (fields.street) fields.street.value = '...';
            if (fields.neighborhood) fields.neighborhood.value = '...';
            if (fields.city) fields.city.value = '...';
        }
    }

    async function fetchCep(cep) {
        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        return await response.json();
    }

    document.addEventListener('blur', async function (event) {

        if (!event.target.classList.contains('postcode')) return;

        const input = event.target;
        const scope = input.dataset.scope || 'billing';
        const fields = getFields(scope);
        const cep = input.value.replace(/\D/g, '');

        if (!/^[0-9]{8}$/.test(cep)) {
            clearFields(fields);
            return;
        }

        try {

            setLoading(fields, true);

            const data = await fetchCep(cep);

            if (data.erro) {
                clearFields(fields);
                return;
            }

            if (fields.street) fields.street.value = data.logradouro || '';
            if (fields.neighborhood) fields.neighborhood.value = data.bairro || '';
            if (fields.city) fields.city.value = data.localidade || '';
            if (fields.region) fields.region.value = data.uf || '';

        } catch (error) {
            clearFields(fields);
        } finally {
            setLoading(fields, false);
        }

    }, true);

    // =============================
    // MOVE CATEGORY MENU TO DRAWER (MOBILE)
    // =============================
    function handleCategoryMenu() {

        const sidebar = document.getElementById('category-sidebar');
        const mobileContainer = document.getElementById('mobile-menu-container');

        if (!sidebar || !mobileContainer) return;

        if (window.innerWidth < 1024) {
            mobileContainer.appendChild(sidebar);
        } else {
            const grid = document.getElementById('slot-content');
            if (grid && !grid.contains(sidebar)) {
                grid.prepend(sidebar);
            }
        }
    }

    window.addEventListener('resize', handleCategoryMenu);
    handleCategoryMenu();

    // =============================
    // MINI CART HOVER
    // =============================
    document.querySelectorAll('.top-cart-contain').forEach(container => {

        const content = container.querySelector('.top-cart-content');
        if (!content) return;

        container.addEventListener('mouseenter', () => {
            content.classList.remove('hidden');
        });

        container.addEventListener('mouseleave', () => {
            content.classList.add('hidden');
        });

    });

    // =============================
    // ADD TO CART
    // =============================
    document.addEventListener('click', async function (event) {

        const button = event.target.closest('.btn-cart-page');
        if (!button) return;

        event.preventDefault();

        const productId = button.dataset.productId;
        const csrf = document.querySelector('meta[name="csrf-token"]').content;
        const cartSubtotal = document.querySelector('#top-cart-subtotal-fmt');
        const cartQtd = document.querySelector('#top-cart-qtd');

        cartQtd.backgroundColor = "blue";

        try {

            const response = await fetch('/checkout/cart/add-to-cart-ajax', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    product_id: productId,
                    qty: 1
                })
            });

            const data = await response.json();

            if (data.success && data.cart) {
                window.location.href = '/checkout/cart'
                // Altera o conteudo do mini-cart
                // document.querySelector('#top-cart-wrapper').innerHTML = data.html;
            }

        } catch (error) {
            console.error('Erro ao adicionar ao carrinho', error);
        }

    });

    // =============================
    // REMOVE CART ITEM
    // =============================
    document.addEventListener('click', async function (event) {

        const button = event.target.closest('.btn-remove-item');
        if (!button) return;

        event.preventDefault();

        const productId = button.dataset.productId;
        const csrf = document.querySelector('meta[name="csrf-token"]').content;

        try {

            const response = await fetch('/checkout/cart/remove-ajax', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({product_id: productId})
            });

            const data = await response.json();

            if (data.success && data.cart) {
                window.location.reload();
            }

        } catch (error) {
            console.error('Erro ao remover item', error);
        }

    });

    // =============================
    // UPDATE CART QTY
    // =============================
    document.addEventListener('click', async function (event) {

        const increase = event.target.closest('.qty-increase');
        const decrease = event.target.closest('.qty-decrease');

        if (!increase && !decrease) return;

        const wrapper = event.target.closest('.cart-qty');

        const productId = wrapper.dataset.productId;
        const qtyElement = wrapper.querySelector('.cart-item-qty');

        let qty = parseInt(qtyElement.textContent);

        if (increase) qty++;
        if (decrease) qty--;

        if (qty < 1) qty = 1;

        const csrf = document.querySelector('meta[name="csrf-token"]').content;

        try {

            const response = await fetch('/checkout/cart/updatePost', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    product_id: productId,
                    qty: qty
                })
            });

            const data = await response.json();

            if (data.success) {
                // Recarrega página para atualizar totais
                window.location.reload();
            }

        } catch (error) {
            console.error('Erro ao atualizar quantidade', error);
        }

    });

    // =============================
    // WISHLIST
    // =============================
    document.addEventListener('click', async function (event) {

        const button = event.target.closest('.link-wishlist');
        if (!button) return;

        event.preventDefault();

        const productId = button.dataset.productId;
        const csrf = document.querySelector('meta[name="csrf-token"]').content;

        if (!productId) {
            console.error('Product ID não encontrado.');
            return;
        }

        try {

            const response = await fetch('/customer/acount/wishlist', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    product_id: productId
                })
            });

            const data = await response.json();

            button.classList.add('text-red-600');

        } catch (error) {
            console.error('Erro ao adicionar aos favoritos', error);

        }

    });


});


// =============================
// HELPERS
// =============================
function onlyNumbers(value) {
    return value.replace(/\D/g, '');
}

// =============================
// VALIDA CPF
// =============================
function validaCPF(cpf) {

    cpf = onlyNumbers(cpf);

    if (
        cpf.length !== 11 ||
        /^(\d)\1+$/.test(cpf)
    ) {
        return false;
    }

    let soma = 0;

    for (let i = 0; i < 9; i++) {
        soma += parseInt(cpf.charAt(i)) * (10 - i);
    }

    let resto = 11 - (soma % 11);
    if (resto >= 10) resto = 0;

    if (resto !== parseInt(cpf.charAt(9))) {
        return false;
    }

    soma = 0;

    for (let i = 0; i < 10; i++) {
        soma += parseInt(cpf.charAt(i)) * (11 - i);
    }

    resto = 11 - (soma % 11);
    if (resto >= 10) resto = 0;

    return resto === parseInt(cpf.charAt(10));
}

// =============================
// VALIDA CNPJ
// =============================
function validaCNPJ(cnpj) {

    cnpj = onlyNumbers(cnpj);

    if (
        cnpj.length !== 14 ||
        /^(\d)\1+$/.test(cnpj)
    ) {
        return false;
    }

    let tamanho = cnpj.length - 2;
    let numeros = cnpj.substring(0, tamanho);
    let digitos = cnpj.substring(tamanho);

    let soma = 0;
    let pos = tamanho - 7;

    for (let i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2) pos = 9;
    }

    let resultado = soma % 11 < 2 ? 0 : 11 - (soma % 11);

    if (resultado != digitos.charAt(0)) return false;

    tamanho = tamanho + 1;
    numeros = cnpj.substring(0, tamanho);

    soma = 0;
    pos = tamanho - 7;

    for (let i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2) pos = 9;
    }

    resultado = soma % 11 < 2 ? 0 : 11 - (soma % 11);

    return resultado == digitos.charAt(1);
}

// =============================
// VALIDA CPF OU CNPJ
// =============================
function validaCpfCnpj(value) {

    const clean = onlyNumbers(value);

    if (clean.length === 11) {
        return validaCPF(clean);
    }

    if (clean.length === 14) {
        return validaCNPJ(clean);
    }

    return false;
}
