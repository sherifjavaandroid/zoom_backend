@section('title', 'Dashboard')
<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <x-baseview title="Dashboard">

        {{-- Info cards --}}
        <div class="grid gap-6 mt-10 md:grid-cols-2 lg:grid-cols-4">

            {{-- Meetings --}}
            <x-dashboard-card bg="bg-primary-100" title="HOST MEETING (TODAY)" value="{{ $hostedMeetings }}">
                <x-heroicon-s-video-camera class="w-16 text-primary-600" />
            </x-dashboard-card>

            {{-- Public Meetings --}}
            <x-dashboard-card bg="bg-blue-100" title="PUBLIC MEETING (TODAY)" value="{{ $publicMeetings }}">
                <x-heroicon-s-chat-bubble-left-right class="w-16 text-primary-600" />
            </x-dashboard-card>

            {{-- Total Meetings --}}
            <x-dashboard-card bg="bg-red-100" title="TOTAL MEETINGS" value="{{ $totalMeetings }}">
                <x-heroicon-s-rectangle-stack class="w-16 text-primary-600" />
            </x-dashboard-card>

            {{-- Users --}}
            <x-dashboard-card bg="bg-yellow-100" title="TOTAL USERS" value="{{ $totalUsers }}">
                <x-heroicon-s-users class="w-16 text-primary-600" />
            </x-dashboard-card>
        </div>

        {{-- Charts --}}
        <div class="grid gap-6 mt-10 mb-20 lg:grid-cols-2">

            {{-- Meetings --}}
            <x-dashboard-chart>
                <livewire:livewire-column-chart :column-chart-model="$hostedMeetingChart" />
            </x-dashboard-chart>

            {{-- Users --}}
            <x-dashboard-chart>
                <livewire:livewire-column-chart :column-chart-model="$usersChart" />
            </x-dashboard-chart>

            {{-- Total Meetings --}}
            <x-dashboard-chart>
                <livewire:livewire-pie-chart :pie-chart-model="$totalMeetingChart" />
            </x-dashboard-chart>

            {{-- Users --}}
            <x-dashboard-chart>
                <livewire:livewire-pie-chart :pie-chart-model="$totalUsersChart" />
            </x-dashboard-chart>


        </div>

    </x-baseview>
</div>
@push('scripts')
    @livewireChartsScripts
@endpush
