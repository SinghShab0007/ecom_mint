<div class="row search-bar">
    <div class="col-lg-9">
        <form class="main-search" action="{{ url('shop') }}" method="get">
            <input type="text" placeholder="{{ __('Search product...') }}" name="q">
            <select>
                <option value="all">{{ __('Product Category') }}</option>
                <option value="is_featured">{{ __('Featured Category') }}</option>
                <option value="price-desc">{{ __('Price categories') }}</option>
                <option value="categories" selected="selected">{{ __('All categories') }}</option>
            </select>
            <button type="submit">{{ __('Search') }}</button>
        </form>
    </div>
    <div class="col-lg-3">
        <div class="country">
            <select>
                <option>{{ __('Iran') }}</option>
                <option>{{ __('Bangladesh') }}</option>
                <option>{{ __('United Kingdom') }}</option>
                <option selected="selected">{{ __('United State') }}</option>
            </select>
        </div>
    </div>
</div>
