<?php

namespace App\Modules\Index\Http\Controllers;

use App\Modules\Categories\Models\Category;
use App\Modules\Projects\Models\Project;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index() {

        $categories = Category::active()->reversed()->get();
        $projects = Project::active()->reversed()->with(['media','category'])->get();

        return view('index::front.index',compact('categories','projects'));
    }
}
