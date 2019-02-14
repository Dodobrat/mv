<?php

namespace App\Modules\Members\Forms;

use ProVision\Administration\Forms\AdminForm;

class MemberForm extends AdminForm
{
    public function buildForm()
    {
        $this->add('name', 'text', [
            'label' => trans('members::admin.name'),
            'translate' => true,
        ]);

        $this->add('position', 'text', [
            'label' => trans('members::admin.position'),
            'translate' => true,
        ]);

        $this->add('bio', 'editor', [
            'label' => trans('members::admin.bio'),
            'translate' => true,
        ]);

        $this->addSeoFields();

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