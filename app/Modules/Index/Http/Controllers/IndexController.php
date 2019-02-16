<?php

namespace App\Modules\Index\Http\Controllers;

use App\Modules\Categories\Models\Category;
use App\Modules\Projects\Models\Project;
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

        $categories = Category::active()->reversed()->with(['projects','translations'])->get();
        $projects = Project::active()->reversed()->with(['media','category','translations'])->skip($skip)->take($take)->get();

        if($request->ajax()) {
            return [
                'projects' => view('index::front.boxes.projects')->with(compact('projects'))->render(),
                'next_page' => $take
            ];
        }

//        return view('blog.index')->with(compact('posts'));
//dd( $projects->nextPageUrl() );
        return view('index::front.index',compact('categories','projects'));
    }
}
