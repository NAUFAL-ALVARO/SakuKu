@php
    $variantClasses = match($variant) {
        'income' => 'border-l-4 border-emerald-500 bg-emerald-50/50',
        'expense' => 'border-l-4 border-rose-500 bg-rose-50/50',
        default => 'border border-gray-200 bg-white',
    };
@endphp

<div {{ $attributes->merge(['class' => "rounded-xl shadow-sm p-5 $variantClasses"]) }}>
    @if($title)
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-sm font-medium text-gray-500">{{ $title }}</h3>
            @if($icon)
                <span class="text-gray-400">{!! $icon !!}</span>
            @endif
        </div>
    @endif

    <div class="text-gray-800">
        {{ $slot }}
    </div>
</div>