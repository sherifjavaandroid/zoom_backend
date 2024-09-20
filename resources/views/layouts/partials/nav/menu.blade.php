<ul class="mt-6">


    <a href="{{ route('meeting.new') }}"
        class="flex items-center justify-center p-3 mx-3 my-5 bg-white border rounded-full shadow cursor-pointer hover:bg-primary-500 hover:text-white">
        <x-heroicon-o-video-camera class="w-5 h-5 mr-2" /> <span> New Meeting</span>
    </a>
    @role('admin')
        {{-- dashboard --}}
        <x-menu-item title="Dashboard" route="dashboard">
            <x-heroicon-o-squares-2x2 class="w-5 h-5" />
        </x-menu-item>

        {{-- Users --}}
        <x-menu-item title="Users" route="users">
            <x-heroicon-o-user-group class="w-5 h-5" />
        </x-menu-item>
    @endrole

    {{-- history --}}
    <x-menu-item title="History" route="history">
        <x-heroicon-o-rectangle-stack class="w-5 h-5" />
    </x-menu-item>

    {{-- lounge --}}
    <x-menu-item title="Lounge" route="lounge">
        <x-heroicon-o-user-group class="w-5 h-5" />
    </x-menu-item>

    @role('admin')
        {{-- meetinngs --}}
        <x-menu-item title="Meetings" route="meetings">
            <x-heroicon-o-video-camera class="w-5 h-5" />
        </x-menu-item>

        {{-- notifications --}}
        <x-menu-item title="Notifications" route="notification.send">
            <x-heroicon-o-bell class="w-5 h-5" />
        </x-menu-item>

        {{-- backups --}}
        <x-menu-item title="Backup" route="backups">
            <x-heroicon-o-circle-stack class="w-5 h-5" />
        </x-menu-item>


        {{-- Settings --}}
        <x-menu-item title="Settings" route="settings">
            <x-heroicon-o-cog class="w-5 h-5" />
        </x-menu-item>

        {{-- Settings --}}
        <x-menu-item title="Privacy Settings" route="settings.privacy">
            <x-heroicon-o-eye-slash class="w-5 h-5" />
        </x-menu-item>

        <hr class="my-2 border-gray-700" />
        {{-- upgrade --}}
        <x-menu-item title="Upgrade" route="upgrade">
            <x-heroicon-o-cloud-arrow-up class="w-5 h-5" />
        </x-menu-item>
    @endrole







</ul>
