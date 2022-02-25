<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu = Menu::all()->sortByDesc('id')->values();
        $total = $menu->sum('price');
        return array('menus' => $menu, 'total' => $total);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'price' => 'required',
            'carbo' => 'required',
            'protein' => 'required',
        ];

        $messages = [
            'required' => 'The :attribute required'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return response(['errors' => $validator->errors()->first()], 422);
        }

        $file = null;
        if($request->file('photo') != null){
            $photo = $request->file('photo')->getClientOriginalExtension();
            $file = Carbon::now()->format('Y_m_d_His').'_'.$request->name.'.'.$photo;
            $request->file('photo')->move('images', $file);
        }

        Menu::create([
            'name' => $request['name'],
            'price' => $request['price'],
            'carbo' => $request['carbo'],
            'protein' => $request['protein'],
            'photo' => $file
        ]);

        return response(['message' => 'Menu successfuly created!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menu = Menu::find($id)->values();
        return array('menus' => $menu);
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
        $rules = [
            'name' => 'required|string',
            'price' => 'required|integer',
            'carbo' => 'required|integer',
            'protein' => 'required|integer',
        ];

        $messages = [
            'required' => 'the :attribute required'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return response([$validator->errors()->first()], 422) ;
        }

        $file = null;
        if($request->file('photo') != null){
            $photo = $request->file('photo')->getClientOriginalExtension();
            $file = Carbon::now()->format('Y_m_d_His').'_'.$request->name.'.'.$photo;
            $request->file('photo')->move('images', $file);
        }

        Menu::find($id)->update([
            'name' => $request['name'],
            'price' => $request['price'],
            'carbo' => $request['carbo'],
            'protein' => $request['protein'],
            'photo' => $file
        ]);

        return response(['message' => 'Menu successfully updated!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Menu::destroy($id);
        return response(['message' => 'Menu successfully deleted!']);
    }

    public function search($search) {
        $menu = Menu::where('id', 'like', '%'.$search.'%')->orWhere('name', 'like', '%'.$search.'%')->orWhere('price', 'like', '%'.$search.'%')->orWhere('carbo', 'like', '%'.$search.'%')->orWhere('protein', 'like', '%'.$search.'%')->get()->values();

        return response(['menus' => $menu], 200);
    }
}
