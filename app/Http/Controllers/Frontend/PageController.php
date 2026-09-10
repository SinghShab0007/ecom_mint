<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Announcement;
use App\Models\Frontend\FAQ;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    /**
     * Display Announcement Page
     *
     * @return View
     */
    public function announcement(): View
    {
        $announcements = Announcement::query()
            ->where('is_active',1)
            ->where('expire_at','>',now())
            ->get();

        return view('frontend.pages.announcement',compact('announcements'));
    }

    /**
     * Display FAQ Page
     *
     * @return View
     */
    public function faq(): View
    {
        $faqs = FAQ::query()->where('is_active',1)->paginate(5);
        return view('frontend.pages.faq',compact('faqs'));
    }
    
    public function profile(): View
    {
        return view('frontend.pages.faq',compact('faqs'));
    }
}
