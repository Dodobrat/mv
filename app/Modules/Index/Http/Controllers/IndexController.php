<?php

namespace App\Modules\Index\Http\Controllers;

use App\Modules\Categories\Models\Category;
use App\Modules\Projects\Models\Project;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    protected $projects_per_page = 5;

    public function index(Request $request) {

        $categories = Category::active()->reversed()->with(['projects','translations'])->get();
        $projects = Project::active()->reversed()->with(['media','category','translations'])->paginate($this->projects_per_page);

        if($request->ajax()) {
            return [
                'projects' => view('index::front.boxes.projects')->with(compact('projects'))->render(),
                'next_page' => $projects->nextPageUrl()
            ];
        }

//        return view('blog.index')->with(compact('posts'));

        return view('index::front.index',compact('categories','projects'));
    }
}
