<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all()->sortByDesc('id')->values();
        return array('users' => $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $fields = $request->validate([
        //     'name' => 'required|string',
        //     'email' => 'required|unique:users,email|email',
        //     'password' => 'required|string',
        //     'level' => 'required|string',
        // ]);

        $rules = [
            'name' => 'required|string',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|string',
            'level' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            // return response()->json($validator->errors(), 403);
            return response(['errors' => $validator->errors()->first()], 422);
        }

        $fields = $request->all();

        User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
            'level' => $fields['level']
        ]);

        return response(['message' => 'User successfully Created!'], 201);
    }

    public function login(Request $request, Exception $e){
        // $user = $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required|string',
        // ]);

        $rules = [
            'email' => 'required|email',
            'password' => 'required|string'
        ];

        $messages = [
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email harus memakai format email',
            'password.required' => 'Password tidak boleh kosong',
            'password.string' => 'Password harus memakai format string'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            //return response()->json($validator->errors(), 422);
            return response(['errors' => $validator->errors()->first()], 422);
        }

        $valid = User::where('email', $request->email)->first();
        if(!$valid || !Hash::check($request->password, $valid->password)) {
            return response(['errors' => 'Email and Password does not match'], 401);
        } else {
            return response(['users' => $valid], 200);
        }
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
