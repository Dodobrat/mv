<?php

namespace App\Modules\Members\Http\Requests;

use App\Modules\Members\Models\MemberTranslation;
use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
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
            $trans[$locale . '.name'] = 'required|string';
            $trans[$locale . '.position'] = 'required|string';
            $trans[$locale . '.bio'] = 'nullable|string';
            $trans[$locale . '.meta_title'] = 'nullable|string';
            $trans[$locale . '.meta_description'] = 'nullable|string';
            $trans[$locale . '.meta_keywords'] = 'nullable|string';

            if ($this->method() == 'PATCH' || $this->method() == 'PUT') {
                $locale_alb = MemberTranslation::where('member_id', $this->route('member'))->where('locale', $locale)->first();
                if($this->has($locale.'.name') && !empty($locale_alb)) {
                    $trans[$locale . '.slug'] = 'nullable|string|unique:members_translations,slug,' . $locale_alb->id;
                }
            }else{
                $trans[$locale.'.slug'] = 'nullable|string|unique:members_translations,slug';
            }
        }

        $trans['visible'] = 'boolean';

        return $trans;
    }
}
