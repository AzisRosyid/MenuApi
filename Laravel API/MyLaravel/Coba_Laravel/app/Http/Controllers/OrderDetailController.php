<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderDetail;
use App\Models\OrderHeader;
use Illuminate\Support\Facades\Validator;


class OrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderHeader = OrderHeader::all()->sortByDesc('id')->values();
        $orderDetail = OrderDetail::all()->sortByDesc('id')->values();
        $orderHeader->push($orderDetail);
        return response(['orderdetails' => $orderDetail], 200);
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
            'header_id' => 'required|numeric',
            'menu_id' => 'required|integer',
            'qty' => 'required|integer'
        ];

        $messages = [
            'menu_id.required' => 'Menu Id diperlukan',
            'qty.required' => 'Qty diperlukan'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return response(['errors' => $validator->errors()->first()], 422);
        }

        OrderDetail::create([
            'order_id' => $request->header_id,
            'menu_id' => $request->menu_id,
            'qty' => $request->qty,
            'status' => 'Preparing'
        ]);

        return response(['message' => 'Menu ordered!'], 201);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
