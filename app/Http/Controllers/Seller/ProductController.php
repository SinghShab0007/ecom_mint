<?php

namespace App\Http\Controllers\Seller;

use App\Models\Backend\Size;
use App\Models\Productstock;
use Illuminate\Http\Request;
use App\Models\Backend\Color;
use App\Models\Seller\Wholesale;
use App\Models\Seller\ProductImage;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use App\Models\Seller\PromotionalProduct;
use App\Modules\Backend\ProductManagement\Entities\Brand;
use App\Modules\Backend\SellerManagement\Entities\Seller;
use App\Modules\Backend\ProductManagement\Entities\Product;
use App\Modules\Backend\ProductManagement\Entities\Category;

class ProductController extends Controller
{
    use ResponseMessage;

    public function index()
    {
        $products = Product::query()
            ->where('seller_id',auth('seller')->id())
            ->latest()
            ->paginate(20);

        return view('seller.product.index',compact('products'));
    }

    public function create()
    {
        $categories = Category::select('id', 'name', 'category_id')->where('is_active', 1)->orderBy('id', 'asc')->get();
        $categories = $this->decendentCategory($categories->toArray(), null);
        $categories = json_decode(json_encode($categories), FALSE);
        $brands = Brand::select('id', 'name')->where('is_active', 1)->orderBy('id', 'desc')->get();
        $sellers = Seller::where('is_active', 1)->get();
        $pro = Product::orderBy('id', 'desc')->first();
        $sku = 'MS' . str_pad($pro->id + 1, "0", STR_PAD_LEFT);
        $colors = Color::where('is_active', 1)->get();
        $sizes = Size::where('is_active', 1)->get();

        return view('seller.product.create', compact('sku', 'categories', 'brands', 'colors', 'sizes'));
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
                'unit_price' => ['required', 'integer'],
                'purchase_price' => ['nullable', 'integer'],
                'quantity' => ['required', 'integer', 'min:1'],
                'shipping_cost' => ['nullable', 'integer'],
                'outside_shipping_cost' => ['nullable', 'integer'],
                'description' => ['nullable', 'string'],
                'pdf_specification' => ['nullable', 'mimes:pdf', 'max:50124'],
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

            $data['tags'] = json_encode($request->input('tags'));
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
                'name', 'category_id', 'brand_id', 'barcode', 'unit', 'minimum_qty', 'is_refundable', 'colors', 'unit_price', 'slug', 'sku', 'shipping_cost', 'outside_shipping_cost', 'size', 'purchase_price', 'discount', 'quantity', 'description', 'meta_title', 'meta_description', 'is_active', 'publish_stat', 'warranty', 'return_policy', 'is_flash_deal', 'is_manage_stock'
            ]);

            $pdf = $request->file('pdf_specification');
            if ($pdf) {
                $path = Storage::putFile('products/pdf', $pdf);
                $pattern = "/products\/pdf\//";
                $path = preg_replace($pattern, '', $path);
                $data['pdf_specification'] = $path;
            }
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
                    $discount = ($data['unit_price'] / 100) * $data['discount'];
                }
            }

            $data['sale_price'] = ($data['unit_price'] - $discount);
            $product = Product::create($data + [
                'seller_id' => auth('seller')->id()
            ]);

            if ($request->colors || $request->quantities) {
                $sizes = [];
                $colors = [];
                foreach ($request->colors as $key => $color) {
                    in_array($color, $colors) ? $color = NULL : $color = $color; array_push($colors, $color);
                    in_array($request->sizes[$key], $sizes) ? $size = NULL : $size = $request->sizes[$key]; array_push($sizes, $request->sizes[$key]);

                    Productstock::create([
                        'product_id' => $product->id,
                        'color_id' => $color,
                        'size_id' => $size,
                        'quantities' => $request->quantities[$key],
                    ]);
                }
            }

            if ($product) {
                $details_data = $request->only([
                    'is_free_shipping', 'is_flat_rate', 'is_product_wise_shipping', 'is_quantity_multiply', 'warning_quantity', 'is_show_stock_quantity', 'is_show_stock_with_text_only', 'is_hide_stock', 'is_cash_on_delivery', 'is_featured', 'is_todays_deal', 'inside_shipping_days', 'outside_shipping_days', 'vat', 'tax', 'is_best_sell'
                ]);
                $product->details()->create($details_data);
                $video_data = $request->only(['video_provider', 'video_link']);
                $product->video()->create($video_data);
                if ($request->hasFile('images')) {
                    $this->createProductImage($request->file('images'), $product);
                }

                return response()->json([
                    'redirect' => route('seller.products'),
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

    public function edit($id)
    {
        $product = Product::with('details', 'images', 'video', 'productstock')->findOrFail($id);
        $categories = Category::select('id', 'name', 'category_id')->where('is_active', 1)->orderBy('id', 'asc')->get();
        $categories = $this->decendentCategory($categories->toArray());
        $categories = json_decode(json_encode($categories), FALSE);
        $brands = Brand::select('id', 'name')->where('is_active', 1)->orderBy('id', 'desc')->get();
        $sellers = Seller::where('is_active', 1)->get();
        $colors = Color::where('is_active', 1)->get();
        $sizes = Size::where('is_active', 1)->get();
        return view('seller.product.edit', compact('product', 'categories', 'brands', 'sellers', 'colors', 'sizes'));
    }

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
                'discount' => ['nullable', 'integer', 'max:99'],
                'discount_type' => ['nullable', 'string', 'max:20'],
                'unit_price' => ['required', 'integer'],
                'purchase_price' => ['nullable', 'integer'],
                'quantity' => ['required', 'integer', 'min:1'],
                'shipping_cost' => ['nullable', 'integer'],
                'outside_shipping_cost' => ['nullable', 'integer'],
                'description' => ['nullable', 'string'],
                'pdf_specification' => ['nullable', 'mimes:pdf', 'max:50124'],
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
                    'name', 'category_id', 'brand_id', 'barcode', 'slug', 'sku', 'unit', 'minimum_qty', 'is_refundable', 'colors', 'unit_price', 'purchase_price', 'discount', 'quantity', 'description', 'meta_title', 'meta_description', 'is_active', 'publish_stat', 'shipping_cost', 'outside_shipping_cost', 'size', 'seller_id', 'warranty', 'return_policy', 'discount_type', 'is_manage_stock'
                ]);
                if (empty($data['meta_title']))
                    $data['meta_title'] = $data['name'];
                else
                    $data['meta_title'] = $data['meta_title'];

                if (empty($data['slug']))
                    $data['slug'] = $this->clean($data['name']);
                else
                    $data['slug'] = $this->clean($data['slug']);

                $pdf = $request->file('pdf_specification');
                if ($pdf) {
                    $path = Storage::putFile('products/pdf', $pdf);
                    $pattern = "/products\/pdf\//";
                    $path = preg_replace($pattern, '', $path);
                    $data['pdf_specification'] = $path;
                    if (file_exists(storage_path('app/public/products/pdf/') . $product->pdf_specification)) {
                        Storage::delete('products/pdf/' . $product->pdf_specification);
                    }
                }
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
                        $discount = ($data['unit_price'] / 100) * $data['discount'];
                    }
                }

                $data['sale_price'] = ($data['unit_price'] - $discount);

                $data['tags'] = json_encode($request->input('tags'));
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
                if ($product->details) {
                    $product->details()->update($details_data);
                } else {
                    $product->details()->create($details_data);
                }
                $video_data = $request->only(['video_provider', 'video_link']);
                if ($product->has('video')) {
                    $product->video()->update($video_data);
                } else {
                    $product->video()->create($video_data);
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
                    'redirect' => route('seller.products'),
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

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
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
            return redirect()->route('seller.products')->with($this->delete_success_message);
        } else {
            return back()->withInput()->with($this->not_found_message);
        }
    }

    private function deleteImage($image_ids, $id)
    {
        $old_image_ids = ProductImage::query()->where('product_id', $id)->pluck('id')->toArray();
        foreach ($image_ids as $key => $image_id) {
            if ($image_id) {
                if (($index = array_search($image_id, $old_image_ids)) !== false) {
                    unset($old_image_ids[$index]);
                }
            }
        }
        foreach ($old_image_ids as $image_id) {
            $img = ProductImage::query()->find($image_id);
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

    public function productWholesale()
    {
        $products = Product::query()
            ->where('seller_id',auth('seller')->id())
            ->where('wholesale_status',1)
            ->select('id','name')
            ->latest()
            ->paginate(20);
        return view('seller.wholesales.index',compact('products'));
    }

    public function productWholesaleForm()
    {
        $products = Product::where('seller_id',auth('seller')->id())
        ->select('id','name','sale_price')->latest()->get();
        return view('seller.wholesales.form',compact('products'));
    }

    public function wholesaleStore(Request $request)
    {
        $request->validate([
            'product_id'=>'required'
        ]);

        foreach ($request->min_range as $index=>$value){
            $wholesales = new Wholesale();
            $wholesales->product_id = $request->product_id;
            $wholesales->min_range = $value;
            $wholesales->max_range = $request->max_range[$index];
            $wholesales->price = $request->price[$index];
            $wholesales->save();
        }
        Product::where('id',$request->product_id)->update(['wholesale_status'=>1]);

        return redirect()->route('seller.products.wholesale')->with($this->create_success_message);
    }

    public function wholesaleEdit(Wholesale $wholesale)
    {
        return view('seller.wholesales.edit',compact('wholesale'));
    }

    public function wholesaleUpdate(Request $request, Wholesale $wholesale)
    {
        $request->validate([
            'product_id'=>'required'
        ]);
        $data = $request->only('min_range','max_range','price');
        $wholesale->update($data);

        return redirect()->route('seller.products.wholesale')->with($this->update_success_message);
    }

    public function wholesaleDestroy(Wholesale $wholesale)
    {
        if (Wholesale::where('product_id',$wholesale->product_id)->count()==1) {
            Product::where('id',$wholesale->product_id)->update(['wholesale_status'=>0]);
            $wholesale->delete();
        }else {
            $wholesale->delete();
        }
        return redirect()->back()->with($this->delete_success_message);
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
}
