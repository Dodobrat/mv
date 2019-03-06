<?php

namespace App\Modules\Workflow\Http\Controllers\Admin;

use App\Modules\Workflow\Forms\WorkflowForm;
use App\Modules\Workflow\Http\Requests\StoreWorkflowRequest;
use App\Modules\Workflow\Models\Workflow;
use Form;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use ProVision\Administration\Facades\Administration;
use ProVision\Administration\Http\Controllers\BaseAdministrationController;
use Yajra\DataTables\Facades\DataTables;

class WorkflowController extends BaseAdministrationController
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
            $works = Workflow::query();
            $datatables = Datatables::of($works)
                ->addColumn('action', function ($work) {
                    $actions = '';
                    if (!empty($work->deleted_at)) {
//
                    } else {
                        $actions .= Form::adminDeleteButton(trans('administration::index.delete'), Administration::route('workflow.destroy', $work->id));
                    }
                    $actions .= Form::mediaManager($work);
                    $actions .= Form::adminOrderButton($work);
                    return Form::adminEditButton(trans('administration::index.edit'), Administration::route('workflow.edit', $work->id)) . $actions;
                })->addColumn('visible', function ($work) {
                    return Form::adminSwitchButton('visible', $work);
                })->addColumn('real_estate', function ($work) {
                    return Form::adminSwitchButton('real_estate', $work);
                });
            return $datatables->make(true);
        }


        Administration::setTitle(trans('workflow::admin.module_name'));
        \Breadcrumbs::register('admin_final', function ($breadcrumbs) {
            $breadcrumbs->parent('admin_home');
            $breadcrumbs->push(trans('workflow::admin.module_name'), Administration::route('workflow.index'));
        });
        $table = Datatables::getHtmlBuilder()
            ->addColumn([
                'data' => 'id',
                'name' => 'id',
                'orderable' => false,
                'title' => trans('administration::administrators.id'),
            ])->addColumn([
                'data' => 'visible',
                'name' => 'visible',
                'orderable' => false,
                'title' => trans('workflow::admin.visible'),
            ])->addColumn([
                'data' => 'real_estate',
                'name' => 'real_estate',
                'orderable' => false,
                'title' => trans('workflow::admin.real_estate'),
            ])->addColumn([
                'data' => 'created_at',
                'name' => 'created_at',
                'orderable' => false,
                'title' => trans('workflow::admin.date'),
            ]);
        return view('administration::empty-listing', compact('table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder) {
        $form = $formBuilder->create(WorkflowForm::class, [
                'method' => 'POST',
                'url' => Administration::route('workflow.store'),
                'role' => 'form',
                'id' => 'formID'
            ]
        );
        Administration::setTitle(trans('workflow::admin.create'));

        \Breadcrumbs::register('admin_final', function ($breadcrumbs) {
            $breadcrumbs->parent('admin_home');
            $breadcrumbs->push(trans('workflow::admin.module_name'), Administration::route('workflow.index'));
            $breadcrumbs->push(trans('workflow::admin.create'), Administration::route('workflow.create'));
        });

        return view('administration::empty-form', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreWorkflowRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWorkflowRequest $request) {
        $data = $request->validated();
        $work = new Workflow();
        $work->fill($data);
        $work->save();

        return \Redirect::route(Administration::routeName('workflow.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, FormBuilder $formBuilder) {
        $work = Workflow::where('id', $id)->first();
        if (empty($work)) {
            return back();
        }
        $form = $formBuilder->create(WorkflowForm::class, [
                'method' => 'PUT',
                'url' => Administration::route('workflow.update', $work->id),
                'role' => 'form',
                'id' => 'formID',
                'model' => $work
            ]
        );

        Administration::setTitle(trans('workflow::admin.edit') . ' - ' . $work->id);

        \Breadcrumbs::register('admin_final', function ($breadcrumbs) use ($work) {
            $breadcrumbs->parent('admin_home');
            $breadcrumbs->push(trans('workflow::admin.module_name'), Administration::route('workflow.index'));
            $breadcrumbs->push($work->id, Administration::route('workflow.edit', $work->id));
        });
        return view('administration::empty-form', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreWorkflowRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreWorkflowRequest $request, $id) {
        $work = Workflow::where('id', $id)->first();
        $data = $request->validated();
        $work->fill($data);
        $work->save();

        return \Redirect::route(Administration::routeName('workflow.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $model = Workflow::where('id', $id)->first();
        $model->delete();
        return response()->json(['ok'], 200);
    }
}
