<?php

namespace App\Modules\Categories\Forms;

use App\Modules\Categories\Models\Category;
use ProVision\Administration\Forms\AdminForm;

class CategoryForm extends AdminForm
{
    public function buildForm()
    {
        $this->add('title', 'text', [
            'label' => trans('categories::admin.title'),
            'translate' => true,
        ]);

        $this->addSeoFields();

        $categories = Category::where('parent_id',null)->get()->pluck('title', 'id')->toArray();

        $this->add('parent_id', 'select', [
            'label' => trans('categories::admin.parent_id'),
            'choices' => $categories,
            'selected' => @$this->model->parent_id,
            'empty_value' => ' ',
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