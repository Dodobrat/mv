<?php

namespace App\Modules\Types\Models;

use App\Modules\Categories\Models\Category;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use ProVision\Administration\AdminModel;
use ProVision\Administration\Traits\RevisionableTrait;
use ProVision\Administration\Traits\ValidationTrait;
use ProVision\MediaManager\Traits\MediaManagerTrait;

class Type extends AdminModel {
    use NodeTrait, MediaManagerTrait, ValidationTrait, Translatable, RevisionableTrait, SoftDeletes;

    public $translationForeignKey = 'type_id';
    /**
     * @var array
     */
    public $translatedAttributes = [
        'title',
    ];
    protected $table = 'types';
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
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where($this->table . '.visible', 1);
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'types_categories','type_id', 'category_id')->active();
    }

}
