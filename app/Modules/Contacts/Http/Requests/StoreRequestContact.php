<?php
/**
 * Copyright (c) 2019. ProVision Media Group Ltd. <http://provision.bg>
 * Venelin Iliev <http://veneliniliev.com>
 */

namespace App\Modules\Contacts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestContact extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $locales = config('translatable.locales');

        $trans = [];

        foreach ($locales as $locale) {
            $trans[$locale . '.title'] = 'required|string';
            $trans[$locale . '.description'] = 'nullable|string';
            $trans[$locale . '.working_time'] = 'nullable|string';
            $trans[$locale . '.email'] = 'nullable|email';
            $trans[$locale . '.address'] = 'nullable|string';
            $trans[$locale . '.phone'] = 'nullable|string';
        }

        $trans['visible'] = 'boolean';
        return $trans;
    }
}
