<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseMessage;
use App\Models\Backend\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    use ResponseMessage;

    public function index()
    {
        $notices = Notice::query()->latest()->get();
        return view('backend.notice.index',compact('notices'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'headline' => 'required'
        ]);

        Notice::query()->create($request->all());

        //return redirect()->back()->with($this->create_success_message);
        return redirect()->back();
    }

    public function edit($id)
    {
        $notices = Notice::query()->latest()->get();
        $notice = Notice::query()->findOrFail($id);
        return view('backend.notice.edit',compact('notices','notice'));
    }

    public function update($id, Request $request)
    {
        $notice = Notice::query()->findOrFail($id);
        $notice->update($request->all());
        return redirect('admin/website_setting/notices');
    }

    public function destroy($id)
    {
        $notice = Notice::query()->findOrFail($id);
        $notice->delete();
        return redirect('admin/website_setting/notices');
    }
}
