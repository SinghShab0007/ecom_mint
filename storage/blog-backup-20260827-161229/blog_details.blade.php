@extends('frontend.layouts.front')

@section('title', $blog->title)

@section('content')


<div class="maan-blog-section maan-section py-5">
        <div class="container">
            <div class="maan-blog-wraper">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="maan-blog-details">
                            <div class="post-details-title wow fadeInUp" >
                                <h3>{{ $blog->title }}</h3>
                                <div class="author-area">
                                    <a href="#" class="maan-btn">{{ $blog->category->name }}</a>
                                    <div class="author">
                                        <div class="author-thumb">
                                            <img src="{{ asset('uploads/users/'.$blog->user->avatar) }}" alt="{{ $blog->user->name }}">
                                        </div>
                                        <div class="content">
                                            <a href="#" class="title">{{ $blog->user->name }}</a>
                                            <a href="#" class="date">{{$blog->created_at->translatedFormat(' F j, Y')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="market-industry-thumb wow fadeInUp"  data-wow-delay="0.6s">
                                <div class="images-thumb">
                                    <img src="{{ asset('uploads/blogs/'.$blog->image) }}" class="img-fluid rounded" alt="{{ $blog->title }}">
                                </div>
                                <div class="content">
                                    <p>by  {{$blog->user->name}}</p>
                                    <h4>{{ $blog->title }}</h4>
                                </div>
                            </div>
                            <div class="toproviding-customers wow fadeInUp"  data-wow-delay="0.9s">
                                {!! $blog->description !!}
                            </div>
                            <div class="maan-details-tags-area wow fadeInUp"  data-wow-delay="1.2s">
                                <div class="tags">
                                    <h5>{{ ('Tag:') }}</h5>
                                    @if($blog->tag)
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item"><span class="maan-btn">{{ $blog->tag }}</span></li>
                                        </ul>
                                    @endif
                                </div>
                                <div class="social-share">
                                    <ul>
                                        <li><a href="https/www.skype.com"><i class="fab fa-skype"></i></a></li>
                                        <li><a href="https/www.twitter.com"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="https/www.instagram.com"><i class="fab fa-instagram"></i></a></li>
                                        <li><a href="https/www.facebook.com"><i class="fab fa-facebook-f"></i></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="maan-comment-area wow fadeInUp">
                                <h3 class="comment-title">{{__('Comments')}}</h3>
                                @foreach($blog->comments as $comment)
                                <div class="comment-author wow fadeInUp"  data-wow-delay="0.3s">
                                    <div class="author-thumb">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                                            <span class="small fw-semibold text-uppercase">{{ strtoupper(mb_substr($comment->name,0,1)) }}</span>
                                        </div>
                                    </div>
                                    <div class="description">
                                        <div class="author-title">
                                            <small class="text-muted">{{$comment->created_at->translatedFormat(' F j, Y')}}</small>
                                            <a class="author-name d-block" href="#">{{$comment->name}}</a>
                                        </div>
                                        <div class="comment">
                                            {{$comment->comment}}
                                        </div>

                                    </div>
                                </div>
                                @endforeach

                                <div class="maan-comment-form-area wow fadeInUp"  data-wow-delay="1.2s">
                                    <h3 class="comment-title">{{__('Leave A Reply')}}</h3>
                                    <form action="{{route('frontend.blog.comment')}}" method="POST" >
                                        @csrf
                                        <input type="hidden" name="blog_id" value="{{$blog->id}}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="name" placeholder="Name*">
                                                @error('name')
                                                <label class="error" id="name-error" for="name">{{$message}}</label>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <input type="email" name="email" placeholder="Email*">
                                                @error('email')
                                                <label class="error" id="email-error" for="email">{{$message}}</label>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <textarea name="comment" placeholder="write your comment"></textarea>
                                                @error('comment')
                                                <label class="error" id="comment-error" for="comment">{{$message}}</label>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="submit" class="maan-btn maan-post-btn">{{__('post comment')}}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="maan-wedgets-area">
                                <div class="maan-wedgets wow fadeInUp"  data-wow-delay="0.2s">
                                <h2 class="wedgets-title">{{__('Search')}}</h2>
                                <form >
                                    <div class="maan-input-group">
                                        <input type="text" placeholder="Search keywords">
                                        <button class="maan-btn"><i class="fal fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="maan-wedgets wow fadeInUp" data-wow-delay="0.4s">
                                <h2 class="wedgets-title">{{ __('Categories') }} </h2>
                                <ul class="categories list-unstyled">
                                    @foreach($categories as $category)
                                        <li class="d-flex justify-content-between align-items-center mb-2">
                                            <span>{{ $category->name }}</span>
                                            <span class="badge bg-light text-dark">{{ $category->blogs->count() }}</span>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                            <div class="maan-wedgets wow fadeInUp" data-wow-delay="0.7s">
                                <h2 class="wedgets-title">{{ __('Recent Posts') }}</h2>
                                @foreach($recents as $recentpost)


                                        <div class="blog-post-categories d-flex mb-3">
                                            <a href="{{route('frontend.blog.details',$recentpost->slug)}}" class="post-thumb me-3">
                                                <img src="{{ asset('uploads/blogs/'.$recentpost->image) }}" width="80" height="60" class="rounded" alt="{{ $recentpost->title }}">
                                            </a>
                                            <div class="post-content">
                                                <a href="{{route('frontend.blog.details',$recentpost->slug)}}" class="post-title d-block">{{ \Illuminate\Support\Str::limit($recentpost->title, 60) }}</a>
                                                <span class="post-date small text-muted">{{ $recentpost->created_at->translatedFormat(' F j, Y') }}</span>
                                            </div>
                                        </div>

                                @endforeach

                            </div>
                            <div class="maan-wedgets wow fadeInUp mb-0"  data-wow-delay="1.4s">
                                <h2 class="wedgets-title">{{ __('Populer Tags') }}</h2>
                                <ul class="maan-popular-tags">
                                    @foreach($recents as $recenttag)
                                    <li><a href="{{route('frontend.blog.details',$recenttag->slug)}}" class="maan-btn">{{$recenttag->tag}}</a></li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
