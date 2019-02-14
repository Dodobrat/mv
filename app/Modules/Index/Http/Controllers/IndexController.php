<?php

namespace App\Modules\Index\Http\Controllers;

use App\Modules\Categories\Models\Category;
use App\Modules\Projects\Models\Project;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index() {

        $categories = Category::active()->reversed()->with(['projects','translations'])->get();
        $projects = Project::active()->reversed()->with(['media','category','translations'])->get();

        return view('index::front.index',compact('categories','projects'));
    }
}
