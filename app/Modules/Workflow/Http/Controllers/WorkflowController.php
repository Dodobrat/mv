<?php

namespace App\Modules\Workflow\Http\Controllers;

use App\Modules\Workflow\Models\Workflow;

use App\Http\Controllers\Controller;

class WorkflowController extends Controller
{
    public function index(){

        $workflow = Workflow::with(['media'])->reversed()->active()->where('real_estate', false)->get();

        return view('workflow::front.index',compact('workflow'));
    }

    public function real(){

        $real = Workflow::with(['media'])->reversed()->active()->estate()->get();

        return view('workflow::front.real',compact('real'));
    }
}
