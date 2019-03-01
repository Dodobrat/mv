<?php

namespace App\Modules\Workflow\Forms;

use ProVision\Administration\Forms\AdminForm;

class WorkflowForm extends AdminForm
{
    public function buildForm()
    {

        $this->add('description', 'editor', [
            'label' => trans('projects::admin.description'),
            'translate' => true,
        ]);

        $this->add('visible', 'checkbox', [
            'label' => trans('projects::admin.visible'),
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