@section('title', 'History')
<div>

    <x-baseview title="History">

        <livewire:tables.history-table />

    </x-baseview>

    <div x-data="{ open: @entangle('showEdit') }">
        <x-modal confirmText="Update" action="update">

            <p class="text-xl font-semibold">Edit Meeting</p>
            <x-input title="Meeting Title" name="meetingTitle" />
            <x-input title="Meeting ID" name="meetingID" />
            <x-checkbox title="Public" description="Make meeting public, anyone with meeting ID can join" name="meetingPulbic" value="{{ $meetingPulbic ?? '0' }}" />

            <x-media-upload
                title="Meeting Banner"
                name="photo"
                preview="{{ $selectedModel != null ? $selectedModel->getFirstMediaUrl() : '' }}"
                :photo="$photo"
                :photoInfo="$photoInfo"
                types="PNG or JPEG"
                rules="image/*" />

        </x-modal>
    </div>
</div>
