<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Backend\ProductManagement\Entities\Category;

class CommissionController extends Controller
{
    public function index()
    {
        $commissions = Category::latest()
                        ->when(request('search'), function($q) {
                            $q->where('name', 'like', '%'.request('search').'%')
                            ->orWhere('commission_rate', 'like', '%'.request('search').'%');
                        })
                        ->paginate(10);

        return view('backend.pages.commissions.index', compact('commissions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rate' => 'required|max:99'
        ]);

        $commission = Category::findOrFail($id);
        $commission->update([
            'commission_rate' => $request->rate
        ]);

        return response()->json([
            'message' => __('Commission rate updated.'),
            'redirect' => route('backend.commissions.index')
        ]);
    }
}
