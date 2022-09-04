<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trip;
use Image;
use DB;

class TripController extends Controller
{
    /**
    * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trip = Trip::orderBy('trip_num', 'ASC')->get();
        return response()->json($trip);
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
            'trip_num' => 'required|unique:trips',
            'trip_name' => 'required|unique:trips|max:255',
            'sedan_option' => 'required|max:255',
            'van_option' => 'required|max:255',
        ]);

        if ($request->image) {


            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];

            ini_set('memory_limit','256M');
            $name = time().".".$ext;
            $img = Image::make($request->image)->resize(300,450);
            $upload_path = 'backend/trip/';
            $image_url = $upload_path.$name;
            $img->save($image_url);

            // $name = time().".".$ext;
            // $base = base64_decode($request->image);
            // ini_set('memory_limit','256M');
            // $img = Image::make($request->image)->resize(300,450);
            // $upload_path = public_path('backend/trip/');
            // $image_url = $upload_path.$name;
            // $img->save($image_url);

            $trip = new Trip;
            $trip->trip_num = $request->trip_num;
            $trip->trip_name = $request->trip_name;
            $trip->sedan_option = $request->sedan_option;
            $trip->van_option = $request->van_option;
            $trip->show = $request->show;
            $trip->image = $image_url;
            $trip->save();
        }else{
            $trip = new Trip;
            $trip->trip_num = $request->trip_num;
            $trip->trip_name = $request->trip_name;
            $trip->sedan_option = $request->sedan_option;
            $trip->van_option = $request->van_option;
            $trip->show = $request->show;
            $trip->image = $image_url;
            $trip->save();
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
        $trip = DB::table('trips')->where('id',$id)->first();
        return response()->json($trip);
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
        $data['trip_num'] = $request->trip_num;
        $data['trip_name'] = $request->trip_name;
        $data['sedan_option'] = $request->sedan_option;
        $data['van_option'] = $request->van_option;
        $data['show'] = $request->show;
        $image = $request->newimage;

        if ($image) {
         $position = strpos($image, ';');
         $sub = substr($image, 0, $position);
         $ext = explode('/', $sub)[1];

         $name = time().".".$ext;
         $img = Image::make($image)->resize(300,450);
         $upload_path = 'backend/trip/';
         $image_url = $name;
         $success = $img->save($image_url);
         
         if ($success) {
            $data['image'] = $image_url;
            $img = DB::table('trips')->where('id',$id)->first();
            $image_path = $img->image;
            $done = unlink($image_path);
            $user  = DB::table('trips')->where('id',$id)->update($data);
         }

          
        }else{
            $oldphoto = $request->image;
            $data['image'] = $oldphoto;
            $user = DB::table('trips')->where('id',$id)->update($data);
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
        $trip = DB::table('trips')->where('id',$id)->first();
        $photo = $trip->image;
        if ($photo) {
            unlink($photo);
            DB::table('trips')->where('id',$id)->delete();
        }else{
            DB::table('trips')->where('id',$id)->delete();
        }
    }

    public function home()
    {
        $trip = DB::table('trips')->where('show', 1)->get();
        return response()->json($trip);
    }
}
