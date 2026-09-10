<div class="container">
    <form id="faqForm" method="post" action="{{route('backend.language.update',$language->id)}}" class="add-brand-form">
        @csrf()
        @method('patch')
        <div class="col-lg-12">
            <div class="input-group">
                <input name="name" type="text" class="form-control" value="{{ $language->name }}" placeholder="Language Name. Ex: English, Arabic">
            </div>
        </div>
        <div class="col-lg-12">
            <div class="input-group">
                <select name="direction" id="direction" class="form-select category form-control">
                    <option value="ltr" {{ $language->direction == 'ltr' ? 'selected' :"" }}>{{ __('Left to Right (LTR)') }}</option>
                    <option value="rtl"{{ $language->direction == 'rtl' ? 'selected' :"" }}>{{ __('Right to Left (RTL)') }}</option>
                </select>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="input-group">
                <input name="alias" type="text" class="form-control" value="{{ $language->alias }}" placeholder="en, bn or eu etc">
            </div>
        </div>
        <div class="col-lg-12">
            <div class="from-submit-btn">
                <button class="submit-btn" type="submit">{{__('Update')}}</button>
            </div>
        </div>
    </form>
</div>
