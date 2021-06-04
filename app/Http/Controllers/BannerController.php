<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
        $banner = \App\Banner::orderBy('position', 'ASC')->get();//paginate(10);\App\Banner::orderBy('id', 'DESC')->first();
        $keyword = $request->get('name');
        if($keyword){
            $banner = \App\Banner::where('name','LIKE',"%$keyword%")->get();//paginate(10);
        }
        return view('banner.index', ['banner'=>$banner]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Validator::make($request->all(), [
            "image" => "required|image|mimes:jpeg,png,jpg|max:500"
        ])->validate();
        $name = $request->get('name');
        $newBanner = new \App\Banner;
        $newBanner->name = $name;
        if($request->file('image')){
            $image_path = $request->file('image')->store('banner_images','public');
            $newBanner->image = $image_path;
        }
        $newBanner->create_by = \Auth::user()->id;
        //$newCategory->slug = \Str::slug($name,'-');
        $newBanner->save();
        return redirect()->route('banner.create')->with('status','Banner Slide Succesfully Created');
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
        $banner_edit = \App\Banner::findOrFail($id);
        return view('banner.edit',['banner_edit'=>$banner_edit]);
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
        \Validator::make($request->all(), [
            "image" => "required|image|mimes:jpeg,png,jpg|max:500"
        ])->validate();
        $name = $request->get('name');
        //$slug = $request->get('slug');
        $banner = \App\Banner::findOrFail($id);
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
            //$category->slug = \Str::slug($name);
            $banner->save();
            return redirect()->route('banner.edit', [$id])->with('status','Banner Slide Succsessfully Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = \App\Banner::findOrFail($id);
        $banner->delete();
        return redirect()->route('banner.index')
        ->with('status', 'Banner Slide successfully moved to trash');
    }

    public function trash(){
        $deleted_banner = \App\Banner::onlyTrashed()->get();//paginate(10);

        return view('banner.trash', ['banner' => $deleted_banner]);
    }

    public function restore($id){

        $banner = \App\Banner::withTrashed()->findOrFail($id);
        if($banner->trashed()){
        $banner->restore();
        } 
        else 
        {
        return redirect()->route('banner.index')
        ->with('status', 'Banner Slide is not in trash');
        }
        return redirect()->route('banner.index')
        ->with('status', 'Banner Slide successfully restored');
    }

    public function deletePermanent($id){

        $banner = \App\Banner::withTrashed()->findOrFail($id);
        if(!$banner->trashed()){
        return redirect()->route('banner.index')
        ->with('status', 'Can not delete permanent active banner slide');
        } else {
        $banner->forceDelete();
        return redirect()->route('banner.index')
        ->with('status', 'Banner Slide permanently deleted');

            }
        }
    
    public function post_sortable(Request $request){
        $banners= \App\Banner::all();

        foreach ($banners as $ban) {
            foreach ($request->posit as $order) {
                if ($order['id'] == $ban->id) {
                    $ban->update(['position' => $order['position']]);
                }
            }
        }
        
        return response('Update Successfully.', 200);
    }

}
