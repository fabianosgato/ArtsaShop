@if ($tracking != null)
<section>
    <div class="bg-white p-6 rounded-lg shadow-lg text-primary-500">
        <h2 class="text-xl font-semibold mb-4 text-blumine-700">Envio e Entrega</h2>
        <div class="mb-4">
            <span class="font-bold">Status Atual:</span> {{ $tracking['descricaoStatus'] }}
        </div>

        <div class="mb-4">
            <span class="font-bold">Código:</span> {{ $tracking['tracking']['tracknumber'] }}
        </div>
        <div class="mb-4">
            <span class="font-bold">Rastreio:</span> <a href="{{ $tracking['tracking']['url'] }}" target="_blank"><span class="text-blumine-500">{{ $tracking['tracking']['url'] }}</span></a></a>
        </div>
        <div class="mb-4">
            <h4 class="font-bold">Histórico</h4>
            <ol class="flex list-decimal flex-col">
                @foreach ($tracking['rastreio'] as $rastreio)
                    <li class="flex items-center gap-2 border-b border-gray-200 px-3 py-2.5 text-sm text-gray-500 last:border-b-0 dark:border-gray-800 dark:text-gray-400">
                    @if($rastreio['correiosStatus'] == null)
                        <strong>{{ \Carbon\Carbon::parse($rastreio['updated'])->format('d/m/Y') }}</strong> {{ $rastreio['status'] }}
                    @else
                        <strong>{{ \Carbon\Carbon::parse($rastreio['updated'])->format('d/m/Y') }}</strong> {{strip_tags($rastreio['correiosStatus'])}}
                    @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
@endif
