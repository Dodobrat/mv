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
        $box = new \ProVision\Administration\Dashboard\HtmlBox();
        $box->setBoxClass('col-lg-6 col-md-8 col-sm-12 col-xs-12');
        $box->setHtml('

<style>
.password-generator-container{
    background-color: #9fc5dc;
    padding: 10px;
    border: 1px solid #7da3ba;
    border-radius: 2px;
    height: 128px;
    text-align: center;
    margin-bottom: 16px;
}.password-generator-title{
    margin: 0;
    padding: 0 0 10px 0;
    font-weight: 600;
    color: #333333;
}.password-generator-btn{
    transition: 0.2s ease-in-out;
    width: 100%;
    text-transform: uppercase;
    border: 0;
    border-radius: 2px;
    background-color: #3097D1;
    padding: 10px;
    color: #ffffff;
    font-weight: 600;
}.password-generator-btn:hover{
    transition: 0.2s ease-in-out;
    background-color: #2086c0;
}.pass{
    padding: 10px;
    font-size: 16px;
}.pass:hover{
    cursor:pointer;
}.copied{
    z-index: 10000;
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #ffffff;
    border: 1px solid #7da3ba;
    border-radius: 2px;
    padding: 20px 25px;
}
</style>
<div class="password-generator-container">
    <h4 class="password-generator-title">'. trans('index::admin.password_generator') .'</h4>
    <button class="password-generator-btn">'. trans('index::admin.generate_password') .'</button>
    <p class="pass"></p>
</div>
<div class="copied">'. trans('index::admin.copied') .'</div>
<script>
let pass = document.querySelector(\'.pass\');
let btn = document.querySelector(\'.password-generator-btn\');
btn.addEventListener(\'click\', function(){
let length = 25,
        charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
        retVal = "";
    for (let i = 0, n = charset.length; i < length; ++i) {
        retVal += charset.charAt(Math.floor(Math.random() * n));
    }
    pass.innerHTML = retVal;
});
pass.onclick = function() {
    document.execCommand("copy");
};
pass.addEventListener("copy", function(event) {
    event.preventDefault();
    if (event.clipboardData) {
        event.clipboardData.setData("text/plain", pass.textContent);
        $(".copied").slideDown(200);
        setTimeout(function(){
            $(".copied").slideUp(300);
        }, 3000);
    }
});
</script>
        ');
        \Dashboard::add($box);
    }

    /**
     * Add settings in administration panel
     * @param $module
     * @param Form $form
     * @return mixed
     */
    public function settings($module, Form $form)
    {
        $form->add($module['slug'].'_company_logo', 'file', [
            'label' => trans($module['slug'].'::admin.company_logo'),
            'path' => '/uploads/settings/'.$module['slug'].'_company_logo/'
        ]);

        $form->add($module['slug'].'_landing_image', 'file', [
            'label' => trans($module['slug'].'::admin.landing_image'),
            'path' => '/uploads/settings/'.$module['slug'].'_landing_image/'
        ]);
    }
}