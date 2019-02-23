<?php

namespace App\Modules\Categories\Http\Controllers;

use App\Modules\Categories\Models\Category;
use App\Modules\Projects\Models\Project;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class CategoriesController extends Controller
{
    public function getSubCategories(Request $request) {
        $errors = [];

        if (empty($request->get('category_slug'))) {
            $errors[] = trans('index::errors.slug_error');
        }

        $category = Category::whereTranslation('slug', $request->get('category_slug'))->first();

        if (empty($category)) {
            $errors[] = trans('index::errors.category_error');
        }

        $sub_categories = new Collection();
        if (empty($errors)) {
            $sub_categories = Category::where('parent_id', $category->id)->get();
        }

        $new_sub_categories = view('index::front.boxes.sub_categories', compact('sub_categories','category'))->render();
        return response()->json(['errors' => $errors, 'new_blade' => $new_sub_categories]);
    }

    public function getProjects(Request $request) {
        $errors = [];

        if (empty($request->get('sub_category_slug'))) {
            $errors[] = trans('index::errors.sub_slug_error');
        }

        $sub_category = Category::whereTranslation('slug', $request->get('sub_category_slug'))->first();

        if (empty($sub_category)) {
            $errors[] = trans('index::errors.sub_cat_error');
        }

        $projects = new Collection();
        if (empty($errors)) {
            $projects = Project::where('category_id', $sub_category->id)->reversed()->get();
        }

        $new_projects = view('index::front.boxes.projects', compact('projects'))->render();
        return response()->json(['errors' => $errors, 'new_view' => $new_projects]);
    }


}
