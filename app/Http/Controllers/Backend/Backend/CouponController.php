<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Category;
use App\Models\Backend\Coupon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::query()->latest()->get();
        return view('backend.pages.coupon.index',compact('coupons'));
    }

    public function create()
    {
        return view('backend.pages.coupon.create');
    }

    public function store(Request $request)
    {
        $type = $request->get('type');

        if($type == 'cart'){
            $this->validate($request,[
                'code' => 'required|unique:coupons',
                'discount' => 'lt:min_buy'
            ]);
            $request['details'] = json_encode(['min_buy'=>$request->get('min_buy'),'max_discount'=>$request->get('max_discount')]);
        }elseif($type == 'product'){
            $this->validate($request,[
                'code' => 'required|unique:coupons',
            ]);
            $request['details'] = json_encode(['product_id'=>$request->get('products')]);
        }else{
            return redirect()->back();
        }
        //dd($request->except(['min_buy','max_discount','product']));

        Coupon::query()->create($request->except(['min_buy','max_discount','product']));

        return redirect('admin/coupon');
    }

    public function edit($id)
    {
        $categories = Category::query()->where('category_id',NULL)->get();
        $coupon = Coupon::query()->findOrFail($id);
        $details = json_decode($coupon->details);

        return view('backend.pages.coupon.edit',compact('categories','coupon','details'));
    }

    public function update($id, Request $request)
    {
        $coupon = Coupon::query()->findOrFail($id);

        if($coupon->type == 'cart'){
            $this->validate($request,[
                'code' => ['required',Rule::unique('coupons')->ignore($id)],
                'discount' => 'sometimes|lt:min_buy',
                'start' => 'required|date',
                'end' => 'required|date'
            ]);
            $request['details'] = json_encode(['min_buy'=>$request->get('min_buy'),'max_discount'=>$request->get('max_discount')]);
        }elseif($coupon->type == 'product'){

            $this->validate($request,[
                'code' => ['required',Rule::unique('coupons')->ignore($id)],
                'start' => 'required|date',
                'end' => 'required|date'
            ]);

            $request['details'] = json_encode(['product_id'=>$request->get('products')]);
        }else{
            return redirect()->back();
        }

        $coupon->update($request->all());

        return redirect('admin/coupon');
    }

    /**
     * Remove coupon from storage
     *
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $coupon = Coupon::query()->findOrFail($id);
        $coupon->delete();
        return redirect()->back()->with(['message'=>'Coupon has been removed!']);
    }

    /**
     * Display coupon list via ajax request
     *
     * @param Request $request
     * @return View
     */
    public function list(Request $request): View
    {
        $q = $request->get('search');
        $coupons = Coupon::query()
            ->where('code','like','%'.$q.'%')
            ->orWhere('type','like','%'.$q.'%')
            ->orWhere('start','like','%'.$q.'%')
            ->orWhere('end','like','%'.$q.'%')
            ->get();

        return view('backend.pages.coupon._list',compact('coupons'));
    }

    /**
     * Display coupon create form via ajax request
     * There are two types of coupon, product based and cart based.
     * According to coupon type the form will display in coupon create page.
     *
     * @param Request $request
     * @return Application|ResponseFactory|Factory|View|Response
     */
    public function product(Request $request)
    {
        $type = $request->get('type');

        if($type == 'product'){
            //$products = Product::query()->groupBy('category_id')->get();
            $categories = Category::query()->where('category_id',NULL)->get();
            return view('backend.pages.coupon._product',compact('categories'));
        }elseif($type == 'cart'){
            return view('backend.pages.coupon._cart');
        }else{
            return response(false);
        }
    }
}
