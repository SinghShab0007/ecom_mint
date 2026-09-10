<?php

use App\Notifications\SendNotification;
use Illuminate\Support\Facades\Notification;
use App\Modules\Backend\SellerManagement\Entities\Seller;

function SellerNotification($user_id, $id, $url, $message) {
    $notify = [
        'id' => $id,
        'url' => $url,
        'message' => $message,
    ];
    $notify_user = Seller::find($user_id);
    Notification::send($notify_user, new SendNotification($notify));
}

function AdminNotification($id, $url, $message) {
    $notify = [
        'id' => $id,
        'url' => $url,
        'message' => $message,
    ];
    $notify_user = App\Models\Backend\Admin::where('is_active', 1)->first();
    Notification::send($notify_user, new SendNotification($notify));
}
