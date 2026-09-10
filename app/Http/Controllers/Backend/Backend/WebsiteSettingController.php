<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseMessage;
use App\Models\Backend\Country;
use App\Models\Backend\Currency;
use App\Models\Backend\Menu;
use App\Models\Backend\Page;
use App\Models\Backend\WebAppearance;
use App\Models\Backend\Header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Mockery\CountValidator\Exception;

class WebsiteSettingController extends Controller
{
    use ResponseMessage;

    /* view header settings */

    public function header()
    {
        $header = Header::find(1);
        if ($header) {
            return view('backend.pages.website_setting.header', compact('header'));
        } else {
            return back()->with($this->not_found_message);
        }
    }

    /* change header setting status*/

    public function changeStatus(Request $request)
    {
        $header = Header::find(1);
        if ($header) {
            if ($request->field == 'show_language')
                $header->show_language = $request->status;
            if ($request->field == 'show_currency')
                $header->show_currency = $request->status;
            if ($request->field == 'enable_sticky_header')
                $header->enable_sticky_header = $request->status;
            if ($request->field == 'enable_tracking_order')
                $header->enable_tracking_order = $request->status;
            if ($request->field == 'show_help')
                $header->show_help = $request->status;
            $header->save();
            return response()->json($this->update_success_message);
        } else {
            return response()->json($this->not_found_message);
        }
    }

    /* upload logo */
    public function uploadLogo(Request $request)
    {
        try {
            $request->validate([
                'header_logo' => 'required|max:100k|mimes:jpeg,png,jpg,gif,svg',
            ]);
            $logo = $request->file('header_logo');
            if ($logo) {
                $logo_path = Storage::putFileAs('', $logo, 'logo.png');
            } else {
                $logo_path = 'logo.png';
            }
            $header = Header::find(1);
            if ($header) {
                $header->header_logo = $logo_path;
                $header->save();
                return response()->json($this->update_success_message);
            } else {
                return response()->json($this->update_fail_message);
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json($this->update_fail_message);
        }
    }

    /* pages list */
    public function pages()
    {
        return view('backend.pages.website_setting.pages.index');
    }

    /* Process ajax request */
    public function pageList(Request $request)
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

        $query = Menu::query();
        // Total records
        $totalRecords = $query->count();
        $totalRecordswithFilter = $totalRecords;
        // Get records, also we have included search filter as well
        if (!empty($searchValue)) {
            $query
                ->where('name', 'like', '%' . $searchValue . '%')
                ->orWhere('url', 'like', '%' . $searchValue . '%')
                ->orWhere('target', 'like', '%' . $searchValue . '%');
            $totalRecordswithFilter = $query->count();
        }
        $records = $query
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $header = '';
            if ($record->is_header_menu)
                $header = 'checked';
            $footer = '';
            if ($record->is_footer_menu)
                $footer = 'checked';
            $quick_link = '';
            if ($record->is_quick_link)
                $quick_link = 'checked';
            $informatic = '';
            if ($record->is_informatics)
                $informatic = 'checked';
            $checked = '';
            if ($record->is_active)
                $checked = 'checked';


            $data_arr[] = array(
                "name" => $record->name,
                "url" => $record->url,
                "target" => $record->target,
                "is_header_menu" => '<div class="form-switch"><input class="form-check-input header" type="checkbox"
                                data-id="' . $record->id . '"' . $header . '></div>',
                "is_footer_menu" => '<div class="form-switch"><input class="form-check-input footer" type="checkbox"
                                data-id="' . $record->id . '"' . $footer . '></div>',
                "is_quick_link" => '<div class="form-switch"><input class="form-check-input quick_link" type="checkbox"
                                data-id="' . $record->id . '"' . $quick_link . '></div>',
                "is_informatics" => '<div class="form-switch"><input class="form-check-input informatic" type="checkbox"
                                data-id="' . $record->id . '"' . $informatic . '></div>',
                "is_active" => '<div class="form-switch"><input class="form-check-input status" type="checkbox"
                                data-id="' . $record->id . '"' . $checked . '></div>',
                "action" => '<ul>
                                <li>
                                    <a class="p-0 action" href="' . route('backend.website_setting.pages.edit', $record->id) . '">
                                        <button title="Add or Edit">
                                            <svg viewBox="0 0 11 11" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8.72031 5.31576C8.48521 5.31576 8.29519 5.50625 8.29519 5.74089V9.1421C8.29519 9.37634 8.1047 9.56722 7.87007 9.56722H1.91801C1.68331 9.56722 1.49289 9.37634 1.49289 9.1421V3.19C1.49289 2.95575 1.68331 2.76487 1.91801 2.76487H5.3192C5.5543 2.76487 5.74432 2.57438 5.74432 2.33975C5.74432 2.10504 5.5543 1.91455 5.3192 1.91455H1.91801C1.21483 1.91455 0.642578 2.4868 0.642578 3.19V9.1421C0.642578 9.84529 1.21483 10.4175 1.91801 10.4175H7.87007C8.57326 10.4175 9.14551 9.84529 9.14551 9.1421V5.74089C9.14551 5.50579 8.95541 5.31576 8.72031 5.31576Z"/>
                                                <path d="M4.62759 4.9274C4.59785 4.95714 4.57785 4.99497 4.56936 5.03577L4.26879 6.53916C4.25477 6.60884 4.27688 6.68069 4.32702 6.73129C4.36742 6.77169 4.42184 6.79333 4.47758 6.79333C4.49112 6.79333 4.50521 6.79209 4.51923 6.78913L6.02218 6.48856C6.06383 6.48 6.10167 6.46007 6.13101 6.43025L9.49487 3.06645L7.99192 1.5636L4.62759 4.9274Z"/>
                                                <path d="M10.5329 0.525254C10.1184 0.110723 9.444 0.110723 9.02982 0.525254L8.44141 1.11362L9.94444 2.61652L10.5329 2.02808C10.7336 1.82786 10.8441 1.56084 10.8441 1.27686C10.8441 0.992876 10.7336 0.725864 10.5329 0.525254Z"/>
                                            </svg>
                                        </button>
                                    </a>
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

    /* page edit view */
    public function pageEdit($id)
    {
        $menu = Menu::with('page')->findOrFail($id);
        $page = $menu->page ?? new Page();

        return view('backend.pages.website_setting.pages.edit', compact('menu', 'page'));
    }

    /* page update */
    public function pageUpdate(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required|max:125|string',
            ]);
            $menu = Menu::with('page')->findOrFail($id);
            $request->request->add(['menu_id' => $menu->id]);
            if ($menu->page) {
                $menu->page()->update($request->only(['title', 'description', 'is_active', 'menu_id']));
            } else {
                $menu->page()->create($request->only(['title', 'description', 'is_active', 'menu_id']));
            }
            return redirect()->route('backend.website_setting.pages')->with($this->update_success_message);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return back()->withInput()->with($this->update_fail_message);
        }
    }

    /* change menu status*/

    public function changeMenuStatus(Request $request)
    {
        $menu = Menu::find($request->id);
        if ($menu) {
            if ($request->field == 'is_header_menu')
                $menu->is_header_menu = $request->status;
            if ($request->field == 'is_footer_menu')
                $menu->is_footer_menu = $request->status;
            if ($request->field == 'is_quick_link')
                $menu->is_quick_link = $request->status;
            if ($request->field == 'is_informatic')
                $menu->is_informatics = $request->status;
            if ($request->field == 'is_active')
                $menu->is_active = $request->status;
            $menu->save();
            return response()->json($this->update_success_message);
        } else {
            return response()->json($this->not_found_message);
        }
    }

    /* view appearance */

    public function appearance()
    {
        $appearance = WebAppearance::query()->findOrFail(1);
        $currencies = Currency::query()->where('is_active', 1)->get();
        $countries = Country::query()->where('is_active', 1)->get();
        return view('backend.pages.website_setting.appearance', compact('appearance', 'currencies', 'countries'));
    }

    /* update appearance*/

    public function appearanceUpdate(Request $request, $id)
    {
        $request->validate([
            'website_name' => ['required'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg,gif', 'max:300'],
            'favicon' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg,gif', 'max:200'],
            'backend_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg,gif', 'max:200'],
            'meta_title' => ['required'],
            'about_us' => ['required'],
            'keywords' => ['required'],
            'currency_id' => ['required'],
            'base_currency_id' => ['required'],
            'email' => ['required', 'email'],
            'city' => ['required'],
            'post_code' => ['required'],
            'country' => ['required'],
            'hotline_number' => ['required'],
            'website_base_color' => ['required'],
            'website_base_hover_color' => ['required'],
            'get_in_touch' => ['required', 'string', 'max:300'],
            'facebook_link' => ['required', 'string', 'max:200'],
            'twitter_link' => ['required', 'string', 'max:200'],
            'pinterest_link' => ['required', 'string', 'max:200'],
            'instagram_link' => ['required', 'string', 'max:200'],
        ]);
        try {
            $appearance = WebAppearance::query()->findOrFail($id);

            $data = $request->only([
                'website_name', 'meta_title', 'meta_desc', 'keywords', 'website_base_color', 'website_base_hover_color',
                'cookies_agreement_desc', 'is_show_cookies_agreement', 'hotline_number', 'currency_id', 'base_currency_id', 'get_in_touch', 'facebook_link',
                'twitter_link', 'pinterest_link', 'instagram_link', 'city', 'country', 'post_code', 'email', 'backend_logo', 'about_us'
            ]);
            $logo = $request->file('logo');
            $favicon = $request->file('favicon');
            $backend_logo = $request->file('backend_logo');
            if ($logo) {
                if (file_exists(storage_path('app/public/') . $appearance->logo)) {
                    Storage::delete($appearance->logo);
                }
                $logo_path = Storage::putFileAs('', $logo, 'logo.' . $logo->getClientOriginalExtension());
                $data['logo'] = $logo_path;
            }
            if ($favicon) {
                if (file_exists(storage_path('app/public/') . $appearance->favicon)) {
                    Storage::delete($appearance->favicon);
                }
                $favicon_path = Storage::putFileAs('', $favicon, 'favicon.' . $favicon->getClientOriginalExtension());
                $data['favicon'] = $favicon_path;
            }
            if ($backend_logo) {
                if (file_exists(storage_path('app/public/') . $appearance->backend_logo)) {
                    Storage::delete($appearance->backend_logo);
                }
                $backend_logo_path = Storage::putFileAs('', $backend_logo, 'backend_logo.' . $backend_logo->getClientOriginalExtension());
                $data['backend_logo'] = $backend_logo_path;
            }
            $appearance->fill($data);
            $is_changed = $appearance->isDirty();
            $appearance->save();
            $appearance->refresh();
            if ($is_changed) {
                $this->setEnv('APP_NAME', $appearance->website_name);
                $this->setEnv('LOGO', 'uploads/' . $appearance->logo);
                $this->setEnv('BACKEND_LOGO', 'uploads/' . $appearance->backend_logo);
                $this->setEnv('FAVICON', 'uploads/' . $appearance->favicon);
                Storage::disk('public')->put('maanAppearance.json', json_encode($appearance));
                Artisan::call('optimize:clear');
                Artisan::call('config:clear');
            }
            if ($appearance->wasChanged('base_currency_id')) {
                $currency = Currency::query()->find($request->base_currency_id);
                if ($currency)
                    $currency->update(['exchange_rate' => 1]);
            }
            return redirect()->route('backend.website_setting.appearance')->with($this->update_success_message);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->withInput()->with($this->update_fail_message);
        }
    }

    private function setEnv($key, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            $escaped = preg_quote('=' . env($key), '/');
            file_put_contents($path, preg_replace(
                "/^{$key}{$escaped}/m",
                "{$key}={$value}",
                file_get_contents($path)
            ));
        }
    }
}
