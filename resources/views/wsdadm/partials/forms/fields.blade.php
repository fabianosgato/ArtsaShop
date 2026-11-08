<x-slot name="header">
    <div class="mx-auto px-8 space-y-6">
        <div class="navbar">
            <div class="flex-1">
                <h2 class="text-bold text-lg text-blumine-700 dark:text-gray-200">{{ $this->getTitle() }}</h2>
            </div>
        </div>
    </div>
</x-slot>
<div class="mx-auto sm:px-6 lg:px-8 space-y-6 pb-15">
    @include('wsdadm.layouts.flash-messages')
    <form wire:submit="save">
        <p class="text-bold text-sm text-blumine-700 dark:text-gray-200">{{ $this->getDescription() }}</p>
        <div class="mt-4">
            {{ $this->form }}
        </div>
    </form>
</div>
