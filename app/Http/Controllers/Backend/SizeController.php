<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseMessage;
use Illuminate\Http\Request;
use App\Models\Backend\Size;

class SizeController extends Controller
{
    use ResponseMessage;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sizes = Size::orderByDesc('id')->paginate(10);
        return  view('backend.pages.sizes.pages.index',compact('sizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $size = new  Size();
        return view('backend.pages.sizes.pages.create',compact('size'));
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
            'name'=>'required|string|unique:sizes,name,'
        ]);

        $data = $request->only('name','is_active');
        $data['display_in_search']=1;
        Size::create($data);
        return redirect()->route('backend.sizes.index')->with($this->create_success_message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $size = Size::findOrFail($id);
        return view('backend.pages.sizes.pages.edit',compact('size'));
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
            'name'=>'required|string|unique:sizes,name,'.$id
        ]);

        $data = $request->only('name','is_active');
        $data['display_in_search']=1;
        $size = Size::findOrFail($id);
        $size->update($data);
        return redirect()->route('backend.sizes.index')->with($this->update_success_message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $color = Size::findorFail($id);
        $color->delete();
        return redirect()->route('backend.colors.index')->with($this->delete_success_message);
    }
    public function sizeStatus(Request $request)
    {
        if ($request->ajax()){
            $color = Size::where('id',$request->id)->first();
            if ($color){
                $color->update(['is_active'=>$request->status]);

                return response()->json($this->update_success_message);
            } else {
                return response()->json($this->not_found_message);
            }
        }else{
            return response()->json("message","Sorry !! Bad Request.");
        }

    }
}
