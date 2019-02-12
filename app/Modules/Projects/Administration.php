<?php
/**
 * Copyright (c) 2019. ProVision Media Group Ltd. <http://provision.bg>
 * Venelin Iliev <http://veneliniliev.com>
 */

namespace App\Modules\Projects;

use App\Modules\Projects\Http\Controllers\Admin\ProjectsController;
use Kris\LaravelFormBuilder\Form;
use ProVision\Administration\Contracts\Module;

class Administration implements Module {

    public function routes($module) {
        \Route::resource('projects', ProjectsController::class);
    }

//    public function dashboard($module) {
//
//    }

    public function menu($module) {

        \AdministrationMenu::addModule(trans('projects::admin.module_name'), [
            'icon' => 'book'
        ], function ($menu) {
            $menu->addItem(trans('projects::admin.list'), [
                'url' => \Administration::route('projects.index'),
                'icon' => 'list'
            ]);

            $menu->addItem(trans('projects::admin.add'), [
                'url' => \Administration::route('projects.create'),
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