<div>
    <x-label :title="$title" :noMargin="$noMargin ?? false" />
    <div class="relative inline-block w-full">
        <select
            class="block w-full px-4 py-3 border rounded appearance-none bg-grey-lighter text-grey-darker border-grey-lighter"
            name="{{ $name ?? '' }}" wire:model='{{ $name ?? '' }}'>
            @foreach ($options as $option)
                @php
                    $optionId = $option->id ?? $option['id'];
                @endphp
                <option value="{{ $optionId }}" {{ $selected ?? '' == $optionId ? 'selected' : '' }}>
                    {{ Str::ucfirst($option->name ?? $option['name']) }}</option>
            @endforeach
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 pointer-events-none">
            <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
            </svg>
        </div>
    </div>

</div>
