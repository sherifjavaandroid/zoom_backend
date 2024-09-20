@section('title', 'Settings')
<div>

    <x-baseview title="Settings">

        <x-tab.tabview class="shadow pb-10">

            <x-slot name="header">
                <x-tab.header tab="1" title="{{ __('App Settings') }}" />
                <x-tab.header tab="2" title="{{ __('Firebase') }}" />
                <x-tab.header tab="3" title="{{ __('Meeting Settings') }}" />
                <x-tab.header tab="4" title="{{ __('AI Settings') }}" />
                <x-tab.header tab="5" title="{{ __('Admob') }}" />
            </x-slot>

            <x-slot name="body">
                <x-tab.body tab="1">
                    <livewire:settings.general />
                </x-tab.body>
                <x-tab.body tab="2">
                    <livewire:settings.firebase />
                </x-tab.body>
                <x-tab.body tab="3">
                    <livewire:settings.meeting />
                </x-tab.body>
                <x-tab.body tab="4">
                    <livewire:settings.aisetting />
                </x-tab.body>
                <x-tab.body tab="5">
                    <livewire:settings.admob />
                </x-tab.body>
            </x-slot>
        </x-tab.tabview>
    </x-baseview>


</div>
