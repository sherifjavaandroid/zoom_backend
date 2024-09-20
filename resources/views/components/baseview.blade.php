<div class="px-16">
    <p class="text-2xl font-semibold">{{ $title ?? 'List' }}</p>
    {{-- list --}}
    {{ $slot }}

    <x-loading />
</div>
