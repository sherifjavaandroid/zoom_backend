@php
    $currentRoute = Route::currentRouteName();
    $isActive = $currentRoute == $route;
@endphp
<li class="relative px-6 py-3">

    @if ( $isActive )
        <span class="absolute inset-y-0 left-0 w-1 bg-white rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
    @endif

  <a
    class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-100 {{ $isActive ? 'text-white':'text-gray-300' }}"
    href="{{  $rawRoute ?? route($route) ?? '#' }}">
    {{ $slot ?? '' }}
    <span class="ml-4">{{ $title }}</span>
  </a>


</li>
