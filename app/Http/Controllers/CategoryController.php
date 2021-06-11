<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{   
    public function __construct(){
        $this->middleware(function($request, $next){
            
            if(Gate::allows('manage-categories')) return $next($request);

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
        $categories = \App\Category::get();//paginate(10);
        $keyword = $request->get('name');
        if($keyword){
            $categories = \App\Category::where('name','LIKE',"%$keyword%")->where('client_id','=',$clientID)->get();//paginate(10);
        }
        return view($clientNM.'.category.index', ['categories'=>$categories, 'client_slug'=>$clientNM]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($client)
    {
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        return view($clientNM.'.category.create', ['client_slug'=>$clientNM]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $client)
    {
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $name = $request->get('name');
        $newCategory = new \App\Category;
        $newCategory->name = $name;
        if($request->file('image')){
            $image_path = $request->file('image')->store('category_images','public');
            $newCategory->image_category = $image_path;
        }
        $newCategory->create_by = \Auth::user()->id;
        $newCategory->slug = \Str::slug($name,'-');
        $newCategory->client_id = $clientID;
        $newCategory->save();
        return redirect()->route('categories.create', $clientNM)->with('status','Category Succesfully Created'); 
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
        $cat_edit = \App\Category::where('client_id', $clientID)->findOrFail($id);
        return view($clientNM.'.category.edit',['cat_edit'=>$cat_edit, 'client_slug'=>$clientNM]);
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
        $category = \App\Category::where('client_id', $clientID)->findOrFail($id);
        $category->name = $name;
        //$category->slug = $slug;

        if($request->file('image')){
            if($category->image_category && file_exists(storage_path('app/public/' .$category->image_category))){
            \Storage::delete('public/' . $category->name);
            }
            $new_image = $request->file('image')->store('category_images','public');
            $category->image_category = $new_image;
            }
            $category->update_by = \Auth::user()->id;
            $category->slug = \Str::slug($name);
            $category->client_id = $clientID;
            $category->save();
            return redirect()->route('categories.edit', [$id, $clientNM])->with('status','Category Succsessfully Update');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $client)
    {
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $category = \App\Category::where('client_id', $clientID)->findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index', $clientNM)
        ->with('status', 'Category successfully moved to trash');
    }

    public function trash($client)
    {
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $deleted_category = \App\Category::onlyTrashed()->get();//paginate(10);

        return view($clientNM.'.category.trash', ['categories' => $deleted_category, 'client_slug'=>$clientNM]);
    }

    public function restore($id, $client)
    {
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $category = \App\Category::where('client_id', $clientID)->withTrashed()->findOrFail($id);
        if($category->trashed()){
        $category->restore();
        } 
        else 
        {
        return redirect()->route('categories.index', $clientNM)
        ->with('status', 'Category is not in trash');
        }
        return redirect()->route('categories.index', $clientNM)
        ->with('status', 'Category successfully restored');
    }

    public function deletePermanent($id, $client)
    {
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $category = \App\Category::where('client_id', $clientID)->withTrashed()->findOrFail($id);
        if(!$category->trashed()){
        return redirect()->route('categories.index', $clientNM)
        ->with('status', 'Can not delete permanent active category');
        } else {
        $category->forceDelete();
        return redirect()->route('categories.index', $clientNM)
        ->with('status', 'Category permanently deleted');

            }
        }

        public function ajaxSearch(Request $request, $client){
            $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

            $clientID = $clientNM = "";
            if(count($sql_client) > 0){
                $clientID = $sql_client[0]->client_id;
                $clientNM = $sql_client[0]->client_slug;
            }
            $keyword = $request->get('q');
            $categories = \App\Category::where('name','LIKE',"%$keyword%")->where('client_id','=',$clientID)->get();
            return $categories;
        }
            
}
