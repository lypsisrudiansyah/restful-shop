<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return response()->json(['semua_data' => $users], 200);
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
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ];

        $this->validate($request, $rules);
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::VERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::REGULAR_USER;

        $user = User::create($data);

        return response()->json(['data_baru_tersimpan' => $user], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json(['data' => $user], 200);
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
        $update = User::findOrFail($id);

        $rules = [
            'email' => 'email|unique:users,email'.$update->id,
            'password' => 'min:6,|confirmed',
            'admin' => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER,
        ];

        if ($request->has('name')) {
            $update->name = $request->name;
        }

        if ($request->has('email') && $update->email != $request->email) {
            $update->verified = User::UNVERIFIED_USER;
            $update->verification_token = User::generateVerificationCode();
            $update->email = $request->email;
        }

        if ($request->has('password')) {
            $update->password = bcrypt($request->password);

        }

        if ($request->has('admin')) {
            if (!$update->isVerified()) {
                return response()->json(['error' => 'Only Verified User Can Modify the Admin Field', 'code' => 409], 409);
            }

            $update->admin = $request->admin;
        }

        if (!$update->isDirty()) {
            return response()->json(['error' => 'You need to Specify a different value to update', 'code' => 422], 422);
        }

        $update->save();

        return response()->json(['data_baru_terupdate' => $update], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = User::findOrFail($id);

        $delete->delete();

        return response()->json(['data' => $delete], 200);
    }
}
