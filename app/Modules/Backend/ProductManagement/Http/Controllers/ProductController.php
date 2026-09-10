<?php

namespace App\Modules\Backend\ProductManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseMessage;
use App\Models\Backend\Color;
use App\Models\Backend\ProductDetail;
use App\Models\Backend\Size;
use App\Models\Backend\Wholesale;
use App\Models\Productstock;
use App\Modules\Backend\ProductManagement\Entities\Brand;
use App\Modules\Backend\ProductManagement\Entities\Category;
use App\Modules\Backend\ProductManagement\Entities\Product;
use App\Modules\Backend\ProductManagement\Entities\ProductImage;
use App\Modules\Backend\PromotionManagement\Entities\PromotionalProduct;
use App\Modules\Backend\SellerManagement\Entities\Seller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ProductController extends Controller
{
    use ResponseMessage;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('productmanagement::products.index');
    }

    /* Process ajax request */
    public function productList(Request $request)
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

        $query = Product::query();

        //        if (auth('seller')->user() && auth('seller')->user()->getRoleNames()->first() == 'Seller') {
        //            $query
        //                ->where('seller_id', 'like', '%' . auth()->id() . '%');
        //        }
        // Total records
        $totalRecords = $query->count();
        $totalRecordswithFilter = $totalRecords;
        // Get records, also we have included search filter as well
        if (!empty($searchValue)) {
            $query
                ->where('name', 'like', '%' . $searchValue . '%')
                ->orWhere('id', 'like', '%' . $searchValue . '%')
                ->orWhere('sku', 'like', '%' . $searchValue . '%')
                ->orWhere('unit_price', 'like', '%' . $searchValue . '%')
                ->orWhere('sale_price', 'like', '%' . $searchValue . '%')
                ->orWhere('quantity', 'like', '%' . $searchValue . '%')
                ->orWhere('description', 'like', '%' . $searchValue . '%')
                ->orWhere('total_viewed', 'like', '%' . $searchValue . '%');
            $totalRecordswithFilter = $query->count();
        }
        $records = $query
            ->with('productstock.color','productstock.size','images')
            ->withSum('orders', 'qty')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $checked = '';
            if ($record->is_active)
                $checked = 'checked';
            $image = '';
            foreach ($record->images as $k => $img) {
                $image = '<img src="' . URL::to('uploads/products/galleries/' . $img->image) . '" width="60px"
                                             height="60px" alt="product">';
                break;
            }
            $variationStock = [];

            foreach ($record->productstock as $productStock) {
                $variationStock[] = '<li>' . ($productStock->color->name ?? null) . (isset($productStock->color->name) ? '-' : '') . ($productStock->size->name ?? null) . (isset($productStock->size->name) ? '-' : '') . ($productStock->quantities ?? null) . '</li>';
            }

// Join the list items generated in the loop using implode
            $variation = implode('', $variationStock);
            $edit_route = auth('seller')->user() ? route('seller.products.edit', $record->id) : route('backend.products.edit', $record->id);
            $delete_route = auth('seller')->user() ? route('seller.products.destroy', $record->id) : route('backend.products.destroy', $record->id);
            $view_button = '';
            $edit_button = '';
            $delete_button = '';
            if (auth()->user()->can('view_products') || auth()->user()->hasRole('super-admin'))
                /*$view_button = '<li>
                                            <a class="p-0 action" href="#product-view-modal" data-bs-toggle="modal" >
                                            <button title="View" >
                                                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z"></path></svg>
                                                </button>
                                            </a>
                                </li>';*/
            if (auth()->user()->can('edit_products') || auth()->user()->hasRole('super-admin'))
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
            if (auth()->user()->can('delete_products') || auth()->user()->hasRole('super-admin'))
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
                "name" => $record->name,
                "image" => $image,
                "sku" => $record->sku,
                "unit_price" => $record->unit_price,
                "quantity" => $record->quantity,
                "variation" => $variation,
                "sold" => $record->orders_sum_qty,
                "total_viewed" => $record->total_viewed,
                "is_active" => '<div class="form-switch"><input class="form-check-input status" type="checkbox"
                                data-id="' . $record->id . '"' . $checked . '></div>',
                "action" => '<ul>
                                ' . $view_button . '
                                ' . $edit_button . '
                                ' . $delete_button . '
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
        $categories = Category::select('id', 'name', 'category_id')->where('is_active', 1)->orderBy('id', 'asc')->get();
        $categories = $this->decendentCategory($categories->toArray(), null);
        $categories = json_decode(json_encode($categories), FALSE);
        $brands = Brand::select('id', 'name')->where('is_active', 1)->orderBy('id', 'desc')->get();
        $sellers = Seller::where('is_active', 1)->get();
        $pro = Product::orderBy('id', 'desc')->first();
        $sku = 'MS' . str_pad($pro->id??0 + 1, "0", STR_PAD_LEFT);
        $colors = Color::where('is_active', 1)->get();
        $sizes = Size::where('is_active', 1)->get();

        return view('productmanagement::products.create', compact('sku', 'categories', 'brands', 'sellers', 'colors', 'sizes'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:200', 'unique:products,name'],
                'minimum_qty' => ['required', 'integer', 'min:1'],
                'category_id' => ['required', 'integer', 'exists:categories,id'],
                'brand_id' => ['nullable', 'integer', 'exists:brands,id'],
                'tags.*' => ['nullable'],
                'tags' => ['nullable', 'max: 100'],
                'barcode' => ['nullable', 'min:1'],
                'unit' => ['required', 'string', 'max:100'],
                'is_refundable' => ['nullable', 'integer'],
                'slug' => ['required', 'string', 'max:250', 'unique:products,slug'],
                'sku' => ['nullable', 'string', 'max:250'],
                'seller_id' => ['nullable', 'integer', 'exists:sellers,id'],
                'warranty' => ['nullable', 'string'],
                'return_policy' => ['nullable', 'string', 'max:100'],
                'is_manage_stock' => ['nullable', 'integer', 'max:1'],

                'images' => ['required', 'array', 'min:1', 'max:4'],
                'images.*' => ['required', 'image', 'max:10240'],
                'video_link' => ['nullable', 'url'],
                // 'colors.*' => ['nullable', 'array'],
                // 'colors' => ['nullable', 'integer', 'exists:colors,id'],
                // 'size.*' => ['nullable', 'array'],
                // 'size' => ['nullable', 'integer', 'exists:sizes,id'],
                // 'attributes.*' => ['nullable', 'array'],
                // 'attributes' => ['nullable', 'string', 'max: 100'],
                'discount' => ['nullable', 'integer'],
                'discount_type' => ['nullable', 'string', 'max:20'],
                'unit_price' => ['required', 'numeric'],
                'purchase_price' => ['nullable', 'numeric'],
                'quantity' => ['required', 'integer', 'min:1'],
                'shipping_cost' => ['nullable', 'numeric'],
                'outside_shipping_cost' => ['nullable', 'numeric'],
                'description' => ['nullable', 'string'],
                'short_description' => ['nullable', 'string', 'max:2000'],
                'specification_items' => ['nullable', 'array'],
                'specification_items.*.label' => ['nullable', 'string', 'max:255'],
                'specification_items.*.value' => ['nullable', 'string', 'max:5000'],
                'warning_quantity' => ['nullable', 'integer'],
                //Meta
                'meta_title' => ['nullable', 'string'],
                'meta_description' => ['nullable', 'string', 'max:1000'],
                'meta_image' => ['nullable', 'mimes:jpg,jpeg,bmp,png,gif,svg', 'max:1024'],
                // Shipping
                'is_free_shipping' => ['nullable', 'integer'],
                'is_flat_rate' => ['required'],
                'is_quantity_multiply' => ['required'],
                'is_product_wise_shipping' => ['required'],
                // Details
                'is_show_stock_quantity' => ['nullable', 'integer'],
                'is_show_stock_with_text_only' => ['nullable', 'integer'],
                'is_hide_stock' => ['nullable', 'integer'],
                'is_cash_on_delivery' => ['nullable', 'integer'],
                'is_featured' => ['nullable', 'integer'],
                'is_best_sell' => ['nullable', 'integer'],
                'is_todays_deal' => ['nullable', 'integer'],
                'is_flash_deal' => ['nullable', 'integer'],
                // Flash Deals
                'inside_shipping_days' => ['required', 'string'],
                'outside_shipping_days' => ['required', 'string'],
                'vat' => ['nullable', 'integer'],
                'tax' => ['nullable', 'integer'],
                'publish_stat' => ['required', 'integer'],
            ]);

            if ($request->is_manage_stock != 0 && $request->warning_quantity < 0) {
                return response()->json(__('Please enter low stock quantity warning or uncheck stock management.'), 403);
            }

            // $data['courieres'] = json_encode($request->input('courieres') ?? NULL);
            $data['attributes'] = json_encode($request->input('attributes'));

            // if ($request->previous_courieres && $request->input('courieres') == '') {
            //     $prev_product = Product::where('seller_id', $request->seller_id ?? auth('seller')->id())->whereNotNull('courieres')->latest()->first();
            //     if (!$prev_product) {
            //         return response()->json(__('Courier not found, please select available courriers.'), 403);
            //     }
            //     $data['courieres'] = json_encode($prev_product->courieres);
            // }

            $request->request->add(['name' => $request->input('name')]);
            $request->request->add(['vat' => $request->input('vat')]);
            $request->request->add(['tax' => $request->input('tax')]);

            $data = $request->only([
                'name', 'category_id', 'brand_id', 'barcode', 'unit', 'minimum_qty', 'is_refundable', 'colors', 'unit_price', 'slug', 'sku', 'shipping_cost', 'outside_shipping_cost', 'size', 'purchase_price', 'discount', 'quantity', 'description', 'short_description', 'meta_title', 'meta_description', 'is_active', 'publish_stat', 'warranty', 'return_policy', 'is_manage_stock','discount_type','tags'
            ]);
            $data['specification_items'] = $this->normalizeSpecificationItems($request->input('specification_items', []));

            $meta_image = $request->file('meta_image');
            if ($meta_image) {
                $path = Storage::putFile('products/meta_image', $meta_image);
                $pattern = "/products\/meta_image\//";
                $path = preg_replace($pattern, '', $path);
                $data['meta_image'] = $path;
            }
            if (empty($data['meta_title']))
                $data['meta_title'] = $data['name'];
            else
                $data['meta_title'] = $data['meta_title'];

            if (empty($data['slug']))
                $data['slug'] = $this->clean($data['name']);
            else
                $data['slug'] = $this->clean($data['slug']);

            $discount = $request->discount ?? 0;
            if ($request->discount_type) {
                if ($request->discount_type == 'percentage') {
                    if ($request->discount > 99) {
                        return response()->json(__('Discount may not be greater than 99.'), 403);
                    }
                    $discount = ($data['discount'] / 100) * $data['unit_price'];
                }else{
                    if ($request->discount > $request->unit_price) {
                        return response()->json(__('Discount may not be greater than unit price.'), 403);
                    }

                }
            }

            $data['sale_price'] = ($data['unit_price'] - $discount);
            $product = Product::create($data + [
                'seller_id' => $request->seller_id ?? auth('seller')->id()
            ]);

            if ($request->colors || $request->quantities) {
                $sizes = [];
                $colors = [];
                /*foreach ($request->colors as $key => $color) {
                    in_array($color, $colors) ? $color = NULL : $color = $color; array_push($colors, $color);
                    in_array($request->sizes[$key], $sizes) ? $size = NULL : $size = $request->sizes[$key]; array_push($sizes, $request->sizes[$key]);

                    Productstock::create([
                        'product_id' => $product->id,
                        'color_id' => $color,
                        'size_id' => $size,
                        'quantities' => $request->quantities[$key],
                    ]);
                }*/
                foreach ($request->colors as $key => $color) {
                    Productstock::create([
                        'product_id' => $product->id,
                        'color_id' => $color,
                        'size_id' =>  $request->sizes[$key],
                        'quantities' => $request->quantities[$key],
                    ]);
                }
            }

            if ($product) {
                $details_data = $request->only([
                    'is_free_shipping', 'is_flash_deal', 'is_flat_rate', 'is_product_wise_shipping', 'is_quantity_multiply', 'warning_quantity', 'is_show_stock_quantity', 'is_show_stock_with_text_only', 'is_hide_stock', 'is_cash_on_delivery', 'is_featured', 'is_todays_deal', 'inside_shipping_days', 'outside_shipping_days', 'vat', 'tax', 'is_best_sell'
                ]);
                if ($request->is_flash_deal==1){
                    $details_data['flash_start_at'] = date('Y-m-d', strtotime($request->flash_start_at));
                    $details_data['flash_end_at'] = date('Y-m-d', strtotime($request->flash_end_at));
                }
                $product->details()->create($details_data);
                if ($request->video_provider || $request->video_link) {
                    $video_data = $request->only(['video_provider', 'video_link']);
                    $product->video()->create($video_data);
                }
                if ($request->hasFile('images')) {
                    $this->createProductImage($request->file('images'), $product);
                }

                return response()->json([
                    'redirect' => auth('seller')->user()
                        ? route('seller.products.index')
                        : route('backend.products.index'),
                    'message' => __('Product created successfully.'),
                ]);
            } else {
                return response()->json(__('Something was wrong.'), 403);
            }
        } catch (\Throwable $ex) {
            Log::error($ex->getMessage());
            return response()->json(__('Something was wrong.'), 403);
        }
    }

    /* change status*/
    public function changeStatus(Request $request)
    {
        $product = Product::find($request->id);
        if ($product) {
            if ($request->field == 'is_active')
                $product->is_active = $request->status;
            $product->save();
            return response()->json($this->update_success_message);
        } else {
            return response()->json($this->not_found_message);
        }
    }
    /* change status*/
    public function changeStatusWholesale(Request $request)
    {
        $wholesaleProduct = Wholesale::find($request->id);
        if ($wholesaleProduct) {
            if ($request->field == 'status')
                $wholesaleProduct->status = $request->status;
            $wholesaleProduct->save();
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
        $product = Product::with('details', 'images', 'video', 'colors', 'sizes')->find($id);
        if ($product) {
            return view('productmanagement::products.show', compact('product'));
        } else {
            return back()->with($this->not_found_message);
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
        $product = Product::with('details', 'images', 'video', 'productstock')->findOrFail($id);
        $categories = Category::select('id', 'name', 'category_id')->where('is_active', 1)->orderBy('id', 'asc')->get();
        $categories = $this->decendentCategory($categories->toArray());
        $categories = json_decode(json_encode($categories), FALSE);
        $brands = Brand::select('id', 'name')->where('is_active', 1)->orderBy('id', 'desc')->get();
        $sellers = Seller::latest()->get();
        $colors = Color::where('is_active', 1)->get();
        $sizes = Size::where('is_active', 1)->get();
        return view('productmanagement::products.edit', compact('product', 'categories', 'brands', 'sellers', 'colors', 'sizes'));
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
                'name' => ['required', 'string', 'max:200', 'unique:products,name,' . $id],
                'slug' => ['required', 'string', 'max:250', 'unique:products,slug,' . $id],
                'minimum_qty' => ['required', 'integer', 'min:1'],
                'category_id' => ['required', 'integer', 'exists:categories,id'],
                'brand_id' => ['nullable', 'integer', 'exists:brands,id'],
                'tags.*' => ['nullable'],
                'tags' => ['nullable', 'max: 100'],
                'barcode' => ['nullable', 'min:1'],
                'unit' => ['required', 'string', 'max:100'],
                'is_refundable' => ['nullable', 'integer'],
                'sku' => ['nullable', 'string', 'max:250'],
                'seller_id' => ['nullable', 'integer', 'exists:sellers,id'],
                'warranty' => ['nullable', 'string'],
                'return_policy' => ['nullable', 'string', 'max:100'],
                'is_manage_stock' => ['nullable', 'integer', 'max:1'],

                'images' => ['nullable', 'array', 'max:4'],
                'images.*' => ['image', 'max:10240'],
                'old_images' => ['nullable', 'array'],
                'old_images.*' => ['integer'],
                'video_link' => ['nullable', 'url'],
                // 'colors.*' => ['nullable', 'array'],
                // 'colors' => ['nullable', 'integer', 'exists:colors,id'],
                // 'size.*' => ['nullable', 'array'],
                // 'size' => ['nullable', 'integer', 'exists:sizes,id'],
                // 'attributes.*' => ['nullable', 'array'],
                // 'attributes' => ['nullable', 'string', 'max: 100'],
                'discount' => ['nullable', 'integer'],
                'discount_type' => ['nullable', 'string', 'max:20'],
                'unit_price' => ['required', 'numeric'],
                'purchase_price' => ['nullable', 'numeric'],
                'quantity' => ['required', 'integer', 'min:1'],
                'shipping_cost' => ['nullable', 'numeric'],
                'outside_shipping_cost' => ['nullable', 'numeric'],
                'description' => ['nullable', 'string'],
                'short_description' => ['nullable', 'string', 'max:2000'],
                'specification_items' => ['nullable', 'array'],
                'specification_items.*.label' => ['nullable', 'string', 'max:255'],
                'specification_items.*.value' => ['nullable', 'string', 'max:5000'],
                'warning_quantity' => ['nullable', 'integer'],
                //Meta
                'meta_title' => ['nullable', 'string'],
                'meta_description' => ['nullable', 'string', 'max:1000'],
                'meta_image' => ['nullable', 'mimes:jpg,jpeg,bmp,png,gif,svg', 'max:1024'],
                // Shipping
                'is_free_shipping' => ['nullable', 'integer'],
                'is_flat_rate' => ['required'],
                'is_quantity_multiply' => ['required'],
                'is_product_wise_shipping' => ['required'],
                // Details
                'is_show_stock_quantity' => ['nullable', 'integer'],
                'is_show_stock_with_text_only' => ['nullable', 'integer'],
                'is_hide_stock' => ['nullable', 'integer'],
                'is_cash_on_delivery' => ['nullable', 'integer'],
                'is_featured' => ['nullable', 'integer'],
                'is_best_sell' => ['nullable', 'integer'],
                'is_todays_deal' => ['nullable', 'integer'],
                'is_flash_deal' => ['nullable', 'integer'],
                // Flash Deals
                'inside_shipping_days' => ['required', 'string'],
                'outside_shipping_days' => ['required', 'string'],
                'vat' => ['nullable', 'integer'],
                'tax' => ['nullable', 'integer'],
                'publish_stat' => ['required', 'integer'],
            ]);

            if ($request->is_manage_stock != 0 && $request->warning_quantity < 0) {
                return response()->json(__('Please enter low stock quantity warning or uncheck stock management.'), 403);
            }

            $keptOldIds = array_filter((array) $request->input('old_images', []));
            if (count($keptOldIds) === 0 && ! $request->hasFile('images')) {
                return response()->json([
                    'errors' => ['images' => [__('At least one product image is required.')]],
                ], 422);
            }

            $product = Product::find($id);
            if ($product) {
                $data = $request->only([
                    'name', 'category_id', 'brand_id', 'barcode', 'slug', 'sku', 'unit', 'minimum_qty', 'is_refundable', 'colors', 'unit_price', 'purchase_price', 'discount', 'quantity', 'description', 'short_description', 'meta_title', 'meta_description', 'is_active', 'publish_stat', 'shipping_cost', 'outside_shipping_cost', 'size', 'seller_id', 'warranty', 'return_policy', 'discount_type', 'is_manage_stock'
                ]);
                $data['specification_items'] = $this->normalizeSpecificationItems($request->input('specification_items', []));
                if (empty($data['meta_title']))
                    $data['meta_title'] = $data['name'];
                else
                    $data['meta_title'] = $data['meta_title'];

                if (empty($data['slug']))
                    $data['slug'] = $this->clean($data['name']);
                else
                    $data['slug'] = $this->clean($data['slug']);

                $meta_image = $request->file('meta_image');
                if ($meta_image) {
                    $path = Storage::putFile('products/meta_image', $meta_image);
                    $pattern = "/products\/meta_image\//";
                    $path = preg_replace($pattern, '', $path);
                    $data['meta_image'] = $path;
                    if (file_exists(storage_path('app/public/products/meta_image/') . $product->meta_image)) {
                        Storage::delete('products/meta_image/' . $product->meta_image);
                    }
                }
                if (!$this->hasPromotion($product->id))
                    $data['sale_price'] = ($data['unit_price'] - $data['discount']);

                $discount = $request->discount ?? 0;
                if ($request->discount_type) {
                    if ($request->discount_type == 'percentage') {
                        if ($request->discount>99){
                            return response()->json(__('Discount may not be greater than 99.'), 403);
                        }
                        $discount = ($data['unit_price'] / 100) * $data['discount'];
                    }else{
                        if ($request->discount > $request->unit_price) {
                            return response()->json(__('Discount may not be greater than unit price.'), 403);
                        }

                    }
                }

                $data['sale_price'] = ($data['unit_price'] - $discount);

                $data['tags'] = $request->input('tags');
                // $data['courieres'] = $request->input('courieres') ?? NULL;
                $data['attributes'] = json_encode($request->input('attributes'));

                // if ($request->previous_courieres && $request->input('courieres') == '') {
                //     $prev_product = Product::where('seller_id', $request->seller_id ?? auth('seller')->id())->whereNotNull('courieres')->latest()->first();
                //     if (!$prev_product) {
                //         return response()->json(__('Courier not found, please select available courriers.'), 403);
                //     }
                //     $data['courieres'] = $prev_product->courieres;
                // }

                Productstock::where('product_id', $product->id)->delete();
                if ($request->has('colors') && is_array($request->colors)) {
                    $sizesInput = $request->input('sizes', []);
                    $quantitiesInput = $request->input('quantities', []);
                    foreach ($request->colors as $key => $color) {
                        if ($color === '' || $color === null) {
                            continue;
                        }
                        Productstock::create([
                            'product_id' => $product->id,
                            'color_id' => $color,
                            'size_id' => $sizesInput[$key] ?? null,
                            'quantities' => $quantitiesInput[$key] ?? 0,
                        ]);
                    }
                }

                $product->update($data);

                $details_data = $request->only([
                    'is_free_shipping', 'is_flat_rate', 'is_product_wise_shipping', 'is_quantity_multiply', 'warning_quantity', 'is_show_stock_quantity', 'is_show_stock_with_text_only', 'is_hide_stock', 'is_cash_on_delivery', 'is_featured', 'is_todays_deal', 'is_flash_deal', 'inside_shipping_days', 'outside_shipping_days', 'vat', 'tax', 'is_best_sell'
                ]);
                if ($request->is_flash_deal==1){
                    $details_data['flash_start_at'] = $request->flash_start_at?date('Y-m-d', strtotime($request->flash_start_at)):null;
                    $details_data['flash_end_at'] = $request->flash_end_at?date('Y-m-d', strtotime($request->flash_end_at)):null;
                }

                if ($product->details) {
                    $product->details()->update($details_data);
                } else {
                    $product->details()->create($details_data);
                }

                if ($request->video_provider || $request->video_link) {
                    $video_data = $request->only(['video_provider', 'video_link']);
                    if ($product->has('video')) {
                        $product->video()->update($video_data);
                    } else {
                        $product->video()->create($video_data);
                    }
                }

                $image_ids = $request->input('old_images');
                if ($image_ids)
                    $this->deleteImage($image_ids, $product->id);
                else
                    $this->deleteImage([], $product->id);
                if ($request->hasFile('images')) {
                    $this->createProductImage($request->file('images'), $product);
                }

                return response()->json([
                    'redirect' => auth('seller')->user()
                        ? route('seller.products.index')
                        : route('backend.products.index'),
                    'message' => __('Product updated successfully.'),
                ]);
            } else {
                return response()->json(__('Something was wrong.'), 403);
            }
        } catch (\Throwable $ex) {
            Log::error($ex->getMessage());
            return response()->json(__('Something was wrong.'), 403);
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
            $product = Product::with('details', 'images', 'video')->find($id);
            if ($product) {
                if ($product->promotion()->exists()) {
                    return back()->with([
                        'message' => 'Product has promotion. Delete promotion First',
                        'alert-type' => 'info',
                    ]);
                }

                if (file_exists(storage_path('app/public/products/pdf/') . $product->pdf_specification)) {
                    Storage::delete('products/pdf/' . $product->pdf_specification);
                }
                if (file_exists(storage_path('app/public/products/meta_image/') . $product->meta_image)) {
                    Storage::delete('products/meta_image/' . $product->meta_image);
                }

                if ($product->has('details'))
                    $product->details()->delete();
                if ($product->has('images')) {
                    $this->deleteImage([], $product->id);
                    $product->images()->delete();
                }
                if ($product->has('video'))
                    $product->video()->delete();
                $product->delete();
                if (auth('seller')->user())
                    return redirect()->route('seller.products.index')->with($this->delete_success_message);
                else
                    return redirect()->route('backend.products.index')->with($this->delete_success_message);
            } else {
                return back()->withInput()->with($this->not_found_message);
            }
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return back()->with([
                'alert-type' => 'error',
                'message' => $ex->getMessage()
            ]);
        }
    }

    private function clean($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    public function decendentCategory(array $elements, $parentId = null): array
    {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['category_id'] == $parentId || is_null($parentId)) {
                $children = $this->decendentCategory($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }

    /* product image creation */

    private function createProductImage($images, $product)
    {
        $files = array_values(array_filter(Arr::wrap($images), function ($file) {
            return $file instanceof UploadedFile && $file->isValid();
        }));

        foreach ($files as $image) {
            $image_path = Storage::putFile('products/galleries', $image);
            $pattern = '/products\/galleries\//';
            $image_path = preg_replace($pattern, '', $image_path);
            $product->images()->create(['image' => $image_path]);
        }
    }

    private function deleteImage($image_ids, $id)
    {
        $old_image_ids = ProductImage::where('product_id', $id)->pluck('id')->toArray();
        foreach ($image_ids as $key => $image_id) {
            if ($image_id) {
                if (($index = array_search($image_id, $old_image_ids)) !== false) {
                    unset($old_image_ids[$index]);
                }
            }
        }
        foreach ($old_image_ids as $image_id) {
            $img = ProductImage::find($image_id);
            //delete from disk
            if ($img) {
                if (file_exists(storage_path('app/public/products/galleries/') . $img->image)) {
                    Storage::delete('products/galleries/' . $img->image);
                }
                $img->delete();
            }
        }
    }

    function hasPromotion($product): bool
    {
        return PromotionalProduct::query()->where('product_id', $product)
            ->where(function ($q) {
                $q->where('expire_at', '>', now())->orWhere('expire_at', null);
            })
            ->where('is_active', 1)
            ->where('is_approve', 1)
            ->exists();
    }

    public function productWholesale(Request $request)
    {
        //$products = Product::where('wholesale_status', 1)->select('id', 'name')->with('wholesales')->latest()->paginate(10);
        $products = Product::where('wholesale_status', 1)->where('name','like', '%' . $request->search . '%')->select('id', 'name')->latest()->paginate(10);
        return view('productmanagement::wholesales.index', compact('products'));
    }

    public function productWholesaleList(Request $request)
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

        $query = Product::query();
        $query = $query->where('wholesale_status', 1);

        //        if (auth('seller')->user() && auth('seller')->user()->getRoleNames()->first() == 'Seller') {
        //            $query
        //                ->where('seller_id', 'like', '%' . auth()->id() . '%');
        //        }
        // Total records
        $totalRecords = $query->count();
        $totalRecordswithFilter = $totalRecords;
        // Get records, also we have included search filter as well
        if (!empty($searchValue)) {
            $query
                ->where('name', 'like', '%' . $searchValue . '%');
            $totalRecordswithFilter = $query->count();
        }
        $records = $query
            ->with('wholesales')
            ->withSum('orders', 'qty')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $checked = '';
            if ($record->is_active)
                $checked = 'checked';
            $min_ranage = '';
            $in_table = '';
            $tr = '';
            //$in_table = '<table class="inner-table-product-qty">';
            foreach ($record->wholesales as $k => $wholesale) {
                $min_ranage = 'hello';
                //break;
            }
            //$in_table ='</table>';
            $edit_route = auth('seller')->user() ? route('seller.products.edit', $record->id) : route('backend.products.edit', $record->id);
            $delete_route = auth('seller')->user() ? route('seller.products.destroy', $record->id) : route('backend.products.destroy', $record->id);
            $view_button = '';
            $edit_button = '';
            $delete_button = '';
            if (auth()->user()->can('view_products') || auth()->user()->hasRole('super-admin'))
                /*$view_button = '<li>
                                            <a class="p-0 action" href="#product-view-modal" data-bs-toggle="modal" >
                                            <button title="View" >
                                                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z"></path></svg>
                                                </button>
                                            </a>
                                </li>';*/
                if (auth()->user()->can('edit_products') || auth()->user()->hasRole('super-admin'))
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
            if (auth()->user()->can('delete_products') || auth()->user()->hasRole('super-admin'))
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
                "name" => $record->name,
                "in_table" => $in_table,
                "min_ranage" => $min_ranage,

                "total_viewed" => $record->total_viewed,
                "is_active" => '<div class="form-switch"><input class="form-check-input status" type="checkbox"
                                data-id="' . $record->id . '"' . $checked . '></div>',
                "action" => '<ul>
                                ' . $view_button . '
                                ' . $edit_button . '
                                ' . $delete_button . '
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

    public function productWholesaleForm()
    {
        $products = Product::select('id', 'name', 'sale_price')->latest()->get();
        return view('productmanagement::wholesales.form', compact('products'));
    }

    public function wholesaleStore(Request $request)
    {
        $request->validate([
            'product_id' => 'required'
        ]);
        //return $request;
        foreach ($request->min_range as $index => $value) {
            $wholesales = new Wholesale();
            $wholesales->product_id = $request->product_id;
            $wholesales->min_range = $value;
            $wholesales->max_range = $request->max_range[$index];
            $wholesales->price = $request->price[$index];
            $wholesales->save();
        }
        Product::where('id', $request->product_id)->update(['wholesale_status' => 1]);

        return redirect()->route('backend.products.wholesale')->with([
            'message' => 'Product Wholesale Created!',
            'alert-type' => 'info',
        ]);
    }

    public function wholesaleEdit($productId)
    {
        $products = Product::select('id', 'name', 'sale_price')->latest()->get();
        $wholesales = Wholesale::where('product_id',$productId)->get();
        return view('productmanagement::wholesales.edit', compact('wholesales','products'));
    }

    public function wholesaleUpdate(Request $request,$product_id)
    {
        $request->validate([
            'product_id' => 'required'
        ]);
        if ( Wholesale::where('product_id',$product_id)->exists()){
            Wholesale::where('product_id',$product_id)->delete();
        }
        foreach ($request->min_range as $index => $value) {
            $wholesales = new Wholesale();
            $wholesales->product_id = $request->product_id;
            $wholesales->min_range = $value;
            $wholesales->max_range = $request->max_range[$index];
            $wholesales->price = $request->price[$index];
            $wholesales->save();
        }
        Product::where('id', $request->product_id)->update(['wholesale_status' => 1]);

        //return$request;

        //$data = $request->only('min_range', 'max_range', 'price');
        //$wholesale->update($data);

        return redirect()->route('backend.products.wholesale')->with($this->update_success_message);
    }

    public function wholesaleDestroy($productId)
    {

        if (Wholesale::where('product_id', $productId)->count() == 1) {
            Product::where('id', $productId)->update(['wholesale_status' => 0]);
            Wholesale::where('product_id', $productId)->delete();
        } else {
            Wholesale::where('product_id', $productId)->delete();
        }
        return redirect()->back()->with($this->delete_success_message);
    }

    public function wholesaleAjax(Request $request)
    {
        if ($request->ajax()){
            $products = Wholesale::where('product_id',$request->product_id)->get();
            return $products;
        }
    }
    public function productFlashDeal()
    {
        return view('productmanagement::flash_deal.flash_deal');
    }
    public function productFlashDealList(Request $request)
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

        $query = Product::query()->whereHas('details', function($q){
            $q->where('flash_end_at', '>=', Carbon::now())
                ->whereOr('is_flash_deal', 1);
        });

        //        if (auth('seller')->user() && auth('seller')->user()->getRoleNames()->first() == 'Seller') {
        //            $query
        //                ->where('seller_id', 'like', '%' . auth()->id() . '%');
        //        }
        // Total records
        $totalRecords = $query->count();
        $totalRecordswithFilter = $totalRecords;
        // Get records, also we have included search filter as well
        if (!empty($searchValue)) {
            $query
                ->where('name', 'like', '%' . $searchValue . '%')
                ->orWhere('id', 'like', '%' . $searchValue . '%')
                ->orWhere('sku', 'like', '%' . $searchValue . '%')
                ->orWhere('unit_price', 'like', '%' . $searchValue . '%')
                ->orWhere('sale_price', 'like', '%' . $searchValue . '%')
                ->orWhere('quantity', 'like', '%' . $searchValue . '%')
                ->orWhere('description', 'like', '%' . $searchValue . '%')
                ->orWhere('total_viewed', 'like', '%' . $searchValue . '%');
            $totalRecordswithFilter = $query->count();
        }
        $records = $query
            ->with('images','details')
            ->withSum('orders', 'qty')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $checked = '';
            if ($record->details->is_flash_deal)
                $checked = 'checked';
            $image = '';
            foreach ($record->images as $k => $img) {
                $image = '<img src="' . URL::to('uploads/products/galleries/' . $img->image) . '" width="60px"
                                             height="60px" alt="product">';
                break;
            }
            $edit_route = auth('seller')->user() ? route('seller.products.edit', $record->id) : route('backend.products.edit', $record->id);
            //$delete_route = auth('seller')->user() ? route('seller.products.destroy', $record->id) : route('backend.products.destroy', $record->id);
            $view_button = '';
            $edit_button = '';
            $delete_button = '';


            $data_arr[] = array(
                "id" => $record->id,
                "name" => $record->name,
                "image" => $image,
                "unit_price" => $record->unit_price,
                "quantity" => $record->quantity,
                "sold" => $record->orders_sum_qty,
                "total_viewed" => $record->total_viewed,
                "is_active" => '<div class="form-switch"><input class="form-check-input status" type="checkbox"
                                data-id="' . $record->details->id . '"' . $checked . '></div>',
                "start_date"=> date('Y-m-d', strtotime($record->details->flash_start_at)),
                "end_date"=> date('Y-m-d', strtotime($record->details->flash_end_at)),

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
    public function flashDealchangeStatus(Request $request)
    {
        $productDetail = ProductDetail::find($request->id);
        if ($productDetail) {
            if ($request->field == 'is_active')
                $productDetail->is_flash_deal = $request->status;
            $productDetail->save();
            return response()->json($this->update_success_message);
        } else {
            return response()->json($this->not_found_message);
        }
    }

    /**
     * @param  array<int, array<string, mixed>|mixed>|null  $rows
     * @return array<int, array{label: string, value: string}>
     */
    private function normalizeSpecificationItems(?array $rows): array
    {
        if ($rows === null || $rows === []) {
            return [];
        }
        $out = [];
        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }
            $label = isset($row['label']) ? trim((string) $row['label']) : '';
            $value = isset($row['value']) ? trim((string) $row['value']) : '';
            if ($label === '' && $value === '') {
                continue;
            }
            $out[] = ['label' => $label, 'value' => $value];
        }

        return $out;
    }

}
