<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    public function load(Request $request)
    {
        $messages = Message::query()
            ->where('seller_id',$request->get('seller_id'))
            ->where('user_id',$request->get('user_id'))
            ->get();

        return view('frontend._messages',compact('messages'));
    }
}
