<?php

namespace App\Modules\Types\Models;

use ProVision\Administration\AdminModelTranslations;
use ProVision\Administration\Traits\RevisionableTrait;

class TypeTranslation extends AdminModelTranslations {
    use RevisionableTrait;

    protected $table = 'types_translations';

    public $timestamps = false;

    protected $fillable = [
        'title',
    ];
}
