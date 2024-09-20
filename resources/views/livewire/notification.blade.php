@section('title', 'Notification')
<div>

    <x-baseview title="Send Notification" showButton="true">

        <x-form backPressed="" action="sendNotification">

            <div class="w-full md:w-4/5 lg:w-5/12">
                <x-input title="Title" name="headings" />
                <x-label title="Message" />
                <textarea wire:model.defer="message" class="w-full h-40 p-2 mt-1 border rounded"></textarea>
                @error('message')
                    <span class="mt-1 text-xs text-red-700">{{ $message }}</span>
                @enderror
                <x-buttons.primary title="Send Notification" />
            <div>

        </x-form>

    </x-baseview>


</div>


