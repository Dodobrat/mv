<?php

namespace App\Modules\Categories\Forms;

use ProVision\Administration\Forms\AdminForm;

class CategoryForm extends AdminForm
{
    public function buildForm()
    {
        $this->add('title', 'text', [
            'label' => trans('categories::admin.title'),
            'translate' => true,
        ]);

        $this->add('visible', 'checkbox', [
            'label' => trans('categories::admin.visible'),
            'value' => 1,
            'checked' => @$this->model->visible,
        ]);

        $this->add('footer', 'admin_footer');
        $this->add('send', 'submit', [
            'label' => trans('administration::index.save'),
            'attr' => [
                'name' => 'save'
            ]
        ]);
    }
}