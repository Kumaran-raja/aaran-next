@props([
    'label' => ''
])
<label for="defaultToggle" class="inline-flex cursor-pointer items-center gap-3">
    <input id="defaultToggle" type="checkbox" class="peer sr-only" role="switch" checked  />
    <span class="trancking-wide text-sm font-medium text-slate-700 peer-checked:text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70 dark:text-slate-300 dark:peer-checked:text-white">{{$label}}</span>
    <div class="relative h-6 w-11 after:h-5 after:w-5 peer-checked:after:translate-x-5 rounded-full border border-slate-300 bg-slate-100 after:absolute after:bottom-0 after:left-[0.0625rem] after:top-0 after:my-auto
    after:rounded-full after:bg-slate-700 after:transition-all after:content-[''] peer-checked:bg-blue-700
    peer-checked:after:bg-slate-100 peer-focus:outline peer-focus:outline-2
    peer-focus:outline-offset-2 peer-focus:outline-slate-800 peer-focus:peer-checked:outline-blue-700
    peer-active:outline-offset-0 peer-disabled:cursor-not-allowed peer-disabled:opacity-70 dark:border-slate-700
    dark:bg-slate-800 dark:after:bg-slate-300 dark:peer-checked:bg-blue-600 dark:peer-checked:after:bg-slate-100
    dark:peer-focus:outline-slate-300 dark:peer-focus:peer-checked:outline-blue-600" aria-hidden="true"></div>
</label>

