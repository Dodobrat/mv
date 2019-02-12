<?php

namespace App\Modules\Categories;

use App\Modules\Categories\Http\Controllers\Admin\CategoriesController;
use Kris\LaravelFormBuilder\Form;
use ProVision\Administration\Contracts\Module;

class Administration implements Module {

    public function routes($module) {
        \Route::resource('categories', CategoriesController::class);
    }


    public function menu($module) {

        \AdministrationMenu::addModule(trans('categories::admin.module_name'), [
            'icon' => 'sitemap'
        ], function ($menu) {
            $menu->addItem(trans('categories::admin.list'), [
                'url'=> \Administration::route('categories.index'),
                'icon' => 'list'
            ]);

            $menu->addItem(trans('categories::admin.add'), [
                'url'=> \Administration::route('categories.create'),
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