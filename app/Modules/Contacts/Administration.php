<?php
/**
 * Copyright (c) 2019. ProVision Media Group Ltd. <http://provision.bg>
 * Venelin Iliev <http://veneliniliev.com>
 */

namespace App\Modules\Contacts;

use Kris\LaravelFormBuilder\Form;
use ProVision\Administration\Contracts\Module;

class Administration implements Module {

    public function routes($module) {
        \Route::resource('contacts', 'App\Modules\Contacts\Http\Controllers\Admin\ContactsController');
    }

//    public function dashboard($module) {
//        $box = new \ProVision\Administration\Dashboard\RecentListBox();
//        $box->setTitle('Последни влизания от Google');
//        $box->addItem('test', false, 'Описание', 1200, 'https://almsaeedstudio.com/themes/AdminLTE/dist/img/default-50x50.gif');
//        $box->addItem('test', false, 'Описание', 1200, 'https://almsaeedstudio.com/themes/AdminLTE/dist/img/default-50x50.gif');
//        $box->addItem('test', false, 'Описание', 1200, 'https://almsaeedstudio.com/themes/AdminLTE/dist/img/default-50x50.gif');
//        $box->setFooterButton('View all', '#');
//        \ProVision\Administration\Dashboard::add($box);
//    }

    public function menu($module) {

        \AdministrationMenu::addModule(trans('contacts::admin.module_name'), [
            'icon' => 'paper-plane-o'
        ], function ($menu) {
            $menu->addItem(trans('contacts::admin.list'), [
                'url'=> \Administration::route('contacts.index'),
                'icon' => 'list'
            ]);

            $menu->addItem(trans('contacts::admin.add'), [
                'url'=> \Administration::route('contacts.create'),
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
        $form->add($module['slug'] . '_phone', 'text', [
            'label' => trans($module['slug'] . '::admin.phone'),
            'translate' => false
        ]);

        $form->add($module['slug'] . '_email', 'email', [
            'label' => trans($module['slug'] . '::admin.email'),
            'translate' => false
        ]);

        $form->add($module['slug'] . '_title', 'text', [
            'label' => trans($module['slug'] . '::admin.title'),
            'translate' => true
        ]);

        $form->add($module['slug'].'_meta_title', 'text', [
            'label' => trans('administration::index.meta_title'),
            'translate' => true,
            'attr' => [
                'data-maxlength' => 70,
                'data-minlength' => 35,
            ]
        ]);

        $form->add($module['slug'].'_meta_keywords', 'text', [
            'label' => trans('administration::index.meta_keywords'),
            'translate' => true,
        ]);

        $form->add($module['slug'].'_meta_description', 'text', [
            'label' => trans('administration::index.meta_description'),
            'translate' => true,
            'attr' => [
                'data-maxlength' => 160,
                'data-minlength' => 80,
            ]
        ]);


//        $form->add($module['slug'].'_header_image', 'file', [
//            'label' => trans($module['slug'].'::admin.header_image'),
////            'translate' => true,
//            'path' => '/uploads/settings/'.$module['slug'].'_header_image/'
//        ]);
    }
}