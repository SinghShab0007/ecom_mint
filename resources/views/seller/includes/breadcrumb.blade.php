<div class="container">
    <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
            @hasSection('title')
                <h6 class="d-inline-block mb-0">@yield('title')</h6>
            @elseif(isset($title))
                <h6 class="d-inline-block mb-0">{{ $title }}</h6>
            @endif
        </div>
        <div class="col-lg-6 col-5 text-right">
            @yield('actions')
        </div>
    </div>
</div>