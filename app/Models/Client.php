<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = 'clients';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
