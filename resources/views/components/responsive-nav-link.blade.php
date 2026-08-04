@props(['active' => false, 'icon' => null])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-3 w-full ps-3 pe-4 py-2 rounded-lg bg-blue-50 text-blue-600 font-medium text-sm transition duration-150 ease-in-out'
            : 'flex items-center gap-3 w-full ps-3 pe-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-800 font-medium text-sm transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        <span class="w-4 h-4 shrink-0">{!! $icon !!}</span>
    @endif
    {{ $slot }}
</a>