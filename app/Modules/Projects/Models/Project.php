<?php

namespace App\Modules\Projects\Models;

use App\Modules\Categories\Models\Category;
use Dimsav\Translatable\Translatable;
use Kalnoy\Nestedset\NodeTrait;
use ProVision\Administration\Traits\RevisionableTrait;
use ProVision\Administration\Traits\ValidationTrait;
use ProVision\MediaManager\Traits\MediaManagerTrait;
use ProVision\Administration\AdminModel;

class Project extends AdminModel
{
    use NodeTrait, MediaManagerTrait, ValidationTrait, Translatable, RevisionableTrait;

    public $translationForeignKey = 'project_id';
    /**
     * @var array
     */
    public $translatedAttributes = [
        'title',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'slug',
    ];
    protected $table = 'projects';
    /**
     * @var array
     */
    protected $fillable = [
        'visible',
        'special',
        'category_id'
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'visible' => 'boolean',
        'special' => 'boolean',
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

    public function scopeSpecial($query) {
        return $query->where($this->table . '.special', 1);
    }

    public function category() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
