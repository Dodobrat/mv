<?php

namespace App\Modules\Contacts\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Modules\Contacts\Http\Requests\SendRequestContact;
use App\Modules\Contacts\Models\Contacts;
use Illuminate\Support\Facades\Mail;
use ProVision\Administration\Facades\Settings;
use SEO;

class ContactsController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @param null $slug
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $contacts = Contacts::withTranslation()->get();
        if (empty($contacts)) {
            return redirect()->back();
        }

//            Set SEO
        SEO::setTitle(Settings::getLocale('contacts_meta_title', $default = false));
        SEO::setDescription(Settings::getLocale('contacts_meta_description', $default = false));
        SEO::metatags()->addMeta(Settings::getLocale('contacts_meta_keywords', $default = false));
        SEO::opengraph()->setUrl(route('contacts.index'));
        SEO::opengraph()->setSiteName(Settings::getLocale('contacts_meta_title', $default = false));
        SEO::setCanonical(route('contacts.index'));
        SEO::opengraph();
        SEO::twitter();
        SEO::metatags()->addMeta('author', 'ProVision.BG');
        SEO::opengraph()->addImage(asset('assets/images/facebook_share.jpg'), ['height' => 630, 'width' => 1200]);


        \Breadcrumbs::register('index', function ($breadcrumbs) {
            $breadcrumbs->parent('index_home');
            $breadcrumbs->push(Settings::getLocale('contacts_title', $default = false), route('contacts.index'));
        });


        return view('contacts::front.index', compact('contacts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(SendRequestContact $request) {
        $requestData = $request->validated();

        $contact = Contacts::first();

        if (!empty($contact)) {
            $email = $contact->email;
        }

        if (!empty($email)) {
            Mail::send('contacts::emails.send_admin_contacts', ['data' => $requestData],
                function ($m) use ($requestData, $email) {
                    $m->subject(trans('contacts::admin.mail_subject'));
                    $m->to($email, trans('contacts::admin.module_name'));
                });
        }


        return redirect()->back()->withSuccess(trans('contacts::front.success_send'));
    }

}
