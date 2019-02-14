<?php

namespace App\Modules\Members\Models;

use Dimsav\Translatable\Translatable;
use Kalnoy\Nestedset\NodeTrait;
use ProVision\Administration\Traits\RevisionableTrait;
use ProVision\Administration\Traits\ValidationTrait;
use ProVision\MediaManager\Traits\MediaManagerTrait;
use ProVision\Administration\AdminModel;

class Member extends AdminModel
{
    use NodeTrait, MediaManagerTrait, ValidationTrait, Translatable, RevisionableTrait;

    public $translationForeignKey = 'member_id';
    /**
     * @var array
     */
    public $translatedAttributes = [
        'name',
        'position',
        'bio',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'slug',
    ];
    protected $table = 'members';
    /**
     * @var array
     */
    protected $fillable = [
        'visible',
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'visible' => 'boolean',
    ];

    protected $with = ['translations'];


    /**
     * Scope a query to only include active users.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query) {
        return $query->where($this->table . '.visible', 1);
    }

    public function thumbnail_media()
    {
        return $this->media('thumbnail');
    }

    public function profile_media()
    {
        return $this->media('profile');
    }
}
