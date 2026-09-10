<?php

namespace App\Modules\Backend\SellerManagement\Http\Controllers;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SellerWithdraw;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseMessage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Modules\Backend\SellerManagement\Entities\Seller;

class SellerController extends Controller
{
    use ResponseMessage;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sellermanagement::sellers.index');
    }

    /* Process ajax request */
    public function sellerList(Request $request)
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

        $query = Seller::query();
        // Total records
        $totalRecords = $query->count();
        $totalRecordswithFilter = $totalRecords;
        // Get records, also we have included search filter as well
        if (!empty($searchValue)) {
            $query
                ->where(function ($qry) use ($searchValue) {
                    $qry->orWhere('last_name', 'like', '%' . $searchValue . '%');
                    $qry->orWhere('email', 'like', '%' . $searchValue . '%');
                    $qry->orWhere('mobile', 'like', '%' . $searchValue . '%');
                });

            $totalRecordswithFilter = $query->count();
        }
        $records = $query
            ->withCount('products')
            ->latest()
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $checked = '';
            if ($record->is_active)
                $checked = 'checked';
            $approve = '';
            if ($record->is_approve)
                $approve = 'checked';
            $delete_route = route('backend.sellers.destroy', $record->id);
            $data_arr[] = array(
                "company_name" => $record->company_name,
                "last_name" => $record->full_name(),
                "mobile" => $record->mobile,
                "email" => $record->email,
                "is_active" => '<div class="form-switch"><input class="form-check-input status" type="checkbox"  data-id="' . $record->id . '"' . $checked . '></div>',
                "is_approve" => '<div class="form-switch"><input class="form-check-input approve" type="checkbox"  data-id="' . $record->id . '"' . $approve . '></div>',
                "product_id" => $record->products_count ?? 0,
                "action" => '<ul>
                                <li>
                                            <a class="p-0 action" href="' . route('backend.sellers.edit', $record->id) . '">
                                                <button title="Edit">
                                                    <svg viewBox="0 0 11 11" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M8.72031 5.31576C8.48521 5.31576 8.29519 5.50625 8.29519 5.74089V9.1421C8.29519 9.37634 8.1047 9.56722 7.87007 9.56722H1.91801C1.68331 9.56722 1.49289 9.37634 1.49289 9.1421V3.19C1.49289 2.95575 1.68331 2.76487 1.91801 2.76487H5.3192C5.5543 2.76487 5.74432 2.57438 5.74432 2.33975C5.74432 2.10504 5.5543 1.91455 5.3192 1.91455H1.91801C1.21483 1.91455 0.642578 2.4868 0.642578 3.19V9.1421C0.642578 9.84529 1.21483 10.4175 1.91801 10.4175H7.87007C8.57326 10.4175 9.14551 9.84529 9.14551 9.1421V5.74089C9.14551 5.50579 8.95541 5.31576 8.72031 5.31576Z"/>
                                                        <path d="M4.62759 4.9274C4.59785 4.95714 4.57785 4.99497 4.56936 5.03577L4.26879 6.53916C4.25477 6.60884 4.27688 6.68069 4.32702 6.73129C4.36742 6.77169 4.42184 6.79333 4.47758 6.79333C4.49112 6.79333 4.50521 6.79209 4.51923 6.78913L6.02218 6.48856C6.06383 6.48 6.10167 6.46007 6.13101 6.43025L9.49487 3.06645L7.99192 1.5636L4.62759 4.9274Z"/>
                                                        <path d="M10.5329 0.525254C10.1184 0.110723 9.444 0.110723 9.02982 0.525254L8.44141 1.11362L9.94444 2.61652L10.5329 2.02808C10.7336 1.82786 10.8441 1.56084 10.8441 1.27686C10.8441 0.992876 10.7336 0.725864 10.5329 0.525254Z"/>
                                                    </svg>
                                                </button>
                                            </a>
                                </li>
                                <li>
                                            <a class="p-0 action" href="' . route('backend.sellers.show', $record->id) . '">
                                                <button title="View">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z"/></svg>
                                                </button>
                                            </a>
                                </li>
                                 <li>
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

                                            </li>

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
        $seller = new Seller();
        return view('sellermanagement::sellers.create', $this->formContext($seller));
    }

    /**
     * Shared payload (categories, business types, Indian states) for create/edit forms,
     * mirroring the seller registration form.
     */
    private function formContext(Seller $seller): array
    {
        $categories = \App\Models\Seller\Category::query()->whereNull('category_id')->where('is_active', 1)->get();

        // 'without_gstin' is retired: it is no longer offered when creating or
        // editing a seller. It is only kept in the list for a legacy record that
        // is still on it, so the admin can open that seller and switch them over
        // without silently losing the value. Once switched, it disappears.
        $businessTypes = ['gstin' => __('Register with GSTIN')];

        if ($seller->exists && $seller->business_type === 'without_gstin') {
            $businessTypes['without_gstin'] = __('Register without GSTIN (legacy — please switch to GSTIN)');
        }
        $indianStates = [
            'Andaman and Nicobar Islands', 'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chandigarh',
            'Chhattisgarh', 'Dadra and Nagar Haveli and Daman and Diu', 'Delhi', 'Goa', 'Gujarat', 'Haryana',
            'Himachal Pradesh', 'Jammu and Kashmir', 'Jharkhand', 'Karnataka', 'Kerala', 'Ladakh', 'Lakshadweep',
            'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha', 'Puducherry',
            'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 'Uttar Pradesh', 'Uttarakhand',
            'West Bengal', 'Other',
        ];
        sort($indianStates);

        return compact('seller', 'categories', 'businessTypes', 'indianStates');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->validationRules(null));

        try {
            $data = $this->buildSellerData($request);
            $data['password'] = Hash::make($request->input('password'));
            $data['slug'] = Str::random(16);
            $data['is_active'] = 1;
            $data['is_approve'] = 1;
            $data['is_suspended'] = 0;
            $data['email_verified_at'] = now();

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('sellers', 'public');
            }
            if ($request->hasFile('pan_image')) {
                $data['pan_image'] = $request->file('pan_image')->store('sellers/pan', 'public');
            }

            $seller = Seller::create($data);
            if ($seller) {
                $role = Role::where('name', 'seller')->where('guard_name', 'seller')->first();
                if ($role) $seller->assignRole($role);
                return redirect()->route('backend.sellers.index')->with($this->create_success_message);
            }
            return back()->withInput()->with($this->create_fail_message);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return back()->withInput()->with($this->create_fail_message);
        }
    }

    /* change status*/
    public function changeStatus(Request $request)
    {
        $seller = Seller::findOrFail($request->id);
        if ($seller) {
            if ($request->field == 'is_active')
                $seller->is_active = $request->status;
            $seller->save();
            return response()->json($this->update_success_message);
        } else {
            return response()->json($this->not_found_message);
        }
    }

    /* change approve */
    public function approve(Request $request)
    {
        $seller = Seller::findOrFail($request->id);
        if ($seller) {
            if ($request->field == 'is_approve')
                $seller->is_approve = $request->status;
            $seller->save();
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
        $seller = Seller::findOrFail($id);

        $panPath = $seller->pan_image && Storage::disk('public')->exists($seller->pan_image)
            ? $seller->pan_image
            : null;
        $panUrl = $panPath ? Storage::disk('public')->url($panPath) : null;
        $panExt = $panPath ? strtolower(pathinfo($panPath, PATHINFO_EXTENSION)) : null;

        $shopPath = $this->resolveShopImagePath($seller);
        $shopUrl = $shopPath ? Storage::disk('public')->url($shopPath) : null;
        $shopExt = $shopPath ? strtolower(pathinfo($shopPath, PATHINFO_EXTENSION)) : null;

        return view('sellermanagement::sellers.show', compact(
            'seller', 'panUrl', 'panExt', 'shopUrl', 'shopExt'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $seller = Seller::findOrFail($id);
        return view('sellermanagement::sellers.edit', $this->formContext($seller));
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
        $seller = Seller::findOrFail($id);
        $request->validate($this->validationRules($seller->id));

        try {
            $data = $this->buildSellerData($request);

            // Nothing on the edit form is mandatory any more, so a blank box means
            // "leave this one alone". That protects the credentials the seller
            // signs in with, and the columns the database declares NOT NULL —
            // writing a blank into either would break the account or the save.
            $keepIfBlank = ['email', 'mobile', 'company_name', 'first_name', 'last_name'];

            foreach ($keepIfBlank as $field) {
                if (blank($data[$field] ?? null)) {
                    unset($data[$field]);
                }
            }

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->input('password'));
            }

            if ($request->hasFile('image')) {
                if ($seller->image && Storage::disk('public')->exists($seller->image)) {
                    Storage::disk('public')->delete($seller->image);
                }
                $data['image'] = $request->file('image')->store('sellers', 'public');
            }
            if ($request->hasFile('pan_image')) {
                if ($seller->pan_image && Storage::disk('public')->exists($seller->pan_image)) {
                    Storage::disk('public')->delete($seller->pan_image);
                }
                $data['pan_image'] = $request->file('pan_image')->store('sellers/pan', 'public');
            }

            $seller->update($data);

            $role = Role::where('name', 'seller')->where('guard_name', 'seller')->first();
            if ($role) $seller->assignRole($role);

            return redirect()->route('backend.sellers.index')->with($this->update_success_message);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return back()->withInput()->with($this->update_fail_message);
        }
    }

    /**
     * Validation rules mirroring the seller registration form.
     * Pass $sellerId when editing to scope unique rules.
     */
    private function validationRules(?int $sellerId): array
    {
        $isCreate = $sellerId === null;

        // Creating a seller demands the full set of details. Editing does not:
        // legacy sellers were saved before several of these fields existed, so
        // insisting on them would make it impossible to change even one field.
        // Format/uniqueness checks still apply to whatever is filled in.
        $req = $isCreate ? 'required' : 'nullable';

        $existing = $isCreate ? null : Seller::find($sellerId);

        // Some legacy rows share a mobile number with each other. Re-checking
        // uniqueness on a value the admin did not touch would make those sellers
        // permanently unsavable, so only enforce it when the value actually changes.
        $uniqueIfChanged = function (string $column) use ($isCreate, $sellerId, $existing) {
            if ($isCreate) {
                return ['unique:sellers,' . $column];
            }

            $submitted = (string) request()->input($column);
            $current = (string) ($existing->{$column} ?? '');

            return trim($submitted) === trim($current)
                ? []
                : ['unique:sellers,' . $column . ',' . $sellerId];
        };

        $emailRule = array_merge([$req, 'string', 'email', 'max:255'], $uniqueIfChanged('email'));
        $mobileRule = array_merge([$req, 'string', 'max:32'], $uniqueIfChanged('mobile'));
        $companyRule = array_merge([$req, 'string', 'max:255'], $uniqueIfChanged('company_name'));

        return [
            'email'               => $emailRule,
            'password'            => [$isCreate ? 'required' : 'nullable', 'string', 'min:6', 'confirmed'],
            'business_type'       => [$req, 'string', 'max:64'],
            // Same GSTIN format the public seller registration enforces. Kept
            // nullable so a legacy 'without_gstin' seller can still be saved.
            'gstin'               => [
                'nullable',
                'string',
                'size:15',
                'regex:/^[0-9]{2}[A-Za-z]{5}[0-9]{4}[A-Za-z]{1}[0-9A-Za-z]{1}[Zz]{1}[0-9A-Za-z]{1}$/',
                \Illuminate\Validation\Rule::requiredIf(fn() => $isCreate && request()->input('business_type') === 'gstin'),
            ],
            'referral_code'       => ['nullable', 'string', 'max:100'],
            'pan'                 => [$req, 'string', 'size:10', 'regex:/^[A-Za-z]{5}[0-9]{4}[A-Za-z]{1}$/'],
            'aadhaar'             => ['nullable', 'digits:12', 'unique:sellers,aadhaar' . ($isCreate ? '' : ',' . $sellerId)],
            'bank_account_number' => ['nullable', 'digits_between:9,18'],
            'ifsc_code'           => ['nullable', 'string', 'size:11', 'regex:/^[A-Za-z]{4}0[A-Za-z0-9]{6}$/'],
            'business_name'       => [$req, 'string', 'max:255'],
            'shop_owner_name'     => [$req, 'string', 'max:255'],
            'mobile'              => $mobileRule,
            'shop_manager_name'   => ['nullable', 'string', 'max:255'],
            'shop_manager_mobile' => ['nullable', 'string', 'max:32'],
            'first_name'          => [$req, 'string', 'max:255'],
            'last_name'           => ['nullable', 'string', 'max:255'],
            'company_name'        => $companyRule,
            'shop_no_complex'     => [$req, 'string', 'max:255'],
            'area'                => ['nullable', 'string', 'max:255'],
            'landmark'            => ['nullable', 'string', 'max:255'],
            'post_code'           => [$req, 'string', 'max:20'],
            'city'                => [$req, 'string', 'max:120'],
            'district'            => ['nullable', 'string', 'max:120'],
            'state'               => [$req, 'string', 'max:120'],
            'country'             => [$req, 'string', 'max:120'],
            'shipping_phone'      => [$req, 'string', 'max:32'],
            'category'            => [$req, 'exists:categories,id'],
            'image'               => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:4096'],
            'pan_image'           => [$isCreate ? 'required' : 'nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:4096'],
        ];
    }

    /**
     * Build the database payload mirroring SellerRegisterController::create() field mapping.
     */
    private function buildSellerData(Request $request): array
    {
        $addressParts = array_filter([
            $request->shop_no_complex,
            $request->area,
            $request->landmark,
            $request->city,
            $request->district,
            $request->state,
            $request->country,
            $request->post_code,
        ]);
        $fullAddress = implode(', ', $addressParts);

        return [
            'company_name'        => $request->company_name,
            'email'               => $request->email,
            'first_name'          => $request->first_name,
            'last_name'           => $request->last_name ?? '',
            'gender'              => 1,
            // Blank means "not provided" on an edit — never write an empty
            // string into the foreign key column.
            'category_id'         => $request->filled('category') ? $request->category : null,
            'mobile'              => $request->mobile,
            'business_mobile'     => $request->shipping_phone,
            'address'             => $fullAddress,
            'city'                => $request->city,
            'post_code'           => $request->post_code,
            'tin'                 => $request->gstin,
            'nid_no'              => strtoupper($request->pan),
            'business_type'       => $request->business_type,
            'gstin'               => $request->business_type === 'gstin' ? $request->gstin : null,
            'gstin_verified_at'   => null,
            'referral_code'       => $request->referral_code,
            'pan'                 => strtoupper($request->pan),
            'aadhaar'             => $request->filled('aadhaar') ? preg_replace('/\D/', '', $request->aadhaar) : null,
            'bank_account_number' => $request->filled('bank_account_number') ? preg_replace('/\D/', '', $request->bank_account_number) : null,
            'ifsc_code'           => $request->filled('ifsc_code') ? strtoupper($request->ifsc_code) : null,
            'business_name'       => $request->business_name,
            'shop_owner_name'     => $request->shop_owner_name,
            'shop_manager_name'   => $request->shop_manager_name,
            'shop_manager_mobile' => $request->shop_manager_mobile,
            'shop_no_complex'     => $request->shop_no_complex,
            'area'                => $request->area,
            'landmark'            => $request->landmark,
            'district'            => $request->district,
            'state'               => $request->state,
            'country'             => $request->country,
            'shipping_phone'      => $request->shipping_phone,
            'data_consent'        => $request->boolean('data_consent', true),
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Stream the seller's PAN card file as an attachment.
     */
    public function downloadPan($id)
    {
        $seller = Seller::findOrFail($id);
        if (!$seller->pan_image || !Storage::disk('public')->exists($seller->pan_image)) {
            return back()->with([
                'alert-type' => 'error',
                'message' => __('PAN file is not available for this seller.'),
            ]);
        }
        $ext = pathinfo($seller->pan_image, PATHINFO_EXTENSION) ?: 'bin';
        $filename = 'pan-' . ($seller->pan ?? $seller->id) . '.' . $ext;
        return Storage::disk('public')->download($seller->pan_image, $filename);
    }

    /**
     * Stream the seller's shop image/document as an attachment.
     */
    public function downloadShopImage($id)
    {
        $seller = Seller::findOrFail($id);
        $path = $this->resolveShopImagePath($seller);
        if (!$path) {
            return back()->with([
                'alert-type' => 'error',
                'message' => __('Shop image is not available for this seller.'),
            ]);
        }
        $ext = pathinfo($path, PATHINFO_EXTENSION) ?: 'bin';
        $filename = 'shop-' . $seller->id . '.' . $ext;
        return Storage::disk('public')->download($path, $filename);
    }

    /**
     * Shop image was historically stored either at the bare filename (admin form)
     * or under sellers/... (registration form). Try both.
     */
    private function resolveShopImagePath(Seller $seller): ?string
    {
        if (!$seller->image) return null;
        if (Storage::disk('public')->exists($seller->image)) return $seller->image;
        $prefixed = 'sellers/' . ltrim($seller->image, '/');
        if (Storage::disk('public')->exists($prefixed)) return $prefixed;
        return null;
    }

    public function destroy($id)
    {
        $seller = Seller::find($id);
        if ($seller) {
            try {
                if (file_exists(storage_path('app/public/sellers/') . $seller->image)) {
                    Storage::delete('sellers' . '/' . $seller->image);
                }
                if (file_exists(storage_path('app/public/sellers/') . $seller->banner)) {
                    Storage::delete('sellers' . '/' . $seller->banner);
                }
                $seller->delete();
                return redirect()->route('backend.sellers.index')->with($this->delete_success_message);
            } catch (Exception $exception) {
                Log::error($exception->getMessage());
                return back()->with([
                    'alert-type' => 'info',
                    'message' => $exception->getMessage()
                ]);
            }
        } else {
            return back()->with($this->not_found_message);
        }
    }
}
