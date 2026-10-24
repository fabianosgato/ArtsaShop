<form wire:submit.prevent="save">
    <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6 shadow {{ isset($actions) ? '' : '' }}">
        {{ $this->form }}
    </div>
    <div class="flex items-center justify-end px-4 py-3 bg-gray-50 dark:bg-gray-700/20 text-right sm:px-6 shadow">
        <x-filament::button type="submit">
            Salvar
        </x-filament::button>
    </div>
</form>
