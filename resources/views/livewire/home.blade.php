@section('title', 'Join Meeting')
<div>
    <div class="flex items-center min-h-screen p-6 bg-primary-500 ">
        <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl ">
            <div class="flex flex-col overflow-y-auto md:flex-row">
                <div class="h-32 md:h-auto md:w-1/2">
                    <img aria-hidden="true" class="object-cover w-full h-full"
                        src="{{ getValidValue(setting('loginImage'), asset('images/home.jpg')) }}" alt="Office" />
                </div>
                {{-- form --}}
                <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2" x-data="{ host: false }">
                    <div class="w-full">

                        {{--  --}}
                        <a class="text-lg font-bold text-black dark:text-white" href="{{ route('home') }}">
                            <img src="{{ appLogo() }}" class="w-12 h-12 mx-auto rounded" />
                            <p class="text-center">{{ setting('websiteName') }}</p>
                        </a>
                        {{-- button group --}}
                        <div class="mb-6">
                            <div class="flex items-center justify-center mb-4 space-x-4" x-show="!host">
                                <x-buttons.primary title="Join Meeting" onClick="host = false"
                                    class=" hover:text-white" />
                                <x-buttons.outline title="Host Meeting" onClick="host = true"
                                    class=" hover:text-white" />
                            </div>
                            <div class="flex items-center justify-center mb-4 space-x-4" x-show="host">
                                <x-buttons.outline title="Join Meeting" onClick="host = false"
                                    class=" hover:text-white" />
                                <x-buttons.primary title="Host Meeting" onClick="host = true"
                                    class=" hover:text-white" />
                            </div>
                        </div>

                        {{-- join meeting --}}
                        <form wire:submit.prevent="join" x-show="!host">
                            <x-input title="Meeting ID" placeholder="Enter Meeting ID" name="meetingid" />
                            <x-buttons.primary title="Join Now" />
                        </form>

                        {{-- host meeting --}}
                        <form wire:submit.prevent="host" x-show="host">
                            <x-input title="Meeting Title(Optional)" placeholder="Enter Meeting Title"
                                name="meetingTitle" />
                            <div class="flex items-end gap-2">
                                <div class="w-full">
                                    <x-input title="Meeting ID" placeholder="Enter Meeting ID" name="newMeetingid" />
                                </div>
                                <div class="w-2/12">
                                    <x-buttons.outline wireClick="generateMeetingID" type="button">
                                        <x-heroicon-o-arrow-path class="w-5 h-5" />
                                    </x-buttons.outline>
                                    {{-- to prevent icon to properly set when there is an error --}}
                                    @error('newMeetingid')
                                        <div class="h-4 mt-1 text-xs"></div>
                                    @enderror
                                </div>
                            </div>
                            <p class="mt-4 text-xs text-red-500">NOTE: All create meeting here is made public. SignIn to
                                create private meetings</p>
                            <p class="flex items-center justify-end mt-2">

                            </p>
                            <x-buttons.primary title="Create & Join Now" />
                        </form>

                        {{-- show login or signup whenn not auth --}}
                        <hr class="my-5" />
                        <p class="flex items-center justify-center gap-5 mt-4">
                            @auth

                                @role('admin')
                                    <a class="mx-auto text-sm font-medium text-center text-primary-600 hover:underline"
                                        href="{{ route('dashboard') }}">
                                        Dashboard
                                    </a>
                                @else
                                    <a class="mx-auto text-sm font-medium text-center text-primary-600 hover:underline"
                                        href="{{ route('lounge') }}">
                                        Lounge
                                    </a>
                                    |
                                    <a class="mx-auto text-sm font-medium text-center text-primary-600 hover:underline"
                                        href="{{ route('history') }}">
                                        history
                                    </a>
                                @endrole
                            @else
                                <a class="text-sm font-medium text-primary-600 hover:underline" href="{{ route('login') }}">
                                    Login
                                </a>
                                |
                                <a class="text-sm font-medium text-primary-600 hover:underline"
                                    href="{{ route('register') }}">
                                    Signup
                                </a>


                            @endauth
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
