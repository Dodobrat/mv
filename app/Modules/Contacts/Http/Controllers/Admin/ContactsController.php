<?php
/**
 * Copyright (c) 2019. ProVision Media Group Ltd. <http://provision.bg>
 * Venelin Iliev <http://veneliniliev.com>
 */

namespace App\Modules\Contacts\Http\Controllers\Admin;

use App\Http\Requests;
use App\Modules\Contacts\Http\Requests\StoreRequestContact;
use Illuminate\Http\Request;
use App\Modules\Contacts\Models\Contacts;
use Form;
use Kris\LaravelFormBuilder\FormBuilder;

use ProVision\Administration\Facades\Administration;
use ProVision\Administration\Http\Controllers\BaseAdministrationController;
use Yajra\DataTables\Facades\DataTables;

class ContactsController extends BaseAdministrationController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $contacts = Contacts::query();

            $datatables = Datatables::of($contacts)
                ->editColumn('title', function ($contact) {
                    return !empty($contact->title) ? $contact->title : trans('contacts::admin.empty');
                })
                ->addColumn('action', function ($contact) {
                    $actions = '';
                    if (!empty($contact->deleted_at)) {
                        //restore button
                    } else {
                        $actions .= Form::adminDeleteButton(trans('administration::index.delete'), Administration::route('contacts.destroy', $contact->id));
                    }
                    return Form::adminEditButton(trans('administration::index.edit'), Administration::route('contacts.edit', $contact->id)) . $actions;
                })->addColumn('visible', function ($contact) {
                    return Form::adminSwitchButton('visible', $contact);
                });;

            return $datatables->make(true);
        }

        Administration::setTitle(trans('contacts::admin.module_name'));

        \Breadcrumbs::register('admin_final', function ($breadcrumbs) {
            $breadcrumbs->parent('admin_home');
            $breadcrumbs->push(trans('contacts::admin.module_name'), Administration::route('contacts.index'));
        });


        $table = Datatables::getHtmlBuilder()
            ->addColumn([
                'data' => 'id',
                'name' => 'id',
                'orderable' => false,
                'title' => trans('administration::administrators.id')
            ])->addColumn([
                'data' => 'title',
                'name' => 'title',
                'orderable' => false,
                'title' => trans('contacts::admin.title')
            ])->addColumn([
                'data' => 'created_at',
                'name' => 'created_at',
                'orderable' => false,
                'title' => trans('contacts::admin.date')
            ])->addColumn([
                'data' => 'visible',
                'name' => 'visible',
                'orderable' => false,
                'title' => trans('projects::admin.visible'),
            ]);

        return view('administration::empty-listing', compact('table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Modules\Contacts\Forms\ContactForm::class, [
                'method' => 'POST',
                'url' => Administration::route('contacts.store'),
                'role' => 'form',
                'id' => 'formID'
            ]
        );
        Administration::setTitle(trans('contacts::admin.create'));
        \Breadcrumbs::register('admin_final', function ($breadcrumbs) {
            $breadcrumbs->parent('admin_home');
            $breadcrumbs->push(trans('contacts::admin.module_name'), Administration::route('contacts.index'));
            $breadcrumbs->push(trans('contacts::admin.create'), Administration::route('contacts.create'));
        });
        return view('administration::empty-form', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequestContact $request)
    {
        $contact = new Contacts();
        $contact->lat = $request->validated()['map']['lat'];
        $contact->lng = $request->validated()['map']['lng'];
        $data = $request->only(array_keys($request->rules()));
        $contact->fill($data);
        $contact->save();
        return \Redirect::route(Administration::routeName('contacts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, FormBuilder $formBuilder)
    {
        $contact = Contacts::where('id', $id)->first();
        if (!empty($contact)) {
            $form = $formBuilder->create(\App\Modules\Contacts\Forms\ContactForm::class, [
                    'method' => 'PUT',
                    'url' => Administration::route('contacts.update', $contact->id),
                    'role' => 'form',
                    'id' => 'formID',
                    'model' => $contact
                ]
            );

            Administration::setTitle(trans('contacts::admin.edit') . ' - ' . $contact->title);

            \Breadcrumbs::register('admin_final', function ($breadcrumbs) use ($contact) {
                $breadcrumbs->parent('admin_home');
                $breadcrumbs->push(trans('contacts::admin.module_name'), Administration::route('contacts.index'));
                $breadcrumbs->push($contact->title, Administration::route('contacts.edit', $contact->id));
            });
            return view('administration::empty-form', compact('form'));
        } else {
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequestContact $request, $id)
    {
        $contact = Contacts::where('id', $id)->first();
        $contact->lat = $request->validated()['map']['lat'];
        $contact->lng = $request->validated()['map']['lng'];
        $data = $request->only(array_keys($request->rules()));
        $contact->fill($data);
        $contact->save();
        return \Redirect::route(Administration::routeName('contacts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contacts::findOrFail($id);
        $contact->delete();
        return response()->json(['ok'], 200);
    }
}
