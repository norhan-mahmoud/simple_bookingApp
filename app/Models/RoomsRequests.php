<?php

namespace App\Models;

use App\Models\Room;
use App\Models\User;
use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomsRequests extends Model
{
    use HasFactory;

    protected $table = 'rooms_requests';
    protected $guarded = [];

    public function room(){
        return $this->belongsTo(Room::class);
     }
     public function client(){
        return $this->belongsTo(Client::class);
     }
     public function employee(){
        return $this->belongsTo(User::class,'employee_id');
     }

}
