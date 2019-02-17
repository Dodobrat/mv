<?php

namespace App\Modules\Index\Http\Controllers;

use App\Modules\Categories\Models\Category;
use App\Modules\Projects\Models\Project;
use App\Modules\Types\Models\Type;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    protected $projects_per_page = 4;

    public function index(Request $request) {

        $count = 0;

        if ($request->has('count')) {
            $count = $request->get('count');
        }

        $skip = $count;
        $take = $count + $this->projects_per_page;

        $types = Type::active()->reversed()->with(['categories'])->get();
//        $categories = Category::active()->reversed()->with(['projects'])->get();
        $projects = Project::active()->reversed()->with(['media','translations'])->skip($skip)->take($take)->get();

        if($request->ajax()) {
            return [
                'projects' => view('index::front.boxes.projects')->with(compact('projects'))->render(),
                'next_page' => $take
            ];
        }

        return view('index::front.index',compact('projects','types'));
    }
}
