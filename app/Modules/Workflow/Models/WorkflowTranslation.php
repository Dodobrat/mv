<?php

namespace App\Modules\Workflow\Models;

use ProVision\Administration\AdminModelTranslations;
use ProVision\Administration\Traits\RevisionableTrait;

class WorkflowTranslation extends AdminModelTranslations
{
    use RevisionableTrait;

    protected $table = 'workflow_translations';

    public $timestamps = false;

    protected $fillable = [
        'description',
    ];

}
