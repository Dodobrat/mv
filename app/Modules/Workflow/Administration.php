<?php

namespace App\Modules\Workflow;

use App\Modules\Workflow\Http\Controllers\Admin\WorkflowController;
use Kris\LaravelFormBuilder\Form;
use ProVision\Administration\Contracts\Module;

class Administration implements Module {

    public function routes($module) {
        \Route::resource('workflow', WorkflowController::class);
    }

    public function menu($module) {

        \AdministrationMenu::addModule(trans('workflow::admin.module_name'), [
            'icon' => 'briefcase'
        ], function ($menu) {
            $menu->addItem(trans('workflow::admin.list'), [
                'url' => \Administration::route('workflow.index'),
                'icon' => 'list'
            ]);

            $menu->addItem(trans('workflow::admin.add'), [
                'url' => \Administration::route('workflow.create'),
                'icon' => 'plus'
            ]);
        });
    }


    /**
     * Init Dashboard boxes.
     *
     * @param $module
     * @return mixed
     */
    public function dashboard($module) {
        // TODO: Implement dashboard() method.
    }

    /**
     * Add settings in administration panel
     * @param $module
     * @param Form $form
     * @return mixed
     */
    public function settings($module, Form $form) {

    }
}