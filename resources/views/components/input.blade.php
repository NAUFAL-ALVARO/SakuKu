<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
            @if($required)
                <span class="text-rose-500">*</span>
            @endif
        </label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm']) }}
    >

    @error($name)
        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>