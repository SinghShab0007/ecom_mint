<?php

namespace App\Http\Controllers\Backend;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotifyController extends Controller
{
    public function mtIndex()
    {
        $notifications = Notification::where('notifiable_id', auth(Auth::getDefaultDriver())->id())->where('notifiable_type', 'App\Models\Backend\Admin')->get();
        return view('backend.pages.notifications.index', compact('notifications'));
    }

    public function mtView($id)
    {
        $notify = Notification::where('data->id', $id)->first();
        $notify->read_at = now();
        $notify->save();
        return redirect($notify->data['url'] ?? '/');
    }

    public function mtReadAll()
    {
        Notification::where('notifiable_id', auth(Auth::getDefaultDriver())->id())->update(['read_at' => now()]);
        return back();
    }
}
