<?php

namespace App\Http\Controllers\Api;

use App\Models\Room;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\RoomsRequests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 422);
        }

        $client = Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $client->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Client registered successfully',
            'data' => [
                'client' => $client,
                'token' => $token,
            ],
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $client = Client::where('email', $request->email)->first();

        if (!$client || !Hash::check($request->password, $client->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email or password',
            ], 401);
        }

        $token = $client->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Client logged in successfully',
            'data' => [
                'token' => $token,
            ],
        ]);
    }
    public function rooms($type = 'all'){
        $validator = Validator::make([
            'type' => $type
        ], [
            'type' => 'required|in:single,double,suite,all'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 422);
        }
        $rooms = Room::where('status','available');
       if($rooms != 'all'){
        $rooms = $rooms->where('type',$type);
       }
       $rooms= $rooms->get();

       return response()->json([
        'status' => 'success',
        'data' => [
            'rooms' => $rooms,
        ],
     ], 200);
    }

    public function requestRoom(Request $request){
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:rooms,id',
            'client_id' => 'required|exists:clients,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 422);
        }


        $roomRequest = RoomsRequests::create([
            'room_id' => $request->room_id,
            'client_id' => $request->client_id,

        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Client request send successfully',
            'data' => [
                'roomRequest' => $roomRequest,
            ],
        ], 201);

    }
    public function myRequests($client_id){
        $validator = Validator::make([
            'client_id' => $client_id
        ], [
            'client_id' => 'required|exists:clients,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 422);
        }
        $clientRequests = RoomsRequests::where('id',$client_id)->get();


        return response()->json([
            'status' => 'success',
            'data' => [
                'clientRequests' => $clientRequests,
            ],
         ], 200);

    }

}
