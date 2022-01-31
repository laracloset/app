<?php

namespace App\Models;

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

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function treeList()
    {
        $categoryCollection = self::query()
            ->get()
            ->toTree();

        $list = [];
        $traverse = function ($categories, $prefix = '-') use (&$traverse, &$list) {
            foreach ($categories as $category) {
                $list[$category->id] = $prefix . $category->name;
                $traverse($category->children, $prefix . '-');
            }
        };
        $traverse($categoryCollection);

        return collect($list);
    }
}
