@props([
'show',
'maxWidth' => 'max-w-md',
'requireSelected' => false,
'selectedExpr' => 'selected',
])

<div x-show="{{ $show }}" x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4"
    x-transition.opacity>

    <div @click.outside="{{ $show }} = false"
        {{ $attributes->merge(['class' => "bg-[#1c1f2a] w-full {$maxWidth} rounded-xl border border-gray-800 p-6 max-h-[90vh] overflow-y-auto"]) }}
        @if($requireSelected) x-show="{{ $selectedExpr }}" @endif>
        {{ $slot }}
    </div>

</div>