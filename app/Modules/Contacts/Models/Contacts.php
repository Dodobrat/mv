<?php
/**
 * Copyright (c) 2019. ProVision Media Group Ltd. <http://provision.bg>
 * Venelin Iliev <http://veneliniliev.com>
 */

namespace App\Modules\Contacts\Models;

use Dimsav\Translatable\Translatable;
use ProVision\Administration\AdminModel;
use ProVision\Administration\Facades\Administration;
use ProVision\Administration\Traits\ValidationTrait;
use ProVision\Administration\Traits\RevisionableTrait;
use ProVision\MediaManager\Traits\MediaManagerTrait;

class Contacts extends AdminModel
{

    use MediaManagerTrait, ValidationTrait, Translatable;

    public $translatedAttributes = [
        'title',
        'email',
        'address',
        'working_time',
        'phone',
        'description'
    ];
    public $module = 'contacts';

    protected $fillable = [
        'visible',
        'lat',
        'long',
    ];

    protected $with = ['translations'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'visible' => 'boolean'
    ];

    /**
     * Scope a query to only include active users.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('contacts.visible', 1);
    }
}
