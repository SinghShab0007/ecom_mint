<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller\Sale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SaleController extends Controller
{
    /**
     * Save sale information in storage
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request['seller_id'] = auth('seller')->id();

        Sale::query()->create($request->all());

        Session::flash('success','Sale added successfully');

        return redirect()->back();
    }

    public function edit(Request $request)
    {
        $sale = Sale::query()->findOrFail($request->get('id'));

        return view('seller.sale._edit',compact('sale'));
    }

    /**
     * Modify sale information
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $sale = Sale::query()->findOrFail($id);
        
        $sale->update($request->all());

        Session::flash('success','Information updated successfully!');

        return redirect()->back();
    }

    /**
     * remove sale information from database
     *
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $sale = Sale::query()->findOrFail($id);

        $sale->delete();

        Session::flash('success','Sale record has been removed');

        return redirect()->back();
    }
}
