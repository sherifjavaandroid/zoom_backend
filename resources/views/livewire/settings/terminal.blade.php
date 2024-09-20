@section('title', 'Settings')
<div>

    <x-baseview title="System Update">

        <div class="grid grid-cols-1 gap-6 mt-10 md:grid-cols-2 lg:grid-cols-3">

            {{-- update --}}
            <x-settings-item title="Update System" wireClick="upgradeAppSystem">
                <x-heroicon-o-cloud-arrow-up class="w-5 h-5 mr-4" />
            </x-settings-item>

            {{-- terminal --}}
            <x-settings-item title="Terminal" wireClick="appSettings">
                <x-heroicon-o-command-line class="w-5 h-5 mr-4" />
            </x-settings-item>

        </div>

    </x-baseview>

</div>
