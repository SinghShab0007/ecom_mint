@extends('frontend.layouts.front')

@section('title', 'Blog')

@section('content')

<section class="maan-blog-section maan-section py-5">
    <div class="container">
        <div class="row">
            {{-- Main blog list --}}
            <div class="col-lg-8">
                <div class="mb-4">
                    <h2 class="mb-3">{{ __('Latest Articles') }}</h2>
                    <p class="text-muted mb-0">{{ __('Stay updated with offers, product guides and news from POROSKART.') }}</p>
                </div>
                <div class="row g-4">
                    @foreach($blogs as $blog)
                        <div class="col-md-6">
                            <article class="card h-100 shadow-sm border-0 blog-card">
                                <a href="{{ route('frontend.blog.details', $blog->slug) }}" class="card-thumb d-block position-relative overflow-hidden">
                                    <img src="{{ asset('uploads/blogs/'.$blog->image) }}" class="w-100" alt="{{ $blog->title }}">
                                    <span class="maan-category-btn maan-btn position-absolute top-0 start-0 m-3 px-3 py-1 small">
                                        {{ $blog->category->name }}
                                    </span>
                                </a>
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex align-items-center mb-2 small text-muted author-date">
                                        <span class="me-3 d-flex align-items-center">
                                            <img src="{{ asset('frontend/img/icons/calendar.svg') }}" class="me-1" alt="date">
                                            {{ $blog->created_at->translatedFormat(' F j, Y') }}
                                        </span>
                                        <span class="d-flex align-items-center">
                                            <img src="{{ asset('uploads/users/'.$blog->user->avatar) }}" class="rounded-circle me-1" width="22" height="22" alt="{{ $blog->user->name }}">
                                            {{ __('by ') }}{{ $blog->user->name }}
                                        </span>
                                    </div>
                                    <h5 class="card-title mb-2">
                                        <a href="{{ route('frontend.blog.details', $blog->slug) }}" class="text-dark text-decoration-none">
                                            {{ $blog->title }}
                                        </a>
                                    </h5>
                                    <p class="card-text text-muted mb-3">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($blog->description), 120) }}
                                    </p>
                                    <div class="mt-auto">
                                        <a href="{{ route('frontend.blog.details', $blog->slug) }}" class="link text-primary fw-semibold">
                                            {{ __('Read more') }} <i class="fal fa-long-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $blogs->links() }}
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4 mt-5 mt-lg-0">
                <aside class="maan-wedgets-area">
                    {{-- Search (UI only for now) --}}
                    <div class="maan-wedgets mb-4">
                        <h2 class="wedgets-title">{{ __('Search') }}</h2>
                        <div class="maan-input-group">
                            <input type="text" class="form-control" placeholder="{{ __('Search keywords') }}">
                            <button class="maan-btn" type="button"><i class="fal fa-search"></i></button>
                        </div>
                    </div>

                    {{-- Categories --}}
                    <div class="maan-wedgets mb-4">
                        <h2 class="wedgets-title">{{ __('Categories') }}</h2>
                        <ul class="categories list-unstyled mb-0">
                            @foreach($categories as $category)
                                <li class="d-flex justify-content-between align-items-center mb-2">
                                    <span>{{ $category->name }}</span>
                                    <span class="badge bg-light text-dark">{{ $category->blogs->count() }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Recent posts --}}
                    <div class="maan-wedgets mb-4">
                        <h2 class="wedgets-title">{{ __('Recent Posts') }}</h2>
                        @foreach($blogs->take(5) as $recentpost)
                            <div class="blog-post-categories d-flex mb-3">
                                <a href="{{ route('frontend.blog.details', $recentpost->slug) }}" class="post-thumb me-3">
                                    <img src="{{ asset('uploads/blogs/'.$recentpost->image) }}" width="80" height="60" class="rounded" alt="{{ $recentpost->title }}">
                                </a>
                                <div class="post-content">
                                    <a href="{{ route('frontend.blog.details', $recentpost->slug) }}" class="post-title d-block">
                                        {{ \Illuminate\Support\Str::limit($recentpost->title, 60) }}
                                    </a>
                                    <span class="post-date small text-muted">
                                        {{ $recentpost->created_at->translatedFormat(' F j, Y') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>

@stop
