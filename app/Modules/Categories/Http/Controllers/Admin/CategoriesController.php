<?php

namespace App\Modules\Categories\Http\Controllers\Admin;

use App\Modules\Categories\Forms\CategoryForm;
use App\Modules\Categories\Http\Requests\StoreCategoryRequest;
use App\Modules\Categories\Models\Category;
use Form;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use ProVision\Administration\Facades\Administration;
use ProVision\Administration\Http\Controllers\BaseAdministrationController;
use Yajra\DataTables\Facades\DataTables;

class CategoriesController extends BaseAdministrationController {
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request) {
        if ($request->ajax()) {
            $categories = Category::withTrashed()->reversed();
            $datatables = Datatables::of($categories)
                ->addColumn('action', function ($category) {
                    $actions = '';
                    if (!empty($category->deleted_at)) {
                        $actions .= Form::adminRestoreButton(trans('administration::index.restore'), Administration::route('categories.destroy', $category->id));
                    } else {
                        $actions .= Form::adminDeleteButton(trans('administration::index.delete'), Administration::route('categories.destroy', $category->id));
                    }
                    $actions .= Form::adminOrderButton($category);
                    return Form::adminEditButton(trans('administration::index.edit'), Administration::route('categories.edit', $category->id)) . $actions;
                })->addColumn('parent', function ($category) {
                    if ($category->parent_id == null){
                        return 'Category';
                    }else{
                        return 'Sub Category';
                    }
                    return '';
                })
                ->addColumn('visible', function ($category) {
                    return Form::adminSwitchButton('visible', $category);
                });
            return $datatables->make(true);
        }


        Administration::setTitle(trans('categories::admin.module_name'));
        \Breadcrumbs::register('admin_final', function ($breadcrumbs) {
            $breadcrumbs->parent('admin_home');
            $breadcrumbs->push(trans('categories::admin.module_name'), Administration::route('categories.index'));
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
                'data' => 'parent',
                'name' => 'parent',
                'orderable' => false,
                'title' => trans('categories::admin.parent'),
            ])->addColumn([
                'data' => 'visible',
                'name' => 'visible',
                'orderable' => false,
                'title' => trans('categories::admin.visible'),
            ])->addColumn([
                'data' => 'created_at',
                'name' => 'created_at',
                'orderable' => false,
                'title' => trans('categories::admin.date'),
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
        $form = $formBuilder->create(CategoryForm::class, [
                'method' => 'POST',
                'url' => Administration::route('categories.store'),
                'role' => 'form',
                'id' => 'formID'
            ]
        );
        Administration::setTitle(trans('categories::admin.create'));

        \Breadcrumbs::register('admin_final', function ($breadcrumbs) {
            $breadcrumbs->parent('admin_home');
            $breadcrumbs->push(trans('categories::admin.module_name'), Administration::route('categories.index'));
            $breadcrumbs->push(trans('categories::admin.create'), Administration::route('categories.create'));
        });

        return view('administration::empty-form', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request) {
        $data = $request->validated();
        $category = new Category();
        $category->fill($data);
        $category->save();

        return \Redirect::route(Administration::routeName('categories.index'));
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
        $category = Category::withTrashed()->where('id', $id)->first();
        if (empty($category)) {
            return back();
        }
        $form = $formBuilder->create(CategoryForm::class, [
                'method' => 'PUT',
                'url' => Administration::route('categories.update', $category->id),
                'role' => 'form',
                'id' => 'formID',
                'model' => $category
            ]
        );

        Administration::setTitle(trans('categories::admin.edit') . ' - ' . $category->title);

        \Breadcrumbs::register('admin_final', function ($breadcrumbs) use ($category) {
            $breadcrumbs->parent('admin_home');
            $breadcrumbs->push(trans('categories::admin.module_name'), Administration::route('categories.index'));
            $breadcrumbs->push($category->title, Administration::route('categories.edit', $category->id));
        });
        return view('administration::empty-form', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategoryRequest $request, $id) {
        $category = Category::withTrashed()->where('id', $id)->first();
        $data = $request->validated();
        $category->fill($data);
        $category->save();

        return \Redirect::route(Administration::routeName('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $model = Category::withTrashed()->where('id', $id)->first();
        if ($model->trashed()) {
            $model->restore();
        } else {
            $model->delete();
        }
        return response()->json(['ok'], 200);
    }
}
