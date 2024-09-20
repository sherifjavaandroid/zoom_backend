@section('title', 'Meetings')
<div>

    <x-baseview title="Meetings">

        <livewire:tables.meeting-table />

    </x-baseview>

    <div x-data="{ open: @entangle('showCreate') }">
        <x-modal confirmText="Save" action="save">
            <p class="text-xl font-semibold">Create Meeting</p>
            <x-input title="Meeting Title" name="meetingTitle" />
            <x-input title="Meeting ID" name="meetingID" />
            <x-checkbox title="Public" description="Make meeting public, anyone with meeting ID can join" name="meetingPulbic" />

            <x-media-upload
                title="Meeting Banner"
                name="photo"
                :photo="$photo"
                :photoInfo="$photoInfo"
                types="PNG or JPEG"
                rules="image/*" />
        </x-modal>
    </div>

    <div x-data="{ open: @entangle('showEdit') }">
        <x-modal confirmText="Update" action="update">

            <p class="text-xl font-semibold">Edit Meeting</p>
            <x-input title="Meeting Title" name="meetingTitle" />
            <x-input title="Meeting ID" name="meetingID" />
            <x-checkbox title="Public" description="Make meeting public, anyone with meeting ID can join" name="meetingPulbic" />

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
