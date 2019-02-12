<?php

namespace App\Modules\Categories\Models;

use ProVision\Administration\AdminModelTranslations;
use ProVision\Administration\Traits\RevisionableTrait;

class CategoryTranslation extends AdminModelTranslations {
    use RevisionableTrait;

    protected $table = 'categories_translations';

    public $timestamps = false;

    protected $fillable = [
        'title',
    ];
}
