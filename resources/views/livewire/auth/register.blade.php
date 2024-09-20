@section('title', 'Register')
<div>
    <div class="flex items-center min-h-screen p-6 bg-primary-500">
        <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl shadow-slate-900">
            <div class="flex flex-col overflow-y-auto md:flex-row">
                <div class="h-32 md:h-auto md:w-1/2">
                    <img aria-hidden="true" class="object-cover w-full h-full"
                        src="{{ getValidValue(setting('registerImage'), asset('images/register.jpg')) }}"
                        alt="Office" />
                </div>
                {{-- form --}}
                <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                    <div class="w-full">
                        {{-- logo ad name --}}
                        <a class="text-lg font-bold text-black dark:text-white" href="{{ route('home') }}">
                            <img src="{{ appLogo() }}" class="w-12 h-12 mx-auto rounded" />
                            <p class="text-center">{{ setting('websiteName') }}</p>
                        </a>
                        <form wire:submit.prevent="register" class="mt-5">
                            @csrf
                            <h1 class="mb-4 text-xl font-semibold text-gray-700">Register</h1>
                            <x-input title="Name" type="text" placeholder="Name" name="name" />
                            <x-input title="Email" type="email" placeholder="info@mail.com" name="email" />
                            <x-phoneselector />
                            <x-input title="Password" type="password" placeholder="***************" name="password" />
                            <x-buttons.primary title="Register" />
                        </form>

                        <p class="flex items-center justify-center mt-4 space-x-2">
                            <span class="font-base">Already have an account?</span>
                            <a class="text-sm font-medium text-primary-600 hover:underline" href="{{ route('login') }}">
                                Login
                            </a>


                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.partials.phoneselector')
