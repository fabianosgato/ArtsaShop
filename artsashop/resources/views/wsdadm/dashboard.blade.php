<x-wsdadm.app-layout>
    <section>

        <x-slot name="header">
            <div class="mx-auto px-8">
                <div class="flex w-full items-center justify-between">

                    {{-- Título --}}
                    <div>
                        <h2 class="text-lg font-bold text-blumine-700">
                            {{ __('Dashboard') }}
                        </h2>
                    </div>

                    {{-- Manual --}}
                    <div>
                        <a
                            href="{{ route('wsdadm.manual') }}"
                            target="_blank"
                            class="inline-flex items-center gap-2 rounded-lg border border-blumine-200
                           bg-white px-4 py-2 text-sm font-medium text-blumine-700
                           transition-colors
                           hover:border-blumine-300 hover:bg-blumine-50"
                        >
                            <svg
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 6.75v13.5m0-13.5A4.5 4.5 0 0 0 7.5 2.25H4.875A1.875 1.875 0 0 0 3 4.125v14.25A1.875 1.875 0 0 0 4.875 20.25H9a3 3 0 0 1 3 3m0-16.5A4.5 4.5 0 0 1 16.5 2.25h2.625A1.875 1.875 0 0 1 21 4.125v14.25a1.875 1.875 0 0 1-1.875 1.875H15a3 3 0 0 0-3 3"
                                />
                            </svg>

                            <span>
                        Manual do sistema
                    </span>
                        </a>
                    </div>

                </div>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="mx-auto sm:px-12 lg:px-8 space-y-12">
            @if($orders['total'] > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            {{ __("Você está logado!") }}
                        </div>
                    </div>
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title text-base">Pedidos de Hoje ({{$orders['dateIni']}} à {{$orders['dateEnd']}})</h5>
                        </div>
                        <div class="card-body">
                            <span class="text-2xl text-emerald-500">Pedidos: {{$orders['total']}}</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-1 gap-12">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            {{ __("Você está logado!") }}
                        </div>
                    </div>
                </div>
            @endif

            </div>
        </div>
    </section>
</x-wsdadm.app-layout>
