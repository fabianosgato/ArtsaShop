@if ($tracking != null)
<section>
    <div class="bg-white p-6 rounded-lg shadow-lg text-primary-500">
        <h2 class="text-xl font-semibold mb-4 text-blumine-700">Envio e Entrega</h2>
        <div class="mb-4">
            <span class="font-bold">Código:</span> {{ $tracking['tracking_code'] }}
        </div>
        <div class="mb-4">
            <span class="font-bold">Rastreio:</span> <a href="{{ $tracking['url'] }}" target="_blank"><span class="text-blumine-500">{{ $tracking['url'] }}</span></a></a>
        </div>
        <div class="mb-4">
            <span class="font-bold">Carrier:</span> {{ $tracking['carrier'] }}
        </div>
    </div>

</section>
@endif
