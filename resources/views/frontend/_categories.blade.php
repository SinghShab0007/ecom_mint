<!-- Categories Start -->
<section class="categories">
    <div class="container">
        <div class="main-title">
            <div class="row align-items-center">
                <div class="col-sm-8 col-md-9">
                    <h4>{{ __('CATEGORIES COLLECTION') }}</h4>
                </div>
                <div class="col-sm-4 col-md-3">
                    <div class="right-link">
                        <a href="{{ url('shop') }}">{{ __('View All') }} <span class="icon"><svg viewBox="0 0 512 512"><path d="M477.5 273L283.1 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.7-22.7c-9.4-9.4-9.4-24.5 0-33.9l154-154.7-154-154.7c-9.3-9.4-9.3-24.5 0-33.9l22.7-22.7c9.4-9.4 24.6-9.4 33.9 0L477.5 239c9.3 9.4 9.3 24.6 0 34zm-192-34L91.1 44.7c-9.4-9.4-24.6-9.4-33.9 0L34.5 67.4c-9.4 9.4-9.4 24.5 0 33.9l154 154.7-154 154.7c-9.3 9.4-9.3 24.5 0 33.9l22.7 22.7c9.4 9.4 24.6 9.4 33.9 0L285.5 273c9.3-9.4 9.3-24.6 0-34z"></path></svg></span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="categori-grid cat-items">
            @foreach($categories as $category)
                <div class="item" onclick="location.replace('{{ route('category',$category->slug ?? 'undefined') }}')">
                    <img src="{{ asset('uploads/categories/200x200') }}/{{ $category->banner ?? 'default.png' }}" alt="category">
                    <div class="item-link">
                        <a href="{{ route('category',$category->slug ?? 'undefined') }}">
                            {{ $category->name }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Categories End -->
