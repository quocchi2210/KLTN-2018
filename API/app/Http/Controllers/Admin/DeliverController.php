<?php

namespace App\Http\Controllers\Admin;

use App\Deliver;
use App\Mail\ConfirmPasswordMail;
use App\Role;
use App\User;
use App\VerifyResetUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DeliverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Role::find(2);
        $delivers = $role->user;
        return view('admin.deliver.index',['delivers'=>$delivers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $deliver = $request->get('Deliver');
        $password = str_random(10);
        $user = User::create([
            'email' => $deliver['email'],
            'fullName' => $deliver['full_name'],
            'roleId' => 2,
            'password' => bcrypt($password)
        ]);
        $verifyUser = VerifyResetUser::create([
            'user_id' => $user->idUser,
            'token' => str_random(32),
            'confirmation' => 1
        ]);
        Mail::to($user->email)->send(new ConfirmPasswordMail($user,$verifyUser));
        return back();
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

    public function getConfirmDeliver()
    {
        return view('auth.passwords.confirm-password');
    }
    public function confirmDeliver($userId,$token,Request $request)
    {
        $password = $request->get('password');
        $verifyUser = VerifyResetUser::where('token', $token)->where('user_id',$userId)->where('confirmation', 1)->first();
        if($verifyUser){
            $user = $verifyUser->user;
            if(!$user->isActivated) {
                $verifyUser->user->isActivated = 1;
                $verifyUser->user->password = bcrypt($password);
                $verifyUser->user->save();
            }
        }
        return redirect('/');
    }
}
