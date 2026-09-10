<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseMessage;
use App\Models\Backend\Color;
use App\Models\Backend\Menu;
use Illuminate\Http\Request;
use Laravel\Prompts\Concerns\Colors;

class ColorController extends Controller
{
    use ResponseMessage;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = Color::orderByDesc('id')->paginate(10);
        return  view('backend.pages.colors.pages.index',compact('colors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $color = new  Color();
        return view('backend.pages.colors.pages.create',compact('color'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|unique:colors,name,'
        ]);

        $data = $request->only('name','hex','is_active');
        $data['display_in_search']=1;
        Color::create($data);
        return redirect()->route('backend.colors.index')->with($this->create_success_message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $color = Color::findOrFail($id);
        return view('backend.pages.colors.pages.edit',compact('color'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required|string|unique:colors,name,'.$id
        ]);

        $data = $request->only('name','hex','is_active');
        $data['display_in_search']=1;
        $color = Color::findOrFail($id);
        $color->update($data);
        return redirect()->route('backend.colors.index')->with($this->update_success_message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $color = Color::findorFail($id);
        $color->delete();
        return redirect()->route('backend.colors.index')->with($this->delete_success_message);
    }

    /* Process ajax request */
    public function colorStatus(Request $request)
    {
        if ($request->ajax()){
            $color = Color::where('id',$request->id)->first();
            if ($color){
                $color->update(['is_active'=>$request->status]);

                return response()->json($this->update_success_message);
            } else {
                return response()->json($this->not_found_message);
            }
        }

    }
}
