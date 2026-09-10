@extends('backend.layouts.app')

@section('title','Language')

@push('css')
    @include('backend.includes.datatable_css')
@endpush

@section('content')

            <div class="content-body">
                <div class="container">
                    <div class="content-tab-title">
                        <h4>{{ $language->name }} ({{ $language->direction }})</h4>
                    </div>
                </div>
                <!-- Tab Content Start -->
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="add-category" role="tabpanel" aria-labelledby="add-category-tab">
                        <div class="container">
                            <form id="faqForm" method="post" action="{{route('backend.language.translate',$language->id)}}" class="add-brand-form">
                                @csrf
                           <table class="table table-condensed">
                               @foreach($lines as $key => $line)
                               <tr>
                                   <td width="50%">{{ $key }}</td>
                                   <td>
                                       <div class="input-group">
                                           <input name="trans[{{$key}}]" type="text" required class="form-control" value="{{$line}}" placeholder="Enter a sentence">
                                       </div>
                                   </td>
                               </tr>
                               @endforeach
                           </table>
                            <div class="from-submit-btn">
                                <button class="submit-btn" type="submit">{{__('Save')}}</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Tab Content End -->
            </div>

@endsection
