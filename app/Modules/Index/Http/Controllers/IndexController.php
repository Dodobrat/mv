<?php

namespace App\Modules\Index\Http\Controllers;

use App\Modules\Categories\Models\Category;
use App\Modules\Projects\Models\Project;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    public function index($slug = null) {

        $top_projects = Project::active()->special()->reversed()->with(['media'])->limit(9)->get();

        $categories = Category::where('parent_id',null)->active()->get();

        $current_category = $categories->first();
        if (!empty($slug)) {
            $current_category = Category::whereTranslation('slug', $slug)->first();
        }

        if($current_category != null){

            $sub_categories = $current_category->children()->get();

            $current_sub_category = $sub_categories->first();
            if (!empty($slug)) {
                $current_sub_category = Category::whereTranslation('slug', $slug)->first();
            }

            if ($current_sub_category != null){
                $projects = Project::active()->with(['media'])->where('category_id',$current_sub_category->id)->get();
            }

        }


        return view('index::front.index',compact('categories','sub_categories','projects','top_projects'));
    }
}
