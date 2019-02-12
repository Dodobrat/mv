<?php

namespace App\Modules\Index;

use Kris\LaravelFormBuilder\Form;
use ProVision\Administration\Contracts\Module;

class Administration implements Module {

    public function routes($module) {

    }


    public function menu($module) {

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
        $form->add($module['slug'].'_landing_image', 'file', [
            'label' => trans($module['slug'].'::admin.landing_image'),
            'path' => '/uploads/settings/'.$module['slug'].'_landing_image/'
        ]);
    }
}