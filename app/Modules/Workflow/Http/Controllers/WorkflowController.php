<?php

namespace App\Modules\Workflow\Http\Controllers;

use App\Modules\Workflow\Models\Workflow;

use App\Http\Controllers\Controller;

class WorkflowController extends Controller
{
    public function index(){

        $workflow = Workflow::with(['media'])->reversed()->get();

        return view('workflow::front.index',compact('workflow'));
    }
}
