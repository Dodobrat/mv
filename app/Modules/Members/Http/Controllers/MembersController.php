<?php

namespace App\Modules\Members\Http\Controllers;

use App\Modules\Members\Models\Member;
use App\Http\Controllers\Controller;

class MembersController extends Controller
{
    public function index() {

        $members = Member::active()->with(['thumbnail_media','profile_media'])->reversed()->get();

        return view('members::front.index',compact('members'));

    }
}
