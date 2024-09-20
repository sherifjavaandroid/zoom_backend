<div>



    <x-form action="saveMeetingSetting" :noStyle="true">

        <div class="w-full md:w-4/5 lg:w-5/12">

            <x-checkbox title="Mandatory Login" description="Must Login To Create or Join Meeting" name="mandatoryLogin"
                :defer="false" />
            <x-checkbox title="Unauthorized Meeting ID" description="Allow users join meeting created outside app"
                name="unauthorizedMeeting" :defer="false" />
            {{-- meeting jitsi server --}}
            <x-input title="Jitsi Server" name="jitsi_meeting_domain" />
            <a href="https://jitsi.github.io/handbook/docs/community/community-instances/" target="_blank"
                class="underline text-primary-400 text-sm italic">
                List of free jitsi servers
            </a>
            {{-- meeting prefix id --}}
            <div class="flex items-end justify-start">
                <x-input title="Meeting Prefix ID" name="meeting_prefix_id" />
                {{-- gen button --}}
                <button type="button" class="border rounded px-4 h-10 mt-4" wire:click="generateMeetingPrefix">
                    <x-heroicon-o-arrow-path class="w-5 h-5" />
                </button>
            </div>

            <x-buttons.primary title="Save Changes" />
        </div>
    </x-form>



</div>
