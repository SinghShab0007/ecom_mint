<?php

namespace App\Http\Controllers\Seller;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotifyController extends Controller
{
    public function mtIndex()
    {
        return view('seller.notifications.index');
    }

    public function mtView($id)
    {
        $notify = Notification::find($id);
        $notify->read_at = now();
        $notify->save();
        return redirect($notify->data['url'] ?? '/');
    }

    public function mtReadAll()
    {
        auth('seller')->user()->unreadNotifications()->update(['read_at' => now()]);
        return back();
    }
}
