<?php
/**
 * Copyright (c) 2019. ProVision Media Group Ltd. <http://provision.bg>
 * Venelin Iliev <http://veneliniliev.com>
 */

namespace App\Modules\Contacts\Models;

use ProVision\Administration\AdminModelTranslations;
use ProVision\Administration\Traits\RevisionableTrait;

class ContactsTranslation extends AdminModelTranslations
{
    use RevisionableTrait;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'email',
        'address',
        'working_time',
        'phone',
        'description'
    ];
}
