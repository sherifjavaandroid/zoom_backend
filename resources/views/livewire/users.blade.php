@section('title', 'Users')
<div>

    <x-baseview title="Users">
        <livewire:tables.user-table />
    </x-baseview>

    <div x-data="{ open: @entangle('showCreate') }">
        <x-modal confirmText="Save" action="save">
            <p class="text-xl font-semibold">Create User Account</p>
            <x-input title="Name" name="name" placeholder="John Doe" />
            <x-input title="Email" name="email" placeholder="info@mail.com" />
            <x-phoneselector />
            <x-input title="Login Password" name="password" type="password" placeholder="**********************" />
            <x-select title="Role" :options='$roles' name="role" />
        </x-modal>
    </div>

    <div x-data="{ open: @entangle('showEdit') }">
        <x-modal confirmText="Update" action="update">

            <p class="text-xl font-semibold">Edit User Account</p>
            <x-input title="Name" name="name" placeholder="John Doe" />
            <x-input title="Email" name="email" placeholder="info@mail.com" />
            <x-phoneselector inputId="phoneEdit" />
            <x-input title="Login Password" name="password" type="password" placeholder="**********************" />
            <x-select title="Role" :options='$roles' name="role"
                selected="{{ !empty($selectedModel) ? $selectedModel->role_id : '' }}" />

        </x-modal>
    </div>
</div>
@include('layouts.partials.phoneselector')
