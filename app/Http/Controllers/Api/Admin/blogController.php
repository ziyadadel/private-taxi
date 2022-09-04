<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Image;
use DB;

class blogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blog = Blog::all();
        return response()->json($blog);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'duration' => 'required|max:255',
            'date' => 'required'
        ]);

        if ($request->image) {
            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time().".".$ext;
            $img = Image::make($request->image);
            $upload_path = 'backend/blog/';
            $image_url = $upload_path.$name;
            $img->save($image_url);

            $blog = new Blog;
            $blog->title = $request->title;
            $blog->description = $request->description;
            $blog->duration = $request->duration;
            $blog->date = $request->date;
            $blog->show = $request->show;
            $blog->image = $image_url;
            $blog->save();
        }else{
            $blog = new Blog;
            $blog->title = $request->title;
            $blog->description = $request->description;
            $blog->duration = $request->duration;
            $blog->date = $request->date;
            $blog->show = $request->show;
            $blog->image = $image_url;
            $blog->save();
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
        $blog = DB::table('blogs')->where('id',$id)->first();
        return response()->json($blog);
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
        $data = array();
        $data['id'] = $request->id;
        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['duration'] = $request->duration;
        $data['date'] = $request->date;
        $data['show'] = $request->show;
        $image = $request->newimage;

        if ($image) {
         $position = strpos($image, ';');
         $sub = substr($image, 0, $position);
         $ext = explode('/', $sub)[1];

         $name = time().".".$ext;
         $img = Image::make($image);
         $upload_path = 'backend/blog/';
         $image_url = $upload_path.$name;
         $success = $img->save($image_url);
         
         if ($success) {
            $data['image'] = $image_url;
            $img = DB::table('blogs')->where('id',$id)->first();
            $image_path = $img->image;
            $done = unlink($image_path);
            $user  = DB::table('blogs')->where('id',$id)->update($data);
         }

          
        }else{
            $oldphoto = $request->image;
            $data['image'] = $oldphoto;
            $user = DB::table('blogs')->where('id',$id)->update($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = DB::table('blogs')->where('id',$id)->first();
        $photo = $blog->image;
        if ($photo) {
            unlink($photo);
            DB::table('blogs')->where('id',$id)->delete();
        }else{
            DB::table('blogs')->where('id',$id)->delete();
        }
    }

    public function home()
    {
        $blog = DB::table('blogs')->where('show', 1)->get();
        return response()->json($blog);
    }
}
