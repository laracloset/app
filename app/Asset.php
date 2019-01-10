<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{

    protected $fillable = [
        'foreign_key',
        'model',
        'name',
        'type',
        'size',
        'path',
    ];
}
