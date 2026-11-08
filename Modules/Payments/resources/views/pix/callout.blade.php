<div role="alert" class="border border-blue-200 bg-blue-50 rounded-lg p-4 text-sm space-y-4">

    <div class="flex items-start gap-2 text-blue-900 font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>Pagamento via PIX</span>
    </div>

    <ul class="list-disc pl-5 space-y-1 text-gray-700">
        <li>O pagamento deve ser realizado por conta bancária de sua titularidade.</li>
        <li>O CPF informado será utilizado como responsável legal pela compra.</li>
    </ul>

    <div class="text-xs text-gray-500">
        Ao concluir o pagamento, você concorda com os termos acima.
    </div>

    {{-- QR Code e Código PIX --}}
    @if(!empty($pix) && !empty($pix['qrcode_base64']))
        <div class="space-y-4 border-t border-blue-200 pt-4">
            <h4 class="font-semibold text-gray-800">QR Code para Pagamento</h4>
            
            <div class="text-center">
                <img 
                    src="{{ $pix['qrcode_base64'] }}" 
                    alt="QR Code PIX"
                    class="mx-auto border rounded-lg p-2 bg-white max-w-[280px]"
                    width="280"
                    height="280"
                >
            </div>

            {{-- Código PIX (Copia e Cola) --}}
            @if(!empty($pix['qrcode']))
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Código PIX (Copia e Cola)</label>
                    <div class="relative">
                        <textarea 
                            readonly 
                            class="w-full h-20 bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono text-gray-800 resize-none"
                            onclick="this.select()"
                        >{{ $pix['qrcode'] }}</textarea>
                        <button 
                            type="button"
                            onclick="navigator.clipboard.writeText('{{ $pix['qrcode'] }}').then(() => { 
                                const btn = this; 
                                btn.textContent = 'Copiado!'; 
                                setTimeout(() => btn.textContent = 'Copiar', 2000); 
                            })"
                            class="absolute right-2 bottom-2 text-xs text-blue-600 hover:underline"
                        >
                            Copiar
                        </button>
                    </div>
                    <p class="text-xs text-gray-500">Clique em "Copiar" ou selecione o texto acima</p>
                </div>
            @endif

            {{-- Link do QR Code --}}
            @if(!empty($pix['link']))
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Link do QR Code</label>
                    <a 
                        href="{{ $pix['link'] }}" 
                        target="_blank" 
                        class="text-sm text-blue-600 hover:underline break-all"
                    >
                        {{ $pix['link'] }}
                    </a>
                </div>
            @endif

            {{-- Expiração --}}
            @if(!empty($pix['expires_at']))
                <div class="text-sm text-gray-600">
                    <strong>Expira em:</strong> 
                    <span x-data="{ expires: '{{ $pix['expires_at'] }}' }" 
                          x-text="new Date(expires).toLocaleString('pt-BR')"></span>
                </div>
            @endif
        </div>
    @endif

    @if(empty($pix) || empty($pix['qrcode_base64']))
        <div class="border-t border-blue-200 pt-4 text-center text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            <p class="mt-2">Aguardando geração do QR Code PIX...</p>
        </div>
    @endif

</div>