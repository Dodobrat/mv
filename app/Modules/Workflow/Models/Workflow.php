<?php

namespace App\Modules\Workflow\Models;

use Dimsav\Translatable\Translatable;
use Kalnoy\Nestedset\NodeTrait;
use ProVision\Administration\Traits\RevisionableTrait;
use ProVision\Administration\Traits\ValidationTrait;
use ProVision\MediaManager\Traits\MediaManagerTrait;
use ProVision\Administration\AdminModel;

class Workflow extends AdminModel
{
    use NodeTrait, MediaManagerTrait, ValidationTrait, Translatable, RevisionableTrait;

    public $translationForeignKey = 'work_id';
    /**
     * @var array
     */
    public $translatedAttributes = [
        'description',
    ];
    protected $table = 'workflow';
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
}
