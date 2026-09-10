<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseMessage;
use App\Modules\Backend\SellerManagement\Entities\Seller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;

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

        try {
            if (auth('admin')->user()) {
                try {
                    $request->validate([
                        'name' => ['required', 'string', 'max:255'],
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email,' . $id],
                        'password' => ['nullable', 'string', 'min:6', 'confirmed'],
                        'current_password' => ['nullable', 'string', 'min:6'],
                        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:204800',
                    ]);

                } catch (\Illuminate\Validation\ValidationException $e) {
                    return redirect()->back()->withErrors($e->errors());
                }
                $data = array();
                $user = User::find($id);
                if ($user) {
                    $data = $request->only(['name', 'email']);
                    if ($request->password) {
                        if (Hash::check($request->current_password, $user->password)) {
                            $data['password'] = Hash::make($request->input('password'));
                        } else {
                            return redirect()->back()->withErrors(['current_password' => ['Current Password is not Match']]);
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
                    return redirect()->route('backend.account')->with($this->update_success_message);

                } else {
                    return back()->withInput()->with($this->not_found_message);
                }
            } else {
                //return $request;
                try {
                    $request->validate([
                        'first_name' => ['required', 'string', 'max:255'],
                        'last_name' => ['required', 'string', 'max:255'],
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:sellers,email,' . $id],
                        'password' => ['nullable', 'string', 'min:6', 'confirmed'],
                        'current_password' => ['nullable', 'string', 'min:6'],
                        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:204800',
                    ]);

                } catch (Exception $e) {
                    return redirect()->back()->withErrors($e->errors());
                }
                //return $request;
                $data = array();
                $user = Seller::find($id);
                if ($user) {
                    $data = $request->only(['first_name', 'last_name', 'email', 'mobile', 'address', 'city', 'tin', 'nid_no', 'website', 'post_code', 'facebook', 'banner']);
                    if ($request->password) {
                        if (Hash::check($request->current_password, $user->password)) {
                            $data['password'] = Hash::make($request->input('password'));
                        } else {
                            return redirect()->back()->withErrors(['current_password' => ['Current Password is not Match']]);
                        }
                    }
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
                   // return$data ;
                    $user->update($data);
                    return redirect()->route('seller.account')->with($this->update_success_message);

                } else {
                    return back()->withInput()->with($this->not_found_message);
                }
            }
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return redirect()->back()->withInput()->with($this->update_fail_message);
        }
    }

}
