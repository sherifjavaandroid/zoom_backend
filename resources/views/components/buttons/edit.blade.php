<button
    class="flex items-center p-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray"
    wire:click="$emit('initiateEdit', {{ $model->id }} ) "
    >
    <x-heroicon-o-pencil class="w-4 h-4 mr-1" /> Edit
</button>
