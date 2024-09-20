<aside class="z-20 flex-shrink-0 hidden w-64 overflow-y-auto bg-primary-500 md:block">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="flex items-center ml-6 text-lg font-bold text-gray-200 " href="{{ route('home') }}">
            <img src="{{ appLogo() }}" class="w-16 h-16 mr-5" />
            <div>
                <p>{{ setting('websiteName') }}</p>
                <p class="text-xs text-gray-100">version {{ setting('appVerison', '1.0.0') }}</p>
            </div>
        </a>
        @include('layouts.partials.nav.menu')
    </div>
</aside>
