<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{   

    public function __construct(){
        $this->middleware(function($request, $next){
            
            if(Gate::allows('manage-banner')) return $next($request);

            abort(403, 'Anda tidak memiliki cukup hak akses');
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$request->client_id'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }

        // $tes = \Route::current()->parameter('client_id');

        $banner = \App\Banner::orderBy('id', 'DESC')->get();//paginate(10);\App\Banner::orderBy('id', 'DESC')->first();
        $keyword = $request->get('name');
        if($keyword){
            $banner = \App\Banner::where('name','LIKE',"%$keyword%")->where('client_id','=',$clientID)->get();//paginate(10);
        }
        return view($clientNM.'.banner.index', ['banner'=>$banner, 'client_slug'=>$clientNM]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = \Route::current()->parameter('client_id');
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        return view($clientNM.'.banner.create', ['client_slug'=>$clientNM]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = \Route::current()->parameter('client_id');
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $name = $request->get('name');
        $newBanner = new \App\Banner;
        $newBanner->name = $name;
        if($request->file('image')){
            $image_path = $request->file('image')->store('banner_images','public');
            $newBanner->image = $image_path;
        }
        $newBanner->create_by = \Auth::user()->id;
        $newBanner->client_id = $clientID;
        //$newCategory->slug = \Str::slug($name,'-');
        $newBanner->save();
        return redirect()->route('banner.create', $clientNM)->with('status','Banner Slide Succesfully Created');
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
    public function edit($id, $client)
    {
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $banner_edit = \App\Banner::where('client_id', $clientID)->findOrFail($id);
        return view($clientNM.'.banner.edit',['banner_edit'=>$banner_edit, 'client_slug'=>$clientNM]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $client)
    {
        // $client = \Route::current()->parameter('client_id');
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $name = $request->get('name');
        //$slug = $request->get('slug');
        $banner = \App\Banner::where('client_id', $clientID)->findOrFail($id);
        $banner->name = $name;
        //$category->slug = $slug;

        if($request->file('image')){
            if($banner->image && file_exists(storage_path('app/public/' .$banner->image))){
            \Storage::delete('public/' . $banner->name);
            }
            $new_image = $request->file('image')->store('banner_images','public');
            $banner->image = $new_image;
            }
            $banner->update_by = \Auth::user()->id;
            $banner->client_id = $clientID;
            //$category->slug = \Str::slug($name);
            $banner->save();
            return redirect()->route('banner.edit', [$id, $clientNM])->with('status','Banner Slide Succsessfully Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $client)
    {
        // $client = \Route::current()->parameter('client_id');
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $banner = \App\Banner::where('client_id', $clientID)->findOrFail($id);
        $banner->delete();
        return redirect()->route('banner.index', $clientNM)
        ->with('status', 'Banner Slide successfully moved to trash');
    }

    public function trash()
    {
        $client = \Route::current()->parameter('client_id');
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $deleted_banner = \App\Banner::onlyTrashed()->where('client_id','=',$clientID)->get();//paginate(10);

        return view($clientNM.'.banner.trash', ['banner' => $deleted_banner, 'client_slug'=>$clientNM]);
    }

    public function restore($id, $client)
    {
        // $client = \Route::current()->parameter('client_id');
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $banner = \App\Banner::where('client_id', $clientID)->withTrashed()->findOrFail($id);
        if($banner->trashed()){
            $banner->restore();
        } 
        else 
        {
            return redirect()->route('banner.index', $clientNM)
            ->with('status', 'Banner Slide is not in trash');
        }
        return redirect()->route('banner.index', $clientNM)
        ->with('status', 'Banner Slide successfully restored');
    }

    public function deletePermanent($id, $client){
        $client = \Route::current()->parameter('client_id');
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $banner = \App\Banner::where('client_id', $clientID)->withTrashed()->findOrFail($id);
        if(!$banner->trashed()){
        return redirect()->route('banner.index')
        ->with('status', 'Can not delete permanent active banner slide');
        } else {
        $banner->forceDelete();
        return redirect()->route('banner.index')
        ->with('status', 'Banner Slide permanently deleted');

            }
        }

}
