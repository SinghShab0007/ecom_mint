<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Language;
use Illuminate\Http\RedirectResponse;
use App\Http\Traits\ResponseMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    use ResponseMessage;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $languages = Language::query()->get();
        return view('backend.pages.language.index',compact('languages'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:languages',
            'direction' => 'required',
            'alias' => 'required|unique:languages'
        ]);

        Language::query()->create($request->all());

        $exists = File::exists(base_path().'/resources/lang/'.$request->alias.'.json');

        if(!$exists){
            File::copy(base_path().'/resources/lang/ex.json',base_path().'/resources/lang/'.$request->alias.'.json');
        }

        return redirect()->back();
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        $language = Language::query()->findOrFail($id);
        return view('backend.pages.language._edit',compact('language'));
    }

    public function update(Request $request,$id)
    {
        $language = Language::query()->findOrFail($id);

        $exists = File::exists(base_path().'/resources/lang/'.$language->alias.'.json');

        if($language->alias != $request->alias){
            if($exists){
                File::move(base_path('resources/lang/'.$language->alias.'.json'),base_path('resources/lang/'.$request->alias.'.json'));
            }else{
                File::copy(base_path().'/resources/lang/ex.json',base_path().'/resources/lang/'.$request->alias.'.json');

            }
        }

        $language->update($request->all());

        return redirect()->back();

    }

    public function translation($id)
    {
        $language = Language::query()->findOrFail($id);
        $exists = file_exists(base_path('resources/lang/'.$language->alias.'.json'));

        if(!$exists){
            return redirect()->back()->withErrors(['msg'=>__('Language file not exists. If you are trying to change English it is not necessary.')]);
        }

        $lines = json_decode(file_get_contents(base_path('resources/lang/'.$language->alias.'.json')));
        return view('backend.pages.language.translation',compact('language','lines'));
    }

    /**
     * Translate language for the specific language
     *
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function translate($id, Request $request): RedirectResponse
    {
        $language = Language::query()->findOrFail($id);
        $file = json_decode(file_get_contents(base_path().'/resources/lang/'.$language->alias.'.json'),true);
        foreach ($request->trans as $key => $line){
            //dd($key);
            //dd(json_encode($request->trans,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
            $file[$key] = $line;
        }
        //dd($file);
        // Write File

        //dd(json_encode($file,));
        $newJsonString = json_encode($file, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        //dd($newJsonString);

        file_put_contents(base_path('resources/lang/'.$language->alias.'.json'), stripslashes($newJsonString));

        return redirect()->back();
    }

    /**
     * Set the default language for website
     *
     * @return RedirectResponse
     */
    public function default(Request $request): RedirectResponse
    {
        $languages = Language::query()->get();

        foreach ($languages as $lang){
            $lang->update(['default'=>0]);
        }

        $language = Language::query()->findOrFail($request->id);
        $language->update(['default'=>1]);

        Session::flash('success','Default language set to '.$language->name);

        return redirect()->back();
    }

    /**
     * Remove language from storage
     *
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $language = Language::query()->findOrFail($id);
        $language->delete();

        File::delete(base_path('resources/lang/'.$language->alias.'.json'));

        Session::flash('success','Language has been removed successfully!');

        return redirect()->back();
    }
}
