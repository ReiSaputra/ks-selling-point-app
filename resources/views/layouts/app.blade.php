@include('parts.header')
@include('parts.navbar')
@include('parts.sidebar')

<main class="app-main">
    @yield('content')
</main>

@include('parts.footer')
