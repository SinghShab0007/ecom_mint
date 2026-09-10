<div class="sidebar-widget">
    <h6>{{ __('Browse Categories') }}</h6>
    <ul>
        @foreach($categories as $category)
            <li>
                <input type="radio" name="category" data-name="{{ $category->name }}" class="category-check" id="{{ $category->slug }}" value="{{ $category->id }}" {{ $category->slug == Request::segment(2) ? 'checked' : '' }}>
                <label for="{{ $category->slug }}">{{ $category->name }} ({{ $category->productCount() }})</label>
            </li>
        @endforeach
    </ul>
</div>
