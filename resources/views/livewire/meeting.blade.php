@section('title', 'Meeting Room')

<div wire:init="loadMeeting">
    @empty($errorMessage)
        <div wire:loading.remove>
            <div id="meeting" class="w-full h-screen"></div>
        </div>
    @else
        <div class="my-40 text-3xl text-center">
            <div class="flex justify-center">
                <x-heroicon-o-no-symbol class="w-20 h-20 my-3 text-red-600" />
            </div>
            <p>{{ $errorMessage }}</p>
        </div>
    @endempty

    @push('scripts')
        <script src='https://meet.jit.si/external_api.js'></script>
        <script src="{{ asset('js/meeting.js') }}"></script>
    @endpush


    <x-loading />
</div>
