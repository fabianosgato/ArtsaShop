<x-frontend.app-layout layout="1column">
    <div class="x-auto px-4 py-10">

        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">
                @if($salesOrder->status == 'approved')
                    Pedido Concluído
                @else
                    @if($salesOrder->payment_method === 'pix')
                        Aguardando pagamento via PIX
                    @else
                        Pedido Concluído
                    @endif
                @endif
            </h1>

            <h2 class="text-gray-600 mt-2 text-sm leading-relaxed">
                @if($salesOrder->status == 'approved')
                    Obrigado pela sua compra. Seu pagamento foi confirmado com sucesso.

                @elseif(($salesOrder->status == 'pending') || ($salesOrder->status == 'pending_payment') || ($salesOrder->status == 'holded'))
                    @if($salesOrder->payment_method === 'pix' && !empty($additionalInformation['pix']))
                        Seu pedido foi criado com sucesso. Para finalizar a compra, realize o pagamento via PIX.
                        <div class="mt-3 space-y-1">
                            <p>1. Abra o app do seu banco ou carteira digital</p>
                            <p>2. Escolha a opção <strong>Pagar com PIX</strong></p>
                            <p>3. Escaneie o QR Code ou utilize o código Copia e Cola</p>
                            <p>4. Confirme o pagamento</p>
                        </div>
                    @elseif($salesOrder->payment_method === 'credit_card')
                        Seu pedido foi criado. Agora estamos validando a compra em nosso sistema anti-fraude
                        <div class="mt-3 space-y-1">
                            <div
                                x-data="threeDSWatcher({{ $salesOrder->order_id }})"
                                x-init="init()"
                                class="flex flex-col items-center justify-center py-6"
                            >

                                {{-- LOADING --}}
                                <div class="flex flex-col items-center gap-3">

                                    <svg class="animate-spin h-8 w-8 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                              d="M4 12a8 8 0 018-8v8z"></path>
                                    </svg>

                                    <p class="text-sm text-gray-600 text-center">
                                        Estamos validando seu pagamento...
                                    </p>

                                    <p class="text-xs text-gray-500 text-center">
                                        Você será redirecionado automaticamente para a validação do seu cartão.
                                    </p>

                                </div>

                            </div>
                        </div>
                    @endif
                @endif
            </h2>
        </div>

        {{-- CARD --}}
        <div class="bg-white border rounded-lg p-6 shadow-sm">

            {{-- ORDER --}}
            <div class="mb-6">
                <span class="block text-sm text-gray-500">
                    Número do Pedido
                </span>
                <span class="text-lg font-semibold text-gray-800">
                    {{ $salesOrder->increment_code }}
                </span>
            </div>

            {{-- INFO GERAL --}}
            <div class="mt-6 space-y-2 text-sm text-gray-600 mb-4">
                <p>
                    A confirmação foi enviada para o e-mail:
                    <span class="font-medium">{{ $salesOrder->customer_email }}</span>
                </p>
                @if($salesOrder->status == 'approved')
                <p>
                    Você receberá um e-mail com os detalhes do pedido e um link para acompanhar a entrega.
                </p>
                @endif
            </div>

            {{-- STATUS SUCCESS --}}
            @if($salesOrder->status == 'approved')
                <div class="bg-green-50 border border-green-200 text-green-700 p-4">

                    <div class="mt-6 space-y-2 text-3xl b-4">
                        <i class="fa-regular fa-circle-check"></i>
                        <span>Pagamento confirmado com sucesso!</span>
                    </div>

                    {{-- SUPORTE --}}
                    <div class="mt-6 bg-blue-50 border border-blue-200 rounded p-4 text-sm text-blue-800">
                        Caso não receba o e-mail, verifique sua caixa de SPAM.
                        Para qualquer dúvida, fale com nosso suporte via WhatsApp clicando
                        <a
                            href="https://wa.me/5511994267313?text={{urlencode('Finalizei a compra no seu site agora, pode me ajudar?')}}"
                            target="_blank"
                            rel="noopener"
                            class="font-semibold text-red-700"
                        >
                            aqui
                        </a>.

                    </div>
                </div>
            @else

                <div class="flex flex-col">

                    {{-- PIX --}}
                    @if($salesOrder->payment_method === 'pix' && !empty($additionalInformation['pix']))

                        <div
                            x-data="pixPayment({
                                pixCode: '{{ $additionalInformation['pix']['qrcode'] ?? '' }}',
                                expireAt: '{{ $additionalInformation['pix']['expires_at'] ?? '' }}',
                                orderId: '{{ $salesOrder->order_id }}'
                            })"
                            class="text-center border rounded-lg p-6 bg-gray-50 w-full md:w-auto"
                        >

                            <h3 class="font-semibold text-lg mb-4">
                                Pagamento via PIX
                            </h3>

                            {{-- QR CODE --}}
                            @if(!empty($additionalInformation['pix']['qrcode_base64']))
                                <div class="flex justify-center mb-4">
                                    <img
                                        src="{{ $additionalInformation['pix']['qrcode_base64'] }}"
                                        class="w-56 h-56"
                                        alt="QR Code PIX">
                                </div>
                            @endif

                            {{-- COPIA E COLA --}}
                            @if(!empty($additionalInformation['pix']['qrcode']))
                                <div class="mb-4">

                                    <label class="block text-sm text-gray-600 mb-2">
                                        Código PIX (Copia e Cola)
                                    </label>

                                    <div class="flex gap-2">

                                        <input
                                            type="text"
                                            :value="pixCode"
                                            readonly
                                            class="w-full border rounded px-3 py-2 text-sm bg-white">

                                        <button
                                            @click="copyPix()"
                                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                            Copiar
                                        </button>

                                    </div>

                                    <p class="text-xs text-gray-500 mt-1">
                                        Dica: copie o código e cole diretamente no app do seu banco.
                                    </p>

                                </div>
                            @endif


                            {{-- TIMER + ALERTA --}}
                            <div class="mt-4">

                                <p class="text-sm text-gray-600" x-show="!expired && expireAt">
                                    Este PIX expira em
                                    <span x-text="timer" class="font-semibold text-red-500"></span>
                                </p>

                                <p class="text-sm text-red-600 font-medium mt-2" x-show="expired">
                                    Este PIX expirou. Atualize a página para gerar um novo pagamento.
                                </p>

                            </div>


                            {{-- INFO --}}
                            <p class="text-sm text-gray-500 mt-4">
                                Após o pagamento, a confirmação será realizada automaticamente.
                            </p>

                        </div>

                    @elseif($salesOrder->payment_method === 'boleto' && !empty($additionalInformation['link']))

                        <div class="text-center border rounded-lg p-6 bg-gray-50 w-full md:w-auto">

                            <h3 class="font-semibold text-lg mb-4">
                                Pagamento via Boleto
                            </h3>
                            <div class="flex justify-center mb-4">
                                <div class="mt-3 space-y-1">
                                    <p>Para imprimir o boleto clique <strong><a href="{{$additionalInformation['link']}}" target="_blank">aqui</a></strong>.</p>
                                    <p>Caso deseje apenas o código de barras do seu boleto segue abaixo</p>

                                    <input
                                        type="text"
                                        value="{{$additionalInformation['digitable_line']}}"
                                        readonly
                                        class="w-full border rounded px-3 py-2 text-sm bg-white">

                                    <button
                                        @click="copyPix()"
                                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                        Copiar
                                    </button>

                                    <p>Seu pedido será aprovado após a compensação do pagamento</p>
                                </div>
                            </div>
                        </div>

                    @endif

                </div>
            @endif
        </div>

        {{-- BOTÃO --}}
        <div class="mt-8 text-center">

            <button
                onclick="window.location='{{ route('index.home') }}'"
                class="bg-gray-900 text-white px-6 py-3 rounded hover:bg-black transition">
                Continuar Comprando
            </button>

        </div>

    </div>
    <script>
        document.addEventListener('alpine:init', () => {

            // Validação do pagamento
            Alpine.data('threeDSWatcher', (orderId) => ({

                interval: null,

                init() {
                    this.startPolling();
                },

                startPolling() {

                    this.interval = setInterval(async () => {

                        try {

                            const response = await fetch(`/payments/status/${orderId}`);
                            const data = await response.json();

                            // 🔥 Se tiver URL 3DS → redireciona
                            if (data.url_3ds) {
                                clearInterval(this.interval);
                                window.location.href = data.url_3ds;
                            }

                            // Se aprovado → pode parar também
                            if (data.status === 'approved') {
                                clearInterval(this.interval);
                                location.reload();
                            }

                        } catch (error) {
                            console.error('Erro ao consultar status', error);
                        }

                    }, 3000); // a cada 3 segundos

                }

            }));

            // Validação e timeout do PIX no Pagamento
            Alpine.data('pixPayment', (config) => ({

                pixCode: config.pixCode,
                expireAt: config.expireAt,
                orderId: config.orderId,

                timer: '',
                expired: false,

                init() {

                    if (this.expireAt) {
                        this.startTimer();
                    }

                    this.startPolling();

                },

                copyPix() {

                    navigator.clipboard.writeText(this.pixCode);

                    alert('Código PIX copiado!');

                },

                startTimer() {

                    const expireDate = new Date(this.expireAt).getTime();

                    setInterval(() => {

                        const now = new Date().getTime();

                        const distance = expireDate - now;

                        if (distance < 0) {

                            this.timer = 'Expirado';
                            this.expired = true;

                            return;

                        }

                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        this.timer = `${minutes}m ${seconds}s`;

                    }, 1000);

                },

                startPolling() {

                    const interval = setInterval(async () => {

                        try {

                            const response = await fetch(`/payments/status/${this.orderId}`);
                            const data = await response.json();

                            switch (data.status) {

                                case 'approved':
                                    clearInterval(interval);
                                    this.handleApproved();
                                    break;

                                case 'canceled':
                                    clearInterval(interval);
                                    this.handleCanceled();
                                    break;

                                case 'expired':
                                    clearInterval(interval);
                                    this.handleExpired();
                                    break;


                            }

                        } catch (e) {

                            console.log('Erro ao verificar status do pagamento');

                        }

                    }, 5000);

                },

                handleApproved() {
                    this.showMessage('Pagamento aprovado! Redirecionando...');
                    setTimeout(() => {
                        window.location.href = '/checkout/onepage/success/id/' + this.orderId;
                    }, 2000);
                },

                handleCanceled() {
                    this.showMessage('Pagamento cancelado. Redirecionando...');
                    setTimeout(() => {
                        window.location.href = '/checkout/onepage/fail';
                    }, 2000);
                },

                handleExpired() {
                    this.showMessage('PIX expirado. Gere um novo pagamento.');
                },

                showMessage(message, type = 'success') {
                    this.statusMessage = message;
                    this.statusType = type;
                }

            }));
        });
    </script>
</x-frontend.app-layout>
