@extends('backend.layouts.app')

@section('title','Language')

{{--@push('css')--}}
{{--    @include('backend.includes.datatable_css')--}}
{{--@endpush--}}

@section('content')

    <div class="row">
        <div class="col-6">
            <div class="content-body">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="add-category" role="tabpanel" aria-labelledby="add-category-tab">
                        <div class="container">
                            <form id="faqForm" method="post" action="{{route('backend.notice.store')}}" class="add-brand-form">
                                @csrf()
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <input name="headline" type="text" class="form-control" placeholder="Notice title" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <textarea name="description" class="form-control" id="description" cols="30" rows="10" required>lorem ipsum dolor sumit</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <input name="published_at" type="date" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <select name="is_active" class="form-control" required>
                                            <option value="1" selected>Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="from-submit-btn">
                                        <button class="submit-btn" type="submit">{{ __('Save') }}</button>
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
                <div class="container">
                    <div class="content-tab-title">
                        <h4>{{__('Notices')}}</h4>
                    </div>
                </div>
                <!-- Tab Content Start -->
                {{--                <div class="tab-content" id="nav-tabContent">--}}
                {{--                    <div class="tab-pane fade show active" id="questions-and-answer" role="tabpanel"--}}
                {{--                         aria-labelledby="questions-and-answer-tab">--}}
                {{--                        <div class="container">--}}
                {{--                            <div class="row">--}}
                {{--                                <div class="col">--}}
                {{--                                    <input type="text" name="search" class="form-control" id="search">--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                            <div class="content-table">--}}
                {{--                                @foreach($notices as $notice)--}}
                {{--                                    <h5>{{ $notice->headline }}</h5>--}}
                {{--                                    <p>{{ $notice->description }}</p>--}}
                {{--                                    <span>{{ $notice->published_at }}</span>--}}
                {{--                                @endforeach--}}
                {{--                            </div>--}}
                {{--                        </div>--}}

                {{--                    </div>--}}
                {{--                </div>--}}
                <div class="list-group">
                    @foreach($notices as $notice)
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $notice->headline }}</h5>
                                <small>{{ $notice->published_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">{{ $notice->description }}</p>
                            <small>{{ $notice->is_active == 1 ? 'Active' : 'Inactive' }}</small>
                            <form action="{{ route('backend.notice.destroy',$notice->id) }}" method="post" class="float-end">
                                @csrf
                                @method('delete')
                                <a href="#" onclick="deleteWithSweetAlert(event,parentNode)"><i class="fas fa-trash"></i></a>
                            </form>
                            <a href="{{ route('backend.notice.edit',$notice->id) }}" class="float-end px-2"><i class="fas fa-edit"></i></a>
                        </div>
                    @endforeach
                </div>
                <!-- Tab Content End -->
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
@endpush
