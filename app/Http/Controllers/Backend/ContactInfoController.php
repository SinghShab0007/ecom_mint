<?php

namespace App\Http\Controllers\Backend;

use App\Models\Option;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ContactInfoController extends Controller
{
    public function index()
    {
        $infos = Option::where('key', 'contact-infos')->latest()->paginate(10);
        return view('backend.pages.website_setting.contact-infos.index', compact('infos'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'number' => 'required|string|max:15',
        ]);

        Option::create([
            'key' => 'contact-infos',
            'value' => [
                'title' => $request->title,
                'number' => $request->number,
            ]
        ]);

        Cache::forget('contact-infos');

        return response()->json([
            'message' => __('Contact info has been created.'),
            'redirect' => route('backend.contact-infos.index')
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'number' => 'required|string|max:15',
        ]);

        $option = Option::findOrFail($id);

        $option->update([
            'key' => 'contact-infos',
            'value' => [
                'title' => $request->title,
                'number' => $request->number,
            ]
        ]);

        Cache::forget('contact-infos');

        return response()->json([
            'message' => __('Contact info has been updated.'),
            'redirect' => route('backend.contact-infos.index')
        ]);
    }

    public function destroy($id)
    {
        $option = Option::findOrFail($id);
        $option->delete();

        Cache::forget('contact-infos');

        return response()->json([
            'message' => __('Contact info has been deleted.'),
            'redirect' => route('backend.contact-infos.index')
        ]);
    }
}
