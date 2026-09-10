<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Country;
use App\Models\Frontend\OrderDetail;
use App\Models\Frontend\ShippingAddress;
use App\Models\Frontend\User;
use App\Models\Frontend\UserBilling;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    public function index()
    {
        $url = config('constants.image_base_path') . '/orders.json';

        //  Initiate curl
        $ch = curl_init();
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL, $url);
        // Execute
        $result = curl_exec($ch);
        // Closing
        curl_close($ch);

        $allOrders = json_decode($result, true);
        $pending = json_decode($result, true);
        return view('customer.pages.order', compact('allOrders', 'pending'));
    }

    public function profile()
    {
        $user = auth('customer')->user();
        $orders = OrderDetail::query()->where('user_id', auth('customer')->id())->get();
        $shipping = ShippingAddress::query()->where('user_id', auth('customer')->id())->latest()->first();
        $billing = UserBilling::query()->where('user_id', auth('customer')->id())->latest()->first();

        $countries = Country::query()->where('is_active', 1)->get();

        if ($billing == null) {
            $billing = new UserBilling;
        }

        if ($shipping == null) {
            $shipping = new ShippingAddress;
        }

        $uploadLimitMb = round($this->uploadSizeLimitKb() / 1024, 1);

        return view('customer.pages.profile', compact('user', 'orders', 'billing', 'shipping', 'countries', 'uploadLimitMb'));
    }

    /**
     * Update user's information
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => ['required', 'string', Rule::unique('users')->ignore($id)],
            'dob' => 'required|date',
            'old_password' => 'nullable',
            'password' => 'nullable',
        ]);

        $user = User::find(auth('customer')->id());
        $password = $user->password;
        if ($request->old_password != '' && $request->password != '') {
            if (Hash::check($request->old_password, $user->password)) {
                $password = bcrypt($request->password);
            } else {
                return response()->json(__('The old password is incorrect.'), 403);
            }
        }

        $user->update($request->except('password') + [
            'password' => $password
        ]);

        return response()->json(__('Profile updated successfully.'));
    }

    /**
     * Update user's default billing information
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function billing(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'address_1' => 'required',
            'user_city' => 'required',
            'mobile' => 'required|numeric',
            'post_code' => 'required|max:5',
        ]);

        $request['user_id'] = auth('customer')->id();

        $billing = auth('customer')->user()->billing;

        if ($billing) {
            $billing->update($request->all());
        } else {
            UserBilling::query()->create($request->all());
        }

        if ($request->has('address')) {
            $user = auth('customer')->user();
            $user->update(['address' => $request->get('address')]);
        }

        Session::flash('success', 'Billing has been updated');

        return redirect()->back();
    }

    /**
     * Update user's default shipping address
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function shipping(Request $request): RedirectResponse
    {
        $this->validate($request, [
            "address_line_one" => 'required',
            "address_line_two" => 'required',
            "shipping_post" => 'required',
            "shipping_town" => 'required',
            "shipping_country_id" => 'required',
        ]);

        $request['user_id'] = auth('customer')->id();

        $shipping = auth('customer')->user()->shipping;

        if ($shipping) {
            $shipping->update($request->all());
        } else {
            ShippingAddress::query()->create($request->all());
        }

        Session::flash('success', 'Shipping address has been updated');

        return redirect()->back();
    }

    /**
     * Update user's avatar
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function image(Request $request, $id): RedirectResponse
    {
        // A photo bigger than PHP's upload_max_filesize never reaches us at all —
        // $request->file() is simply empty — so the "required" message has to
        // explain that case too, otherwise the upload looks like it did nothing.
        $limit = $this->uploadSizeLimitKb();

        // PHP rejects anything over upload_max_filesize before validation ever
        // sees it: the file is present but flagged invalid, which used to fall
        // through as a silent no-op.
        $uploaded = $request->file('image');

        if ($uploaded !== null && !$uploaded->isValid()) {
            $reason = $uploaded->getError() === UPLOAD_ERR_INI_SIZE || $uploaded->getError() === UPLOAD_ERR_FORM_SIZE
                ? __('That photo is larger than the :size MB upload limit. Please choose a smaller one.', ['size' => round($limit / 1024, 1)])
                : __('The photo could not be uploaded. Please try again.');

            return redirect()->back()->with('error', $reason);
        }

        $this->validate($request, [
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:' . $limit],
        ], [
            'image.required' => __('Please choose an image first. If you already picked one, it may be larger than the :size MB upload limit — try a smaller photo.', ['size' => round($limit / 1024, 1)]),
            'image.image' => __('That file is not a valid image.'),
            'image.mimes' => __('Only PNG, JPG and WEBP images can be used as a profile photo.'),
            'image.max' => __('That image is too large. Please upload one under :size MB.', ['size' => round($limit / 1024, 1)]),
        ]);

        $user = User::query()->findOrFail($id);

        // Never let one customer overwrite another customer's photo.
        if ((int) $user->id !== (int) auth('customer')->id()) {
            abort(403);
        }

        $file = $request->file('image');
        $image = now()->format('YmdHis') . $id . '.' . strtolower($file->getClientOriginalExtension());

        $file->move(public_path('frontend/img/users'), $image);

        $oldImage = $user->image;

        $user->update(['image' => $image]);

        // Only remove the previous file — guard against blowing away the folder
        // when the user had no photo yet.
        if ($oldImage && $oldImage !== $image) {
            $oldPath = public_path('frontend/img/users/') . $oldImage;
            if (File::exists($oldPath) && File::isFile($oldPath)) {
                File::delete($oldPath);
            }
        }

        return redirect()->back()->with('success', __('Your profile photo has been updated.'));
    }

    /**
     * Largest upload PHP will actually accept, in kilobytes.
     */
    protected function uploadSizeLimitKb(): int
    {
        $toKb = function ($value) {
            $value = trim((string) $value);
            $unit = strtolower(substr($value, -1));
            $num = (int) $value;

            switch ($unit) {
                case 'g': return $num * 1024 * 1024;
                case 'm': return $num * 1024;
                case 'k': return $num;
                default:  return (int) ($num / 1024);
            }
        };

        $limits = array_filter([
            $toKb(ini_get('upload_max_filesize')),
            $toKb(ini_get('post_max_size')),
        ]);

        return $limits ? max(256, min($limits)) : 2048;
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);

        $user = User::query()->find(auth('customer')->id());

        if (Hash::check($request->old_password, $user->password)) {
            $user->update(['password' => bcrypt($request->password)]);
        } else {
            Session::flash('error', 'Password not matched');
        }

        return redirect()->back();
    }
}
