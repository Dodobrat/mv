<?php
/**
 * Copyright (c) 2019. ProVision Media Group Ltd. <http://provision.bg>
 * Venelin Iliev <http://veneliniliev.com>
 */

namespace App\Modules\Contacts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendRequestContact extends FormRequest
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
        $trans = [];

//        $trans['business'] = 'nullable|string';
        $trans['first_name'] = 'required|string';
        $trans['last_name'] = 'required|string';
        $trans['phone'] = 'required|string';
        $trans['email'] = 'required|email';
        $trans['message'] = 'required|string';
        $trans['g-recaptcha-response'] = 'required|captcha';

        return $trans;
    }
}
