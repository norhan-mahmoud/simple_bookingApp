<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomsRequests extends Model
{
    use HasFactory;

    protected $table = 'rooms_requests';
    protected $guarded = [];
}
