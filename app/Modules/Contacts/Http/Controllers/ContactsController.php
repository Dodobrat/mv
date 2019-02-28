<?php

namespace App\Modules\Contacts\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Modules\Contacts\Http\Requests\SendRequestContact;
use App\Modules\Contacts\Models\Contacts;
use Illuminate\Support\Facades\Mail;
use ProVision\Administration\Administration;
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
     * @param SendRequestContact $request
     * @return \Illuminate\Http\Response
     */
    public function store(SendRequestContact $request) {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:50|min:2',
            'email' => 'required|email',
            'phone' => 'required|min:5|max:14',
            'comment' => 'required|max:300',
        ]);
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $contact_id = $request->input('contact_id');

        $contactInfo = Contacts::whereHas('translations', function ($query) use ($contact_id) {
            $query->where('locale', Administration::getLanguage())
                ->where('contacts_id', $contact_id);
        })->first();

        Mail::send('contacts::emails.send_mail', ['data' => $validator], function ($m) use ($validator, $contactInfo) {
            $m->subject(trans('contacts::front.mail_subject'));
            $m->to($contactInfo->email, trans('contacts::front.module_name'));
        });

        return response()->json(['success'=>trans('contacts::front.email_success')], 200);

    }

}
