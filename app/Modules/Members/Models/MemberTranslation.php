<?php

namespace App\Modules\Members\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use ProVision\Administration\AdminModelTranslations;
use ProVision\Administration\Traits\RevisionableTrait;

class MemberTranslation extends AdminModelTranslations
{
    use Sluggable, RevisionableTrait;

    protected $table = 'members_translations';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'position',
        'bio',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'slug',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable() {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }
}
