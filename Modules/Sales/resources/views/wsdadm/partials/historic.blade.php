@if ($historics != null)
<section>
    <div class="bg-white p-6 rounded-lg shadow-lg text-primary-500">
        <h2 class="text-xl font-semibold mb-4 text-blumine-700">Histórico do Pedido</h2>
        <div class="mb-4">
            <ol class="flex list-decimal flex-col">
                @foreach ($historics as $historic)
                    <li class="flex items-center gap-2 border-b border-gray-200 px-3 py-2.5 text-sm text-gray-500 last:border-b-0 dark:border-gray-800 dark:text-gray-400">
                        <span><strong>{{ \Carbon\Carbon::parse($historic['created_at'])->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i:s') }}</strong>: {{ $historic['description'] }}</span>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>

</section>
@endif
