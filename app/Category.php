<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use NodeTrait;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'parent_id'
    ];
}
