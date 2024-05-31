<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\RoomsRequests;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    //
    public function index(){
        $rooms = Room::get();
        return view('rooms.index',['rooms'=>$rooms]);
    }
    public function store(Request $request){
        $request->validate([
            'code'=> 'required|max:255',
            'type'=>'required|in:single,double,suite',
            'status'=>'required|in:available,booked,pending'
        ]);

        Room::create([
            'code'=> $request->code,
            'type'=>$request->type,
            'status'=>$request->status
        ]);
        return back()->with('success','create room success');
    }
    public function upload(Request $request){
        $request->validate([
            'id'=> 'required|exists:rooms,id',
            'status'=>'required|in:available,booked,pending'
        ]);
        Room::where('id', $request->id)->update([
            'status' => $request->status,
        ]);
        return response()->json([
            'success' => 'success',
         ], 200);

    }
    public function requests(){
        $requests = RoomsRequests::get();

        return view('rooms.roomRequests',['requests'=>$requests]);
    }
    public function uploadRequest(Request $request){

        $request->validate([
            'id'=> 'required|exists:rooms_requests,id',
            'status'=>'required|in:approve,reject,pending'
        ]);
     
        RoomsRequests::where('id', $request->id)->update([
            'status' => $request->status,
            'employee_id'=>auth()->user()->id
        ]);
        return response()->json([
            'success' => 'success',
         ], 200);

    }
    public function destory($id){
        $validator = Validator::make([
            'id' => $id
        ], [
            'id' => 'required|exists:rooms,id'
        ]);

        if ($validator->fails()) {
            return back()->with('message' , $validator->errors());
        }
        Room::where('id',$id)->delete();
        return back()->with('success','room delete success');

    }
}
