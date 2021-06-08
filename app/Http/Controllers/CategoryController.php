<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

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
        $categories = \App\Category::get();//paginate(10);
        $keyword = $request->get('name');
        if($keyword){
            $categories = \App\Category::where('name','LIKE',"%$keyword%")->get();//paginate(10);
        }
        return view('category.index', ['categories'=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->get('name');
        $newCategory = new \App\Category;
        $newCategory->name = $name;
        if($request->file('image')){
            $image_path = $request->file('image')->store('category_images','public');
            $newCategory->image_category = $image_path;
        }
        $newCategory->create_by = \Auth::user()->id;
        $newCategory->slug = \Str::slug($name,'-');
        $newCategory->save();
        return redirect()->route('categories.create')->with('status','Category Succesfully Created'); 
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
        $cat_edit = \App\Category::findOrFail($id);
        return view('category.edit',['cat_edit'=>$cat_edit]);
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
        $name = $request->get('name');
        //$slug = $request->get('slug');
        $category = \App\Category::findOrFail($id);
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
            $category->save();
            return redirect()->route('categories.edit', [$id])->with('status','Category Succsessfully Update');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = \App\Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')
        ->with('status', 'Category successfully moved to trash');
    }

    public function trash(){
        $deleted_category = \App\Category::onlyTrashed()->get();//paginate(10);

        return view('category.trash', ['categories' => $deleted_category]);
    }

    public function restore($id){

        $category = \App\Category::withTrashed()->findOrFail($id);
        if($category->trashed()){
        $category->restore();
        } 
        else 
        {
        return redirect()->route('categories.index')
        ->with('status', 'Category is not in trash');
        }
        return redirect()->route('categories.index')
        ->with('status', 'Category successfully restored');
    }

    public function deletePermanent($id){

        $category = \App\Category::withTrashed()->findOrFail($id);
        if(!$category->trashed()){
        return redirect()->route('categories.index')
        ->with('status', 'Can not delete permanent active category');
        } else {
        $category->forceDelete();
        return redirect()->route('categories.index')
        ->with('status', 'Category permanently deleted');

            }
        }

        public function ajaxSearch(Request $request){
            $keyword = $request->get('q');
            $categories = \App\Category::where('name','LIKE',"%$keyword%")->get();
            return $categories;
        }
            
}
