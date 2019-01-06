<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use NodeTrait;
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'parent_id'
    ];
}
