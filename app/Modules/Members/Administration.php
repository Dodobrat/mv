<?php

namespace App\Modules\Members;

use App\Modules\Members\Http\Controllers\Admin\MembersController;
use Kris\LaravelFormBuilder\Form;
use ProVision\Administration\Contracts\Module;

class Administration implements Module {

    public function routes($module) {
        \Route::resource('members', MembersController::class);
    }

//    public function dashboard($module) {
//
//    }

    public function menu($module) {

        \AdministrationMenu::addModule(trans('members::admin.module_name'), [
            'icon' => 'users'
        ], function ($menu) {
            $menu->addItem(trans('members::admin.list'), [
                'url' => \Administration::route('members.index'),
                'icon' => 'list'
            ]);

            $menu->addItem(trans('members::admin.add'), [
                'url' => \Administration::route('members.create'),
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