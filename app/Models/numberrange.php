<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class numberrange extends Model
{
    use HasFactory, Notifiable;

    public $timestamps = false;

    protected $table = 'numberrange';
    protected $primaryKey = 'type';
    protected $fillable = [
        'from',
        'to',
        'current'
    ];
}
