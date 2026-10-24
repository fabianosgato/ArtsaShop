<div class="mx-auto px-8 py-4">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-blumine-700">
                {{ $title }}
            </h2>
        </div>
        @if($buttonInsert)
            <div class="md:text-right">
                <a href="{{ route($actionInsert) }}" class="btn btn-forms">Inserir</a>
            </div>
        @endif
    </div>
</div>
