<?php

namespace App\Modules\Types;

use App\Modules\Types\Http\Controllers\Admin\TypesController;
use Kris\LaravelFormBuilder\Form;
use ProVision\Administration\Contracts\Module;

class Administration implements Module {

    public function routes($module) {
        \Route::resource('types', TypesController::class);
    }


    public function menu($module) {

        \AdministrationMenu::addModule(trans('types::admin.module_name'), [
            'icon' => 'code-fork'
        ], function ($menu) {
            $menu->addItem(trans('types::admin.list'), [
                'url'=> \Administration::route('types.index'),
                'icon' => 'list'
            ]);

            $menu->addItem(trans('types::admin.add'), [
                'url'=> \Administration::route('types.create'),
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
    public function dashboard($module)
    {
        // TODO: Implement dashboard() method.
    }

    /**
     * Add settings in administration panel
     * @param $module
     * @param Form $form
     * @return mixed
     */
    public function settings($module, Form $form)
    {

    }
}