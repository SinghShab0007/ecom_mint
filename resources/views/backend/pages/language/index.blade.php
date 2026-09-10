@extends('backend.layouts.app')

@section('title','Language')

{{--@push('css')--}}
{{--    @include('backend.includes.datatable_css')--}}
{{--@endpush--}}

@section('content')

    <div class="row">
        <div class="col-6">
            <div class="content-body">
                <!-- Tab Content Start -->
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="add-category" role="tabpanel" aria-labelledby="add-category-tab">
                        <div class="container">
                            <form id="faqForm" method="post" action="{{route('backend.language.default')}}" class="add-brand-form">
                                @csrf()
                                <div>
                                    <p>{{ __('Set the default language for website') }}</p>
                                </div>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <select name="id" class="form-select category form-control{{ $errors->has('faq_category_id') ? ' is-invalid' : '' }}" required id="type">
                                            <option value="">{{ __('Select Language') }}</option>
                                            @foreach($languages as $language)
                                                <option value="{{ $language->id }}">{{ $language->name }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('type'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('type') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-7 offset-3">
                                    <div class="from-submit-btn">
                                        <button class="submit-btn" type="submit">{{__('Set Default')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Tab Content End -->
            </div>
        </div>
        <div class="col-6">
            <div class="content-body">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="add-category" role="tabpanel" aria-labelledby="add-category-tab">
                        <div class="container">
                            <form id="faqForm" method="post" action="{{route('backend.language.store')}}" class="add-brand-form">
                                @csrf()
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <input name="name" type="text" class="form-control" placeholder="Language Name. Ex: English, Arabic">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <select name="direction" id="direction" class="form-select category form-control">
                                            <option value="ltr">{{ __('Left to Right (LTR)') }}</option>
                                            <option value="rtl">{{ __('Right to Left (RTL)') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <input name="alias" type="text" class="form-control" placeholder="en, bn or eu etc">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="from-submit-btn">
                                        <button class="submit-btn" type="submit">{{__('Save')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Tab Content End -->
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="container">
            <div class="content-tab-title">
                <h4>{{__('Language List')}}</h4>
            </div>
        </div>
        <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="questions-and-answer" role="tabpanel"
                 aria-labelledby="questions-and-answer-tab">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="float-md-end">
                                <label for="q">{{ __('Search') }}</label>
                                <input type="text" name="search" class="form-control" id="search">
                            </div>
                        </div>
                    </div>
                    <div class="content-table">
                        <table class="table p-table">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('Id') }}</th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Direction') }}</th>
                                <th scope="col">{{ __('Alias') }}</th>
                                <th scope="col">{{ __('Is Default') }}</th>
                                <th scope="col">{{ __('Is Active') }}</th>
                                <th scope="col">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody id="coupon-list">
                            @foreach($languages as $language)
                                <tr>
                                    <td>{{ $language->id }}</td>
                                    <td>{{ $language->name }}</td>
                                    <td>{{ $language->direction }}</td>
                                    <td>{{ $language->alias }}</td>
                                    <td>
                                        {{ $language->default }}
                                    </td>
                                    <td>
                                        {{ $language->is_active }}
                                    </td>
                                    <td>
                                        <ul>
                                            <li>
                                                <a class="p-0 action" href="{{ route('backend.language.translation',$language->id) }}">
                                                    <button title="Translate">
                                                        <i class="fa-solid fa-language"></i>
                                                    </button>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="p-0 action" href="#" data-bs-toggle="modal" data-bs-target="#editModal" onclick="langEdit({{$language->id}})">
                                                    <button title="Edit">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                </a>
                                            </li>
                                            <li>
                                                <form user="deleteForm" method="POST" action="{{ route('backend.language.destroy', $language->id) }}">
                                                    @csrf() @method("DELETE")
                                                    <a class="p-0 action" href="javascript:void(0);"
                                                       onclick="deleteWithSweetAlert(event,parentNode);">
                                                        <button title="Delete">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    </a>
                                                </form>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <!-- Tab Content End -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">{{ __('Edit Language') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body">

                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    @if($errors->any())
        <script>
            swal ( "Oops" , "{{$errors->first('msg')}}" ,  "error" )
        </script>
    @endif

    <script>
        function langEdit(id){
            var csrf = "{{ csrf_token() }}";
            $.ajax({
                url: "{{ route('backend.language.edit') }}",
                data: {_token:csrf,id:id},
                method: "post"
            }).done(function(e){
                $("#modal-body").html(e);
            })
        }
    </script>
@endpush
