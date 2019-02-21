<?php

namespace App\Modules\Index\Http\Controllers;

use App\Modules\Categories\Models\Category;
use App\Modules\Projects\Models\Project;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{

//    protected $projects_per_page = 4;

    public function index(Request $request, $slug = null) {

//        $count = 0;
//
//        if ($request->has('count')) {
//            $count = $request->get('count');
//        }
//
//        $skip = $count;
//        $take = $count + $this->projects_per_page;

//        $types = Type::active()->reversed()->with(['categories'])->get();
//        $categories = Category::active()->reversed()->with(['projects'])->get();
//        $projects = Project::active()->reversed()->with(['media','translations'])->skip($skip)->take($take)->get();

//        if($request->ajax()) {
//            return [
//                'projects' => view('index::front.boxes.projects')->with(compact('projects'))->render(),
//                'next_page' => $take
//            ];
//        }

        $categories = Category::where('parent_id',null)->active()->reversed()->get();

        $current_category = $categories->first();
        if (!empty($slug)) {
            $current_category = Category::whereTranslation('slug', $slug)->first();
        }

        $sub_categories = $current_category->children()->with(['projects'])->reversed()->get();

        $current_sub_category = $sub_categories->first();
        if (!empty($slug)) {
            $current_sub_category = Category::whereTranslation('slug', $slug)->first();
        }

        $projects = Project::active()->where('category_id',$current_sub_category->id)->reversed()->get();

        return view('index::front.index',compact('categories','sub_categories','projects'));
    }





}
