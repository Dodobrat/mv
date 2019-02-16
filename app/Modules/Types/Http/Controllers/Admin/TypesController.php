<?php

namespace App\Modules\Types\Http\Controllers\Admin;

use App\Modules\Types\Forms\TypeForm;
use App\Modules\Types\Http\Requests\StoreTypeRequest;
use App\Modules\Types\Models\Type;
use Form;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use ProVision\Administration\Facades\Administration;
use ProVision\Administration\Http\Controllers\BaseAdministrationController;
use Yajra\DataTables\Facades\DataTables;

class TypesController extends BaseAdministrationController
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
            $types = Type::reversed();
            $datatables = Datatables::of($types)
                ->addColumn('action', function ($type) {
                    $actions = '';
                    if (!empty($type->deleted_at)) {
//                        $actions .= Form::adminRestoreButton(trans('administration::index.restore'), Administration::route('types.destroy', $type->id));
                    } else {
                        $actions .= Form::adminDeleteButton(trans('administration::index.delete'), Administration::route('types.destroy', $type->id));
                    }
                    $actions .= Form::adminOrderButton($type);
                    return Form::adminEditButton(trans('administration::index.edit'), Administration::route('types.edit', $type->id)) . $actions;
                })
                ->addColumn('visible', function ($type) {
                    return Form::adminSwitchButton('visible', $type);
                });
            return $datatables->make(true);
        }


        Administration::setTitle(trans('types::admin.module_name'));
        \Breadcrumbs::register('admin_final', function ($breadcrumbs) {
            $breadcrumbs->parent('admin_home');
            $breadcrumbs->push(trans('types::admin.module_name'), Administration::route('types.index'));
        });
        $table = Datatables::getHtmlBuilder()
            ->addColumn([
                'data' => 'id',
                'name' => 'id',
                'orderable' => false,
                'title' => trans('administration::administrators.id'),
            ])->addColumn([
                'data' => 'title',
                'name' => 'title',
                'orderable' => false,
                'title' => trans('administration::administrators.name'),
            ])->addColumn([
                'data' => 'visible',
                'name' => 'visible',
                'orderable' => false,
                'title' => trans('types::admin.visible'),
            ])->addColumn([
                'data' => 'created_at',
                'name' => 'created_at',
                'orderable' => false,
                'title' => trans('types::admin.date'),
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
        $form = $formBuilder->create(TypeForm::class, [
                'method' => 'POST',
                'url' => Administration::route('types.store'),
                'role' => 'form',
                'id' => 'formID'
            ]
        );
        Administration::setTitle(trans('types::admin.create'));

        \Breadcrumbs::register('admin_final', function ($breadcrumbs) {
            $breadcrumbs->parent('admin_home');
            $breadcrumbs->push(trans('types::admin.module_name'), Administration::route('types.index'));
            $breadcrumbs->push(trans('types::admin.create'), Administration::route('types.create'));
        });

        return view('administration::empty-form', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTypeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTypeRequest $request) {
        $data = $request->validated();
        $type = new Type();
        $type->fill($data);
        $type->save();

        if (!empty($data['categories'])) {
            $type->categories()->attach($data['categories']);
        }

        return \Redirect::route(Administration::routeName('types.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     * @throws \DaveJamesMiller\Breadcrumbs\Facades\DuplicateBreadcrumbException
     */
    public function edit($id, FormBuilder $formBuilder) {
        $type = Type::where('id', $id)->first();
        if (empty($type)) {
            return back();
        }
        $form = $formBuilder->create(TypeForm::class, [
                'method' => 'PUT',
                'url' => Administration::route('types.update', $type->id),
                'role' => 'form',
                'id' => 'formID',
                'model' => $type
            ]
        );

        Administration::setTitle(trans('types::admin.edit') . ' - ' . $type->title);

        \Breadcrumbs::register('admin_final', function ($breadcrumbs) use ($type) {
            $breadcrumbs->parent('admin_home');
            $breadcrumbs->push(trans('types::admin.module_name'), Administration::route('types.index'));
            $breadcrumbs->push($type->title, Administration::route('types.edit', $type->id));
        });
        return view('administration::empty-form', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreTypeRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTypeRequest $request, $id) {
        $type = Type::where('id', $id)->first();
        $data = $request->validated();
        $type->fill($data);
        $type->save();

        $type->categories()->detach();
        if (!empty($data['categories'])) {
            $type->categories()->attach($data['categories']);
        }

        return \Redirect::route(Administration::routeName('types.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $model = Type::where('id', $id)->first();
        $model->delete();
        return response()->json(['ok'], 200);
    }
}
