<?php

namespace App\Helpers;

use App\Models\Backend\Admin;
use App\Notifications\SendNotification;
use Illuminate\Support\Facades\Notification;
use App\Modules\Backend\SellerManagement\Entities\Seller;

trait NotifyHelper
{
    function SellerNotification($user_id, $id, $url, $message) {
        if ($user_id === null) {
            return;
        }
        $notify = [
            'id' => $id,
            'url' => $url,
            'message' => $message,
        ];
        $notify_user = Seller::find($user_id);
        if ($notify_user !== null) {
            Notification::send($notify_user, new SendNotification($notify));
        }
    }

    function AdminNotification($id, $url, $message) {
        $notify = [
            'id' => $id,
            'url' => $url,
            'message' => $message,
        ];
        $notify_user = Admin::where('is_active', 1)->first();
        if ($notify_user !== null) {
            Notification::send($notify_user, new SendNotification($notify));
        }
    }
}
