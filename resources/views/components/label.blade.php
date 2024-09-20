<label class="block {{ $noMargin ?? false ? '' : 'mt-4' }} text-sm">
    <p class="mb-1 text-gray-700">{{ $title ?? '' }}</p>
    {{ $slot ?? '' }}
</label>
