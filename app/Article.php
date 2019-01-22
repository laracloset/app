<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    const PUBLISHED = 'published';
    const DRAFT = 'draft';
    const PUBLISHED_ALIAS = 'Published';
    const DRAFT_ALIAS = 'Draft';

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'body',
        'state',
    ];

    /**
     * @return array
     */
    public static function getAvailableStates()
    {
        return [
            self::PUBLISHED => self::PUBLISHED_ALIAS,
            self::DRAFT     => self::DRAFT_ALIAS,
        ];
    }

    /**
     * @param $state
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public static function getState($state)
    {
        if (array_key_exists($state, self::getAvailableStates())) {
            return self::getAvailableStates()[$state];
        }

        throw new \Exception('Invalid state');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
