<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseMessage;
use App\Modules\Backend\SellerManagement\Entities\Seller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    use ResponseMessage;

    public function show()
    {
        $user = Auth::user();
        return view('backend.pages.account.index', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if (auth('admin')->user()) {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:admins,email,' . auth('admin')->id()],
                'password' => ['nullable', 'string', 'confirmed'],
                'current_password' => ['nullable', 'string', 'min:4'],
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:204800',
            ]);

            $data = array();
            $user = User::find(auth('admin')->id());
            $data = $request->only(['name', 'email']);
            if ($request->password) {
                if (Hash::check($request->current_password, $user->password)) {
                    $data['password'] = Hash::make($request->input('password'));
                } else {
                    return response()->json(__('Current Password is not Match'), 403);
                }
            }
            $image = $request->file('avatar');
            if ($image) {
                $path = Storage::putFile('users', $image);
                $pattern = "/users\//";
                $path = preg_replace($pattern, '', $path);
                if ($path) {
                    $data['avatar'] = $path;
                    if (file_exists(storage_path('app/public/users/') . $user->avatar)) {
                        Storage::delete('users/' . $user->avatar);
                    }
                }
            }
            $user->update($data);

        } else {
            $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:sellers,email,'. auth('seller')->id()],
                'password' => ['nullable', 'string', 'min:6', 'confirmed'],
                'current_password' => ['nullable', 'string', 'min:6'],
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:204800',
            ]);

            $user = Seller::find(auth('seller')->id());
            if ($request->password) {
                if (Hash::check($request->current_password, $user->password)) {
                    $data['password'] = Hash::make($request->input('password'));
                } else {
                    return response()->json(__('Current Password is not Match'), 403);
                }
            }

            $data = array();
            $data = $request->only(['first_name', 'last_name', 'email', 'mobile', 'address', 'city', 'tin', 'nid_no', 'website', 'post_code', 'facebook', 'banner']);
            
            $image = $request->file('image');
            if ($image) {
                $path = Storage::putFile('/sellers', $image);
                $pattern = "/sellers\//";
                $path = preg_replace($pattern, '', $path);
                if ($path) {
                    $data['image'] = $path;
                    if (file_exists(storage_path('app/public/sellers/') . $user->image)) {
                        Storage::delete('sellers' . '/' . $user->image);
                    }
                }
            }
            $banner = $request->file('banner');
            if ($banner) {
                $path = Storage::putFile('/sellers/banner', $banner);
                $pattern = "/sellers\//";
                $path = preg_replace($pattern, '', $path);
                if ($path) {
                    $data['banner'] = $path;
                    if (file_exists(storage_path('app/public/sellers/banner/') . $user->banner)) {
                        Storage::delete('sellers/banner' . '/' . $user->banner);
                    }
                }
            }
            $user->update($data);
        }

        return response()->json([
            'message' => __('Profile updated successfully.'),
            'redirect' => auth('admin')->user() ? route('backend.account'): route('seller.account')
        ]);
    }
}
