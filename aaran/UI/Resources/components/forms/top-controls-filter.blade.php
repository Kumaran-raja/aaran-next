@props([
'showFilters'=>false,
])

<div class="md:flex md:justify-between md:items-center">
    <div class="w-full h-20 md:w-2/4 md:items-center flex md:space-x-2">

        <x-Ui::input.search-box/>
        <x-Ui::input.toggle-filter :show-filters="$showFilters"/>

    </div>

    <div class="flex justify-between items-center  md:space-x-2 md:flex md:items-center">
        <x-Ui::forms.per-page/>
        <x-Ui::button.new-x/>
    </div>
</div>

