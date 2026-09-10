<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Mail\OtpMail;
use App\Models\Frontend\Seller;
use App\Models\Seller\Category;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class SellerRegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/seller/dashboard';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function guard()
    {
        return Auth::guard('seller');
    }

    public function registration()
    {
        $categories = Category::whereNull('category_id')->where('is_active', 1)->get();
        $defaultCategoryId = $categories->first()->id ?? null;

        // Registering without a GSTIN is no longer offered — every new seller
        // must supply one. (The admin-side list still carries 'without_gstin'
        // so existing sellers on that plan stay editable.)
        $businessTypes = [
            'gstin' => __('Register with GSTIN'),
        ];

        $indianStates = [
            'Andaman and Nicobar Islands', 'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chandigarh',
            'Chhattisgarh', 'Dadra and Nagar Haveli and Daman and Diu', 'Delhi', 'Goa', 'Gujarat', 'Haryana',
            'Himachal Pradesh', 'Jammu and Kashmir', 'Jharkhand', 'Karnataka', 'Kerala', 'Ladakh', 'Lakshadweep',
            'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha', 'Puducherry',
            'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 'Uttar Pradesh', 'Uttarakhand',
            'West Bengal', 'Other',
        ];
        sort($indianStates);

        return view('backend.pages.auth.seller.registration', compact(
            'categories',
            'defaultCategoryId',
            'businessTypes',
            'indianStates'
        ));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:sellers,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'business_type' => ['required', 'string', 'max:64', Rule::in(['gstin'])],
            'gstin' => ['required', 'string', 'size:15', 'regex:/^[0-9]{2}[A-Za-z]{5}[0-9]{4}[A-Za-z]{1}[0-9A-Za-z]{1}[Zz]{1}[0-9A-Za-z]{1}$/'],
            'referral_code' => ['nullable', 'string', 'max:100'],
            'pan' => ['required', 'string', 'size:10', 'regex:/^[A-Za-z]{5}[0-9]{4}[A-Za-z]{1}$/'],
            'aadhaar' => ['required', 'digits:12', 'unique:sellers,aadhaar'],
            'bank_account_number' => ['required', 'digits_between:9,18'],
            'ifsc_code' => ['required', 'string', 'size:11', 'regex:/^[A-Za-z]{4}0[A-Za-z0-9]{6}$/'],
            'business_name' => ['required', 'string', 'max:255'],
            'shop_owner_name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'digits:10', 'regex:/^[6-9][0-9]{9}$/', 'unique:sellers,mobile'],
            'shop_manager_name' => ['nullable', 'string', 'max:255'],
            'shop_manager_mobile' => ['nullable', 'string', 'max:32'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255', 'unique:sellers,company_name'],
            'shop_no_complex' => ['required', 'string', 'max:255'],
            'area' => ['nullable', 'string', 'max:255'],
            'landmark' => ['nullable', 'string', 'max:255'],
            'post_code' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:120'],
            'district' => ['nullable', 'string', 'max:120'],
            'state' => ['required', 'string', 'max:120'],
            'country' => ['required', 'string', 'max:120'],
            'shipping_phone' => ['required', 'string', 'max:32'],
            'category' => ['required', 'exists:categories,id'],
            'shop_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:4096'],
            'pan_image' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:4096'],
            'data_consent' => ['accepted'],
        ], [
            'data_consent.accepted' => __('You must agree to the data processing terms.'),
            'pan.required' => __('PAN is required.'),
            'pan.regex' => __('Enter a valid 10-character PAN (e.g. ABCDE1234F).'),
            'gstin.required' => __('GSTIN is required.'),
            'gstin.size' => __('GSTIN must be exactly 15 characters.'),
            'gstin.regex' => __('Enter a valid 15-character GSTIN (e.g. 22AAAAA0000A1Z5).'),
            'mobile.digits' => __('Mobile number must be exactly 10 digits.'),
            'mobile.regex' => __('Enter a valid 10-digit Indian mobile number.'),
            'aadhaar.required' => __('Aadhaar number is required.'),
            'aadhaar.digits' => __('Aadhaar number must be exactly 12 digits.'),
            'aadhaar.unique' => __('This Aadhaar number is already registered with us.'),
            'bank_account_number.required' => __('Bank account number is required.'),
            'bank_account_number.digits_between' => __('Bank account number must be 9 to 18 digits.'),
            'ifsc_code.required' => __('IFSC code is required.'),
            'ifsc_code.size' => __('IFSC code must be exactly 11 characters.'),
            'ifsc_code.regex' => __('Enter a valid IFSC code (e.g. SBIN0001234).'),
            'pan_image.required' => __('PAN card image is required.'),
            'pan_image.mimes' => __('PAN card must be a JPG, PNG, WEBP or PDF file.'),
            'pan_image.max' => __('PAN card file must be 4 MB or smaller.'),
            'shop_image.mimes' => __('Shop file must be a JPG, PNG, WEBP or PDF file.'),
            'shop_image.max' => __('Shop file must be 4 MB or smaller.'),
        ]);
    }

    protected function create(array $data)
    {
        $imagePath = null;
        if (request()->hasFile('shop_image')) {
            $imagePath = request()->file('shop_image')->store('sellers', 'public');
        }

        $panImagePath = null;
        if (request()->hasFile('pan_image')) {
            $panImagePath = request()->file('pan_image')->store('sellers/pan', 'public');
        }

        $addressParts = array_filter([
            $data['shop_no_complex'] ?? '',
            $data['area'] ?? '',
            $data['landmark'] ?? '',
            $data['city'] ?? '',
            $data['district'] ?? '',
            $data['state'] ?? '',
            $data['country'] ?? '',
            $data['post_code'] ?? '',
        ]);
        $fullAddress = implode(', ', $addressParts);

        $otp = (string) random_int(100000, 999999);

        return Seller::create([
            'company_name' => $data['company_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? '',
            'gender' => 1,
            'slug' => Str::random(16),
            'category_id' => $data['category'],
            'mobile' => $data['mobile'],
            'business_mobile' => $data['shipping_phone'],
            'address' => $fullAddress,
            'city' => $data['city'],
            'post_code' => $data['post_code'],
            'tin' => strtoupper($data['gstin']),
            'nid_no' => strtoupper($data['pan']),
            'image' => $imagePath,
            'business_type' => $data['business_type'],
            'gstin' => strtoupper($data['gstin']),
            'gstin_verified_at' => null,
            'referral_code' => $data['referral_code'] ?? null,
            'pan' => strtoupper($data['pan']),
            'pan_image' => $panImagePath,
            'aadhaar' => preg_replace('/\D/', '', $data['aadhaar']),
            'bank_account_number' => preg_replace('/\D/', '', $data['bank_account_number']),
            'ifsc_code' => strtoupper($data['ifsc_code']),
            'business_name' => $data['business_name'],
            'shop_owner_name' => $data['shop_owner_name'],
            'shop_manager_name' => $data['shop_manager_name'] ?? null,
            'shop_manager_mobile' => $data['shop_manager_mobile'] ?? null,
            'shop_no_complex' => $data['shop_no_complex'],
            'area' => $data['area'] ?? null,
            'landmark' => $data['landmark'] ?? null,
            'district' => $data['district'] ?? null,
            'state' => $data['state'],
            'country' => $data['country'],
            'shipping_phone' => $data['shipping_phone'],
            'deal_categories' => null,
            'data_consent' => true,
            'verification_code' => $otp,
            'verification_expire_at' => Carbon::now()->addMinutes(10),
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $seller = $this->create($request->all());

        $this->sendOtpEmail($seller);

        $request->session()->put('pending_seller_verification_id', $seller->id);

        return redirect()->route('seller.verification.show')
            ->with('status', __('A 6-digit OTP has been sent to :email. Please enter it below to verify your account.', ['email' => $seller->email]));
    }

    protected function sendOtpEmail(Seller $seller): void
    {
        try {
            Mail::to($seller->email)->send(new OtpMail($seller->verification_code, trim(($seller->first_name ?? '') . ' ' . ($seller->last_name ?? ''))));
        } catch (\Throwable $e) {
            \Log::error('OTP mail send failed (seller): ' . $e->getMessage());
        }
    }

    public function showVerifyForm(Request $request)
    {
        $sellerId = $request->session()->get('pending_seller_verification_id');
        if (!$sellerId) {
            return redirect()->route('seller.registration');
        }

        $seller = Seller::find($sellerId);
        if (!$seller) {
            return redirect()->route('seller.registration');
        }

        return view('backend.pages.auth.seller.verify-otp', [
            'email' => $seller->email,
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $sellerId = $request->session()->get('pending_seller_verification_id');
        if (!$sellerId) {
            return redirect()->route('seller.registration')
                ->withErrors(['otp' => __('Verification session expired. Please register again.')]);
        }

        $seller = Seller::find($sellerId);
        if (!$seller) {
            return redirect()->route('seller.registration')
                ->withErrors(['otp' => __('Seller not found.')]);
        }

        if (empty($seller->verification_code) || $seller->verification_code !== $request->otp) {
            return back()->withErrors(['otp' => __('Invalid OTP. Please try again.')]);
        }

        if ($seller->verification_expire_at && Carbon::parse($seller->verification_expire_at)->isPast()) {
            return back()->withErrors(['otp' => __('OTP has expired. Please request a new one.')]);
        }

        $seller->forceFill([
            'verification_code' => null,
            'verification_expire_at' => null,
            'email_verified_at' => Carbon::now(),
        ])->save();

        $request->session()->forget('pending_seller_verification_id');

        Auth::guard('seller')->login($seller);

        return redirect($this->redirectTo)->with('status', __('Email verified successfully. Welcome!'));
    }

    public function resendOtp(Request $request)
    {
        $sellerId = $request->session()->get('pending_seller_verification_id');
        if (!$sellerId) {
            return redirect()->route('seller.registration');
        }

        $seller = Seller::find($sellerId);
        if (!$seller) {
            return redirect()->route('seller.registration');
        }

        $otp = (string) random_int(100000, 999999);
        $seller->forceFill([
            'verification_code' => $otp,
            'verification_expire_at' => Carbon::now()->addMinutes(10),
        ])->save();

        $this->sendOtpEmail($seller);

        return back()->with('status', __('A new OTP has been sent to your email.'));
    }
}
