<div
    {{-- ADICIONADO: Inicializa um componente AlpineJS para controlar o sortable --}}
    x-data="{
        initSortable() {
            const el = this.$refs.sortableContainer;
            new Sortable(el, {
                animation: 150,
                ghostClass: 'bg-blue-100',

                // ADICIONADO: O evento que é disparado ao final da reordenação
                onEnd: (evt) => {
                    // Pega todos os itens ordenados e extrai seus IDs do atributo 'data-id'
                    const newOrder = Array.from(el.children).map(item => {
                        return item.getAttribute('data-id');
                    });

                    // A URL para onde o POST será enviado
                    const postUrl = '{{route('wsdadm.catalog.products.reorderImages')}}';

                    // Faz a chamada AJAX usando fetch()
                    fetch(postUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            // IMPORTANTE: Enviar o token CSRF do Laravel
                            'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                        },
                        body: JSON.stringify({
                            // Enviamos um array de IDs na ordem correta
                            ordered_ids: newOrder
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Ordem atualizada com sucesso:', data);
                        // Opcional: você pode mostrar uma notificação de sucesso aqui
                    })
                    .catch(error => {
                        console.error('Erro ao atualizar a ordem:', error);
                        // Opcional: mostrar uma notificação de erro
                    });
                }
            });
        }
    }"
    x-init="initSortable()"
>

    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Atenção:</strong> Ao subir novas imagens, as atuais (abaixo) serão excluídas
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    {{-- REMOVIDO: A diretiva wire:sortable foi removida para dar lugar ao controle via JS --}}
    <div class="grid grid-cols-3 gap-3" x-ref="sortableContainer">
        @foreach ($getImages() as $image)
            {{--
                REMOVIDO: wire:sortable.item e wire:key
                ADICIONADO: data-id para que o JavaScript possa identificar cada item
            --}}
            <div class="bg-white rounded shadow p-2 cursor-move border"
                 data-id="{{ $image['media_id'] }}">
                <img src="{{ $image['media_url'] }}" class="w-full h-auto"/>
            </div>
        @endforeach
    </div>
</div>

@pushOnce('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
@endPushOnce
