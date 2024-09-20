<button class="flex items-center p-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red" wire:click="initiateDelete({{ $model->id ?? $id ?? '' }})">
    <x-heroicon-o-trash class="w-4 h-4 mr-1" /> Delete
</button>
