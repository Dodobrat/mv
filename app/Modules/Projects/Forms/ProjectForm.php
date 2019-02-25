<?php

namespace App\Modules\Projects\Forms;

use App\Modules\Categories\Models\Category;
use ProVision\Administration\Forms\AdminForm;

class ProjectForm extends AdminForm
{
    public function buildForm()
    {
        $this->add('title', 'text', [
            'label' => trans('projects::admin.title'),
            'translate' => true,
        ]);

        $this->add('description', 'editor', [
            'label' => trans('projects::admin.description'),
            'translate' => true,
        ]);

        $this->addSeoFields();

        $categories = Category::where('parent_id','!=',null)->get()->pluck('title', 'id')->toArray();

        $this->add('category_id', 'select', [
            'label' => trans('projects::admin.category_id'),
            'choices' => $categories,
            'selected' => @$this->model->category_id
        ]);

        $this->add('visible', 'checkbox', [
            'label' => trans('projects::admin.visible'),
            'value' => 1,
            'checked' => @$this->model->visible,
        ]);

        $this->add('special', 'checkbox', [
            'label' => trans('projects::admin.special'),
            'value' => 1,
            'checked' => @$this->model->special,
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