<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseMessage;
use App\Models\Backend\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductReviewController extends Controller
{
    use ResponseMessage;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.pages.content_management.product_review.index');
    }

    /* Process ajax request */
    public function productReviewList(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $query = ProductReview::query();
        // specific seller
        if (auth('seller')->user() && auth('seller')->user()->getRoleNames()->first() == 'Seller') {
            $query->whereHas('product', function ($query) {
                $query->where('seller_id', 'like', '%' . auth()->id() . '%');
            });
        }
        // Total records
        $totalRecords = $query->count();
        $totalRecordswithFilter = $totalRecords;
        $query
            ->join('products', 'products.id', '=', 'product_reviews.product_id')
            ->join('users', 'users.id', '=', 'product_reviews.user_id')
            ->select('products.name as product_name','users.last_name as customer_name', 'product_reviews.*');
        // Get records, also we have included search filter as well
        if (!empty($searchValue)) {
            $query
                ->where('product_name', 'like', '%' . $searchValue . '%')
                ->orWhere('customer_name', 'like', '%' . $searchValue . '%')
                ->orWhere('review_point', 'like', '%' . $searchValue . '%')
                ->orWhere('review_note', 'like', '%' . $searchValue . '%')
                ->orWhere('product_reviews.created_at', 'like', '%' . $searchValue . '%')
                ->orWhere('product_reviews.id', 'like', '%' . $searchValue . '%');
            $totalRecordswithFilter = $query->count();
        }
        $records = $query
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $checked = '';
            if ($record->is_active)
                $checked = 'checked';
            $publish = '';
            if ($record->publish_stat)
                $publish = 'checked';

            $show_route = auth('seller')->user() ? route('seller.product_review.show' , $record->id) : route('backend.product_review.show' , $record->id);
            $delete_route = auth('seller')->user() ? route('seller.product_review.destroy', $record->id) : route('backend.product_review.destroy', $record->id);
            $show_button = '';
            $delete_button = '';
            if(auth()->user()->can('show_product_review') || auth()->user()->hasRole('super-admin'))
                $show_button = '<li>
                                            <a class="p-0 action" href="' . $show_route . '">
                                                <button title="Show">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z"/></svg>
                                                </button>
                                            </a>
                                </li>';
            if(auth()->user()->can('delete_product_review') || auth()->user()->hasRole('super-admin'))
                $delete_button = '<li>
                                             <form user="deleteForm" method="POST"
                                                      action="' . $delete_route . '">
                                                    ' . csrf_field() . method_field("DELETE") . '
                                                    <a class="p-0 action" href="javascript:void(0);"
                                                       onclick="deleteWithSweetAlert(event,parentNode);">
                                                        <button title="Delete">
                                                            <svg viewBox="0 0 10 11" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M8.65184 10.2545C8.63809 10.5288 8.36791 10.7452 8.03934 10.7452H2.31625C1.98768 10.7452 1.7175 10.5288 1.70375 10.2545L1.29504 3.04834H9.06055L8.65184 10.2545ZM3.88317 4.83823C3.88317 4.7234 3.77169 4.63027 3.63416 4.63027H3.23589C3.09844 4.63027 2.98688 4.72338 2.98688 4.83823V8.95529C2.98688 9.07014 3.09835 9.16324 3.23589 9.16324H3.63416C3.77163 9.16324 3.88317 9.07019 3.88317 8.95529V4.83823ZM5.62591 4.83823C5.62591 4.7234 5.51444 4.63027 5.37693 4.63027H4.97866C4.84121 4.63027 4.72968 4.72338 4.72968 4.83823V8.95529C4.72968 9.07014 4.84112 9.16324 4.97866 9.16324H5.37693C5.51441 9.16324 5.62591 9.07019 5.62591 8.95529V4.83823ZM7.36871 4.83823C7.36871 4.7234 7.25724 4.63027 7.11973 4.63027H6.72143C6.58396 4.63027 6.47245 4.72338 6.47245 4.83823V8.95529C6.47245 9.07014 6.58393 9.16324 6.72143 9.16324H7.11973C7.25721 9.16324 7.36871 9.07019 7.36871 8.95529V4.83823Z"/>
                                                                <path d="M1.0213 1.09395H3.66155V0.677051C3.66155 0.617846 3.71902 0.569824 3.78994 0.569824H6.56248C6.63337 0.569824 6.69083 0.617846 6.69083 0.677051V1.09393H9.33112C9.5436 1.09393 9.71582 1.23779 9.71582 1.41526V2.42468H0.636597V1.41528C0.636597 1.23782 0.808817 1.09395 1.0213 1.09395Z"/>
                                                            </svg>
                                                        </button>
                                                    </a>
                                                </form>
                                    </li>';
            $data_arr[] = array(
                "id" => $record->id,
                "product_name" => $record->product_name??'',
                "customer_name" => $record->customer_name??'',
                "review_point" => $record->review_point??'',
                "review_note" => substr($record->review_note, 0, 50) . '...',
                "created_at" => date("Y-m-d", strtotime($record->created_at)),
                "is_active" => '<div class="form-switch"><input class="form-check-input status" type="checkbox"
                                data-id="' . $record->id . '"' . $checked . '></div>',
                "publish_stat" => '<div class="form-switch"><input class="form-check-input publish" type="checkbox"
                                data-id="' . $record->id . '"' . $publish . '></div>',
                "action" => '<ul>
                                '.$show_button.'
                                '.$delete_button.'
                            </ul>'
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );

        return json_encode($response);
    }


    /* change status*/
    public function changeStatus(Request $request)
    {
        $product_review = ProductReview::findOrFail($request->id);
        if ($product_review) {
            if ($request->field == 'is_active')
                $product_review->is_active = $request->status;
            if ($request->field == 'publish_stat')
                $product_review->publish_stat = $request->status;
            $product_review->save();
            return response()->json($this->update_success_message);
        } else {
            return response()->json($this->not_found_message);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $query = ProductReview::query();
        // specific seller
        if (auth('seller')->user() && auth('seller')->user()->getRoleNames()->first() == 'Seller') {
            $query->whereHas('product', function ($query) {
                $query->where('seller_id', 'like', '%' . auth()->id() . '%');
            });
        }

        $product_review = $query->with('product','customer')->find($id);

        if ($product_review) {
            return view('backend.pages.content_management.product_review.show', compact('product_review'));
        } else {
            return redirect()->back()->with($this->not_found_message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product_review = ProductReview::find($id);
            if ($product_review) {
                // delete this product_review
                $product_review->delete();
                if (auth('seller')->user())
                return redirect()->route('seller.product_review.index')->with($this->delete_success_message);
            else
                return redirect()->route('backend.product_review.index')->with($this->delete_success_message);
            } else {
                return back()->with($this->not_found_message);
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with($this->delete_fail_message);
        }
    }
}
