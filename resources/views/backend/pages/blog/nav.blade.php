<div class="content-tab-title">
    <h4>{{__('Blog List')}}</h4>
</div>
<!-- Tab Manu Start  -->
<div class="nav nav-tabs p-tab-manu" id="nav-tab" role="tablist">
    <button class="nav-link @if(Request::is('admin/blog/category','admin/blog/category/*'))active @endif" id="header-tab" data-bs-toggle="tab" data-bs-target="#header"
            type="button" role="tab" aria-controls="header" aria-selected="true"
            @if(url()->full()!=route('backend.blog.category.index')) onclick="location.href='{{route('backend.blog.category.index')}}'" @endif
    >{{__('Category')}}
    </button>
    <button class="nav-link @if(Request::is('admin/blog','admin/blog/*'))active @endif" id="blog-category-tab" data-bs-toggle="tab" data-bs-target="#blog-category" type="button"
            role="tab" aria-controls="blog-category" aria-selected="false"
            @if(url()->full()!=route('backend.blog.index')) onclick="location.href='{{route('backend.blog.index')}}'" @endif
    >{{__('blog')}}
    </button>

</div>
