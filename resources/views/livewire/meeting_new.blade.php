@section('title', 'New Meeting')
<div>

    <x-baseview title="Create New Meeting">

        <form wire:submit.prevent="save">
            <div class="px-4 pt-5 pb-4 my-5 mr-auto bg-white shadow sm:p-6 sm:pb-4 lg:w-6/12">
                <p class="text-xl font-semibold">Start new Meeting</p>
                <x-input title="Meeting Title" name="meetingTitle" />
                <div class="flex items-end justify-start">
                    <div>
                        <div class="border rounded px-2 h-10 mt-4 my-auto text-center justify-center items-center flex">
                            <p>{{ setting('meeting_prefix_id') }}</p>
                        </div>
                        @error('meetingID')
                            <div class="h-5"></div>
                        @enderror
                    </div>
                    <div>
                        <x-input title="Meeting ID" name="meetingID" />
                    </div>
                </div>
                <x-checkbox title="Public" description="Make meeting public, anyone with meeting ID can join"
                    name="meetingPulbic" value="{{ $meetingPulbic }}" />

                <x-media-upload title="Meeting Banner" name="photo" :photo="$photo" :photoInfo="$photoInfo"
                    types="PNG or JPEG" rules="image/*" />

                {{-- actions --}}
                <div class="flex justify-end py-3 mt-4 sm:px-6 md:px-0">
                    <button type="submit"
                        class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white border border-transparent rounded-md shadow-sm bg-primary-500 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                        <x-heroicon-o-video-camera class="w-5 h-5 mr-2" /> Create Meeting
                    </button>
                </div>
            </div>
        </form>

    </x-baseview>


</div>
