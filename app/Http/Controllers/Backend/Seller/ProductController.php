<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseMessage;
use App\Models\Backend\Color;
use App\Models\Backend\Size;
use App\Models\Seller\Wholesale;
use App\Models\Seller\Product;
use App\Models\Seller\ProductImage;
use App\Models\Seller\PromotionalProduct;
use App\Modules\Backend\ProductManagement\Entities\Brand;
use App\Modules\Backend\ProductManagement\Entities\Category;
use App\Modules\Backend\SellerManagement\Entities\Seller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Mockery\CountValidator\Exception;

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
        $product = new Product();
        $categories = Category::query()
            ->select('id', 'name', 'category_id')
            ->where('is_active', 1)
            ->orderBy('id', 'asc')
            ->get();

        //$categories = $this->decendentCategory($categories->toArray(),null);
        //$categories = json_decode(json_encode($categories), FALSE);
        $brands = Brand::query()
            ->select('id', 'name')
            ->where('is_active', 1)
            ->orderBy('id', 'desc')
            ->get();

        $sellers = Seller::query()
            ->where('is_active', 1)
            ->get();

        //$pro = Product::orderBy('id', 'desc')->first();
        //if ($pro) {
        //$length = (strlen((string)$pro->id));
        //$length = $length > 5 ? $length : 5;
        //$product->sku = 'MS' . str_pad($pro->id + 1, $length, "0", STR_PAD_LEFT);
        //} else {
        //$product->sku = 'MS' . str_pad('1', 5, "0", STR_PAD_LEFT);
        //}
        //$product->unit = 'Piece';
        $colors = Color::query()->where('is_active', 1)->get();
        $sizes = Size::query()->where('is_active', 1)->get();

        return view('seller.product.create', compact('product','categories', 'brands', 'sellers', 'colors', 'sizes'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:200'],
                'category_id' => ['required'],
                //'seller_id' => ['required'],
                'unit' => ['required'],
                'minimum_qty' => ['required'],
                'quantity' => ['required'],
                'purchase_price' => ['required'],
                'unit_price' => ['required'],
                'warning_quantity' => ['required'],
                'pdf_specification' => ['nullable', 'mimes:pdf', 'max:540288'],
                'meta_image' => ['nullable', 'mimes:jpg,jpeg,bmp,png,gif,svg', 'max:540288'],
                'inside_shipping_days' => ['required'],
                'outside_shipping_days' => ['required'],
                'flash_deal_title' => ['required_with:flash_deal_discount'],
                'flash_deal_discount' => ['required_with:flash_deal_title'],
                'flash_deal_discount_type' => ['required_with:flash_deal_discount'],
                'images' => ['required'],
                'images.*' => ['image', 'mimes:jpg,jpeg,bmp,png,gif,svg', 'max:10240'],
            ]);
            if ($request->input('tags') != '') {
                $tags = implode(',', $request->input('tags'));
                $request->request->remove('tags');
                $request->request->add(['tags' => $tags]);
            }
            $request->request->add(['name' => $request->input('name')]);
            $request->request->add(['vat' => $request->input('vat')]);
            $request->request->add(['tax' => $request->input('tax')]);

            if ($request->has('is_draft')) {
                $request->request->add(['publish_stat' => 1]);
            }
            if ($request->has('is_publish')) {
                $request->request->add(['publish_stat' => 2]);
            }
            if ($request->has('is_unpublish')) {
                $request->request->add(['publish_stat' => 0]);
            }
            $data = $request->only([
                'name', 'category_id', 'brand_id', 'barcode', 'unit', 'minimum_qty', 'tags', 'is_refundable', 'colors', 'attributes',
                'unit_price', 'slug', 'sku', 'shipping_cost', 'size', 'seller_id',
                'purchase_price', 'discount', 'quantity', 'description', 'meta_title', 'meta_description', 'is_active', 'publish_stat'
            ]);
            if ($request->input('attributes') != '') {
                $attributes = $request->input('attributes');
                $data['attributes'] = json_encode($attributes, JSON_FORCE_OBJECT);
            }

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
            $data['sale_price'] = ($data['unit_price'] - $data['discount']);
            $data['seller_id'] = auth('seller')->id();
            $product = \App\Modules\Backend\ProductManagement\Entities\Product::query()->create($data);
            if ($product) {
                if ($request->input('colors') != '') {
                    $colors = $request->input('colors');
                    $colors = array_map(
                        function ($value) {
                            return (int)$value;
                        },
                        $colors
                    );
                    $product->colors()->attach($colors);
                }
                if ($request->input('size') != '') {
                    $sizes = $request->input('size');
                    $sizes = array_map(
                        function ($value) {
                            return (int)$value;
                        },
                        $sizes
                    );
                    $product->sizes()->attach($sizes);
                }
                $details_data = $request->only([
                    'is_free_shipping', 'is_flat_rate', 'is_product_wise_shipping', 'is_quantity_multiply', 'warning_quantity', 'is_show_stock_quantity',
                    'is_show_stock_with_text_only', 'is_hide_stock', 'is_cash_on_delivery', 'is_featured', 'is_todays_deal', 'flash_deal_title', 'flash_deal_discount',
                    'flash_deal_discount_type', 'inside_shipping_days', 'outside_shipping_days', 'vat', 'tax', 'is_best_sell'
                ]);
                $product->details()->create($details_data);
                $video_data = $request->only(['video_provider', 'video_link', '']);
                $product->video()->create($video_data);
                $images = $request->file('images');
                if (count($images)) {
                    $this->createProductImage($images, $product);
                }
                return redirect()->route('seller.products')->with($this->create_success_message);
            } else {
                return back()->withInput()->with($this->create_fail_message);
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return back()->withInput()->with($this->create_fail_message);
        }
    }

    public function edit($id)
    {
        $product = Product::query()
            ->with('details', 'images', 'video', 'colors', 'sizes')
            ->find($id);

        if ($product) {
            $categories = Category::select('id', 'name', 'category_id')->where('is_active', 1)->orderBy('id', 'asc')->get();
            $categories = $this->decendentCategory($categories->toArray());
            $categories = json_decode(json_encode($categories), FALSE);
            $brands = Brand::select('id', 'name')->where('is_active', 1)->orderBy('id', 'desc')->get();
            $sellers = Seller::where('is_active', 1)->get();
            $colors = Color::where('is_active', 1)->get();
            $sizes = Size::where('is_active', 1)->get();
            return view('seller.product.edit', compact('product', 'categories', 'brands', 'sellers', 'colors', 'sizes'));
        } else {
            return back()->with($this->not_found_message);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'category_id' => ['required'],
            //'seller_id' => ['required'],
            'unit' => ['required'],
            'minimum_qty' => ['required'],
            'quantity' => ['required'],
            'shipping_cost' => ['required'],
            'purchase_price' => ['required'],
            'unit_price' => ['required'],
            'warning_quantity' => ['required'],
            'pdf_specification' => ['nullable', 'mimes:pdf', 'max:540288'],
            'meta_image' => ['nullable', 'mimes:jpg,jpeg,bmp,png,gif,svg', 'max:540288'],
            'inside_shipping_days' => ['required'],
            'outside_shipping_days' => ['required'],
            'flash_deal_title' => ['required_with:flash_deal_discount'],
            'flash_deal_discount' => ['required_with:flash_deal_title'],
            'flash_deal_discount_type' => ['required_with:flash_deal_discount'],
            'images' => ['required_without:old_images'],

        ]);
        if ($request->input('tags') != '') {
            $tags = implode(',', $request->input('tags'));
            $request->request->remove('tags');
            $request->request->add(['tags' => $tags]);
        }
        $product = Product::query()->find($id);
        if ($product) {
            $data = $request->only([
                'name', 'category_id', 'brand_id', 'barcode', 'sku', 'unit', 'minimum_qty', 'tags', 'is_refundable', 'colors', 'attributes',
                'unit_price', 'purchase_price', 'discount', 'quantity', 'description', 'meta_title', 'meta_description', 'is_active',
                'publish_stat', 'shipping_cost', 'size', 'seller_id'
            ]);
            if (empty($data['meta_title']))
                $data['meta_title'] = $data['name'];
            else
                $data['meta_title'] = $data['meta_title'];

            $data['seller_id'] = auth('seller')->id();

            if (empty($data['slug']))
                $data['slug'] = $this->clean($data['name']);
            else
                $data['slug'] = $this->clean($data['slug']);
            if ($request->input('attributes') != '') {
                $attributes = $request->input('attributes');
                $data['attributes'] = json_encode($attributes, JSON_FORCE_OBJECT);
            }

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
            if (!$this->hasPromotion($product->id))
                $data['sale_price'] = ($data['unit_price'] - $data['discount']);
            $product->update($data);
            if ($request->input('colors') != '') {
                $colors = $request->input('colors');
                $colors = array_map(
                    function ($value) {
                        return (int)$value;
                    },
                    $colors
                );
                $product->colors()->sync($colors);
            }
            if ($request->input('size') != '') {
                $sizes = $request->input('size');
                $sizes = array_map(
                    function ($value) {
                        return (int)$value;
                    },
                    $sizes
                );
                $product->sizes()->sync($sizes);
            }
            $details_data = $request->only([
                'is_free_shipping', 'is_flat_rate', 'is_product_wise_shipping', 'is_quantity_multiply', 'warning_quantity', 'is_show_stock_quantity',
                'is_show_stock_with_text_only', 'is_hide_stock', 'is_cash_on_delivery', 'is_featured', 'is_todays_deal', 'flash_deal_title', 'flash_deal_discount',
                'flash_deal_discount_type', 'inside_shipping_days', 'outside_shipping_days', 'vat', 'tax', 'is_best_sell'

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
            $images = $request->file('images');
            if ($request->hasFile('images')) {
                $this->createProductImage($images, $product);
            }

            return redirect()->route('seller.products')->with($this->update_success_message);
        } else {
            return back()->withInput()->with($this->not_found_message);
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
        $image_data = [];
        foreach ($images as $key => $image) {
            $image_path = Storage::putFile('products/galleries', $image);
            $pattern = "/products\/galleries\//";
            $image_path = preg_replace($pattern, '', $image_path);
            $image_data['image'] = $image_path;
            $product->images()->create($image_data);
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
//            if ($product->promotion()->exists()) {
//                return back()->with([
//                    'message' => 'Product has promotion. Delete promotion First',
//                    'alert-type' => 'info',
//                ]);
//            }
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
