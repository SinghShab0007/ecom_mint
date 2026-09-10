<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseMessage;
use App\Models\Backend\Blog;
use App\Models\Backend\BlogCategory;
use App\Models\Frontend\BlogComment;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    use ResponseMessage;
    public function index()
    {
        $blogs = Blog::where('status',1)->latest()->paginate(10);
        $categories = BlogCategory::where('status',1)->get();
        return view('frontend.pages.blogs.blog',compact('blogs','categories'));
    }
    public function blogDetails($slug)
    {
        $blog = Blog::with('comments')->where('slug',$slug)->first();
        $categories = BlogCategory::where('status',1)->get();
        $recents = Blog::where('status',1)->latest()->take(5)->get();

        return view('frontend.pages.blogs.blog_details',compact('blog','recents','categories'));
    }

    public function blogComment(Request $request)
    {
        $request->validate([
            'blog_id'=>'required',
            'name'=>'required',
            'email'=>'required',
            'comment'=>'required'
        ]);
        $data = $request->only('blog_id','name','email','comment');
       $comment = BlogComment::create($data);

       return redirect()->back()->with($this->create_success_message);
    }
}
