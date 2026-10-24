<div class="grid grid-cols-8">
    <!-- Ocupa 2 de 8 -->
    <div class="col-span-2 bg-blumine-400 dark:bg-blumine-600 ">
        <livewire:catalog::categories.categories-tree />
    </div>
    <!-- Ocupa as 6 restantes (2 + 6 = 8) -->
    <div class="col-span-6">
{{--        <livewire:catalog::categories.categories-form--}}
{{--            :category-id="$categoryId"--}}
{{--            :wire:key="'category-form-'.$categoryId"--}}
{{--        />--}}

        <livewire:catalog::categories.categories-form
            :params="[
                'categoryId' => $categoryId,
            ]"
            :wire:key="'category-form-'.$categoryId"
        />
    </div>
</div>
