@include('layouts.header')

@include('layouts.navbar')
@include('layouts.sidebar')
<main class="app-main"> <!--begin::App Content Header-->
    @yield('content')
</main> <!--end::App Main--> <!--begin::Footer-->
@include('layouts.footer')
