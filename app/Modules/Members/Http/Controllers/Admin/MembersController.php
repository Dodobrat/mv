<?php

namespace App\Modules\Members\Http\Controllers\Admin;

use App\Modules\Members\Forms\MemberForm;
use App\Modules\Members\Http\Requests\StoreMemberRequest;
use App\Modules\Members\Models\Member;
use Form;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use ProVision\Administration\Facades\Administration;
use ProVision\Administration\Http\Controllers\BaseAdministrationController;
use Yajra\DataTables\Facades\DataTables;

class MembersController extends BaseAdministrationController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request) {
        if ($request->ajax()) {
            $members = Member::reversed();
            $datatables = Datatables::of($members)
                ->addColumn('action', function ($member) {
                    $actions = '';
                    if (!empty($member->deleted_at)) {
//
                    } else {
                        $actions .= Form::adminDeleteButton(trans('administration::index.delete'), Administration::route('members.destroy', $member->id));
                    }
                    $actions .= ' ' . Form::mediaManager($member,
                            [
                                'filters' => [
                                    'mediaable_sub_type' => 'thumbnail'
                                ],
                                'button' => [
                                    'title' => 'Illustrated Picture',
                                    'class' => 'media-manager btn btn-sm btn-warning',
                                    'icon' => 'picture-o'
                                ]
                            ]
                        );
                    $actions .= ' ' . Form::mediaManager($member,
                            [
                                'filters' => [
                                    'mediaable_sub_type' => 'profile'
                                ],
                                'button' => [
                                    'title' => 'Profile Picture',
                                    'class' => 'media-manager btn btn-sm btn-success',
                                    'icon' => 'picture-o'
                                ]
                            ]
                        );
                    $actions .= Form::adminOrderButton($member);
                    return Form::adminEditButton(trans('administration::index.edit'), Administration::route('members.edit', $member->id)) . $actions;
                })->addColumn('visible', function ($member) {
                    return Form::adminSwitchButton('visible', $member);
                });
            return $datatables->make(true);
        }


        Administration::setTitle(trans('members::admin.module_name'));
        \Breadcrumbs::register('admin_final', function ($breadcrumbs) {
            $breadcrumbs->parent('admin_home');
            $breadcrumbs->push(trans('members::admin.module_name'), Administration::route('members.index'));
        });
        $table = Datatables::getHtmlBuilder()
            ->addColumn([
                'data' => 'id',
                'name' => 'id',
                'orderable' => false,
                'title' => trans('administration::administrators.id'),
            ])->addColumn([
                'data' => 'name',
                'name' => 'name',
                'orderable' => false,
                'title' => trans('administration::administrators.name'),
            ])->addColumn([
                'data' => 'position',
                'name' => 'position',
                'orderable' => false,
                'title' => trans('members::admin.position'),
            ])->addColumn([
                'data' => 'visible',
                'name' => 'visible',
                'orderable' => false,
                'title' => trans('members::admin.visible'),
            ])->addColumn([
                'data' => 'created_at',
                'name' => 'created_at',
                'orderable' => false,
                'title' => trans('members::admin.date'),
            ]);
        return view('administration::empty-listing', compact('table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder) {
        $form = $formBuilder->create(MemberForm::class, [
                'method' => 'POST',
                'url' => Administration::route('members.store'),
                'role' => 'form',
                'id' => 'formID'
            ]
        );
        Administration::setTitle(trans('members::admin.create'));

        \Breadcrumbs::register('admin_final', function ($breadcrumbs) {
            $breadcrumbs->parent('admin_home');
            $breadcrumbs->push(trans('members::admin.module_name'), Administration::route('members.index'));
            $breadcrumbs->push(trans('members::admin.create'), Administration::route('members.create'));
        });

        return view('administration::empty-form', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMemberRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMemberRequest $request) {
        $data = $request->validated();
        $member = new Member();
        $member->fill($data);
        $member->save();

        return \Redirect::route(Administration::routeName('members.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function edit($id, FormBuilder $formBuilder) {
        $member = Member::where('id', $id)->first();
        if (empty($member)) {
            return back();
        }
        $form = $formBuilder->create(MemberForm::class, [
                'method' => 'PUT',
                'url' => Administration::route('members.update', $member->id),
                'role' => 'form',
                'id' => 'formID',
                'model' => $member
            ]
        );

        Administration::setTitle(trans('members::admin.edit') . ' - ' . $member->title);

        \Breadcrumbs::register('admin_final', function ($breadcrumbs) use ($member) {
            $breadcrumbs->parent('admin_home');
            $breadcrumbs->push(trans('members::admin.module_name'), Administration::route('members.index'));
            $breadcrumbs->push($member->name, Administration::route('members.edit', $member->id));
        });
        return view('administration::empty-form', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreMemberRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreMemberRequest $request, $id) {
        $member = Member::where('id', $id)->first();
        $data = $request->validated();
        $member->fill($data);
        $member->save();

        return \Redirect::route(Administration::routeName('members.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $model = Member::where('id', $id)->first();
        $model->delete();
        return response()->json(['ok'], 200);
    }


}
