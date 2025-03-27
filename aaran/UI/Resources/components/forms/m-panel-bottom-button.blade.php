@props([
    'save'=>false,
    'back'=>false,
    'print'=>false,
    'active'=>false,
    'routes' => '/',

])
<div class="sm:px-8 px-2 border border-gray-100 border-t-0 bg-zinc-50 rounded-b-md shadow-lg w-full">
    <div class="flex flex-row justify-between py-4 gap-3" >
        <div class="flex flex-wrap  gap-3">
            @if($active)
                <x-aaran-ui::button.active/>
            @endif
            <div>
                @if($print)
{{--                    <x-button.print/>--}}
                    <x-aaran-ui::button.print-x href="{{$routes}}"  />
                @endif
            </div>
        </div>
        <div class="flex flex-wrap gap-3 justify-end ">

            @if($save)

{{--                <x-button.save/>--}}
                <x-aaran-ui::button.save-x wire:click.prevent="save" />
            @endif
            @if($back)

{{--                <x-button.back/>--}}
                <x-aaran-ui::button.back-x wire:click="getRoute" />
            @endif
            <div>
                {{$slot}}
            </div>
        </div>
    </div>
</div>
