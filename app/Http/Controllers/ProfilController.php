<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id=\Auth::user()->id;
        $paket = \App\Paket::all()->first();//paginate(10);
        $user = \App\User::where('id',$id)->first();
        return view('customer.profil',['user'=> $user,'paket'=>$paket]);
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
        //
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
        $user =\App\User::findOrFail($id);
        if($request->has('avatar')){
            if($request->file('avatar')){
                if($user->avatar && file_exists(storage_path('app/public/'.$user->avatar)))
                {
                    \Storage::delete('public/'.$user->avatar);
                }
                $file = $request->file('avatar')->store('avatars','public');
                $user->avatar =$file;
            }
        }else if($request->has('profil_desc')){
            $user->profile_desc = $request->get('profil_desc');
        }
        
        $user->save();
        return redirect()->route('profil.index',[$id])->with('status','User Succsessfully Update');
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
