<?php

namespace App\Modules\Projects\Http\Controllers\Admin;

use App\Modules\Projects\Forms\ProjectForm;
use App\Modules\Projects\Http\Requests\StoreProjectRequest;
use App\Modules\Projects\Models\Project;
use Form;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use ProVision\Administration\Facades\Administration;
use ProVision\Administration\Http\Controllers\BaseAdministrationController;
use Yajra\DataTables\Facades\DataTables;

class ProjectsController extends BaseAdministrationController
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
            $projects = Project::reversed()->with(['category']);
            $datatables = Datatables::of($projects)
                ->addColumn('action', function ($project) {
                    $actions = '';
                    if (!empty($project->deleted_at)) {
//
                    } else {
                        $actions .= Form::adminDeleteButton(trans('administration::index.delete'), Administration::route('projects.destroy', $project->id));
                    }
                    $actions .= Form::mediaManager($project);
                    $actions .= Form::adminOrderButton($project);
                    return Form::adminEditButton(trans('administration::index.edit'), Administration::route('projects.edit', $project->id)) . $actions;
                })->addColumn('category', function ($project) {
                    return $project->category->title;
                })->addColumn('visible', function ($project) {
                    return Form::adminSwitchButton('visible', $project);
                });
            return $datatables->make(true);
        }


        Administration::setTitle(trans('projects::admin.module_name'));
        \Breadcrumbs::register('admin_final', function ($breadcrumbs) {
            $breadcrumbs->parent('admin_home');
            $breadcrumbs->push(trans('projects::admin.module_name'), Administration::route('projects.index'));
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
                'data' => 'category',
                'name' => 'category',
                'orderable' => false,
                'title' => trans('projects::admin.category_id'),
            ])->addColumn([
                'data' => 'visible',
                'name' => 'visible',
                'orderable' => false,
                'title' => trans('projects::admin.visible'),
            ])->addColumn([
                'data' => 'created_at',
                'name' => 'created_at',
                'orderable' => false,
                'title' => trans('projects::admin.date'),
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
        $form = $formBuilder->create(ProjectForm::class, [
                'method' => 'POST',
                'url' => Administration::route('projects.store'),
                'role' => 'form',
                'id' => 'formID'
            ]
        );
        Administration::setTitle(trans('projects::admin.create'));

        \Breadcrumbs::register('admin_final', function ($breadcrumbs) {
            $breadcrumbs->parent('admin_home');
            $breadcrumbs->push(trans('projects::admin.module_name'), Administration::route('projects.index'));
            $breadcrumbs->push(trans('projects::admin.create'), Administration::route('projects.create'));
        });

        return view('administration::empty-form', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProjectRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request) {
        $data = $request->validated();
        $project = new Project();
        $project->fill($data);
        $project->save();

        return \Redirect::route(Administration::routeName('projects.index'));
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
        $project = Project::where('id', $id)->first();
        if (empty($project)) {
            return back();
        }
        $form = $formBuilder->create(ProjectForm::class, [
                'method' => 'PUT',
                'url' => Administration::route('projects.update', $project->id),
                'role' => 'form',
                'id' => 'formID',
                'model' => $project
            ]
        );

        Administration::setTitle(trans('projects::admin.edit') . ' - ' . $project->title);

        \Breadcrumbs::register('admin_final', function ($breadcrumbs) use ($project) {
            $breadcrumbs->parent('admin_home');
            $breadcrumbs->push(trans('projects::admin.module_name'), Administration::route('projects.index'));
            $breadcrumbs->push($project->title, Administration::route('projects.edit', $project->id));
        });
        return view('administration::empty-form', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreProjectRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProjectRequest $request, $id) {
        $project = Project::where('id', $id)->first();
        $data = $request->validated();
        $project->fill($data);
        $project->save();

        return \Redirect::route(Administration::routeName('projects.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $model = Project::where('id', $id)->first();
        $model->delete();
        return response()->json(['ok'], 200);
    }
}
