<?php

namespace App\Modules\Types\Forms;

use App\Modules\Categories\Models\Category;
use ProVision\Administration\Forms\AdminForm;

class TypeForm extends AdminForm
{
    public function buildForm()
    {
        $this->add('title', 'text', [
            'label' => trans('types::admin.title'),
            'translate' => true,
        ]);

        $this->addSeoFields();

        $categories = Category::all()->pluck('title', 'id')->toArray();

        $this->add('categories', 'select', [
            'label' => trans('types::admin.categories'),
            'choices' => $categories,
            'selected' => (!empty($this->model) && !empty($this->model->categories)) ? $this->model->categories->pluck('id')->toArray() : null,
            'attr' => [
                'multiple' => 'multiple',
                'class' => 'select2',
                'id' => 'categories-exist2',
                'style' => 'width: 100%;'
            ],
//            'empty_value' => trans('products::admin.empty_value'),
        ]);

        $this->add('visible', 'checkbox', [
            'label' => trans('types::admin.visible'),
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