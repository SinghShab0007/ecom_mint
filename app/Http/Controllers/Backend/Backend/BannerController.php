<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseMessage;
use App\Models\Backend\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Mockery\CountValidator\Exception;
use App\Modules\Backend\ProductManagement\Entities\Category;

class BannerController extends Controller
{
    use ResponseMessage;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.pages.content_management.banners.index');
    }

    /* Process ajax request */
    public function bannerList(Request $request)
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

        $query = Banner::query();
        // Total records
        $totalRecords = $query->count();
        $totalRecordswithFilter = $totalRecords;
        // Get records, also we have included search filter as well
        if (!empty($searchValue)) {
            $query
                ->where('title', 'like', '%' . $searchValue . '%')
                ->orWhere('total_click', 'like', '%' . $searchValue . '%')
                ->orWhere('target', 'like', '%' . $searchValue . '%')
                ->orWhere('type', 'like', '%' . $searchValue . '%')
                ->orWhere('expire_at', 'like', '%' . $searchValue . '%');

            $totalRecordswithFilter = $query->count();
        }
        $records = $query
            ->with('category')
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
            $image = '<img src="' . URL::to('uploads/banners/' . $record->image) . '" alt="banner">';

            $edit_route = auth('seller')->user() ? route('seller.banners.edit', $record->id) : route('backend.banners.edit', $record->id);
            $delete_route = auth('seller')->user() ? route('seller.banners.destroy', $record->id) : route('backend.banners.destroy', $record->id);
            $edit_button = '';
            $delete_button = '';
            if(auth()->user()->can('edit_banners') || auth()->user()->hasRole('super-admin'))
                $edit_button = '<li>
                                            <a class="p-0 action" href="' . $edit_route . '">
                                                <button title="Edit">
                                                    <svg viewBox="0 0 11 11" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M8.72031 5.31576C8.48521 5.31576 8.29519 5.50625 8.29519 5.74089V9.1421C8.29519 9.37634 8.1047 9.56722 7.87007 9.56722H1.91801C1.68331 9.56722 1.49289 9.37634 1.49289 9.1421V3.19C1.49289 2.95575 1.68331 2.76487 1.91801 2.76487H5.3192C5.5543 2.76487 5.74432 2.57438 5.74432 2.33975C5.74432 2.10504 5.5543 1.91455 5.3192 1.91455H1.91801C1.21483 1.91455 0.642578 2.4868 0.642578 3.19V9.1421C0.642578 9.84529 1.21483 10.4175 1.91801 10.4175H7.87007C8.57326 10.4175 9.14551 9.84529 9.14551 9.1421V5.74089C9.14551 5.50579 8.95541 5.31576 8.72031 5.31576Z"/>
                                                        <path d="M4.62759 4.9274C4.59785 4.95714 4.57785 4.99497 4.56936 5.03577L4.26879 6.53916C4.25477 6.60884 4.27688 6.68069 4.32702 6.73129C4.36742 6.77169 4.42184 6.79333 4.47758 6.79333C4.49112 6.79333 4.50521 6.79209 4.51923 6.78913L6.02218 6.48856C6.06383 6.48 6.10167 6.46007 6.13101 6.43025L9.49487 3.06645L7.99192 1.5636L4.62759 4.9274Z"/>
                                                        <path d="M10.5329 0.525254C10.1184 0.110723 9.444 0.110723 9.02982 0.525254L8.44141 1.11362L9.94444 2.61652L10.5329 2.02808C10.7336 1.82786 10.8441 1.56084 10.8441 1.27686C10.8441 0.992876 10.7336 0.725864 10.5329 0.525254Z"/>
                                                    </svg>
                                                </button>
                                            </a>
                                </li>';
            if(auth()->user()->can('delete_banners') || auth()->user()->hasRole('super-admin'))
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
                "image" => $image,
                "title" => $record->title,
                "total_click" => $record->total_click,
                "target" => $record->target,
                "type" => $record->type,
                "expire_at" => date("Y-m-d", strtotime($record->expire_at)),
                "is_active" => '<div class="form-switch"><input class="form-check-input status" type="checkbox"  data-id="' . $record->id . '"' . $checked . '></div>',
                "publish_stat" => '<div class="form-switch"><input class="form-check-input publish" type="checkbox"  data-id="' . $record->id . '"' . $publish . '></div>',
                "action" => '<ul>
                                '.$edit_button.'
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banner = new Banner();
        $categories = Category::all();
        return view('backend.pages.content_management.banners.create', compact('banner', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'category_id' => 'required',
                'title' => 'required|string|max:200',
                'offer_title' => 'required|string|max:200',
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg',
                'type' => 'required',
                'description' => 'nullable|string|max:300',
            ]);
            $data = $request->only(
                'category_id', 'title', 'sub_title',
                'target', 'type', 'description', 'expire_at', 'publish_stat', 'total_click','offer_title'
            );
            $data['publish_stat'] = 0;
            $data['total_click'] = 0;
            if ($data['expire_at'] == '')
                $data['expire_at'] = date('Y-m-d', strtotime('+1 year'));
            if ($data['target'] == '')
                $data['target'] = '_self';
            $image = $request->file('image');
            if ($image) {
                $path = Storage::putFile('banners', $image);
                $pattern = "/banners\//";
                $path = preg_replace($pattern, '', $path);
                $data['image'] = $path;
            }

            $banner = Banner::create($data);
            if ($banner) {
                if (auth('seller')->user())
                    return redirect()->route('seller.banners.index')->with($this->create_success_message);
                else
                    return redirect()->route('backend.banners.index')->with($this->create_success_message);
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return back()->withInput()->with($this->create_fail_message);
        }
    }

    /* change status*/
    public function changeStatus(Request $request)
    {
        $banner = Banner::findOrFail($request->id);
        if ($banner) {
            if ($request->field == 'is_active')
                $banner->is_active = $request->status;
            if ($request->field == 'publish_stat')
                $banner->publish_stat = $request->status;
            $banner->save();
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
        $banner = Banner::with('product')->find($id);
        if ($banner) {
            return view('backend.pages.content_management.banners.show', compact('banner'));
        } else {
            return redirect()->back()->with($this->not_found_message);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::with('category')->find($id);
        if ($banner) {
            $categories = Category::all();
            return view('backend.pages.content_management.banners.edit', compact('banner', 'categories'));
        } else {
            return redirect()->back()->with($this->not_found_message);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'category_id' => 'required',
                'title' => 'required|string|max:200',
                'offer_title' => 'required|string|max:200',
                'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg',
                'type' => 'required',
                'description' => 'nullable|string|max:300',
            ]);
            $banner = Banner::findOrFail($id);
            if ($banner) {
                if ($request->input('expire_at') == '')
                    $request->request->add(['expire_at' => date('Y-m-d', strtotime('+1 year'))]);
                if ($request->input('target') == '')
                    $request->request->add(['target' => '_self']);
                $data = $request->only(
                    'category_id', 'title', 'sub_title', 'target', 'type', 'description', 'expire_at','offer_title'
                );
                $image = $request->file('image');
                if ($image) {
                    $path = Storage::putFile('banners', $image);
                    $pattern = "/banners\//";
                    $path = preg_replace($pattern, '', $path);
                    if (file_exists(storage_path('app/public/banners/') . $banner->image)) {
                        Storage::delete('banners/' . $banner->image);
                    }
                    $data['image'] = $path;
                }
                $banner->update($data);
                if (auth('seller')->user())
                    return redirect()->route('seller.banners.index')->with($this->update_success_message);
                else
                    return redirect()->route('backend.banners.index')->with($this->update_success_message);
            } else {
                return back()->withInput()->with($this->update_fail_message);
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return back()->withInput()->with($this->update_fail_message);
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
            $banner = Banner::find($id);
            if ($banner) {
                if (file_exists(storage_path('app/public/banners/') . $banner->image)) {
                    Storage::delete('banners/' . $banner->image);
                }
                // delete this banner
                $banner->delete();
                if (auth('seller')->user())
                    return redirect()->route('seller.banners.index')->with($this->delete_success_message);
                else
                    return redirect()->route('backend.banners.index')->with($this->delete_success_message);
            } else {
                return back()->with($this->not_found_message);
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with($this->delete_fail_message);
        }
    }
}
