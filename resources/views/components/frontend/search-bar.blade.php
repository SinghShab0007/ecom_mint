<div class="row search-bar">
    <div class="col-lg-3 text-center">
        {{ __('Showing')}} {{ $products->firstItem() .' - '. $products->lastItem() }} {{ __('of') }} {{ $products->total() }} {{ __('results') }}
    </div>
    <div class="col-lg-9">
        <form class="main-search" action="{{ url('shop') }}" method="get">
            <input type="text" placeholder="{{ __('Search product...') }}" name="q" id="q" oninput="ajaxFilter()">
            <button type="submit">{{ __('Search') }}</button>
        </form>
    </div>
</div>
