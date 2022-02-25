<?php

namespace App\Http\Controllers;

use App\Models\OrderHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class OrderHeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderHeader = OrderHeader::all()->sortByDesc('id')->values();
        // $orderDetail = OrderHeader::join('order_details', 'order_details.order_id', '=', 'order_headers.id')->where('order_headers.id', 'order_details.order_id')->get()->values();
        // return array('orders' => $orderHeader);
        return array('orderheaders' => $orderHeader);
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
            'user_id' => 'required|numeric',
        ];

        $messages = [
            'required' => 'The :attribute diperlukan',
            'numeric' => 'The :attribute format must be number'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return response(['errors' => $validator->errors()->first()], 422);
        }

        OrderHeader::create([
            'user_id' => $request->user_id,
            'date' => Carbon::now()->format('Y-m-d'),
        ]);

        $headerId = OrderHeader::all('id')->sortByDesc('id')->first();

        return response(['message' => $headerId->id], 201);
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
        OrderHeader::find($id)->update($request->all());

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
        //
    }
}
