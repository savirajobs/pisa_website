<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WsLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'endpoint',
        'identifier',
        'identifier_data',
        'request_data',
        'response_data',
        'status',
        'ip_address'
    ];
}
